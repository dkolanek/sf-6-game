<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function save(Game $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Game $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws Exception
     */
    public function findAllEqualScore(int $score = 100): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql =
            'SELECT * FROM game g
            WHERE g.score = :score
            ORDER BY g.score ASC';

        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery(['score' => $score]);
        return $resultSet->fetchAllAssociative();
    }

    public function findAllEqualScoreDql(int $score = 100): array
    {
        #query builder
        $qb = $this->createQueryBuilder('g')
            ->andWhere('g.score = :score')
            ->orderBy('g.score', 'ASC')
            ->setParameter('score', $score);

        $query = $qb->getQuery();

        return $query->execute();
    }

}
