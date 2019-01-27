<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getOnePost()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM 
        post ORDER BY RAND() LIMIT 4
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    public function getPostDESC(){

        $qd = $this
                ->createQueryBuilder('p')
                ->orderBy('p.id', 'DESC')
                ->setMaxResults(4)
                ->getQuery()
        ;

        return $qd->execute();
    }

    public function getPostBetween($page_count){
       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
        'SELECT p FROM App\Entity\Post p 
              ORDER BY p.id DESC    
              '

       )->setMaxResults('4')
        ->setFirstResult($page_count)
       ;

       return $query->execute();

    }

    public function getCountofTable(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT COUNT(*)
         FROM post;
         ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function search($queryGet){

        $qb = $this->createQueryBuilder('p')
                    ->where('p.Tag LIKE :queryGet')
                    ->orWhere('p.Text LIKE :queryGet')
                    ->orderBy('p.id', 'DESC')
                    ->setParameter('queryGet', '%' . $queryGet . '%')
                    ->getQuery()
                    ;

        return $qb->execute();

    }

    public function searchTag($queryGet){

        $qb = $this->createQueryBuilder('p')
            ->where('p.Tag LIKE :queryGet')
            ->orderBy('p.id', 'DESC')
            ->setParameter('queryGet', '%' . $queryGet . '%')
            ->getQuery()
        ;

        return $qb->execute();

    }


    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
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
