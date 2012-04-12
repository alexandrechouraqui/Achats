<?php

namespace Crossknowledge\OrderManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crossknowledge\OrderManagementBundle\Entity\Commande
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Crossknowledge\OrderManagementBundle\Entity\CommandeRepository")
 */
class Commande {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $typeCommande
     *
     * @ORM\Column(name="typeCommande", type="string", length=255)
     * 
     */
    private $typeCommande;
    
    /**
     * @var string $designation
     *
     * @ORM\Column(name="designation", type="string", length=255, nullable=true)
     * 
     */
    private $designation;
    
    /**
     * @var string $typeOA
     *
     * @ORM\Column(name="typeOA", type="string", length=255, nullable=true)
     * 
     */
    private $typeOA;
    

    /**
     * @ORM\ManyToOne(targetEntity="Crossknowledge\OrderManagementBundle\Entity\Fournisseur", inversedBy="commandes",cascade={"persist"})
     */
    private $fournisseur;

    /**
     * @ORM\OneToMany(targetEntity="DetailCommande", mappedBy="commande",orphanRemoval=false)
     */
    protected $detailsCommande;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set typeCommande
     *
     * @param string $typeCommande
     */
    public function setTypeCommande($typeCommande) {
        $this->typeCommande = $typeCommande;
    }

    /**
     * Get typeCommande
     *
     * @return string 
     */
    public function getTypeCommande() {
        return $this->typeCommande;
    }
    
    /**
     * Set designation
     * 
     * @param string $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }
    
    /**
     * Get designation
     * 
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }
    
    /**
     * Set typeOA
     * 
     * @param string $typeOA
     */
    public function setTypeOA($typeOA)
    {
        $this->typeOA = $typeOA;
    }
    
    /**
     * Get typeOA
     * 
     * @return string
     */
    public function getTypeOA()
    {
        return $this->typeOA;
    }

    /**
     * Set Fournisseur
     * 
     * @param \Crossknowledge\OrderManagementBundle\Entity\Fournisseur $fournisseur 
     */
    public function setFournisseur(\Crossknowledge\OrderManagementBundle\Entity\Fournisseur $fournisseur) {
        $this->fournisseur = $fournisseur;
    }

    /**
     * Get Fournisseur
     * 
     * @return \Crossknowledge\OrderManagementBundle\Entity\Fournisseur
     */
    public function getFournisseur() {
        return $this->fournisseur;
    }

    public function __toString() {
        return $this->typeCommande;
    }

}