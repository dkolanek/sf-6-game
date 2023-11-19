<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function save(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function generate(bool $flush = false): Comment
    {
        $title = 'Comment '. rand(1, 999);
        $comment = new Comment();
        $comment->setAuthor('Author '.rand(1, 999))
            ->setTitle($title)
            ->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget aliquam aliquam, nisl nisl aliquet nisl, quis aliquam nisl nisl nec nisl. Donec euismod, nisl eget aliquam aliquam, nisl nisl aliquet nisl, quis aliquam nisl nisl nec nisl.')
            ->setCreatedDate(new \DateTime('now'));

        $this->save($comment, $flush);

        return $comment;
    }

}
