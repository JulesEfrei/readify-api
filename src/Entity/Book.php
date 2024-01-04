<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(denormalizationContext: ['groups' => ['book:create']], security: "is_granted('ROLE_LIBRARY')"),
        new Get(),
        new Put(denormalizationContext: ['groups' => ['book:update']], security: "is_granted('ROLE_LIBRARY')"),
        new Patch(denormalizationContext: ['groups' => ['book:update']], security: "is_granted('ROLE_LIBRARY')"),
        new Delete(security: "is_granted('ROLE_LIBRARY')"),
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

    #[ORM\Column(length: 255)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?string $author = null;

    #[ORM\Column(length: 60)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?string $genre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?string $cover = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?string $publisher = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?string $isbn = null;

    #[ORM\Column(length: 100)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?string $language = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private ?string $edition = null;

    #[ORM\ManyToMany(targetEntity: Library::class, inversedBy: 'books')]
    #[Groups(['book:read', 'book:create', 'book:update'])]
    private Collection $libraryId;

    #[ORM\OneToMany(mappedBy: 'bookId', targetEntity: Review::class)]
    #[Groups(['book:read'])]
    private Collection $reviews;

    #[ORM\OneToOne(mappedBy: 'bookId', cascade: ['persist', 'remove'])]
//    #[Groups(['book:read', 'book:update'])]
    private ?Borrow $borrow = null;

    #[ORM\OneToMany(mappedBy: 'bookId', targetEntity: Reservation::class)]
//    #[Groups(['book:read', 'book:update'])]
    private Collection $reservations;

    public function __construct()
    {
        $this->libraryId = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->reviews = new ArrayCollection();
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

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

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
     * @return Collection<int, Library>
     */
    public function getLibraryId(): Collection
    {
        return $this->libraryId;
    }

    public function addLibraryId(Library $libraryId): static
    {
        if (!$this->libraryId->contains($libraryId)) {
            $this->libraryId->add($libraryId);
        }

        return $this;
    }

    public function removeLibraryId(Library $libraryId): static
    {
        $this->libraryId->removeElement($libraryId);

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setBookId($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getBookId() === $this) {
                $review->setBookId(null);
            }
        }

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
            $reservation->setBookId($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getBookId() === $this) {
                $reservation->setBookId(null);
            }
        }

        return $this;
    }
}
