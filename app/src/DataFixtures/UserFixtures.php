<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 * @psalm-suppress PropertyNotSetInConstructor
 */
class UserFixtures extends Fixture
{
    private EncoderFactoryInterface $encoderFactory;

    private \Faker\Generator $faker;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->createMainUser($manager);

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setName($this->faker->firstName);
            $user->setPhone($this->faker->phoneNumber);
            $user->setStatus(2);
            $user->setRoles([User::ROLE_USER]);

            $user->setPassword($this->encoderFactory->getEncoder(User::class)->encodePassword('1234', null));

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function createMainUser(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('denscherbakov@yandex.ru');
        $user->setName('Denis');
        $user->setPhone('+79231111111');
        $user->setStatus(1);
        $user->setRoles([User::ROLE_ADMIN]);

        $user->setPassword($this->encoderFactory->getEncoder(User::class)->encodePassword('1234', null));

        $manager->persist($user);

        $manager->flush();
    }
}
