<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BorrowRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeBorrowController extends AbstractController
{
    public function __construct(
        private readonly BorrowRepository $borrowRepository
    )
    {
    }

    public function __invoke(): array
    {

        /** @var  $user */
        $user = $this->getUser();

        return $this->borrowRepository->findBy(["userId" => $user]);
    }
}
