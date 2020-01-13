<?php

namespace App\Repository;

use App\Entity\FanArt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method FanArt|null find($id, $lockMode = null, $lockVersion = null)
 * @method FanArt|null findOneBy(array $criteria, array $orderBy = null)
 * @method FanArt[]    findAll()
 * @method FanArt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FanArtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FanArt::class);
    }

    public function findPaginatedFanArts($from){
        $query = $this->createQueryBuilder("fa")
            ->orderBy("fa.id", "DESC")
            ->getQuery();
        $pages = $this->paginate($query, $from);
        return $pages;
    }

    private function paginate($dql, $page = 1, $limit = 3){
        $paginator = new Paginator($dql);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);
        return $paginator;
    }



    // /**
    //  * @return FanArt[] Returns an array of FanArt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FanArt
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
