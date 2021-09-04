<?php

// src/Entity/Siteweb.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="siteweb")
 * @ORM\Entity(repositoryClass="App\Repository\SitewebRepository")
 */
class Siteweb
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Siteweb", mappedBy="siteweb")
     */
    private $zones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Siteweb", mappedBy="dernier_site")
     */
    private $sitewebs;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="sitewebs")
     */
    private $users;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->zones = new ArrayCollection();
        $this->sitewebs = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) 
        {
            $this->users[] = $user;
        }
        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) 
        {
            $this->users->removeElement($user);
        }
        return $this;
    }

    /**
     * @return Collection|Zone[]
     */
    public function getZones(): Collection
    {
        return $this->zones;
    }

    public function addZones(Zone $zone): self
    {
        if (!$this->zones->contains($zone)) 
        {
            $this->zones[] = $zone;
        }
        return $this;
    }

    public function removeZone(Zone $zone): self
    {
        if ($this->zones->contains($zone)) 
        {
            $this->zones->removeElement($zone);
        }
        return $this;
    }

    /**
     * @return Collection|Siteweb[]
     */
    public function getSitewebs(): Collection
    {
        return $this->sitewebs;
    }

    public function addSitewebs(Siteweb $siteweb): self
    {
        if (!$this->sitewebs->contains($siteweb)) 
        {
            $this->sitewebs[] = $siteweb;
        }
        return $this;
    }

    public function removeSitewebs(Siteweb $siteweb): self
    {
        if ($this->sitewebs->contains($siteweb)) 
        {
            $this->sitewebs->removeElement($siteweb);
        }
        return $this;
    }
    
}