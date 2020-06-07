<?php
/**
 * Created by PhpStorm.
 * User: Grisel
 * Date: 08/12/2016
 * Time: 19:01
 */

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package AppBundle\Repository*
 */
class UserRepository extends EntityRepository
{
    
    public function getUsers($order,$keyword) {
        
        $qb = $this->createQueryBuilder("a");

        $qb->select("a");

        if($order != "none") {
            $qb->orderBy("a." . $order, "ASC");
        }

        if($keyword != "all") {
            $qb->andWhere("a.username LIKE :keyword OR a.nom_labo LIKE :keyword OR a.reference LIKE :keyword  ")->setParameter("keyword", "%".$keyword."%");
        }

        return $qb->getQuery()->getResult();

    }

}