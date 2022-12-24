<?php

namespace App\Entity;

use App\Repository\FunderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FunderRepository::class)]
class Funder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(nullable: false)]
    private ?int $nbrActivities = 0;

    #[ORM\Column(length: 255)]
    private ?string $funderType = null;

    #[ORM\OneToMany(mappedBy: 'activityFunder', targetEntity: Demand::class, orphanRemoval: true)]
    private Collection $demands;

    public function __construct()
    {
        $this->demands = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    /**
     * @return int|null
     */
    public function getNbrActivities(): ?int
    {
        return $this->nbrActivities;
    }

    /**
     * @param int|null $nbrActivities
     */
    public function setNbrActivities(?int $nbrActivities): void
    {
        $this->nbrActivities = $nbrActivities;
    }

    /**
     * @return string|null
     */
    public function getFunderType(): ?string
    {
        return $this->funderType;
    }

    /**
     * @param string|null $funderType
     */
    public function setFunderType(?string $funderType): void
    {
        $this->funderType = $funderType;
    }



    /**
     * @return Collection<int, Demand>
     */
    public function getDemands(): Collection
    {
        return $this->demands;
    }

    public function addDemand(Demand $demand): self
    {
        if (!$this->demands->contains($demand)) {
            $this->demands->add($demand);
            $demand->setActivityFunder($this);
        }

        return $this;
    }

    public function removeDemand(Demand $demand): self
    {
        if ($this->demands->removeElement($demand)) {
            // set the owning side to null (unless already changed)
            if ($demand->getActivityFunder() === $this) {
                $demand->setActivityFunder(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->getName();
    }


}
