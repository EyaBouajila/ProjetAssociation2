<?php

namespace App\Repository;

use App\Entity\DemandFundingPatient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandFundingPatient>
 *
 * @method DemandFundingPatient|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandFundingPatient|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandFundingPatient[]    findAll()
 * @method DemandFundingPatient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandFundingPatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandFundingPatient::class);
    }

    public function save(DemandFundingPatient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DemandFundingPatient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DemandFundingPatient[] Returns an array of DemandFundingPatient objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DemandFundingPatient
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
