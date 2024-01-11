<?php

namespace App\DataFixtures;

use App\Entity\Library;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LibraryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $librariesData = [
            [
                "name" => "Bibliothèque nationale de France",
                "phone" => "0153795379",
                "address" => "5 Rue Vivienne",
                "city" => "Paris",
                "zip" => "75002",
            ],
            [
                "name" => "Médiathèque André Malraux",
                "phone" => "0143763077",
                "address" => "4 Rue Albert Camus",
                "city" => "Maisons-Alfor",
                "zip" => "94700",
            ],
            [
                'name' => 'Bibliothèque Nationale',
                'phone' => '0140205317',
                'address' => 'Quai François-Mauriac',
                'city' => 'Paris',
                'zip' => '75013',
            ],
            [
                'name' => 'Médiathèque Jacques Demy',
                'phone' => '0240419595',
                'address' => '24 quai de la Fosse',
                'city' => 'Nantes',
                'zip' => '44000',
            ],
            [
                'name' => 'Bibliothèque municipale de Lyon',
                'phone' => '0478621800',
                'address' => '30 Boulevard Vivier Merle',
                'city' => 'Lyon',
                'zip' => '69003',
            ],
            // Add more libraries as needed
        ];

        foreach ($librariesData as $index => $libraryData) {
            $library = new Library();
            $library->setName($libraryData['name']);
            $library->setPhone($libraryData['phone']);
            $library->setAddress($libraryData['address']);
            $library->setCity($libraryData['city']);
            $library->setZip($libraryData['zip']);

            $manager->persist($library);
            $this->addReference("library-" . $index, $library);
        }

        $manager->flush();
    }
}
