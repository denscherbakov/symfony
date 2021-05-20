<?php

namespace App\Repository;

use App\Entity\Category;
use App\Service\FileManagerServiceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<Category> findAll()
 * @psalm-method list<Category> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{

	/**
	 * @var EntityManagerInterface
	 */
	private EntityManagerInterface $manager;

	/**
	 * @var FileManagerServiceInterface
	 */
	private  FileManagerServiceInterface $fileManagerService;

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $manager,
                                FileManagerServiceInterface $fileManagerService)
    {
        parent::__construct($registry, Category::class);

        $this->manager = $manager;
        $this->fileManagerService = $fileManagerService;
    }

	public function getAll(): array
	{
		return parent::findAll();
	}

	public function getOne(int $id): object
	{
		return parent::find($id);
	}

	public function setCreate(Category $category, UploadedFile $image = null): object
	{
		if (!is_null($image)){
			$fileName = $this->fileManagerService->imagePostUpload($image);
			$category->setImage($fileName);
		}

		$category->setCreatedAtValue();
		$category->setUpdatedAtValue();
		$this->manager->persist($category);
		$this->manager->flush();

		return $category;
	}

	public function setDelete(Category $category): void
	{
		// TODO: Implement setDelete() method.
	}
}
