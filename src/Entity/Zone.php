<?php

// src/Entity/Zone.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Validator as Validator;
use Symfony\Component\Validator\Constraints as Assert;

use App\Traits\Timestamp as TraitsTimestamp;
use App\Traits\User as TraitsUser;

/**
 * @ORM\Table(name="zone")
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository")
 */
class Zone 
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
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     */
    private $page;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min=3)
     * @Validator\Zone
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3)
     */
    private $url;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active = true;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Categorie", mappedBy="zone")
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Siteweb", inversedBy="zones")
     */
    private $siteweb;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function __toString() 
    {
        return $this->page . ' - ' . $this->libelle;
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
     * Get siteweb
     *
     * @return string
     */
    public function getSiteweb()
    {
        return $this->siteweb;
    }

    /**
     * Set siteweb
     *
     * @param string $siteweb
     */
    public function setSiteweb($siteweb)
    {
        $this->siteweb = $siteweb;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
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