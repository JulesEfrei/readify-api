<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $booksData = [
            [
                'name' => 'Les Misérables',
                'author' => 'Victor Hugo',
                'genre' => 'Historical Fiction',
                'publicationDate' => new \DateTimeImmutable('1862-01-03'),
                'cover' => 'https://example.com/les-miserables.jpg',
                'publisher' => 'Albert Lacroix',
                'description' => 'A sprawling novel set in post-revolutionary France, focusing on the struggles of ex-convict Jean Valjean and his experience of redemption.',
                'isbn' => '9780140444308',
                'language' => 'fr',
                'edition' => 'Penguin Classics',
                'libraryId' => $this->getReference("library-0"),
            ],
            [
                'name' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'genre' => 'Southern Gothic',
                'publicationDate' => new \DateTimeImmutable('1960-07-11'),
                'cover' => 'https://example.com/to-kill-a-mockingbird.jpg',
                'publisher' => 'J.B. Lippincott & Co.',
                'description' => 'A classic novel that explores themes of racial injustice and moral growth in the American South during the 1930s.',
                'isbn' => '0061120081',
                'language' => 'en',
                'edition' => 'Harper Perennial Modern Classics',
                'libraryId' => $this->getReference("library-2"),
            ],
            [
                'name' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'genre' => 'Classic Literature',
                'publicationDate' => new \DateTimeImmutable('1925-04-10'),
                'cover' => 'https://example.com/the-great-gatsby.jpg',
                'publisher' => 'Charles Scribner\'s Sons',
                'description' => 'Set in the Roaring Twenties, this novel explores the decadence and disillusionment of the American Dream through the eyes of Jay Gatsby.',
                'isbn' => '9780743273565',
                'language' => 'en',
                'edition' => 'Scribner Paperback Fiction',
                'libraryId' => $this->getReference("library-0"),
            ],
            [
                'name' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'genre' => 'Romance',
                'publicationDate' => new \DateTimeImmutable('1813-01-28'),
                'cover' => 'https://example.com/pride-and-prejudice.jpg',
                'publisher' => 'T. Egerton, Whitehall',
                'description' => 'A classic novel of manners, the story follows the romantic entanglements of Elizabeth Bennet and Mr. Darcy in early 19th-century England.',
                'isbn' => '9780141439518',
                'language' => 'en',
                'edition' => 'Penguin Classics',
                'libraryId' => $this->getReference("library-4"),
            ],
        ];

        foreach ($booksData as $bookData) {
            $book = new Book();
            $book->setName($bookData['name']);
            $book->setAuthor($bookData['author']);
            $book->setGenre($bookData['genre']);
            $book->setPublicationDate($bookData['publicationDate']);
            $book->setCover($bookData['cover']);
            $book->setPublisher($bookData['publisher']);
            $book->setDescription($bookData['description']);
            $book->setIsbn($bookData['isbn']);
            $book->setLanguage($bookData['language']);
            $book->setEdition($bookData['edition']);
            $book->addLibraryId($bookData['libraryId']);

            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LibraryFixtures::class,
        ];
    }
}
