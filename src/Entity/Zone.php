<?php

// src/Entity/Zone.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\TimestampTrait as Timestamp;
use App\Traits\UserTrait as UserTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="zone")
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository")
 */
class Zone 
{
    use Timestamp;
    use UserTrait;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * @ORM\Column(type="string", length=255)
     */
    private $page;

    /**
     * @Assert\Length(min=3)
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @Assert\Length(min=3)
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

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

    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;

        return $this;
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

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;

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