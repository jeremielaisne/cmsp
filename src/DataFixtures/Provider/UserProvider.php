<?php

namespace App\DataFixtures\Provider;

use App\Entity\User;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProvider
{
    private static $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        UserProvider::$passwordHasher = $passwordHasher;
    }

    public static function setPassword()
    {
        $user = new User();
        return UserProvider::$passwordHasher->hashPassword($user, 'test');
    } 

    public static function setCreatedAt()
    {
        return new DateTime();
    }

    public static function setRoles()
    {
        $roles = ["ROLE_USER", "ROLE_ADMIN"];

        $tab_roles[] = $roles[rand(0, 1)];

        return array_unique($tab_roles);
    }
}