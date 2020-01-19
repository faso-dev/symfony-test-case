<?php


namespace App\Tests\Controller;


use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    use FixturesTrait;
    public function testDisplayLoginPage()
    {
        $client = self::createClient();
        $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Se connecter');
        $this->assertSelectorNotExists('.alert.alert-danger');
    }
    public function testDisplayLoginForm()
    {
        $client = self::createClient();
        $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('form');
        $this->assertSelectorNotExists('.alert.alert-danger');
    }
    public function testLoginFormWithBadCredentials()
    {
        $client = self::createClient();
        $client->request('POST', '/login', [
            'email' => 'faso-dev@gmail.com',
            'password' => 'test_de_connection',
            '_csrf_token' => $client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate')
        ]);
        /*$form = $crawler->selectButton('Se connecter')->form([
            'email' => 'faso-dev@gmail.com',
            'password' => 'test_de_connection'
        ]);
        $client->submit($form);*/
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }
    public function testSuccesfulLoginFormWithGoodCredentials()
    {
        $this->loadFixtureFiles([
            dirname(__DIR__).'/DataFixtures/entity/UserTestFixture.yaml'
        ]);
        $client = self::createClient();
        $client->request('POST', '/login', [
            '_csrf_token' => $client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate'),
            'email' => 'user@domain.faso-dev',
            'password' => 'user<1',
        ]);
        /*$form = $crawler->selectButton('Se connecter')->form([
            'email' => 'user@domain.faso-dev',
            'password' => 'user<1'
        ]);
        $client->submit($form);*/
        $this->assertResponseRedirects('/auth');
    }
}
