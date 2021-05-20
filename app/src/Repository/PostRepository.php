<?php

namespace App\Repository;

use App\Entity\Post;
use App\Service\FileManagerServiceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<Post> findAll()
 * @psalm-method list<Post> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
	/**
	 * @var EntityManagerInterface
	 */
	private  EntityManagerInterface $manager;

	/**
	 * @var FileManagerServiceInterface
	 */
	private  FileManagerServiceInterface $fileManagerService;

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $manager,
                                FileManagerServiceInterface $fileManagerService)
    {
        parent::__construct($registry, Post::class);

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

	public function setCreate(Post $post, UploadedFile $image = null): object
	{
		if (!is_null($image)){
			$fileName = $this->fileManagerService->imagePostUpload($image);
			$post->setImage($fileName);
		}

		$post->setCreatedAtValue();
		$post->setUpdatedAtValue();
		$post->setIsPublished();
		$this->manager->persist($post);
		$this->manager->flush();

		return $post;
	}

	public function setDelete(Post $post): void
	{
		if (!is_null($post->getImage())){
			$this->fileManagerService->removePostImage($post->getImage());
		}

		$this->manager->remove($post);
		$this->manager->flush();
	}
}
