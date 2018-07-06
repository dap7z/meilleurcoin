<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRegistered;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ad", mappedBy="createdBy")
     */
    private $selfAds;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ad", mappedBy="favoriteBy")
     */
    private $favoriteAds;


    public function __construct()
    {
        $this->roles = array('ROLE_USER');
        $this->selfAds = new ArrayCollection();
        $this->favoriteAds = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function hasRole($role)
    {
        return in_array($role, $this->getRoles());
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getDateRegistered(): ?\DateTimeInterface
    {
        return $this->dateRegistered;
    }

    public function setDateRegistered(\DateTimeInterface $dateRegistered): self
    {
        $this->dateRegistered = $dateRegistered;

        return $this;
    }


    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
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
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * @return Collection|Ad[]
     */
    public function getSelfAds(): Collection
    {
        return $this->selfAds;
    }

    public function addSelfAd(Ad $selfAd): self
    {
        if (!$this->selfAds->contains($selfAd)) {
            $this->selfAds[] = $selfAd;
            $selfAd->setCreatedBy($this);
        }

        return $this;
    }

    public function removeSelfAd(Ad $selfAd): self
    {
        if ($this->selfAds->contains($selfAd)) {
            $this->selfAds->removeElement($selfAd);
            // set the owning side to null (unless already changed)
            if ($selfAd->getCreatedBy() === $this) {
                $selfAd->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ad[]
     */
    public function getFavoriteAds(): Collection
    {
        return $this->favoriteAds;
    }

    public function addFavoriteAd(Ad $favoriteAd): self
    {
        if (!$this->favoriteAds->contains($favoriteAd)) {
            $this->favoriteAds[] = $favoriteAd;
            $favoriteAd->setFavoriteBy($this);
        }

        return $this;
    }

    public function removeFavoriteAd(Ad $favoriteAd): self
    {
        if ($this->favoriteAds->contains($favoriteAd)) {
            $this->favoriteAds->removeElement($favoriteAd);
            // set the owning side to null (unless already changed)
            if ($favoriteAd->getFavoriteBy() === $this) {
                $favoriteAd->setFavoriteBy(null);
            }
        }

        return $this;
    }

}
