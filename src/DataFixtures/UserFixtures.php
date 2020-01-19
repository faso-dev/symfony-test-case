<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
       for($i = 0; $i <= 9; $i++){
           $user = new User();
           $user
               ->setEmail("user{$i}@gmail.com")
               ->setPassword("@pass{$i}");
           $manager->persist($user);
           $manager->flush();
       }
    }
}
