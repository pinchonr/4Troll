<?php

namespace AppBundle\Repository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCommentsByGag($id)
    {
        return $this->getEntityManager()
                    ->createQuery('SELECT comment 
                    			   FROM AppBundle:Comment comment 
                    			   WHERE comment.gag =:id 
                    			   ORDER BY comment.publishedAt ASC')
                    ->setParameter('id', $id)
                    ->getResult();
    }

    public function fingCommentByIdAndGagId($id_gag, $id_comment)
    {
        return $this->getEntityManager()
                    ->createQuery('SELECT comment 
                    			   FROM AppBundle:Comment comment 
                    			   WHERE comment.gag =:id_gag 
                    			   AND comment.id =:id_comment ORDER BY comment.publishedAt ASC')
                    ->setParameters(array('id_gag'=> $id_gag, 'id_comment'=> $id_comment))
                    ->getOneOrNullResult();
    }
}
