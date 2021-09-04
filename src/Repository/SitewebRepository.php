<?php
// /src/Repository/SitewebRepository.php
namespace App\Repository;

use App\Entity\Siteweb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Siteweb|null find($id, $lockMode = null, $lockVersion = null)
 * @method Siteweb|null findOneBy(array $criteria, array $orderBy = null)
 * @method Siteweb[]    findAll()
 * @method Siteweb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitewebRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Siteweb::class);
    }

    // /**
    //  * @return MyEntity[] Returns an array of MyEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MyEntity
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}