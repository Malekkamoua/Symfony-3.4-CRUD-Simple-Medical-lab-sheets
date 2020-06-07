<?php

namespace AppBundle\Repository;

/**
 * PatientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PatientRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPatients($order, $keyword) {
        
        $qb = $this->createQueryBuilder("a");

        $qb->select("a");

        if($order != "none") {
            $qb->orderBy("a." . $order, "DESC");
        }

        if($keyword != "all") {
            $qb->andWhere("a.nom LIKE :keyword OR a.prenom LIKE :keyword ")->setParameter("keyword", "%".$keyword."%");
        }

        return $qb->getQuery()->getResult();

    }
}
