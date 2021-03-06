<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->roles = array('ROLE_USER');
    }

     /**
    * @ORM\Column(name="nom_labo", type="string", length=255, nullable=true)
    */
    protected $nom_labo;

     /**
    * @ORM\Column(name="reference", type="string", length=255, nullable=true)
    */
    protected $reference;

    /**
     * Set nomLabo
     *
     * @param string $nomLabo
     *
     * @return User
     */
    public function setNomLabo($nomLabo)
    {
        $this->nom_labo = $nomLabo;

        return $this;
    }

    /**
     * Get nomLabo
     *
     * @return string
     */
    public function getNomLabo()
    {
        return $this->nom_labo;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return User
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
}
