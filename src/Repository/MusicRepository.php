<?php

namespace App\Repository;

use App\Entity\Music;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Music|null find($id, $lockMode = null, $lockVersion = null)
 * @method Music|null findOneBy(array $criteria, array $orderBy = null)
 * @method Music[]    findAll()
 * @method Music[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Music::class);
    }

    public function searchInName(string $name): array
    {
        $qb = $this->createQueryBuilder('m');
        $qb
            ->where('m.name LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->orderBy('m.name', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function searchByComposerName(string $composerName): array
    {
        $qb = $this->createQueryBuilder('m');
        $qb
            ->join('m.composer', 'c')
            ->where('c.name LIKE :name')
            ->setParameter('name', '%'.$composerName.'%')
            ->orderBy('m.name', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }
}
