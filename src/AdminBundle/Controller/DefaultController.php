<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Examen;
use AppBundle\Form\UserType;
use AppBundle\Entity\Patient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends Controller {

       public function createPAction(Request $request, $id = null) {

        $em = $this->getDoctrine()->getManager();

        if ($id == null) {
            $patient = new Patient();
        }

        else {
            $patient = $em->getRepository('AppBundle:Patient')->findOneById($id); 
        }

        $information = array('MOROCCAN'=>'02','CATALAN'=>'03',
        'ANDALUSIAN'=>'04','BASQUE'=>'05',
        'GALICIAN'=>'06','GYPSY'=>'07',
        'GAMBIAN'=>'08','NORTH-EUROPEAN'=>'09',
        'CENTER-EUROPEAN'=>'10','SOUTH-EUROPEAN'=>'11','ANGLO-SAXON'=>'12',
        'EAST-EUROPEAN'=>'13','HINDU-PAKISTAN'=>'14','CHINESE'=>'16','JAPANESE'=>'17','PHILIPPINE'=>'18','NORTH-AMERICAN'=>'19','SOUTH-AMERICAN'=>'20','AFRO-CARIBBEAN'=>'21','SOUTH-AFRICAN'=>'22','CENTER-AFRICAN'=>'23','NORTH-AFRICAN'=>'24','GUINEAN'=>'25','EST-AFRICAN'=>'26','PORTUGUESE'=>'28','CANARIAN'=>'29','BALEARIC'=>'30','IBERIAN'=>'31','Autres'=>'01');

        $formP = $this->createFormBuilder($patient)

            ->add('nom', TextType::class, array('label' => 'Nom Patient', 'required'  => true,'attr' => array('class' =>'form-control')))
            ->add('reference', TextType::class, array('label' => 'reference Patient', 'required'  => true,'attr' => array('class' =>'form-control')))
            ->add('prenom', TextType::class, array('label' => 'Prenom Patient', 'required'   => true,'attr' => array('class' =>'form-control')))
            ->add('sexe',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'expanded'=>true,
                'data'=> $patient->getSexe(),
                'choices' => [
                    'Sexe' => [
                        'Masculin' => 'Masculin',
                        'Feminin' => 'Feminin',
                ]],
                'attr' => array('class' =>'choice')
            ))
            ->add('civilite',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'expanded'=>true,
                'data'=> $patient->getCivilite(),
                'choices' => [
                    'civilite' => [
                        'Enfant' => 'Enfant',
                        'Mademoiselle' =>'Mademoiselle',
                        'Dame' => 'Dame',
                        'Monsieur' => 'Monsieur',
                ]],
                'attr' => array('class' =>'choice')
            ))
            ->add('dateDeNaissance', BirthdayType::class, array('label' => 'dateDeNaissance', 'required'  => false,'attr' => array('class' =>'form-control')))

            ->add('datePrelevement', DateType::class, array('label' => 'dateDeNaissance', 'required'  => false,'attr' => array('class' =>'form-control')))
            
            ->add('nomPrenomMed', TextType::class, array('label' => 'Nom Medecin', 'required'  => true,'attr' => array('class' =>'form-control')))
            ->add('telMed', IntegerType::class, array('label' => 'Tel Medecin', 'required'  => false,'attr' => array('class' =>'form-control')))
            ->add('adressMed', TextType::class, array('label' => 'Adresse Medecin', 'required'  => false,'attr' => array('class' =>'form-control')))

            ->add('taille', TextType::class, array('label' => 'Taille Patient (cm)', 'required'  => false,'attr' => array('class' =>'form-control')))
            ->add('poids', TextType::class, array('label' => 'poids Patient (Kg)', 'required'  => false,'attr' => array('class' =>'form-control')))

            ->add('Examen', EntityType::class, array('label' => 'Examen (s)', 'required'   => true,'multiple'=>true,
            'class' => 'AppBundle:Examen', 'placeholder'=>'Aucun','attr'=> array('class'=> 'trisomie select2 select2-container select2-container--default')))

            ->add('type_tube',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'expanded'=>true,
                'data'=> $patient->getTypeTube(),
                'choices' => [
                    'Type tube' => [
                        'Congelé' => 'Congelé',
                        'Réfrigéré' => 'Réfrigéré',
                        'Ambiant' => 'Ambiant'
                ]],
                'attr' => array('class' =>'choice')
            ))
            ->add('type_dossier',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'expanded'=>true,
                'data'=> $patient->getTypeDossier(),
                'choices' => [
                    'Type tube' => [
                        'Normal' => 'Normal',
                        'Urgent' => 'Urgent'
                ]],
                'attr' => array('class' =>'choice')
            ))

            ->add('nb_tube', IntegerType::class, array( 'required'  => true,'attr' => array('class' =>'form-control')))

            ->add('traitement', TextareaType::class, array('label' => 'traitement', 'required'  => false,'attr' => array('class' =>'form-control')))
            
            ->add('commentaires', TextareaType::class, array('label' => 'Commentaires', 'required'  => false,'attr' => array('class' =>'form-control')))

            ->add('origine', ChoiceType::class, array('label' => 'Origine','choices'=>$information, 'placeholder' => 'NORTH-AFRICAN' ,'required'=>false,  'attr'=> array('class'=> 'trisomie select2 select2-container select2-container--default')))


            ->add('tabagisme',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'expanded'=>true,
                'data'=> $patient->getTabagisme(),
                'choices' => [
                    'Type tube' => [
                        'oui' => 'oui',
                        'non' => 'non'
                ]],
                'attr' => array('class' =>'choice')
            ))

            ->add('fiv',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'required' => false,
                'expanded'=>true,
                'placeholder' => false,
                'data'=> $patient->getFiv(),
                'choices' => [
                    'FIV' => [
                        'oui' => 'oui',
                        'non' => 'non'
                ]]
            ))

            ->add('diabetique',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'required' => false,
                'expanded'=>true,
                'placeholder' => false,
                'data'=> $patient->getDiabetique(),
                'choices' => [
                    'diabetique' => [
                        'oui' => 'oui',
                        'non' => 'non',
                        
                ]]
            ))

            ->add('antecedentT18_13',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'required' => false,
                'expanded'=>true,
                'placeholder' => false,
                'data'=> $patient->getAntecedentT1813(),
                'choices' => [
                    'antecedentT18_13' => [
                        'oui' => 'oui',
                        'non' => 'non',
                        'indéterminé' => 'indéterminé'
                ]]
            ))

            ->add('antecedentT21',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'required' => false,
                'expanded'=>true,
                'placeholder' => false,
                'data'=> $patient->getAntecedentT21(),
                'choices' => [
                    'antecedentT21' => [
                        'oui' => 'oui',
                        'non' => 'non',
                        'indéterminé' => 'indéterminé'

                ]]
            ))

            ->add('antecedentMTN',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'required' => false,
                'expanded'=>true,
                'placeholder' => false,
                'data'=> $patient->getAntecedentMTN(),
                'choices' => [
                    'antecedentMTN' => [
                        'oui' => 'oui',
                        'non' => 'non',
                        'indéterminé' => 'indéterminé'

                ]]
            ))

            ->add('trimestre',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'required' => false,
                'expanded'=>true,
                'placeholder' => false,
                'data'=> $patient->getTrimestre(),
                'choices' => [
                    'trimestre' => [
                        'Trimestre 1' => '1',
                        'Trimestre 2' => '2'
                ]]
            ))

            ->add('foetus', IntegerType::class, array('label' => 'foetus', 'required'  => false,'attr' => array('class' =>'form-control', 'placeholder'=>'nombre de foetus')))

            ->add('date_ddr', DateType::class, array('label' => 'date_ddr', 'required'  => false,'attr' => array('class' =>'form-control')))

            ->add('date_echo', DateType::class, array('label' => 'date_echo', 'required'  => false,'attr' => array('class' =>'form-control')))

            ->add('age_grossesse_semaines', IntegerType::class, array('label' => 'date_echo', 'required'  => false,'attr' => array('class' =>'form-control')))

            
            ->add('age_grossesse_jours', IntegerType::class, array('label' => 'date_echo', 'required'  => false,'attr' => array('class' =>'form-control')))

            
            ->add('date_deb_concep', DateType::class, array('label' => 'date_deb_concep', 'required'  => false,'attr' => array('class' =>'form-control')))

            ->add('type_grossesse',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'required' => false,
                'expanded'=>true,
                'data'=> $patient->getTypeGrossesse(),
                'choices' => [
                    'Type tube' => [
                        'Spontanée' => 'Spontanée',
                        'FIV' => 'FIV',
                        'ICSI' => 'ICSI',
                        'Don d\'ovule' => 'Don ovule'
                ]]
            ))

            ->add('LCC_PBD',ChoiceType::class, array(
                'mapped'=>false,
                'multiple'=>false,
                'required' => false,
                'expanded'=>true,
                'data'=> $patient->getLCCPBD(),
                'placeholder'=> false,
                'choices' => [
                    'LCC_PBD' => [
                        'LCC' => 'LCC',
                        'PBD' => 'PBD'
                        
                ]]
            ))

            ->add('LCC_PBD_value', TextType::class, array( 'required' => false,'attr' => array('class' =>'form-control')))


            ->add('Clarte_nucale', TextType::class, array('label' => 'Clarte nucale ', 'required' => false,'attr' => array('class' =>'form-control')))

            ->add('ordenance', DateType::class, array('label' => 'ordonnance', 'required'  => false,'attr' => array('class' =>'form-control')))

            ->getForm();

        $formP->handleRequest($request);
        $message = "";

        if($formP->isSubmitted() && $formP->isValid() )
        {
            $patient->setCreatedAt(new \DateTime());

            $Nom = $formP ['nom']->getData();
            $Prenom = $formP ['prenom']->getData();
            $civilite = $formP ['civilite']->getData();
            $sexe = $formP ['sexe']->getData();
            $ddn = $formP ['dateDeNaissance']->getData();

            $tube =$formP['type_tube']->getData();
            $nbTube =$formP['nb_tube']->getData();
            $type_dossier = $formP['type_dossier']->getData();
            $ordenance = $formP['ordenance']->getData();
            $traitement = $formP['traitement']->getData();
            $commentaires = $formP['commentaires']->getData();
            $datePrelevement = $formP['datePrelevement']->getData();

            $origine = $formP['origine']->getData();
            $tabagisme = $formP['tabagisme']->getData();
            $fiv = $formP['fiv']->getData();
            $diabetique = $formP['diabetique']->getData();
            $antecedentT18_13 = $formP['antecedentT18_13']->getData();
            $antecedentT21 = $formP['antecedentT21']->getData();
            $antecedentMTN = $formP['antecedentMTN']->getData();

            $foetus = $formP['foetus']->getData();

            $trimestre = $formP['trimestre']->getData();
            $date_ddr = $formP['date_ddr']->getData();
            $date_echo = $formP['date_echo']->getData();
            $age_grossesse_semaines = $formP['age_grossesse_semaines']->getData();
            $age_grossesse_jours = $formP['age_grossesse_jours']->getData();
            $date_deb_concep = $formP['date_deb_concep']->getData();
            $type_grossesse = $formP['type_grossesse']->getData();
            $LCC_PBD = $formP['LCC_PBD']->getData();
            $LCC_PBD_value = $formP['LCC_PBD_value']->getData();
            $Clarte_nucale = $formP['Clarte_nucale']->getData();

            $reference = $formP['reference']->getData();

            if ($ddn == NULL) {
                $message="Veuillez remplir la date de naissance du patient";

                return $this->render('Default/createP.html.twig', [

                    'formP' => $formP->createView(),
                    'message' => $message]);
            }

            if ($ordenance == NULL) {
                $message="Veuillez remplir la date de l'ordonance du patient";

                return $this->render('Default/showE.html.twig', [

                    'formP' => $formP->createView(),
                    'message' => $message]);
            }

            $user = $this->getUser();

            if($origine == NULL){
                $patient->setOrigine('24');
            }else {
                $patient->setOrigine($origine);
            }
        
        if($date_echo != NULL){

                if($date_ddr != NULL){
                    $patient->setMethodeDatation('DDR');
                }
                if ($age_grossesse_semaines != NULL && $age_grossesse_jours != NULL){
                        $patient->setMethodeDatation('Date début grossesse');
                    };
                if($date_deb_concep != NULL){
                    $patient->setMethodeDatation('Date de conception');
                }else {
                    $patient->setMethodeDatation('Date echographique');
                }
        }
            else
                {
                    $patient->setMethodeDatation(NULL);
                };
            

            $patient->setNom($Nom)
                    ->setPrenom($Prenom)
                    ->setCivilite($civilite)
                    ->setSexe($sexe)
                    ->setDateDeNaissance($ddn)
                    ->setTypeTube($tube)
                    ->setNbTube($nbTube)
                    ->setTypeDossier($type_dossier)
                    ->setTrimestre($trimestre)
                    ->setTypeGrossesse($type_grossesse)
                    ->setDateDebConcep($date_deb_concep)
                    ->setAgeGrossesseJours($age_grossesse_jours)
                    ->setAgeGrossesseSemaines($age_grossesse_semaines)
                    ->setAntecedentT1813($antecedentT18_13)
                    ->setAntecedentMTN($antecedentMTN)
                    ->setAntecedentT21($antecedentT21)
                    ->setDiabetique($diabetique)
                    ->setFiv($fiv)
                    ->setTabagisme($tabagisme)
                    ->setDatePrelevement($datePrelevement)
                    ->setLCCPBD($LCC_PBD)
                    ->setLCCPBDValue($LCC_PBD_value)
                    ->setClarteNucale($Clarte_nucale)
                    ->setReference($reference)
                    ->setUser($user);

            
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();

            $this->addFlash('message','Action terminée avec succès');

            return $this->RedirectToRoute('ListePatient');

        }
        return $this->render('createP.html.twig', [

            'formP' => $formP->createView(),
            'message' => $message]);
    }

    public function showPAction($id) {

        $patient = $this->getDoctrine()->getRepository('AppBundle:Patient')->find($id);

        return $this->render('showP.html.twig', ['patient' => $patient]);

    }

    public function validePAction($id) {

        $em = $this->getDoctrine()->getManager();
        $patient = $em->getRepository('AppBundle:Patient')->find($id);
       
        $patient->setStatus("Traite");

        $em->persist($patient);
        $em->flush();

        $this->addFlash('message','Le dossier est traité avec succès');

        return $this->RedirectToRoute('ListePatient');
        
    }

    public function searchPAction(Request $request) {
        
        $q = $request->query->get('q','all');
        
        $patients = $this->get('service')->getPatients(array('keyword' => $q)); 

        $paginator=$this->get('knp_paginator');

        $result=$paginator->paginate(
            $patients,
            $request->query->get('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('ListePatients.html.twig', [
            'patients' => $result
            ]);
    }

    public function deletePAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $patient = $em->getRepository('AppBundle:Patient')->find($id);

        $em->remove($patient);
        $em->flush();
        $this->addFlash('message','Patient supprimé avec succès');

        return $this->RedirectToRoute('ListePatient');
    }

      public function listePatientAction(Request $request) {
        
        $q = $request->query->get('q','all');
    
        $patients=$this->get('service')
        ->getPatients(array('order'=>'createdAt','keyword'=>$q));

        $paginator=$this->get('knp_paginator');

        $result=$paginator->paginate(
            $patients,
            $request->query->get('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('ListePatients.html.twig', [
            'patients' => $result
            ]);
    }

    public function createEAction(Request $request, $id = null) {

         $em = $this->getDoctrine()->getManager();

        if ($id == null) {
            $examen = new Examen();
        }

        else {
            $examen = $em->getRepository('AppBundle:Examen')->findOneById($id); 
        }

        $formE = $this->createFormBuilder($examen)

            ->add('titre', TextType::class, array('label' => 'Titre Examen', 'required'  => true,'attr' => array('class' =>'form-control')))
            ->add('description', TextType::class, array('label' => 'Description examen', 'required'  => true,'attr' => array('class' =>'form-control')))
            ->add('code', TextType::class, array('label' => 'code Examen', 'required'   => true,'attr' => array('class' =>'form-control')))
      
            
            ->getForm();

        $formE->handleRequest($request);

        if($formE->isSubmitted() && $formE->isValid() )
        {
            $titre = $formE ['titre']->getData();
            $code = $formE ['code']->getData();
            $description = $formE ['description']->getData();

          

            $examen->setTitre($titre)
                    ->setCode($code)
                    ->setDescription($description);


            $em = $this->getDoctrine()->getManager();
            $em->persist($examen);
            $em->flush();

            $this->addFlash('message','Examen enregistré avec succès');

            return $this->RedirectToRoute('listeExamen');

        }
        
        return $this->render('createE.html.twig', [

            'formE' => $formE->createView()]);
    }
    
    public function showEAction($id) {

        $examen = $this->getDoctrine()->getRepository('AppBundle:Examen')->find($id);

        return $this->render('showE.html.twig', ['examen' => $examen]);

    }

    public function deleteEAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $examen = $em->getRepository('AppBundle:Examen')->find($id);

        $em->remove($examen);
        $em->flush();
        $this->addFlash('message','Examen supprimé avec succès');

        return $this->RedirectToRoute('ListeExamen');
    }

    public function listeExamenAction(Request $request) {
        
        $q = $request->query->get('q','all');
        $examens=$this->get('service')->getExams(array('keyword' => $q)); 

        $paginator=$this->get('knp_paginator');

        $result=$paginator->paginate(
            $examens,
            $request->query->get('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('ListeExamens.html.twig', [
            'examens' => $result
            ]);
    }

    public function searchEAction(Request $request) {
        
        $q = $request->query->get('q','all');
        
        $examens = $this->get('service')->getExams(array('keyword' => $q)); 

        $paginator=$this->get('knp_paginator');

        $result=$paginator->paginate(
            $examens,
            $request->query->get('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('ListeExamens.html.twig', [
            'examens' => $result
            ]);
    
}


