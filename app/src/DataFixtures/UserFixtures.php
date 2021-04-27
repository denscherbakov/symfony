<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserFixtures extends Fixture
{
    private EncoderFactoryInterface $encoderFactory;

    private \Faker\Generator $faker;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->createMainUser($manager);

        for ($i = 0; $i < 20; $i++) {

            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setRoles(['ROLE_ADMIN']);

            $user->setPassword($this->encoderFactory->getEncoder(User::class)->encodePassword('1234', null));

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function createMainUser(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('denscherbakov@yandex.ru');
        $user->setRoles(['ROLE_ADMIN']);

        $user->setPassword($this->encoderFactory->getEncoder(User::class)->encodePassword('1234', null));

        $manager->persist($user);

        $manager->flush();
    }
}