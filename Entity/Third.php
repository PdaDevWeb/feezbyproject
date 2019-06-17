<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ThirdRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Third
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="thirdOrder")
     */
    private $serviceOrder;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="thirdShipper")
     */
    private $serviceShipper;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="thirdReceiver")
     */
    private $thirdReceiver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PostalCode", inversedBy="thirds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postalCode;

    public function __construct()
    {
        $this->serviceOrder = new ArrayCollection();
        $this->serviceShipper = new ArrayCollection();
        $this->thirdReceiver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function getAddress(): ?string
    {
        return $this->address;
    }
    
    public function setAddress(string $address): self
    {
        $this->address = $address;
        
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
    
    public function getComment(): ?string
    {
        return $this->comment;
    }
    
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        
        return $this;
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
       
        if(empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
        
    }
    

   /**
    * @return Collection|Service[]
    */
   public function getServiceOrder(): Collection
   {
       return $this->serviceOrder;
   }

   public function addServiceOrder(Service $serviceOrder): self
   {
       if (!$this->serviceOrder->contains($serviceOrder)) {
           $this->serviceOrder[] = $serviceOrder;
           $serviceOrder->setThirdOrder($this);
       }

       return $this;
   }

   public function removeServiceOrder(Service $serviceOrder): self
   {
       if ($this->serviceOrder->contains($serviceOrder)) {
           $this->serviceOrder->removeElement($serviceOrder);
           // set the owning side to null (unless already changed)
           if ($serviceOrder->getThirdOrder() === $this) {
               $serviceOrder->setThirdOrder(null);
           }
       }

       return $this;
   }

   /**
    * @return Collection|Service[]
    */
   public function getServiceShipper(): Collection
   {
       return $this->serviceShipper;
   }

   public function addServiceShipper(Service $serviceShipper): self
   {
       if (!$this->serviceShipper->contains($serviceShipper)) {
           $this->serviceShipper[] = $serviceShipper;
           $serviceShipper->setThirdShipper($this);
       }

       return $this;
   }

   public function removeServiceShipper(Service $serviceShipper): self
   {
       if ($this->serviceShipper->contains($serviceShipper)) {
           $this->serviceShipper->removeElement($serviceShipper);
           // set the owning side to null (unless already changed)
           if ($serviceShipper->getThirdShipper() === $this) {
               $serviceShipper->setThirdShipper(null);
           }
       }

       return $this;
   }

   /**
    * @return Collection|Service[]
    */
   public function getThirdReceiver(): Collection
   {
       return $this->thirdReceiver;
   }

   public function addThirdReceiver(Service $thirdReceiver): self
   {
       if (!$this->thirdReceiver->contains($thirdReceiver)) {
           $this->thirdReceiver[] = $thirdReceiver;
           $thirdReceiver->setThirdReceiver($this);
       }

       return $this;
   }

   public function removeThirdReceiver(Service $thirdReceiver): self
   {
       if ($this->thirdReceiver->contains($thirdReceiver)) {
           $this->thirdReceiver->removeElement($thirdReceiver);
           // set the owning side to null (unless already changed)
           if ($thirdReceiver->getThirdReceiver() === $this) {
               $thirdReceiver->setThirdReceiver(null);
           }
       }

       return $this;
   }

   public function getPostalCode(): ?PostalCode
   {
       return $this->postalCode;
   }

   public function setPostalCode(?PostalCode $postalCode): self
   {
       $this->postalCode = $postalCode;

       return $this;
   }

}
