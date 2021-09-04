<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = $this->signUp(); 

        $manager->persist($user);
        $manager->flush();
    }

    public function signUp(): ?User
    {
        $user = new User();

        $user->setUsername("test");
        $user->setFirstname("test");
        $user->setLastname("test");

        $user->setRoles(['ROLE_USER']);

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'test'
        ));
        $user->setEmail("test@test.fr");

        return $user;
    }
}
