<?php


namespace App\Tests\Repository;


use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    use FixturesTrait;
    public function testCount()
    {
        self::bootKernel();
        $this->loadFixtureFiles([
            __DIR__.'/UserRepositoryTestFixture.yaml'
        ]);
        $users = self::$container->get(UserRepository::class)->count([]);
        $this->assertEquals(10, $users);
    }
}
