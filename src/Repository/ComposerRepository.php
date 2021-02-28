<?php

namespace App\Repository;

use App\Entity\Composer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Composer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Composer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Composer[]    findAll()
 * @method Composer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComposerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Composer::class);
    }

    public function bornAfter(int $year = 1500): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where('c.birth >= :year')
            ->setParameter('year', $year)
            ->orderBy('c.name')
        ;

        return $qb->getQuery()->getResult();
    }

    public function bornBetween(int $start, int $end): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where('c.birth >= :start')
            ->andWhere('c.birth <= :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->orderBy('c.name', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function bornBetween2(int $start, int $end): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where('c.birth BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->orderBy('c.name', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function searchInName(string $name): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where('c.name LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->orderBy('c.name', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function search(string $text): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->leftJoin('c.musics', 'm')
            ->where('c.name LIKE :text')
            ->orWhere('m.name LIKE :text')
            ->orWhere('c.description LIKE :text')
            ->setParameter('text', '%'.$text.'%')
        ;

        return $qb->getQuery()->getResult();
    }
}
