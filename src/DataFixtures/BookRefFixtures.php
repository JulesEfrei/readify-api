<?php

namespace App\DataFixtures;

use App\Entity\BookRef;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookRefFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $booksRefData = [
            [
                'name' => 'Les Misérables',
                'author' => 'Victor Hugo',
                'genre' => 'Historical Fiction',
                'publicationDate' => new \DateTimeImmutable('1862-01-03'),
                'cover' => 'https://example.com/les-miserables.jpg',
                'publisher' => 'Albert Lacroix',
                'description' => 'A sprawling novel set in post-revolutionary France, focusing on the struggles of ex-convict Jean Valjean and his experience of redemption.',
                'isbn' => '9780140444308',
                'edition' => 'Penguin Classics',
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
                'edition' => 'Harper Perennial Modern Classics',
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
                'edition' => 'Scribner Paperback Fiction',
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
                'edition' => 'Penguin Classics',
            ],
        ];

        foreach ($booksRefData as $index => $bookRefData) {
            $bookRef = new BookRef();
            $bookRef->setName($bookRefData['name']);
            $bookRef->setAuthor($bookRefData['author']);
            $bookRef->setGenre($bookRefData['genre']);
            $bookRef->setPublicationDate($bookRefData['publicationDate']);
            $bookRef->setCover($bookRefData['cover']);
            $bookRef->setPublisher($bookRefData['publisher']);
            $bookRef->setDescription($bookRefData['description']);
            $bookRef->setIsbn($bookRefData['isbn']);
            $bookRef->setEdition($bookRefData['edition']);

            $manager->persist($bookRef);
            $this->addReference("bookref-" . $index, $bookRef);
        }

        $manager->flush();
    }
}
