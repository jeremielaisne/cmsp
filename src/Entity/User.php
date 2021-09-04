<?php

// src/Entity/User.php
namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;

use App\Traits\Timestamp as TraitsTimestamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    use TraitsTimestamp;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", name="is_active")
     */
    private $isActive;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="float", scale=5, nullable=true)
     */
    private $latitude_loc;

    /**
     * @ORM\Column(type="float", scale=5, nullable=true)
     */
    private $longitude_loc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $visites;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifications;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detail_modifications;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Siteweb", inversedBy="users")
     */
    private $dernier_site;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Siteweb", inversedBy="users")
     */
    private $sitewebs;


    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
        $this->sitewebs = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserIdentifier()
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }
    

    public function supportsClass($class)
    {
        return User::class === $class;
    }


    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

    public function setDateNaissance($date_naissance)
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude_loc;
    }

    public function setLatitude($latitude_loc)
    {
        $this->latitude_loc = $latitude_loc;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude_loc;
    }

    public function setLongitude($longitude_loc)
    {
        $this->longitude_loc = $longitude_loc;

        return $this;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getFonction()
    {
        return $this->fonction;
    }

    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getVisites()
    {
        return $this->visites;
    }

    public function setVisites($visites)
    {
        $this->visites = $visites;

        return $this;
    }

    public function getModifications()
    {
        return $this->modifications;
    }

    public function setModifications($modifications)
    {
        $this->modifications = $modifications;

        return $this;
    }

    public function getDetailsModifs()
    {
        return $this->detail_modifications;
    }

    public function setDetailsModifs($detail_modifications)
    {
        $this->detail_modifications = $detail_modifications;

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
        if (!$this->sitewebs->contains($siteweb)) {
            $this->sitewebs[] = $siteweb;
        }
        return $this;
    }
    public function removeSitewebs(Siteweb $siteweb): self
    {
        if ($this->sitewebs->contains($siteweb)) {
            $this->sitewebs->removeElement($siteweb);
        }
        return $this;
    }

    public function getDernierSite()
    {
        return $this->dernier_site;
    }

    public function setDernierSite($dernier_site)
    {
        $this->dernier_site = $dernier_site;

        return $this;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }
}