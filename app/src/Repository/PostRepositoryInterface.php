<?php


namespace App\Repository;


use App\Entity\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PostRepositoryInterface
{
	/**
	 * @return Post[]
	 */
	public function getAll(): array;

	/**
	 * @param int $id
	 * @return Post
	 */
	public function getOne(int $id): object;

	/**
	 * @param Post $post
	 * @param UploadedFile $image
	 * @return Post
	 */
	public function setCreate(Post $post, UploadedFile $image): object;

	/**
	 * @param Post $post
	 */
	public function setDelete(Post $post);
}