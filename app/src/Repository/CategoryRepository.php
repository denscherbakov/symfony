<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{

	private EntityManagerInterface $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Category::class);

        $this->manager = $manager;
    }

	public function getAll(): array
	{
		return parent::findAll();
	}

	public function getOne(int $id): object
	{
		return parent::find($id);
	}

	public function setCreate(Category $category): object
	{
		// TODO: Implement setCreate() method.
	}

	public function setDelete(Category $category)
	{
		// TODO: Implement setDelete() method.
	}
}
