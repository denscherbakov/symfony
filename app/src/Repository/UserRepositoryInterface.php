<?php


namespace App\Repository;


use App\Entity\User;

interface UserRepositoryInterface
{
	/**
	 * @return User[]
	 */
	public function getAll(): array;

	/**
	 * @param int $id
	 * @return User
	 */
	public function getOne(int $id): object;

	/**
	 * @param User $user
	 * @return User
	 */
	public function setCreateOrUpdate(User $user): object;

	/**
	 * @param User $user
	 */
	public function setDelete(User $user);
}