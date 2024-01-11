<?php

namespace App\State;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Bundle\SecurityBundle\Security;

class ReviewStateProcessor implements ProcessorInterface
{

    public function __construct(
        private readonly ProcessorInterface $persistProcessor,
        private readonly ProcessorInterface $removeProcessor,
        private readonly Security           $security
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {

        if ($operation instanceof Post) {
            $data->setUserId($this->security->getUser());

            if(in_array("ROLE_LIBRARY", $this->security->getUser()->getRoles(), true)) {
                $data->setIsBoosted(true);
            }

            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

        if ($this->security->isGranted("ROLE_SUPER_ADMIN") || $this->security->getUser()->getId() === $data->getUserId()->getId()) {

            if ($operation instanceof DeleteOperationInterface) {
                $this->removeProcessor->process($data, $operation, $uriVariables, $context);
            }

            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }

    }
}
