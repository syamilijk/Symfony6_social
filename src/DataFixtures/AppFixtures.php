<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\MicroPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ){

    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user1 = new User();
        $user1->setEmail('test@test.com');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                '12345678'
            )
        );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('syamili@test.com');
        $user2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user2,
                '12345678'
            )
        );
        $manager->persist($user2);


        $microPost1 = new MicroPost();
        $microPost1->setTitle('Welcome to Poland!');
        $microPost1->setText('Welcome to Poland!');
        $microPost1->setAuthor($user1);
        $microPost1->setCreated(new DateTime());
        $manager->persist($microPost1);

        $microPost2 = new MicroPost();
        $microPost2->setTitle('Welcome to India!');
        $microPost2->setText('Welcome to India!');
        $microPost2->setAuthor($user2);
        $microPost2->setCreated(new DateTime());
        $manager->persist($microPost2);

        $microPost3 = new MicroPost();
        $microPost3->setTitle('Welcome to US!');
        $microPost3->setText('Welcome to US!');
        $microPost3->setAuthor($user2);
        $microPost3->setCreated(new DateTime());
        $manager->persist($microPost3);

        $microPost4 = new MicroPost();
        $microPost4->setTitle('Welcome to France!');
        $microPost4->setText('Welcome to France!');
        $microPost4->setAuthor($user1);
        $microPost4->setCreated(new DateTime());
        $manager->persist($microPost4);

        $manager->flush();
    }
}
