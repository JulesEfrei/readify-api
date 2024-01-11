<?php

namespace App\Repository;

use App\Entity\BookRef;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookRef>
 *
 * @method BookRef|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookRef|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookRef[]    findAll()
 * @method BookRef[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRefRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookRef::class);
    }

}
