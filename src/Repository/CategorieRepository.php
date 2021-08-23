<?php
// /src/Repository/CategorieRepository.php
namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function findBySites($siteweb)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT c.id, c.libelle, c.description, z.id as zone_id, z.libelle as zone_libelle, z.page as zone_page
                FROM categorie AS c
                LEFT JOIN zone AS z ON c.zone_id = z.id
                WHERE c.is_active = 1 AND z.siteweb = :siteweb
                ";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute(["siteweb" => $siteweb]);

        $results = [];

        $i = 0;
        while ($row = $stmt->fetch()) {
            $results[$i] = $row;
            $results[$i]['champs'] = $this->getChamps($row['id']);
            $i++;
        }
  
        return $results;
    }

    public function getChamps($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT c.id, c.libelle
                FROM champ AS c
                LEFT JOIN categorie_champ AS cat ON cat.champ_id = c.id
                WHERE cat.categorie_id = :id
                ";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

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