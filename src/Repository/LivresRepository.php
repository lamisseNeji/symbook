<?php

namespace App\Repository;
use App\Entity\Categories;
use App\Entity\Livres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livres>
 *
 * @method Livres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livres[]    findAll()
 * @method Livres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livres::class);
    }

    /**
     * @return Livres[] Returns an array of Livres objects
     */
    public function findGreaterThan($prix): array
    {
       return $this->createQueryBuilder('l')
            ->andWhere('l.prix >:val')
            ->setParameter('val', $prix)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    public function search($term)
    {
        return $this->createQueryBuilder('l')
            ->where('l.titre LIKE :term')
            ->orWhere('l.categorie IN (SELECT c.id FROM categorie c WHERE c.libelle LIKE :term)')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getResult();
    }


//    public function findOneBySomeField($value): ?Livres
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
