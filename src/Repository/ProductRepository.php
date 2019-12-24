<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
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

    public function findProducts($gender, $category, $page, $limit, $subCategory, $size, $price)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('
            p.gender LIKE :gender
             AND 
            p.category LIKE :category
             AND 
            p.subCategory LIKE :subCategory
             AND
            p.size LIKE :size 
             AND
            p.price BETWEEN :minPrice AND :maxPrice
            ')
            ->setParameters([
                'gender' => '%'.$gender.'%',
                'category' => '%'.$category.'%',
                'subCategory' => '%'.$subCategory.'%',
                'minPrice' => $price[0],
                'maxPrice' => $price[1],
                'size' => '%'.$size.'%'
            ])
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit)
            ->orderBy('p.price', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllByCriteria($gender, $category, $subCategory, $size, $price)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('
            p.gender LIKE :gender
             AND 
            p.category LIKE :category 
             AND 
            p.subCategory LIKE :subCategory
             AND
            p.size LIKE :size
             AND 
            p.price BETWEEN :minPrice AND :maxPrice'
            )
            ->setParameters([
                'gender' => '%'.$gender.'%',
                'category' => '%'.$category.'%',
                'subCategory' => '%'.$subCategory.'%',
                'size' => '%'.$size.'%',
                'minPrice' => $price[0],
                'maxPrice' => $price[1]
            ])
            ->orderBy('p.price', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByDiscountAndDate()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.discount > 0 AND p.publish > :date')
            ->setParameter('date', new \DateTime('-1day'))
            ->getQuery()
            ->getResult();
    }

    public function findByDate()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.publish > :date')
            ->setParameter('date', new \DateTime('-1day'))
            ->getQuery()
            ->getResult();
    }

    public function findByDiscount()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.discount > 0')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }
}
