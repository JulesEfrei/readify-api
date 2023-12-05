<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ApiResource]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?float $rating = null;

    #[ORM\OneToMany(mappedBy: 'reviews', targetEntity: Book::class)]
    private Collection $bookId;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    public function __construct()
    {
        $this->bookId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBookId(): Collection
    {
        return $this->bookId;
    }

    public function addBookId(Book $bookId): static
    {
        if (!$this->bookId->contains($bookId)) {
            $this->bookId->add($bookId);
            $bookId->setReviews($this);
        }

        return $this;
    }

    public function removeBookId(Book $bookId): static
    {
        if ($this->bookId->removeElement($bookId)) {
            // set the owning side to null (unless already changed)
            if ($bookId->getReviews() === $this) {
                $bookId->setReviews(null);
            }
        }

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }
}
