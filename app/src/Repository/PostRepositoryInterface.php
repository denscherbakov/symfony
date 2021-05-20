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
     * @param null|UploadedFile $image
     * @return Post
     */
    public function setCreate(Post $post, UploadedFile $image = null): object;

    /**
     * @param Post $post
     */
    public function setDelete(Post $post): void;
}
