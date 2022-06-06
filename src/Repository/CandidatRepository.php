<?php

namespace App\Repository;

use App\Entity\Candidat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Candidat>
 *
 * @method Candidat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidat[]    findAll()
 * @method Candidat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidat::class);
    }

    public function add(Candidat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Candidat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Candidat[] Returns an array of Companies objects
     */
    public function findByCriteria(array $domaines, int $region): array
    {
        $query = $this->createQueryBuilder('c');
        $where = '';
        $i = 0;
        $numItems = count($domaines);
        foreach ($domaines as $domaine) {
            if (++$i === $numItems) {
                $query->andWhere($where.'c.formations LIKE :'.$domaine);
            } else {
                $where .= 'c.formations LIKE :'.$domaine.' OR ';
            }
            $query->setParameter($domaine, '%'.$domaine.'%');
        }
        return $query
            ->andWhere('c.is_searching = true')
            ->andWhere('c.searched_region = :region')
            ->setParameter('region', $region)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Candidat
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
