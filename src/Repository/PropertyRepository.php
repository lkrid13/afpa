<?php

namespace App\Repository;
//use Doctrine\Common\Persistence\ManagerRegistry;


use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use function dump;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }
    
    /**
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search): Query {
        
        $query = $this->findVisibleQuery();
        if ($search->getMaxPrice()) {
            $query->andWhere('p.price <= :maxprice' )
                ->setParameter('maxprice', $search->getMaxPrice());
        }
        if ($search->getMinSurface()) {
            $query
                ->andWhere('p.surface >= :minsurface' )
                ->setParameter('minsurface', $search->getMinSurface());
        } 
        if ($search->getOptions()->count() > 0){
            $key = 0;
            //foreach ($search->getOptions() as $key => $option) {
            // il est plus prudent de gérer l'indice du tableau nous même
            // quelqu'un pourrai entrer un indice non numérique dans l'url : ..&option[xsdfs]=1
            foreach ($search->getOptions() as $option) {
                $key++;
                $query
                    ->andWhere(":option$key MEMBER OF p.options")
                    ->setParameter("option$key", $option);
            }
        }
        return $query->getQuery();
    }
    
    /**
     * @return Property[]
     */
    public function findAllVisible(): array {
        
        return $this->findVisibleQuery()
                ->getQuery()
                ->getResult();
        
    }
    
    /**
     * @return Property[]
     */
    public function findLastest(): array {

                return $this->findVisibleQuery()
                ->setMaxResults(4)
                ->getQuery()
                ->getResult();

    }

    /**
     * 
     * @return QueryBuilder
     */
    private function findVisibleQuery(): QueryBuilder {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sold = false');
    
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

