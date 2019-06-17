<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expectedPickupDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $realPickupDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expectedDeliveryDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $realDeliveryDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ServiceCategory", inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceCategory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Third", inversedBy="serviceOrder")
     * @ORM\JoinColumn(nullable=false)
     */
    private $thirdOrder;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Third", inversedBy="serviceShipper")
     */
    private $thirdShipper;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Third", inversedBy="thirdReceiver")
     */
    private $thirdReceiver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pickerServices")
     */
    private $userPicker;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="deliverServices")
     */
    private $userDeliver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ownerServices")
     */
    private $userOwner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OwnerHistoric", mappedBy="service")
     */
    private $ownerHistorics;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PickupState", inversedBy="services")
     */
    private $pickupState;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pickupComment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pickupSignerName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DeliveryState", inversedBy="services")
     */
    private $deliveryState;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryComment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliverySignerName;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $pickedUpPackages;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $deliveredPackages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pickupSigning;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliverySigning;

    public function __construct()
    {
        $this->ownerHistorics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpectedPickupDate(): ?\DateTimeInterface
    {
        return $this->expectedPickupDate;
    }

    public function setExpectedPickupDate(?\DateTimeInterface $expectedPickupDate): self
    {
        $this->expectedPickupDate = $expectedPickupDate;

        return $this;
    }

    public function getRealPickupDate(): ?\DateTimeInterface
    {
        return $this->realPickupDate;
    }

    public function setRealPickupDate(?\DateTimeInterface $realPickupDate): self
    {
        $this->realPickupDate = $realPickupDate;

        return $this;
    }

    public function getExpectedDeliveryDate(): ?\DateTimeInterface
    {
        return $this->expectedDeliveryDate;
    }

    public function setExpectedDeliveryDate(?\DateTimeInterface $expectedDeliveryDate): self
    {
        $this->expectedDeliveryDate = $expectedDeliveryDate;

        return $this;
    }

    public function getRealDeliveryDate(): ?\DateTimeInterface
    {
        return $this->realDeliveryDate;
    }

    public function setRealDeliveryDate(?\DateTimeInterface $realDeliveryDate): self
    {
        $this->realDeliveryDate = $realDeliveryDate;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getServiceCategory(): ?ServiceCategory
    {
        return $this->serviceCategory;
    }

    public function setServiceCategory(?ServiceCategory $serviceCategory): self
    {
        $this->serviceCategory = $serviceCategory;

        return $this;
    }
    
    /**
     * Permet d'initialiser la propriété
     * $createdAt
     * 
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeProperty() {
       
        if(empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
        
    }

    public function getThirdOrder(): ?Third
    {
        return $this->thirdOrder;
    }

    public function setThirdOrder(?Third $thirdOrder): self
    {
        $this->thirdOrder = $thirdOrder;

        return $this;
    }

    public function getThirdShipper(): ?Third
    {
        return $this->thirdShipper;
    }

    public function setThirdShipper(?Third $thirdShipper): self
    {
        $this->thirdShipper = $thirdShipper;

        return $this;
    }

    public function getThirdReceiver(): ?Third
    {
        return $this->thirdReceiver;
    }

    public function setThirdReceiver(?Third $thirdReceiver): self
    {
        $this->thirdReceiver = $thirdReceiver;

        return $this;
    }

    public function getUserPicker(): ?User
    {
        return $this->userPicker;
    }

    public function setUserPicker(?User $userPicker): self
    {
        $this->userPicker = $userPicker;

        return $this;
    }

    public function getUserDeliver(): ?User
    {
        return $this->userDeliver;
    }

    public function setUserDeliver(?User $userDeliver): self
    {
        $this->userDeliver = $userDeliver;

        return $this;
    }

    public function getUserOwner(): ?User
    {
        return $this->userOwner;
    }

    public function setUserOwner(?User $userOwner): self
    {
        $this->userOwner = $userOwner;

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
            $ownerHistoric->setService($this);
        }

        return $this;
    }

    public function removeOwnerHistoric(OwnerHistoric $ownerHistoric): self
    {
        if ($this->ownerHistorics->contains($ownerHistoric)) {
            $this->ownerHistorics->removeElement($ownerHistoric);
            // set the owning side to null (unless already changed)
            if ($ownerHistoric->getService() === $this) {
                $ownerHistoric->setService(null);
            }
        }

        return $this;
    }

    public function getPickupState(): ?PickupState
    {
        return $this->pickupState;
    }

    public function setPickupState(?PickupState $pickupState): self
    {
        $this->pickupState = $pickupState;

        return $this;
    }

    public function getPickupComment(): ?string
    {
        return $this->pickupComment;
    }

    public function setPickupComment(?string $pickupComment): self
    {
        $this->pickupComment = $pickupComment;

        return $this;
    }

    public function getPickupSignerName(): ?string
    {
        return $this->pickupSignerName;
    }

    public function setPickupSignerName(?string $pickupSignerName): self
    {
        $this->pickupSignerName = $pickupSignerName;

        return $this;
    }

    public function getDeliveryState(): ?DeliveryState
    {
        return $this->deliveryState;
    }

    public function setDeliveryState(?DeliveryState $deliveryState): self
    {
        $this->deliveryState = $deliveryState;

        return $this;
    }

    public function getDeliveryComment(): ?string
    {
        return $this->deliveryComment;
    }

    public function setDeliveryComment(?string $deliveryComment): self
    {
        $this->deliveryComment = $deliveryComment;

        return $this;
    }

    public function getDeliverySignerName(): ?string
    {
        return $this->deliverySignerName;
    }

    public function setDeliverySignerName(?string $deliverySignerName): self
    {
        $this->deliverySignerName = $deliverySignerName;

        return $this;
    }

    public function getPickedUpPackages(): ?int
    {
        return $this->pickedUpPackages;
    }

    public function setPickedUpPackages(?int $pickedUpPackages): self
    {
        $this->pickedUpPackages = $pickedUpPackages;

        return $this;
    }

    public function getDeliveredPackages(): ?int
    {
        return $this->deliveredPackages;
    }

    public function setDeliveredPackages(?int $deliveredPackages): self
    {
        $this->deliveredPackages = $deliveredPackages;

        return $this;
    }

    public function getPickupSigning(): ?string
    {
        return $this->pickupSigning;
    }

    public function setPickupSigning(?string $pickupSigning): self
    {
        $this->pickupSigning = $pickupSigning;

        return $this;
    }

    public function getDeliverySigning(): ?string
    {
        return $this->deliverySigning;
    }

    public function setDeliverySigning(?string $deliverySigning): self
    {
        $this->deliverySigning = $deliverySigning;

        return $this;
    }

}
