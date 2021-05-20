<?php


namespace App\DataFixtures;


use App\Entity\Category;
use Cocur\Slugify\Slugify;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class CategoryFixtures
 * @package App\DataFixtures
 * @psalm-suppress PropertyNotSetInConstructor
 */
class CategoryFixtures extends Fixture
{
	/**
	 * @var Generator
	 */
	private Generator $faker;

	/**
	 * @var SlugifyInterface
	 */
	private SlugifyInterface $slug;

	public function __construct(SlugifyInterface $slug)
	{
		$this->faker = Factory::create();
		$this->slug = $slug;
	}

	public function load(ObjectManager $manager): void
	{
		for ($i = 0; $i < 20; $i++) {

			$category = new Category();
			$category->setTitle($this->faker->text(15));
			$category->setDescription($this->slug->slugify($category->getTitle()));
			$category->setImage($this->imageUrl());
			$category->setCreatedAt($this->faker->dateTime);
			$category->setUpdatedAt($this->faker->dateTime);

			$manager->persist($category);
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
		$baseUrl = "https://via.placeholder.com/";
		$url = "{$width}x{$height}/";

		if ($randomize) {
			$url .= '?' . mt_rand();
		}

		return $baseUrl . $url;
	}
}