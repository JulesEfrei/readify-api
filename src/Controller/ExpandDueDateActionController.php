<?php

namespace App\Controller;

use App\Entity\Borrow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpandDueDateActionController extends AbstractController
{

    public function __invoke(Borrow $data): Borrow
    {
        // Expand the dueDate by 7 days
        $newDueDate = (new \DateTimeImmutable($data->getDueDate()->format('Y-m-d H:i:s')))->add(new \DateInterval('P7D'));

        return $data;

    }

}