public function updatePAction(Request $request, $id) {


    $em = $this->getDoctrine()->getManager();


    $patient = $em->getRepository('AppBundle:Patient')->findOneById($id); 


    $information = array('MOROCCAN'=>'02','CATALAN'=>'03',
    'ANDALUSIAN'=>'04','BASQUE'=>'05',
    'GALICIAN'=>'06','GYPSY'=>'07',
    'GAMBIAN'=>'08','NORTH-EUROPEAN'=>'09',
    'CENTER-EUROPEAN'=>'10','SOUTH-EUROPEAN'=>'11','ANGLO-SAXON'=>'12',
    'EAST-EUROPEAN'=>'13','HINDU-PAKISTAN'=>'14','CHINESE'=>'16','JAPANESE'=>'17','PHILIPPINE'=>'18','NORTH-AMERICAN'=>'19','SOUTH-AMERICAN'=>'20','AFRO-CARIBBEAN'=>'21','SOUTH-AFRICAN'=>'22','CENTER-AFRICAN'=>'23','NORTH-AFRICAN'=>'24','GUINEAN'=>'25','EST-AFRICAN'=>'26','PORTUGUESE'=>'28','CANARIAN'=>'29','BALEARIC'=>'30','IBERIAN'=>'31','Autres'=>'01');

    $formP = $this->createFormBuilder($patient)

        ->add('nom', TextType::class, array('label' => 'Nom Patient', 'required'  => true,'attr' => array('class' =>'form-control')))
        ->add('reference', TextType::class, array('label' => 'reference Patient', 'required'  => true,'attr' => array('class' =>'form-control')))
        ->add('prenom', TextType::class, array('label' => 'Prenom Patient', 'required'   => true,'attr' => array('class' =>'form-control')))
        ->add('sexe',ChoiceType::class, array(
            'mapped'=>false,
            'multiple'=>false,
            'expanded'=>true,
            'data'=> $patient->getSexe(),
            'choices' => [
                'Sexe' => [
                    'Masculin' => 'Masculin',
                    'Feminin' => 'Feminin',
            ]],
            'attr' => array('class' =>'choice')
        ))
        ->add('civilite',ChoiceType::class, array(
            'mapped'=>false,
            'multiple'=>false,
            'expanded'=>true,
            'data'=> $patient->getCivilite(),
            'choices' => [
                'civilite' => [
                    'Enfant' => 'Enfant',
                    'Mademoiselle' =>'Mademoiselle',
                    'Dame' => 'Dame',
                    'Monsieur' => 'Monsieur',
            ]],
            'attr' => array('class' =>'choice')
        ))
        ->add('dateDeNaissance', BirthdayType::class, array('label' => 'Date de naissance', 'required'  => false,'attr' => array('class' =>'form-control')))

        ->add('datePrelevement', DateType::class, array('label' => 'date de prelevement', 'required'  => false,'attr' => array('class' =>'form-control')))
        
        ->add('nomPrenomMed', TextType::class, array('label' => 'Nom Medecin', 'required'  => true,'attr' => array('class' =>'form-control')))
        ->add('telMed', IntegerType::class, array('label' => 'Tel Medecin', 'required'  => false,'attr' => array('class' =>'form-control')))
        ->add('adressMed', TextType::class, array('label' => 'Adresse Medecin', 'required'  => false,'attr' => array('class' =>'form-control')))

        ->add('taille', TextType::class, array('label' => 'Taille Patient (cm)', 'required'  => false,'attr' => array('class' =>'form-control')))
        ->add('poids', TextType::class, array('label' => 'poids Patient (Kg)', 'required'  => false,'attr' => array('class' =>'form-control')))

        ->add('Examen', EntityType::class, array('label' => 'Examen (s)', 'required'   => true,'multiple'=>true,
        'class' => 'AppBundle:Examen', 'placeholder'=>'Aucun','attr'=> array('class'=> 'trisomie select2 select2-container select2-container--default')))

        ->add('type_tube',ChoiceType::class, array(
            'label' => 'Type tube',
            'mapped'=>false,
            'multiple'=>false,
            'expanded'=>true,
            'placeholder' => false,
            'data'=> $patient->getTypeTube(),
            'choices' => [
                'Type tube' => [
                    'Congelé' => 'Congelé',
                    'Réfrigéré' => 'Réfrigéré',
                    'Ambiant' => 'Ambiant'
            ]],
            'attr' => array('class' =>'choice')
        ))
        ->add('type_dossier',ChoiceType::class, array(
            'label' => 'Type dossier',
            'placeholder' => false,
            'mapped'=>false,
            'multiple'=>false,
            'expanded'=>true,
            'data'=> $patient->getTypeDossier(),
            'choices' => [
                'Type tube' => [
                    'Normal' => 'Normal',
                    'Urgent' => 'Urgent'
            ]],
            'attr' => array('class' =>'choice')
        ))

        ->add('nb_tube', IntegerType::class, array('label' => 'Nombre de tubes', 'required'  => true,'attr' => array('class' =>'form-control')))

        ->add('traitement', TextareaType::class, array('label' => 'Traitement', 'required'  => false,'attr' => array('class' =>'form-control')))
        
        ->add('commentaires', TextareaType::class, array('label' => 'Commentaires', 'required'  => false,'attr' => array('class' =>'form-control')))

        ->add('origine', ChoiceType::class, array('label' => 'Origine','choices'=>$information, 'placeholder' => 'NORTH-AFRICAN' ,'required'=>false,  'attr'=> array('class'=> 'trisomie select2 select2-container select2-container--default')))


        ->add('tabagisme',ChoiceType::class, array(
            'placeholder' => false,
            'mapped'=>false,
            'multiple'=>false,
            'expanded'=>true,
            'data'=> $patient->getTabagisme(),
            'choices' => [
                'Type tube' => [
                    'oui' => 'oui',
                    'non' => 'non'
            ]],
            'attr' => array('class' =>'choice')
        ))

        ->add('fiv',ChoiceType::class, array(
            'mapped'=>false,
            'multiple'=>false,
            'required' => false,
            'expanded'=>true,
            'placeholder' => false,
            'data'=> $patient->getFiv(),
            'choices' => [
                'FIV' => [
                    'oui' => 'oui',
                    'non' => 'non'
            ]]
        ))

        ->add('diabetique',ChoiceType::class, array(
            'mapped'=>false,
            'multiple'=>false,
            'required' => false,
            'expanded'=>true,
            'placeholder' => false,
            'data'=> $patient->getDiabetique(),
            'choices' => [
                'diabetique' => [
                    'oui' => 'oui',
                    'non' => 'non',
                    
            ]]
        ))

        ->add('antecedentT18_13',ChoiceType::class, array(
            'label' => 'antecedent T18/13',
            'mapped'=>false,
            'multiple'=>false,
            'required' => false,
            'expanded'=>true,
            'placeholder' => false,
            'data'=> $patient->getAntecedentT1813(),
            'choices' => [
                'antecedentT18_13' => [
                    'oui' => 'oui',
                    'non' => 'non',
                    'indéterminé' => 'indéterminé'
            ]]
        ))

        ->add('antecedentT21',ChoiceType::class, array(
            'mapped'=>false,
            'label' => 'antecedent T21',
            'multiple'=>false,
            'required' => false,
            'expanded'=>true,
            'placeholder' => false,
            'data'=> $patient->getAntecedentT21(),
            'choices' => [
                'antecedentT21' => [
                    'oui' => 'oui',
                    'non' => 'non',
                    'indéterminé' => 'indéterminé'

            ]]
        ))

        ->add('antecedentMTN',ChoiceType::class, array(
            'mapped'=>false,
            'label' => 'antecedent MTN',
            'multiple'=>false,
            'required' => false,
            'expanded'=>true,
            'placeholder' => false,
            'data'=> $patient->getAntecedentMTN(),
            'choices' => [
                'antecedentMTN' => [
                    'oui' => 'oui',
                    'non' => 'non',
                    'indéterminé' => 'indéterminé'

            ]]
        ))

        ->add('trimestre',ChoiceType::class, array(
            'mapped'=>false,
            'multiple'=>false,
            'required' => false,
            'expanded'=>true,
            'placeholder' => false,
            'data'=> $patient->getTrimestre(),
            'choices' => [
                'trimestre' => [
                    'Trimestre 1' => '1',
                    'Trimestre 2' => '2'
            ]]
        ))

        ->add('foetus', IntegerType::class, array('label' => 'foetus', 'required'  => false,'attr' => array('class' =>'form-control', 'placeholder'=>'nombre de foetus')))

        ->add('date_ddr', DateType::class, array('label' => 'Date du dernier prélevement', 'required'  => false,'attr' => array('class' =>'form-control')))

        ->add('date_echo', DateType::class, array('label' => 'date echographique', 'required'  => false,'attr' => array('class' =>'form-control')))

        ->add('age_grossesse_semaines', IntegerType::class, array('label' => 'age de grossesse en semaines', 'required'  => false,'attr' => array('class' =>'form-control')))

        
        ->add('age_grossesse_jours', IntegerType::class, array('label' => 'age de grossesse en jours', 'required'  => false,'attr' => array('class' =>'form-control')))

        
        ->add('date_deb_concep', DateType::class, array('label' => 'date de début de conception', 'required'  => false,'attr' => array('class' =>'form-control')))

        ->add('type_grossesse',ChoiceType::class, array(
            'label' => 'Type grossesse',
            'mapped'=>false,
            'placeholder' => false,
            'multiple'=>false,
            'required' => false,
            'expanded'=>true,
            'data'=> $patient->getTypeGrossesse(),
            'choices' => [
                'Type tube' => [
                    'Spontanée' => 'Spontanée',
                    'FIV' => 'FIV',
                    'ICSI' => 'ICSI',
                    'Don d\'ovule' => 'Don ovule'
            ]]
        ))

        ->add('LCC_PBD',ChoiceType::class, array(
            'mapped'=>false,
            'multiple'=>false,
            'label' => 'LCC/PBD',
            'required' => false,
            'expanded'=>true,
            'data'=> $patient->getLCCPBD(),
            'placeholder'=> false,
            'choices' => [
                ' ' => [
                    'LCC' => 'LCC',
                    'PBD' => 'PBD'
                    
            ]]
        ))

        ->add('LCC_PBD_value', TextType::class, array( 'label' => 'Valeur','required' => false,'attr' => array('class' =>'form-control')))


        ->add('Clarte_nucale', TextType::class, array('label' => 'Clarte nucale ', 'required' => false,'attr' => array('class' =>'form-control')))

        ->add('ordenance', DateType::class, array('label' => 'ordonnance', 'required'  => false,'attr' => array('class' =>'form-control')))

        ->add('save', SubmitType::class, array('label' =>'Ajouter', 'attr' => array('class' =>'btn btn-primary', 'style' => 'margin-bottom : 20px ; margin-top : 15px')))
        
        ->getForm();

    $formP->handleRequest($request);

  if($formP->isSubmitted() && $formP->isValid() )
        {
            $patient->setCreatedAt(new \DateTime());

            $Nom = $formP ['nom']->getData();
            $Prenom = $formP ['prenom']->getData();
            $civilite = $formP ['civilite']->getData();
            $sexe = $formP ['sexe']->getData();
            $ddn = $formP ['dateDeNaissance']->getData();

            $tube =$formP['type_tube']->getData();
            $nbTube =$formP['nb_tube']->getData();
            $type_dossier = $formP['type_dossier']->getData();
            $ordenance = $formP['ordenance']->getData();
            $traitement = $formP['traitement']->getData();
            $commentaires = $formP['commentaires']->getData();
            $datePrelevement = $formP['datePrelevement']->getData();

            $origine = $formP['origine']->getData();
            $tabagisme = $formP['tabagisme']->getData();
            $fiv = $formP['fiv']->getData();
            $diabetique = $formP['diabetique']->getData();
            $antecedentT18_13 = $formP['antecedentT18_13']->getData();
            $antecedentT21 = $formP['antecedentT21']->getData();
            $antecedentMTN = $formP['antecedentMTN']->getData();

            $foetus = $formP['foetus']->getData();

            $trimestre = $formP['trimestre']->getData();
            $date_ddr = $formP['date_ddr']->getData();
            $date_echo = $formP['date_echo']->getData();
            $age_grossesse_semaines = $formP['age_grossesse_semaines']->getData();
            $age_grossesse_jours = $formP['age_grossesse_jours']->getData();
            $date_deb_concep = $formP['date_deb_concep']->getData();
            $type_grossesse = $formP['type_grossesse']->getData();
            $LCC_PBD = $formP['LCC_PBD']->getData();
            $LCC_PBD_value = $formP['LCC_PBD_value']->getData();
            $Clarte_nucale = $formP['Clarte_nucale']->getData();

            $reference = $formP['reference']->getData();

            if ($ddn == NULL) {
                $message="Veuillez remplir la date de naissance du patient";

                return $this->render('Default/createP.html.twig', [

                    'formP' => $formP->createView(),
                    'message' => $message]);
            }

            if ($ordenance == NULL) {
                $message="Veuillez remplir la date de l'ordonance du patient";

                return $this->render('Default/showE.html.twig', [

                    'formP' => $formP->createView(),
                    'message' => $message]);
            }

            $user = $this->getUser();

            if($origine == NULL){
                $patient->setOrigine('24');
            }else {
                $patient->setOrigine($origine);
            }

            if($date_echo != NULL){

                if($date_ddr != NULL){
                    $patient->setMethodeDatation('DDR');
                }
                if ($age_grossesse_semaines != NULL && $age_grossesse_jours != NULL){
                        $patient->setMethodeDatation('Date début grossesse');
                    };
                if($date_deb_concep != NULL){
                    $patient->setMethodeDatation('Date de conception');
                }else {
                    $patient->setMethodeDatation('Date echographique');
                }
        }
            else
                {
                    $patient->setMethodeDatation(NULL);
                };
            
            

            $patient->setNom($Nom)
                    ->setPrenom($Prenom)
                    ->setCivilite($civilite)
                    ->setSexe($sexe)
                    ->setDateDeNaissance($ddn)
                    ->setTypeTube($tube)
                    ->setNbTube($nbTube)
                    ->setTypeDossier($type_dossier)
                    ->setTrimestre($trimestre)
                    ->setTypeGrossesse($type_grossesse)
                    ->setDateDebConcep($date_deb_concep)
                    ->setAgeGrossesseJours($age_grossesse_jours)
                    ->setAgeGrossesseSemaines($age_grossesse_semaines)
                    ->setAntecedentT1813($antecedentT18_13)
                    ->setAntecedentMTN($antecedentMTN)
                    ->setAntecedentT21($antecedentT21)
                    ->setDiabetique($diabetique)
                    ->setFiv($fiv)
                    ->setTabagisme($tabagisme)
                    ->setDatePrelevement($datePrelevement)
                    ->setLCCPBD($LCC_PBD)
                    ->setLCCPBDValue($LCC_PBD_value)
                    ->setClarteNucale($Clarte_nucale)
                    ->setReference($reference)
                    ->setUser($user);

            $id = $patient->getId();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();

            $this->addFlash('message','Action terminée avec succès');

            return $this->RedirectToRoute('ListePatient');

        }
    
    return $this->render('patientEdit.html.twig', [

        'formP' => $formP->createView(),
        'patient' => $patient]);
}

