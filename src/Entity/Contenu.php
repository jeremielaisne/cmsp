<?php

// src/Entity/Contenu.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Categorie;
use App\Traits\Timestamp as TraitsTimestamp;
use App\Traits\User as TraitsUser;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="contenu")
 * @ORM\Entity(repositoryClass="App\Repository\ContenuRepository")
 */
class Contenu 
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
     * @ORM\Column(type="string", length=3)
     */
    private $langue;

    /**
     * @ORM\Column(type="array")
     */
    private $type = [];

     /**
     * @Assert\Json(
     *   message = "Vous avez entrer un JSON invalide."
     * )
     * @ORM\Column(type="json", nullable=true)
     */
    private $contenu;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOnline = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="contenus")
     */
    private $categorie;


    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getLangue()
    {
        return $this->langue;
    }

    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getIsOnline()
    {
        return $this->isOnline;
    }

    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}