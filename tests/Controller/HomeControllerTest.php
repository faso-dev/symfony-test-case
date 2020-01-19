<?php


namespace App\Tests\Controller;


use App\Entity\User;
use App\Tests\HelpersTest\NeedLogin;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    use FixturesTrait, NeedLogin;
    public function testWelcomePage()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testIfTheHomePageHasH1()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertSelectorTextContains('h1', 'Welcome to my website');
    }
    public function testIfTheHomePageHasATitle()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertSelectorTextContains('title', 'FASO-DEV..::..WELCOME');
    }

    public function testIfAnonymousCanAcessAuthPage()
    {
        $client = static::createClient();
        $client->request('GET', '/auth');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
    public function testIfAnonymousCannotAcessAuthPageIsRedirect()
    {
        $client = static::createClient();
        $client->request('GET', '/auth');
        $this->assertResponseRedirects('/login');
    }
    public function testIfAuthenticateUserCanAcessAuthPage()
    {

        $client = static::createClient();
        $users = $this->loadFixtureFiles([
            dirname(__DIR__).'/DataFixtures/entity/UserTestFixture.yaml'
        ]);
        /** @var User $user */
        $user = $users['user'];
        $this->login($client, $user);
        $client->request('GET', '/auth');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testIfANotAdminCanAccessAdminDashboard()
    {
        $client = static::createClient();
        $users = $this->loadFixtureFiles([
            dirname(__DIR__).'/DataFixtures/entity/UserTestFixture.yaml'
        ]);
        /** @var User $user */
        $user = $users['user'];
        $this->login($client, $user);
        $client->request('GET', '/dashboard');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

    }
    public function testIfAAdminCanAccessAdminDashboard()
    {
        $client = static::createClient();
        $users = $this->loadFixtureFiles([
            dirname(__DIR__).'/DataFixtures/entity/UserTestFixture.yaml'
        ]);
        /** @var User $user */
        $user = $users['user_admin'];
        $this->login($client, $user);
        $client->request('GET', '/dashboard');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }

    public function testIfTheHierachyRolesWorkCorectly()
    {
        $client = static::createClient();
        $users = $this->loadFixtureFiles([
            dirname(__DIR__).'/DataFixtures/entity/UserTestFixture.yaml'
        ]);
        /** @var User $user */
        $user = $users['user_super_admin'];
        $this->login($client, $user);
        $client->request('GET', '/dashboard');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testSendEmailSend()
    {
        $client = static::createClient();
        $client->enableProfiler();
        $client->request('GET', '/mail');
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $mailCollector->getMessageCount());
        /** @var \Swift_Message[] $messages */
        $messages = $mailCollector->getMessages();
        $this->assertEquals($messages[0]->getTo(), ['admin@faso-dev' => null]);
    }
}
