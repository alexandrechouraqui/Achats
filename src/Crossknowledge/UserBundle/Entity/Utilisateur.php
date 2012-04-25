<?php

namespace Crossknowledge\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateur")
 */
class Utilisateur extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string nom
     *
     * @ORM\Column(name="nom", type="string", nullable=true)
     */
    protected $nom;
    
    /**
     * @var prenom $prenom
     *
     * @ORM\Column(name="prenom", type="string", nullable=true)
     */
    protected $prenom;
    
    /**
     * @var string $shortID
     *
     * @ORM\Column(name="shortid", type="string", nullable=true)
     */
    protected $shortID;
    
    /**
     * @var boolean $isManager
     *
     * @ORM\Column(name="isManager", type="boolean",nullable=true)
     */
    protected $isManager;
    
    /**
     * @var float $budget
     *
     * @ORM\Column(name="budget", type="float", nullable=true)
     * 
     */
    protected $budget;
    
    /**
     * @var float $budgetRestant
     *
     * @ORM\Column(name="budgetRestant", type="float", nullable=true)
     * 
     */
    protected $budgetRestant;
    
    /**
     * @ORM\OneToMany(targetEntity="Crossknowledge\OrderManagementBundle\Entity\DetailCommande", mappedBy="createdBy",orphanRemoval=false)
     */
    protected $createdBys;
    /**
     * @ORM\OneToMany(targetEntity="Crossknowledge\OrderManagementBundle\Entity\DetailCommande", mappedBy="createdBy",orphanRemoval=false)
     */
    protected $assignedTos;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
    /**
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
    
    /**
     *
     * @param type $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    
    /**
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
    
    /**
     *
     * @param type $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
    
    /**
     *
     * @return string 
     */
    public function getShortID()
    {
        return $this->shortID;
    }
    
    /**
     *
     * @param type $shortID
     */
    public function setShortID($shortID)
    {
        $this->shortID = $shortID;
    }
    
    /**
     *
     * @return float 
     */
    public function getBudget()
    {
        return $this->budget;
    }
    
    /**
     *
     * @param type $budget 
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }
    
    /**
     *
     * @return float 
     */
    public function getBudgetRestant()
    {
        return $this->budgetRestant;
    }
    
    /**
     *
     * @param type $budget 
     */
    public function setBudgetRestant($budgetRestant)
    {
        $this->budgetRestant = $budgetRestant;
    }
    
    /**
     *
     * @return float 
     */
    public function getisManager()
    {
        return $this->isManager;
    }
    
    /**
     *
     * @param type $budget 
     */
    public function setisManager($isManager)
    {
        $this->isManager = $isManager;
    }
    
    public function __toString()
    {
        return $this->username;
    }
}