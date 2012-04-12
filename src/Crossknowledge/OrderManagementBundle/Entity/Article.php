<?php

namespace Crossknowledge\OrderManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crossknowledge\OrderManagementBundle\Entity\Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Crossknowledge\OrderManagementBundle\Entity\ArticleRepository")
 */
class Article
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
     * @var string $codeArticle
     *
     * @ORM\Column(name="codeArticle", type="string", length=255)
     */
    private $codeArticle;

    /**
     * @var string $typeArticle
     *
     * @ORM\Column(name="typeArticle", type="string", length=255)
     */
    private $typeArticle;
    
    /**
     * @ORM\OneToMany(targetEntity="Tarif", mappedBy="article",orphanRemoval=false)
     */
    protected $tarifs;
    
    /**
     * @ORM\OneToMany(targetEntity="DetailCommande", mappedBy="article",orphanRemoval=false)
     */
    protected $detailsCommande;


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
     * Set codeArticle
     *
     * @param string $codeArticle
     */
    public function setCodeArticle($codeArticle)
    {
        $this->codeArticle = $codeArticle;
    }

    /**
     * Get codeArticle
     *
     * @return string 
     */
    public function getCodeArticle()
    {
        return $this->codeArticle;
    }

    /**
     * Set typeArticle
     *
     * @param string $typeArticle
     */
    public function setTypeArticle($typeArticle)
    {
        $this->typeArticle = $typeArticle;
    }

    /**
     * Get typeArticle
     *
     * @return string 
     */
    public function getTypeArticle()
    {
        return $this->typeArticle;
    }
    
    public function __toString()
    {
        return $this->codeArticle;
    }
}