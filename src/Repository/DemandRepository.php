<?php

namespace App\Repository;

use App\Entity\Demand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Demand>
 *
 * @method Demand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demand[]    findAll()
 * @method Demand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demand::class);
    }

    public function save(Demand $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Demand $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByStatus($status){
        //select * from demand where status = $status
        $query =$this->createQueryBuilder('d') //select *
            ->where('d.state = :status')
            ->setParameter('status',$status);

        return $query->getQuery()->getResult();
    }
    public function findByStatus2($status1,$status2){
        //select * from demand where status = $status
        $query =$this->createQueryBuilder('d') //select *
        ->where('d.state = :status1')
            ->orWhere('d.state = :status2')
            ->setParameter('status1',$status1)
            ->setParameter('status2',$status2);

        return $query->getQuery()->getResult();
    }
    public function findByStatus3($status1,$status2,$status3){
        //select * from demand where status = $status
        $query =$this->createQueryBuilder('d') //select *
        ->where('d.state = :status1')
            ->orWhere('d.state = :status2')
            ->orWhere('d.state = :status3')
            ->setParameter('status1',$status1)
            ->setParameter('status2',$status2)
            ->setParameter('status3',$status3);

        return $query->getQuery()->getResult();
    }

    public function searchByKeyword($keyword){
        $query =$this->createQueryBuilder('d')
            ->where("d.activityType LIKE '%".$keyword."%'");
//            ->orWhere('d.activityGoal like :keyword')
//            ->orWhere('d.activityDueDate like :keyword')
//            ->orWhere('d.activityFunder like :keyword')
//            ->setParameter('keyword',$keyword);

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Demand[] Returns an array of Demand objects
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

//    public function findOneBySomeField($value): ?Demand
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
