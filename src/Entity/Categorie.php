<?php

// src/Entity/Categorie.php
namespace App\Entity;

use App\Entity\Zone;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\TimestampTrait as Timestamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie 
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
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $diminutif;

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private $totalVue;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contenu", mappedBy="categorie")
     */
    private $contenus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="categories")
     */
    private $zone;


    public function __construct()
    {
        $this->contenus = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDiminutif()
    {
        return $this->diminutif;
    }

    public function setDiminutif($diminutif)
    {
        $this->diminutif = $diminutif;

        return $this;
    }

    public function getTotalVue()
    {
        return $this->totalVue;
    }

    public function setTotalVue($description)
    {
        $this->description = $description;

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

    /**
     * @return Collection|Contenu[]
     */
    public function getContenus(): Collection
    {
        return $this->contenus;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }
}