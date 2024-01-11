<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $booksData = [
            [
                'libraryId' => $this->getReference("library-0"),
                'bookRefId' => $this->getReference("bookref-0"),
                'state' => Book\StateBookEnum::NEW,
                'status' => Book\StatusBookEnum::AVAILABLE,
                'language' => "en"
            ],
            [
                'libraryId' => $this->getReference("library-0"),
                'bookRefId' => $this->getReference("bookref-1"),
                'state' => Book\StateBookEnum::NEW,
                'status' => Book\StatusBookEnum::NOT_AVAILABLE,
                'language' => "fr"
            ],
            [
                'libraryId' => $this->getReference("library-4"),
                'bookRefId' => $this->getReference("bookref-2"),
                'state' => Book\StateBookEnum::CLEAN,
                'status' => Book\StatusBookEnum::AVAILABLE,
                'language' => "en"
            ],
            [
                'libraryId' => $this->getReference("library-3"),
                'bookRefId' => $this->getReference("bookref-3"),
                'state' => Book\StateBookEnum::MID_DAMAGED,
                'status' => Book\StatusBookEnum::BORROWED,
                'language' => "fr"
            ],
        ];

        foreach ($booksData as $index => $bookData) {
            $book = new Book();
            $book->setStatus($bookData['status']);
            $book->setLibraryId($bookData['libraryId']);
            $book->setBookRefId($bookData['bookRefId']);
            $book->setState($bookData['state']);
            $book->setLanguage($bookData['language']);

            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LibraryFixtures::class,
            BookRefFixtures::class
        ];
    }
}
