<?php
namespace AppBundle\Services;
use AppBundle\Entity\Patient;
use AppBundle\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;

class ServiceRecherche {

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {

        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Patient::class);
    }

    public function getPatients(array $criterias){

        $order="none";
        
        if(array_key_exists('order',$criterias)){
        $order=$criterias['order'];
        }

        $keyword="all";
        if(array_key_exists('keyword',$criterias)){
            $keyword=$criterias['keyword'];
        }

    
        $patients=$this->entityManager->getRepository('AppBundle:Patient')->getPatients($order,$keyword);
        
        return $patients;

    }

    public function getExams(array $criterias){

        $keyword="all";
        if(array_key_exists('keyword',$criterias)){
            $keyword=$criterias['keyword'];
        }

    
        $examens=$this->entityManager->getRepository('AppBundle:Examen')->getExams($keyword);
        
        return $examens;

    }

    public function getUsers(array $criterias){

        $order="none";
        
        if(array_key_exists('order',$criterias)){
        $order=$criterias['order'];
        }

        $keyword="all";
        if(array_key_exists('keyword',$criterias)){
            $keyword=$criterias['keyword'];
        }

    
        $users=$this->entityManager->getRepository('AppBundle:User')->getUsers($order,$keyword);
        
        return $users;

    }
}