<?php

namespace Crossknowledge\OrderManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crossknowledge\OrderManagementBundle\Entity\DetailCommande
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Crossknowledge\OrderManagementBundle\Entity\DetailCommandeRepository")
 */
class DetailCommande {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string $BU
     *
     * @ORM\Column(name="BU", type="string", length=255)
     */
    private $BU;

    /**
     * @var string $designation
     *
     * @ORM\Column(name="designation", type="string", length=255)
     */
    private $designation;

    /**
     * @var boolean $lettrage
     *
     * @ORM\Column(name="lettrage", type="boolean", nullable=true)
     */
    private $lettrage;

    /**
     * @var integer $quantite
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var date $dateLivraison
     *
     * @ORM\Column(name="dateLivraison", type="date")
     */
    private $dateLivraison;

    /**
     * @var text $remarque
     *
     * @ORM\Column(name="remarque", type="text", nullable=true)
     */
    private $remarque;

    /**
     * @var boolean $accordBUM
     *
     * @ORM\Column(name="accordBUM", type="boolean", nullable=true)
     */
    private $accordBUM;

    /**
     * @var float $prixHT
     *
     * @ORM\Column(name="prixHT", type="float")
     */
    private $prixHT;
    
    /**
     * @var float $tva
     *
     * @ORM\Column(name="tva", type="float", nullable=true)
     */
    private $tva;

    /**
     * @var float $prixTTC
     *
     * @ORM\Column(name="prixTTC", type="float")
     */
    private $prixTTC;

    /**
     * @var string $client
     *
     * @ORM\Column(name="client", type="string", nullable=true)
     */
    private $client;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crossknowledge\OrderManagementBundle\Entity\Article", inversedBy="detailsCommande", cascade={"persist"})
     */
    protected $article;

    /**
     * @ORM\ManyToOne(targetEntity="Crossknowledge\OrderManagementBundle\Entity\Commande", inversedBy="detailsCommande", cascade={"persist"})
     */
    protected $commande;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crossknowledge\UserBundle\Entity\Utilisateur", inversedBy="createdBy", cascade={"persist"})
     */
    protected $createdBy;
    
    /**
     * @ORM\ManyToOne(targetEntity="Crossknowledge\UserBundle\Entity\Utilisateur", inversedBy="assignedTo", cascade={"persist"})
     */
    protected $assignedTo;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set BU
     *
     * @param string $bU
     */
    public function setBU($bU) {
        $this->BU = $bU;
    }

    /**
     * Get BU
     *
     * @return string 
     */
    public function getBU() {
        return $this->BU;
    }

    /**
     * Set designation
     *
     * @param string $designation
     */
    public function setDesignation($designation) {
        $this->designation = $designation;
    }

    /**
     * Get designation
     *
     * @return string 
     */
    public function getDesignation() {
        return $this->designation;
    }

    /**
     * Set lettrage
     *
     * @param boolean $lettrage
     */
    public function setLettrage($lettrage) {
        $this->lettrage = $lettrage;
    }

    /**
     * Get lettrage
     *
     * @return boolean 
     */
    public function getLettrage() {
        return $this->lettrage;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     */
    public function setQuantite($quantite) {
        $this->quantite = $quantite;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite() {
        return $this->quantite;
    }

    /**
     * Set dateLivraison
     *
     * @param date $dateLivraison
     */
    public function setDateLivraison($dateLivraison) {
        $this->dateLivraison = $dateLivraison;
    }

    /**
     * Get dateLivraison
     *
     * @return date 
     */
    public function getDateLivraison() {
        return $this->dateLivraison;
    }

    /**
     * Set remarque
     *
     * @param text $remarque
     */
    public function setRemarque($remarque) {
        $this->remarque = $remarque;
    }

    /**
     * Get remarque
     *
     * @return text 
     */
    public function getRemarque() {
        return $this->remarque;
    }

    /**
     * Set accordBUM
     *
     * @param boolean $accordBUM
     */
    public function setAccordBUM($accordBUM) {
        $this->accordBUM = $accordBUM;
    }

    /**
     * Get accordBUM
     *
     * @return boolean 
     */
    public function getAccordBUM() {
        return $this->accordBUM;
    }

    /**
     * Set prixHT
     *
     * @param float $prixHT
     */
    public function setPrixHT($prixHT) {
        $this->prixHT = $prixHT;
    }

    /**
     * Get prixHT
     *
     * @return float 
     */
    public function getPrixHT() {
        return $this->prixHT;
    }

    /**
     * Set Tva
     *
     * @param float $Tva
     */
    public function setTva($tva) {
        $this->tva = $tva;
    }

    /**
     * Get Tva
     *
     * @return float 
     */
    public function getTva() {
        return $this->tva;
    }
    /**
     * Set prixTTC
     *
     * @param float $prixTTC
     */
    public function setPrixTTC($prixTTC) {
        $this->prixTTC = $prixTTC;
    }

    /**
     * Get prixTTC
     *
     * @return float 
     */
    public function getPrixTTC() {
        return $this->prixTTC;
    }

    /**
     * Set client
     *
     * @param string $client
     */
    public function setClient($client) {
        $this->client = $client;
    }

    /**
     * Get client
     *
     * @return string 
     */
    public function getClient() {
        return $this->client;
    }
    
    /**
     * Set Artilce
     * 
     * @param \Crossknowledge\OrderManagementBundle\Entity\Article $article 
     */
    public function setArticle(\Crossknowledge\OrderManagementBundle\Entity\Article $article) {
        $this->article = $article;
    }

    /**
     * Get Article
     * 
     * @return \Crossknowledge\OrderManagementBundle\Entity\Article 
     */
    public function getArticle() {
        return $this->article;
    }

    /**
     *  Set Commande
     * 
     * @param \Crossknowledge\OrderManagementBundle\Entity\Commande $commande 
     */
    public function setCommande(\Crossknowledge\OrderManagementBundle\Entity\Commande $commande) {
        $this->commande = $commande;
    }

    /**
     * Get Commande
     * 
     * @return \Crossknowledge\OrderManagementBundle\Entity\Commande 
     */
    public function getCommande() {
        return $this->commande;
    }

    /**
     *  Set createdBy
     * 
     * @param \Crossknowledge\UserBundle\Entity\Utilisateur $createdBy 
     */
    public function setcreatedBy(\Crossknowledge\UserBundle\Entity\Utilisateur $createdBy) {
        $this->createdBy = $createdBy;
    }

    /**
     * Get CommandecreatedBy
     * 
     * @return \Crossknowledge\UserBundle\Entity\Utilisateur 
     */
    public function getcreatedBy() {
        return $this->createdBy;
    }
    
    /**
     *  Set assignedTo
     * 
     * @param \Crossknowledge\UserBundle\Entity\Utilisateur $assignedTo 
     */
    public function setassignedTo(\Crossknowledge\UserBundle\Entity\Utilisateur $assignedTo) {
        $this->assignedTo = $assignedTo;
    }

    /**
     * Get CommandeassignedTo
     * 
     * @return \Crossknowledge\UserBundle\Entity\Utilisateur 
     */
    public function getassignedTo() {
        return $this->assignedTo;
    }
    
}