<?php


namespace App\Repository;


use App\Entity\Category;

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
	 * @return Category
	 */
	public function setCreate(Category $category): object;

	/**
	 * @param Category $category
	 */
	public function setDelete(Category $category);
}