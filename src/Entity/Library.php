<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\LibraryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(denormalizationContext: ['groups' => ['library:create']], security: "is_granted('ROLE_SUPER_ADMIN')"),
        new Get(),
        new Put(denormalizationContext: ['groups' => ['library:update']], security: "is_granted('ROLE_LIBRARY')"),
        new Patch(denormalizationContext: ['groups' => ['library:update']], security: "is_granted('ROLE_LIBRARY')"),
        new Delete(security: "is_granted('ROLE_SUPER_ADMIN')"),
    ],
    normalizationContext: ['groups' => ['library:read']],
)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["library:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["library:read", "library:create", "library:update"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["library:read", "library:create", "library:update"])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(["library:read", "library:create", "library:update"])]
    private ?string $address = null;

    #[ORM\Column(length: 15)]
    #[Groups(["library:read", "library:create", "library:update"])]
    private ?string $zip = null;

    #[ORM\Column(length: 15)]
    #[Groups(["library:read", "library:create", "library:update"])]
    private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'libraryId', targetEntity: Book::class)]
    private Collection $books;

    #[ORM\OneToMany(mappedBy: 'libraryId', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): static
    {
        $this->zip = $zip;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

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
            $book->setLibraryId($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getLibraryId() === $this) {
                $book->setLibraryId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setLibraryId($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLibraryId() === $this) {
                $user->setLibraryId(null);
            }
        }

        return $this;
    }
}
