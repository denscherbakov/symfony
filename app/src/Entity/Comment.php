<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @psalm-suppress MissingConstructor
 */
class Comment
{
	private const PUBLISHED = true;

	private const NOT_PUBLISHED = false;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $content;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private self $post;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $updated_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $is_published;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPost(): self
    {
        return $this->post;
    }

    public function setPost(self $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->is_published;
    }

	public function setIsPublished(): self
	{
		$this->is_published = self::PUBLISHED;

		return $this;
	}

	public function setIsNotPublished(): self
	{
		$this->is_published = self::NOT_PUBLISHED;

		return $this;
	}

	public function setUpdatedAtValue(): self
	{
		$this->updated_at = new \DateTime();

		return $this;
	}

	public function setCreatedAtValue(): self
	{
		$this->created_at = new \DateTime();

		return $this;
	}
}
