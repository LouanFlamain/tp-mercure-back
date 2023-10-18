<?php

namespace App\Repository;

use App\Entity\ChatGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChatGroup>
 *
 * @method ChatGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChatGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChatGroup[]    findAll()
 * @method ChatGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatGroup::class);
    }

//    /**
//     * @return ChatGroup[] Returns an array of ChatGroup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ChatGroup
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
