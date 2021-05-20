<?php

namespace App\Repository;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface CategoryRepositoryInterface
{
    /**
     * @return Category[]
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return Category
     */
    public function getOne(int $id): object;

    /**
     * @param Category $category
     * @param UploadedFile|null $image
     * @return Category
     */
    public function setCreate(Category $category, UploadedFile $image = null): object;

    /**
     * @param Category $category
     */
    public function setDelete(Category $category): void;
}
