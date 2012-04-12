<?php

namespace Crossknowledge\OrderManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crossknowledge\OrderManagementBundle\Entity\Tarif
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Crossknowledge\OrderManagementBundle\Entity\TarifRepository")
 */
class Tarif
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float $prix
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var float $ancienPrix
     *
     * @ORM\Column(name="ancienPrix", type="float")
     */
    private $ancienPrix;
    
    /**
     * @var float $tva
     *
     * @ORM\Column(name="tva", type="float")
     */
    private $tva;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crossknowledge\OrderManagementBundle\Entity\Fournisseur",inversedBy="tarifs",cascade={"persist"})
     */
    private $fournisseur;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crossknowledge\OrderManagementBundle\Entity\Article", inversedBy="tarifs",cascade={"persist"})
     */
    private $article;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set prix
     *
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * Get prix
     *
     * @return float 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set ancienPrix
     *
     * @param float $ancienPrix
     */
    public function setAncienPrix($ancienPrix)
    {
        $this->ancienPrix = $ancienPrix;
    }

    /**
     * Get ancienPrix
     *
     * @return float 
     */
    public function getAncienPrix()
    {
        return $this->ancienPrix;
    }
    
    /**
     * Set TVA
     *
     * @param float $tva
     */
    public function setTva($tva)
    {
        $this->tva = $tva;
    }

    /**
     * Get ancienPrix
     *
     * @return float 
     */
    public function getTva()
    {
        return $this->tva;
    }
    
    /**
     * Set Fournisseur
     * 
     * @param \Crossknowledge\OrderManagementBundle\Entity\Fournisseur $fournisseur 
     */
    public function setFournisseur (\Crossknowledge\OrderManagementBundle\Entity\Fournisseur $fournisseur)
    {
        $this->fournisseur = $fournisseur;
    }

    /**
     * Get Fournisseur
     * 
     * @return \Crossknowledge\OrderManagementBundle\Entity\Fournisseur 
     */
    public function getFournisseur()
    {
            return $this->fournisseur;
    }
    
    /**
     * Set Article
     * 
     * @param \Crossknowledge\OrderManagementBundle\Entity\Article $article 
     */
    public function setArticle (\Crossknowledge\OrderManagementBundle\Entity\Article $article)
    {
        $this->article = $article;
    }
    
    /**
     * Get Article
     * 
     * @return \Crossknowledge\OrderManagementBundle\Entity\Article 
     */
    public function getArticle()
    {
            return $this->article;
    }
}