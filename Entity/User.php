<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="userPicker")
     */
    private $pickerServices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="userDeliver")
     */
    private $deliverServices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="userOwner")
     */
    private $ownerServices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OwnerHistoric", mappedBy="user")
     */
    private $ownerHistorics;

    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
        $this->pickerServices = new ArrayCollection();
        $this->deliverServices = new ArrayCollection();
        $this->ownerServices = new ArrayCollection();
        $this->ownerHistorics = new ArrayCollection();
    }

    /**
     * Permet d'initialiser des propriétés !
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeProperty() {
        if(empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->firstName . ' ' . $this->lastName);
        }

        if(empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getRoles() {
        return ['ROLE_USERS'];
    }

    public function getPassword() {
        return $this->hash;
    }

    public function getSalt() {}

    public function getUsername() {
        return $this->email;
    }

    public function eraseCredentials() {}

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeUser($this);
        }

        return $this;
    }

    /**
     * Permet de retourner le fullName d'un utilisateur
     *
     * @return string
     */
    public function getFullName() {
        return "{$this->firstName} {$this->lastName}";
    }

    /**
     * @return Collection|Service[]
     */
    public function getPickerServices(): Collection
    {
        return $this->pickerServices;
    }

    public function addPickerService(Service $pickerService): self
    {
        if (!$this->pickerServices->contains($pickerService)) {
            $this->pickerServices[] = $pickerService;
            $pickerService->setUserPicker($this);
        }

        return $this;
    }

    public function removePickerService(Service $pickerService): self
    {
        if ($this->pickerServices->contains($pickerService)) {
            $this->pickerServices->removeElement($pickerService);
            // set the owning side to null (unless already changed)
            if ($pickerService->getUserPicker() === $this) {
                $pickerService->setUserPicker(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getDeliverServices(): Collection
    {
        return $this->deliverServices;
    }

    public function addDeliverService(Service $deliverService): self
    {
        if (!$this->deliverServices->contains($deliverService)) {
            $this->deliverServices[] = $deliverService;
            $deliverService->setUserDeliver($this);
        }

        return $this;
    }

    public function removeDeliverService(Service $deliverService): self
    {
        if ($this->deliverServices->contains($deliverService)) {
            $this->deliverServices->removeElement($deliverService);
            // set the owning side to null (unless already changed)
            if ($deliverService->getUserDeliver() === $this) {
                $deliverService->setUserDeliver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getOwnerServices(): Collection
    {
        return $this->ownerServices;
    }

    public function addOwnerService(Service $ownerService): self
    {
        if (!$this->ownerServices->contains($ownerService)) {
            $this->ownerServices[] = $ownerService;
            $ownerService->setUserOwner($this);
        }

        return $this;
    }

    public function removeOwnerService(Service $ownerService): self
    {
        if ($this->ownerServices->contains($ownerService)) {
            $this->ownerServices->removeElement($ownerService);
            // set the owning side to null (unless already changed)
            if ($ownerService->getUserOwner() === $this) {
                $ownerService->setUserOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OwnerHistoric[]
     */
    public function getOwnerHistorics(): Collection
    {
        return $this->ownerHistorics;
    }

    public function addOwnerHistoric(OwnerHistoric $ownerHistoric): self
    {
        if (!$this->ownerHistorics->contains($ownerHistoric)) {
            $this->ownerHistorics[] = $ownerHistoric;
            $ownerHistoric->setUser($this);
        }

        return $this;
    }

    public function removeOwnerHistoric(OwnerHistoric $ownerHistoric): self
    {
        if ($this->ownerHistorics->contains($ownerHistoric)) {
            $this->ownerHistorics->removeElement($ownerHistoric);
            // set the owning side to null (unless already changed)
            if ($ownerHistoric->getUser() === $this) {
                $ownerHistoric->setUser(null);
            }
        }

        return $this;
    }

}
