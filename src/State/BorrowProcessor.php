<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Book\StatusBookEnum;
use Symfony\Component\Config\Definition\Exception\Exception;

class BorrowProcessor implements ProcessorInterface
{

    public function __construct(
        private readonly ProcessorInterface $persistProcessor
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {

//        POST operation => check if the book is available
        if ($operation instanceof Post) {

            if ($data->getBookId()->getStatus() !== StatusBookEnum::AVAILABLE) {
                throw new Exception("The book is not available");
            } else {
                $data->getBookId()->setStatus(StatusBookEnum::BORROWED);

                $dateInterval = \DateInterval::createFromDateString("14 day");
                $data->setDueDate((new \DateTimeImmutable)->add($dateInterval));

                return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
            }

        }

        return $data;
    }
}
