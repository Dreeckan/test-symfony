<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // SELECT a.id, a.title FROM article a WHERE a.title LIKE %truc% OR a.content LIKE %truc% ORDER BY id DESC LIMIT 0,5
    public function search(string $text): array
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select([
                'a',
                't'
            ])
            ->join('a.tag', 't')
            ->where('a.title LIKE :text')
            ->orWhere('a.content LIKE :text')
            ->orWhere('t.name LIKE :text')
            ->setParameter('text', '%'.$text.'%')
            ->addOrderBy('a.title', 'ASC')
            ->setMaxResults(5)
            ->setFirstResult(0)
        ;

        return $qb->getQuery()->getResult();
    }
}
