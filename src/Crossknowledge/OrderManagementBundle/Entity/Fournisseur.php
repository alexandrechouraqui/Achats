<?php

namespace Crossknowledge\OrderManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crossknowledge\OrderManagementBundle\Entity\Fournisseur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Crossknowledge\OrderManagementBundle\Entity\FournisseurRepository")
 */
class Fournisseur {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $codeFournisseur
     *
     * @ORM\Column(name="codeFournisseur", type="string", length=255)
     */
    private $codeFournisseur;

    /**
     * @var string $typeFournisseur
     *
     * @ORM\Column(name="typeFournisseur", type="string", length=255)
     */
    private $typeFournisseur;

    /**
     * @var string $raisonSociale
     *
     * @ORM\Column(name="raisonSociale", type="string", length=255)
     */
    private $raisonSociale;

    /**
     * @var string $contact
     *
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact;
    
    /**
     * @var string $telephone
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    private $telephone;
    
    /**
     * @var string $mail
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=true)
     */
    private $mail;
    

    /**
     * @var text $adresseFacturation
     *
     * @ORM\Column(name="adresseFacturation", type="text")
     */
    private $adresseFacturation;

    /**
     * @var float $caCommande
     *
     * @ORM\Column(name="caCommande", type="float")
     */
    private $caCommande;

    /**
     * @var float $caLettre
     *
     * @ORM\Column(name="caLettre", type="float", nullable=true)
     */
    private $caLettre;
    
    /**
     * @var string $devise
     *
     * @ORM\Column(name="devise", type="string", nullable=true)
     */
    private $devise;

    /**
     * @ORM\OneToMany(targetEntity="Tarif", mappedBy="fournisseur",orphanRemoval=false)
     */
    protected $tarifs;

    /**
     * @ORM\OneToMany(targetEntity="Commande", mappedBy="fournisseur",orphanRemoval=false)
     */
    protected $commandes;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set codeFournisseur
     *
     * @param string $codeFournisseur
     */
    public function setCodeFournisseur($codeFournisseur) {
        $this->codeFournisseur = $codeFournisseur;
    }

    /**
     * Get codeFournisseur
     *
     * @return string 
     */
    public function getCodeFournisseur() {
        return $this->codeFournisseur;
    }

    /**
     * Set typeFournisseur
     *
     * @param string $typeFournisseur
     */
    public function setTypeFournisseur($typeFournisseur) {
        $this->typeFournisseur = $typeFournisseur;
    }

    /**
     * Get typeFournisseur
     *
     * @return string 
     */
    public function getTypeFournisseur() {
        return $this->typeFournisseur;
    }

    /**
     * Set raisonSociale
     *
     * @param string $raisonSociale
     */
    public function setRaisonSociale($raisonSociale) {
        $this->raisonSociale = $raisonSociale;
    }

    /**
     * Get raisonSociale
     *
     * @return string 
     */
    public function getRaisonSociale() {
        return $this->raisonSociale;
    }

    /**
     * Set contact
     *
     * @param string $contact
     */
    public function setContact($contact) {
        $this->contact = $contact;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact() {
        return $this->contact;
    }
    
    /**
     * Set telephone
     *
     * @param string $telephone
     */
    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone() {
        return $this->telephone;
    }
    
    /**
     * Set mail
     *
     * @param string $mail
     */
    public function setMail($mail) {
        $this->mail = $mail;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail() {
        return $this->mail;
    }

    /**
     * Set adresseFacturation
     *
     * @param text $adresseFacturation
     */
    public function setAdresseFacturation($adresseFacturation) {
        $this->adresseFacturation = $adresseFacturation;
    }

    /**
     * Get adresseFacturation
     *
     * @return text 
     */
    public function getAdresseFacturation() {
        return $this->adresseFacturation;
    }

    /**
     * Set caCommande
     *
     * @param float $caCommande
     */
    public function setCaCommande($caCommande) {
        $this->caCommande = $caCommande;
    }

    /**
     * Get caCommande
     *
     * @return float 
     */
    public function getCaCommande() {
        return $this->caCommande;
    }

    /**
     * Set caLettre
     *
     * @param float $caLettre
     */
    public function setCaLettre($caLettre) {
        $this->caLettre = $caLettre;
    }

    /**
     * Get caLettre
     *
     * @return float 
     */
    public function getCaLettre() {
        return $this->caLettre;
    }
    
    /**
     * Get devise
     *
     * @return string
     */
    public function setDevise($devise)
    {
        $this->devise = $devise;
    }
    
    /**Set devise
     *
     * @return string 
     */
    public function getDevise()
    {
        return $this->devise;
    }

    public function __toString() {
        return $this->codeFournisseur;
    }

}