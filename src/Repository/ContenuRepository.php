<?php
// /src/Repository/ContenuRepository.php
namespace App\Repository;

use App\Entity\Contenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contenu[]    findAll()
 * @method Contenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contenu::class);
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