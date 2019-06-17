<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostalCodeRepository")
 */
class PostalCode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $deptCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $deptName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $suburban;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $cityPostalCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cityName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Third", mappedBy="postalCode")
     */
    private $thirds;

    public function __construct()
    {
        $this->thirds = new ArrayCollection();
    }

    public function getDeptCode(): ?string
    {
        return $this->deptCode;
    }

    public function setDeptCode(string $deptCode): self
    {
        $this->deptCode = $deptCode;

        return $this;
    }

    public function getDeptName(): ?string
    {
        return $this->deptName;
    }

    public function setDeptName(string $deptName): self
    {
        $this->deptName = $deptName;

        return $this;
    }

    public function getSuburban(): ?string
    {
        return $this->suburban;
    }

    public function setSuburban(?string $suburban): self
    {
        $this->suburban = $suburban;

        return $this;
    }

    public function getCityPostalCode(): ?string
    {
        return $this->cityPostalCode;
    }

    public function setCityPostalCode(string $cityPostalCode): self
    {
        $this->cityPostalCode = $cityPostalCode;

        return $this;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): self
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * @return Collection|Third[]
     */
    public function getThirds(): Collection
    {
        return $this->thirds;
    }

    public function addThird(Third $third): self
    {
        if (!$this->thirds->contains($third)) {
            $this->thirds[] = $third;
            $third->setPostalCode($this);
        }

        return $this;
    }

    public function removeThird(Third $third): self
    {
        if ($this->thirds->contains($third)) {
            $this->thirds->removeElement($third);
            // set the owning side to null (unless already changed)
            if ($third->getPostalCode() === $this) {
                $third->setPostalCode(null);
            }
        }

        return $this;
    }
}
