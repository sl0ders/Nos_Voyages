<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Picture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    /**
     * Récupere les produits en lien avec les recherche
     * @param SearchData $search
     * @return Picture[]
     */
    public function findSearch(SearchData $search)
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.city', 'c');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('c.name LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if(!empty($search->cities)) {
            $query = $query
                ->andWhere('c.id IN (:cities)')
                ->setParameter('cities', $search->cities);
        }

        if(!empty($search->countries)) {
            $query = $query
                ->andWhere('p.country IN (:countries)')
                ->setParameter('countries', $search->countries);
        }

        return $query->getQuery()->getResult();
    }
}
