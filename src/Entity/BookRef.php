<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\BookRefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiFilter;

#[ORM\Entity(repositoryClass: BookRefRepository::class)]
#[ApiResource(
    uriTemplate: "/book_ref/{id}",
    operations: [
        new GetCollection(uriTemplate: "/book_ref/"),
        new Post(uriTemplate: "/book_ref/", denormalizationContext: ['groups' => ['bookRef:create']], security: "is_granted('ROLE_LIBRARY')"),
        new Get(),
        new Put(denormalizationContext: ['groups' => ['bookRef:update']], security: "is_granted('ROLE_LIBRARY')"),
        new Patch(denormalizationContext: ['groups' => ['bookRef:update']], security: "is_granted('ROLE_LIBRARY')"),
        new Delete(security: "is_granted('ROLE_SUPER_ADMIN')"),
    ],
    normalizationContext: ['groups' => ['bookRef:read']],
),
ApiFilter(
    SearchFilter::class, properties: [
    'name' => 'partial',
    'author' => 'partial',
    'genre' => 'partial',
    'publisher' => 'partial',
    'isbn' => 'partial',
    'edition' => 'partial',
]),
ApiFilter(DateFilter::class, properties: [
    'created_at',
]),
]






class BookRef
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['bookRef:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['bookRef:read', 'bookRef:create', 'bookRef:update', 'book:read:status', 'book:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['bookRef:read', 'bookRef:create', 'bookRef:update'])]
    private ?string $author = null;

    #[ORM\Column(length: 60)]
    #[Groups(['bookRef:read', 'bookRef:create', 'bookRef:update'])]
    private ?string $genre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['bookRef:read', 'bookRef:create', 'bookRef:update'])]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['bookRef:read', 'bookRef:create', 'bookRef:update'])]
    private ?string $cover = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['bookRef:read', 'bookRef:create', 'bookRef:update'])]
    private ?string $publisher = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['bookRef:read', 'bookRef:create', 'bookRef:update'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['bookRef:read', 'bookRef:create', 'bookRef:update', 'book:read:status'])]
    private ?string $isbn = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['bookRef:read', 'bookRef:create', 'bookRef:update'])]
    private ?string $edition = null;

    #[ORM\OneToMany(mappedBy: 'bookRefId', targetEntity: Review::class)]
    #[Groups(['bookRef:read'])]
    private Collection $reviews;

    #[ORM\OneToMany(mappedBy: 'BookRefId', targetEntity: Book::class, orphanRemoval: true)]
    private Collection $books;

    #[ORM\OneToMany(mappedBy: 'bookRefId', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->books = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?\DateTimeInterface $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getEdition(): ?string
    {
        return $this->edition;
    }

    public function setEdition(?string $edition): static
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * @return Collection<int, BookRef>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setBookRefId($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getBookRefId() === $this) {
                $review->setBookRefId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setBookRefId($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getBookRefId() === $this) {
                $book->setBookRefId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setBookRefId($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getBookRefId() === $this) {
                $reservation->setBookRefId(null);
            }
        }

        return $this;
    }
}
