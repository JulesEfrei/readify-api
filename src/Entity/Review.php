<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ReviewRepository;
use App\State\ReviewStateProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(denormalizationContext: ['groups' => ['review:create']], security: "is_granted('ROLE_USER')", processor: ReviewStateProcessor::class),
        new Get(),
        new Put(denormalizationContext: ['groups' => ['review:update']], security: "is_granted('ROLE_USER')", processor: ReviewStateProcessor::class),
        new Patch(denormalizationContext: ['groups' => ['review:update']], security: "is_granted('ROLE_USER')", processor: ReviewStateProcessor::class),
        new Delete(security: "is_granted('ROLE_SUPER_ADMIN')"),
    ],
    normalizationContext: ['groups' => ['review:read']],
)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['review:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['review:read', 'review:create', 'review:update'])]
    private ?string $comment = null;

    #[ORM\Column]
    #[Groups(['review:read', 'review:create', 'review:update'])]
    private ?float $rating = null;

    #[ORM\ManyToOne(inversedBy: "reviews")]
    #[Groups(['review:read', 'review:create', 'review:update'])]
    private BookRef $bookRefId;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['review:read'])]
    private ?User $userId = null;

    #[ORM\Column]
    #[Groups(['review:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?bool $isBoosted = false;

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

    public function getBookRefId(): ?BookRef
    {
        return $this->bookRefId;
    }

    public function setBookRefId(?BookRef $bookRef): static
    {
        $this->bookRefId = $bookRef;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getIsBoosted(): ?bool
    {
        return $this->isBoosted;
    }

    public function setIsBoosted(bool $isBoosted): static
    {
        $this->isBoosted = $isBoosted;

        return $this;
    }
}
