<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class PostFixtures
 * @package App\DataFixtures
 * @psalm-suppress PropertyNotSetInConstructor
 */
class PostFixtures extends Fixture
{
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->text(15));
            $post->setContent($this->faker->text(200));
            $post->setImage($this->imageUrl());
            $post->setCreatedAt($this->faker->dateTime);
            $post->setUpdatedAt($this->faker->dateTime);
            $post->setIsPublished();

            $manager->persist($post);
        }

        $manager->flush();
    }

    /**
     * @param int $width
     * @param int $height
     * @param bool $randomize
     * @return string
     */
    private static function imageUrl(int $width = 640, int $height = 480, bool $randomize = true): string
    {
        $baseUrl = 'https://via.placeholder.com/';
        $url = "{$width}x{$height}/";

        if ($randomize) {
            $url .= '?' . mt_rand();
        }

        return $baseUrl . $url;
    }
}
