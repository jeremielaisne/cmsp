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

    public function findBySites($siteweb)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT ct.id, ct.is_active, ct.langue, ct.type, ct.contenu, c.libelle, z.libelle, z.page
                FROM contenu AS ct
                LEFT JOIN categorie AS c ON ct.categorie_id = c.id
                LEFT JOIN zone AS z ON c.zone_id = z.id
                WHERE c.is_active = 1 AND z.siteweb = :siteweb
                ";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute(["siteweb" => $siteweb]);

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