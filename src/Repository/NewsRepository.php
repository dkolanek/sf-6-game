<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 *
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function save(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function generate(bool $flush = false): News
    {
        $title = 'News '. rand(1, 999);
        $news = new News();
        $news->setTitle($title)
            ->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget aliquam aliquam, nisl nisl aliquet nisl, quis aliquam nisl nisl nec nisl. Donec euismod, nisl eget aliquam aliquam, nisl nisl aliquet nisl, quis aliquam nisl nisl nec nisl.')
            ->setAuthor('Author 1')
            ->setPublishDate(new \DateTime('now'));

        $this->save($news, $flush);

        return $news;
    }

}
