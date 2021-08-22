<?php

// src/Entity/Champ.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="champ")
 * @ORM\Entity(repositoryClass="App\Repository\ChampRepository")
 */
class Champ
{
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", mappedBy="champs")
     */
    private $categories;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
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

    /**
     * @return Collection|Categorie[]
     */
    public function getCategorie(): Collection
    {
        return $this->categories;
    }
    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categories->contains($categorie)) {
            $this->categories[] = $categorie;
        }
        return $this;
    }
    public function removeCategorie(Categorie $categorie): self
    {
        if ($this->categories->contains($categorie)) {
            $this->categories->removeElement($categorie);
        }
        return $this;
    }
}