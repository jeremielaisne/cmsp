<?php
// /src/Repository/ZoneRepository.php
namespace App\Repository;

use App\Entity\Zone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Zone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Zone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Zone[]    findAll()
 * @method Zone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zone::class);
    }

    public function findByUserAndSites($user, $siteweb)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT libelle, page, url
                FROM zone
                WHERE active = 1 AND created_by = :user AND siteweb = :siteweb
                ";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user' => $user, "siteweb" => $siteweb]);
        $results = $stmt->fetchAll();
                 
        return $results;
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