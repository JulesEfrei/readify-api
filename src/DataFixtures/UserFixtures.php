<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {

        //ROLE_SUPER_ADMIN
        $admin = new User();
        $admin->setFirstName("Admin");
        $admin->setLastName("Readify");
        $admin->setEmail("admin@readify.com");
        $admin->setPhone("060606060606");
        $admin->setRoles(["ROLE_SUPER_ADMIN"]);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, "Admin1234"));
        $manager->persist($admin);

        //ROLE_LIBRARY
        $library = new User();
        $library->setFirstName("Baptiste");
        $library->setLastName("Poulin");
        $library->setEmail("b.poulin@mediatheque-paris16.fr");
        $library->setPassword($this->passwordHasher->hashPassword($library, "motdepasse"));
        $library->setPhone("060606060606");
        $library->setRoles(["ROLE_LIBRARY"]);
        $manager->persist($library);

        //ROLE_USER
        $user = new User();
        $user->setFirstName("Mathéo");
        $user->setLastName("Trois");
        $user->setEmail("matheotrois@gmail.com");
        $user->setPassword($this->passwordHasher->hashPassword($library, "matmat"));
        $user->setPhone("060606060606");
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        $manager->flush();
    }
}
