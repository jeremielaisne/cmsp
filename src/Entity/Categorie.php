<?php

// src/Entity/Categorie.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Entity\Zone;
use App\Traits\Timestamp as TraitsTimestamp;
use App\Traits\User as TraitsUser;

/**
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie 
{
    use TraitsTimestamp;
    use TraitsUser;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contenu", mappedBy="categorie")
     */
    private $contenus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="categories")
     */
    private $zone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Champ", inversedBy="categories")
     */
    private $champs;


    public function __construct()
    {
        $this->contenus = new ArrayCollection();
        $this->champs = new ArrayCollection();
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

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

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

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    // public function getOrder()
    // {
    //     return $this->order;
    // }

    // public function setOrder($order)
    // {
    //     $this->order = $order;

    //     return $this;
    // }

    /**
     * @return Collection|Contenu[]
     */
    public function getContenus(): Collection
    {
        return $this->contenus;
    }
    public function addContenus(Contenu $contenu): self
    {
        if (!$this->contenus->contains($contenu)) {
            $this->contenus[] = $contenu;
        }
        return $this;
    }
    public function removeContenus(Contenu $contenu): self
    {
        if ($this->contenus->contains($contenu)) {
            $this->contenus->removeElement($contenu);
        }
        return $this;
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

    /**
     * @return Collection|Champ[]
     */
    public function getChamps(): Collection
    {
        return $this->champs;
    }
    public function addChamps(Champ $champ): self
    {
        if (!$this->champs->contains($champ)) {
            $this->champs[] = $champ;
        }
        return $this;
    }
    public function removeChamps(Champ $champ): self
    {
        if ($this->champs->contains($champ)) {
            $this->champs->removeElement($champ);
        }
        return $this;
    }
}