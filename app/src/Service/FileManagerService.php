<?php


namespace App\Service;


use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManagerService implements FileManagerServiceInterface
{
	private $postImageDirectory;

	public function __construct($postImageDirectory)
	{
		$this->postImageDirectory = $postImageDirectory;
	}

	/**
	 * @param UploadedFile $file
	 * @return string
	 */
	public function imagePostUpload(UploadedFile $file): string
	{
		$fileName = $this->getFileName($file);

		try {

			$file->move($this->getPostImageDirectory(), $fileName);
		} catch (FileException $exception){
			return $exception;
		}

		return $fileName;
	}

	/**
	 * @param UploadedFile $file
	 * @return string
	 */
	private function getFileName(UploadedFile $file): string
	{
		return uniqid() . '.' . $file->guessExtension();
	}

	/**
	 * @param string $fileName
	 * @return bool|\Exception|IOExceptionInterface
	 */
	public function removePostImage(string $fileName)
	{
		$fileSys = new Filesystem();

		try {
			$fileSys->remove($this->getPostImageDirectory() . $fileName);
		} catch (IOExceptionInterface $exception) {
			return $exception;
		}

		return true;
	}

	/**
	 * @return mixed
	 */
	public function getPostImageDirectory()
	{
		return $this->postImageDirectory;
	}
}