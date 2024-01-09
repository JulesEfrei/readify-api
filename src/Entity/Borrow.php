<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\RequestBody;
use App\Controller\ExpandDueDateActionController;
use App\Controller\MeBorrowController;
use App\Repository\BorrowRepository;
use App\State\BorrowProcessor;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BorrowRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(security: "is_granted('ROLE_LIBRARY')"),
        new Post(denormalizationContext: ['groups' => ['borrow:create']], security: "is_granted('ROLE_USER')", processor: BorrowProcessor::class),
        new Get(security: "is_granted('ROLE_USER') and object.userId == user or is_granted('ROLE_LIBRARY')"),
        new Post(
            uriTemplate: "/borrow/{id}/expand",
            controller: ExpandDueDateActionController::class,
            openapi: new Operation(
                summary: "Expand the due date to one week and retrieves the Borrow resource",
                requestBody: new RequestBody(
                    content: new \ArrayObject([
                        'application/ld+json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => []
                            ]
                        ]
                    ])
                )
            ),
            security: "is_granted('ROLE_USER') and object.userId == user or is_granted('ROLE_LIBRARY')"
        ),
        new Patch(denormalizationContext: ['groups' => ['borrow:update']], security: "is_granted('ROLE_LIBRARY')"),
        new Delete(security: "is_granted('ROLE_USER') and object.userId == user or is_granted('ROLE_LIBRARY')"),
    ],
    normalizationContext: ['groups' => ['borrow:read']],
)]
//-- Subresource's --//
    /* User */
#[ApiResource(
    uriTemplate: 'user/{id}/borrow',
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_LIBRARY')"
        )
    ],
    uriVariables: [
        'id' => new Link(fromProperty: 'borrow', fromClass: User::class)
    ],
)]
/* me */
#[ApiResource(
    uriTemplate: 'me/borrow',
    operations: [
        new GetCollection(controller: MeBorrowController::class)
    ]
)]
class Borrow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['borrow:read', "book:read"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['borrow:read', "book:read"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['borrow:read', 'borrow:update', "book:read"])]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\OneToOne(inversedBy: 'borrow', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['borrow:read', 'borrow:create', "book:read"])]
    public ?User $userId = null;

    #[ORM\OneToOne(inversedBy: 'borrow', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['borrow:read', 'borrow:create'])]
    private ?Book $bookId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getBookId(): ?Book
    {
        return $this->bookId;
    }

    public function setBookId(Book $bookId): static
    {
        $this->bookId = $bookId;

        return $this;
    }
}