public function addUserAction(Request $request, $id= null) {

    $em=$this->getDoctrine()->getManager();

    if ($id==null){
        $admin=new User();
        }

    else {

        $admin=$em->getRepository('AppBundle:User')->findOneById($id); 
    }

    $adminForm= $this->createForm(UserType::class,$admin);
    $adminForm->handleRequest($request);
    $message="";

    if ($adminForm->isSubmitted()&& $adminForm->isValid()) {

            $username = $adminForm->get('username')->getData();
            $email = $adminForm->get('email')->getData();
            $password = $adminForm->get('password')->getData();
            $reference = $adminForm->get('reference')->getData();
            $nomLabo = $adminForm->get('nomLabo')->getData();

            $compte=$this->getDoctrine()->getRepository('AppBundle:User')
            ->findBy([
                'username' => $username
            ]);
            
            
            foreach ($compte as $compte ) {
             
            if ($compte->getUsername()==$username) {
                $message="Le nom du compte doit être unique !";
                return $this->render('addUser.html.twig', array(
                    'message' => $message,
                    'form' => $adminForm->createView(),
                ));
            }
        }

        $can_email=$email;

        $mail=$this->getDoctrine()->getRepository('AppBundle:User')
        ->findBy([
            'email' => $email
        ]);
        
        
        foreach ($mail as $mail ) {
         
            if ($mail->getEmail() == $mail || $mail->getEmailCanonical() == $can_email ) {
                $message= "L'adresse mail doit être unique !";
                return $this->render('addUser.html.twig', array(
                    'message' => $message,
                    'form' => $adminForm->createView(),
                ));
            }
    }
     
            $admin->setusername($username)
                ->setEmail($email)
                ->setReference($reference)
                ->setNomLabo($nomLabo)
                ->setPlainPassword($password);

            $em->persist($admin);
            $em->flush();

            $this->addFlash(
                'success',
                'Un nouveau utilisateur est ajouté avec succès');
                return $this->RedirectToRoute('listeUtilisateurs');

        }

    return $this->render('addUser.html.twig', array(
        'form' => $adminForm->createView(),
        'message' => $message
    ));

}

    public function listeUtilisateursAction(Request $request) {

        $q = $request->query->get('q','all');

        $users=$this->get('service')->getUsers(array('order'=>'username','keyword'=>$q));

        $paginator=$this->get('knp_paginator');

        $result=$paginator->paginate(
            $users,
            $request->query->get('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('listeUtilisateurs.html.twig', [
            'users' => $result
            ]);

    }

    public function updateUserAction(Request $request ,$id) {

        $userManager = $this->get('fos_user.user_manager');
        $admin = $userManager->findUserBy(array('id'=> $id)); // get user by id
 
        $adminForm= $this->createForm(UserType::class,$admin);
        $adminForm->handleRequest($request);
        $message="";
    
        if ($adminForm->isSubmitted()&& $adminForm->isValid()) {
    
                $username = $adminForm->get('username')->getData();
                $email = $adminForm->get('email')->getData();
                $password = $adminForm->get('password')->getData();
                $reference = $adminForm->get('reference')->getData();
                $nomLabo = $adminForm->get('nomLabo')->getData();
                
                $admin->setusername($username)
                ->setEmail($email)
                ->setReference($reference)
                ->setNomLabo($nomLabo)
                ->setPlainPassword($password);


        $userManager->updateUser($admin);

        return $this->redirectToRoute('listeUtilisateurs');
    }

    return $this->render('addUser.html.twig', array(
        'form' => $adminForm->createView(),
        'message' => $message
    ));

    }

    public function deleteUserAction($id) {

        $em= $this->getDoctrine()->getManager();

        $admin=$em->getRepository('AppBundle:User')->findOneById($id);

        $em->remove($admin);
        $em->flush();
        $this->addFlash(
            'success',
            'La supression de l\'utilisateur est achevée evec succès');

        return $this->redirectToRoute('listeUtilisateurs');
    }
