<?php

namespace App\Repository;

use App\Entity\Employes;
use App\model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employes>
 *
 * @method Employes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employes[]    findAll()
 * @method Employes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employes::class);
    }
    public function add()
    {
        
    }
    public function save(Employes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Employes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findBySearch($searchTerm)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where(
                $qb->expr()->orX(
                    $qb->expr()->like('p.prenom', ':searchTerm'),
                    $qb->expr()->like('p.nom', ':searchTerm')
            )
            )
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->orderBy('p.nom', 'ASC');
        return $qb->getQuery()->getResult();
    }
//    /**
//     * @return Employes[] Returns an array of Employes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Employes
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
