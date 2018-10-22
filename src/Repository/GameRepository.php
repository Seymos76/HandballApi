<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @param string $match_date
     * @return array Games[]
     */
    public function findFutureGames(string $match_date): ?array
    {
        return $this->createQueryBuilder('g')
            ->where('g.match_date = :match_date')
            ->setParameter('match_date', $match_date)
            ->getQuery()
            ->getResult();
    }

    public function findResults()
    {
        return $this->createQueryBuilder('g')
            ->where('g.winner != :winner')
            ->setParameter('winner', null)
            ->getQuery()
            ->getArrayResult();
    }

//    /**
//     * @return Match[] Returns an array of Match objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Match
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