public function updateEAction(Request $request, $id = null) {

        $em = $this->getDoctrine()->getManager();

        $examen = $em->getRepository('AppBundle:Examen')->findOneById($id); 

        $examen->setTitre($examen->getTitre());
        $examen->setDescription($examen->getDescription());
        $examen->setCode($examen->getCode());

        $formE = $this->createFormBuilder($examen)

            ->add('titre', TextType::class, array('label' => 'Titre Examen', 'required'  => true,'attr' => array('class' =>'form-control')))
            ->add('description', TextType::class, array('label' => 'Description examen', 'required'  => true,'attr' => array('class' =>'form-control')))
            ->add('code', TextType::class, array('label' => 'code Examen', 'required'   => true,'attr' => array('class' =>'form-control')))
            ->add('save', SubmitType::class, array('label' =>'Ajouter', 'attr' => array('class' =>'btn btn-primary', 'style' => 'margin-bottom : 20px ; margin-top : 15px')))
            
            ->getForm();

        $formE->handleRequest($request);

        if($formE->isSubmitted() && $formE->isValid() )
        {
            $titre = $formE ['titre']->getData();
            $code = $formE ['code']->getData();
            $description = $formE ['description']->getData();

          

            $examen->setTitre($titre)
                    ->setCode($code)
                    ->setDescription($description);


            $em = $this->getDoctrine()->getManager();
            $em->persist($examen);
            $em->flush();

            $this->addFlash('message','Examen mis à jour avec succès');

            $r= new Request();
            $this->listeExamenAction($r);
    
        }
        
        return $this->render('updateE.html.twig', [
    
            'formE' => $formE->createView(),
            'examen' => $examen]);
    }
}