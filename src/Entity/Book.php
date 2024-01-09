<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Entity\Book\StateBookEnum;
use App\Entity\Book\StatusBookEnum;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(denormalizationContext: ['groups' => ['book:create']], security: "is_granted('ROLE_LIBRARY')"),
        new Get(),
        new Get(uriTemplate: "/book/{id}/status", normalizationContext: ['groups' => ["book:read:status"]]),
        new Put(denormalizationContext: ['groups' => ['book:update']], security: "is_granted('ROLE_SUPER_ADMIN') or object.libraryId == user.libraryId"),
        new Patch(denormalizationContext: ['groups' => ['book:update']], security: "is_granted('ROLE_SUPER_ADMIN') or object.libraryId == user.libraryId"),
        new Delete(security: "is_granted('ROLE_SUPER_ADMIN') or object.libraryId == user.libraryId"),
    ],
    normalizationContext: ['groups' => ['book:read']],
)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['book:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    public ?Library $libraryId = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['book:read', 'book:create', 'book:read:status'])]
    private ?BookRef $BookRefId = null;

    #[ORM\Column(length: 50, enumType: StatusBookEnum::class)]
    #[Groups(['book:read', 'book:create', 'book:update', 'book:read:status'])]
    private ?StatusBookEnum $status = null;

    #[ORM\Column(length: 50, enumType: StateBookEnum::class)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    #[ApiProperty(security: "is_granted('ROLE_LIBRARY')")]
    private ?StateBookEnum $state = null;

    #[ORM\OneToOne(mappedBy: 'bookId', cascade: ['persist', 'remove'])]
    #[ApiProperty(security: "is_granted('ROLE_LIBRARY')")]
    #[Groups(['book:read'])]
    private ?Borrow $borrow = null;

    #[ORM\Column(length: 5)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?string $language = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibraryId(): ?Library
    {
        return $this->libraryId;
    }

    public function setLibraryId(?Library $libraryId): static
    {
        $this->libraryId = $libraryId;

        return $this;
    }

    public function getBookRefId(): ?BookRef
    {
        return $this->BookRefId;
    }

    public function setBookRefId(?BookRef $BookRefId): static
    {
        $this->BookRefId = $BookRefId;

        return $this;
    }

    public function getStatus(): ?StatusBookEnum
    {
        return $this->status;
    }

    public function setStatus(StatusBookEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getState(): ?StateBookEnum
    {
        return $this->state;
    }

    public function setState(?StateBookEnum $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getBorrow(): ?Borrow
    {
        return $this->borrow;
    }

    public function setBorrow(Borrow $borrow): static
    {
        // set the owning side of the relation if necessary
        if ($borrow->getBookId() !== $this) {
            $borrow->setBookId($this);
        }

        $this->borrow = $borrow;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }
}
