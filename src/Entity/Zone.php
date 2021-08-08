<?php

// src/Entity/Zone.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\TimestampTrait as Timestamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="zone")
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository")
 */
class Zone 
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Categorie", mappedBy="zone")
     */
    private $categories;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|Contenu[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }
}