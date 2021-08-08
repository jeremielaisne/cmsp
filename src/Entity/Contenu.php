<?php

// src/Entity/Contenu.php
namespace App\Entity;

use App\Entity\Categorie;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\TimestampTrait as Timestamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="contenu")
 * @ORM\Entity(repositoryClass="App\Repository\ContenuRepository")
 */
class Contenu 
{
    use Timestamp;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $texte;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="categories")
     */
    private $categories;


    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTexte()
    {
        return $this->texte;
    }

    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCategories(): ?Categorie
    {
        return $this->categories;
    }

    public function setCategories(?Categorie $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}