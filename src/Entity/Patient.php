<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $healthStatus = null;

    #[ORM\Column]
    private ?float $fundingNeeded = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $patientDetails = null;

    #[ORM\ManyToMany(targetEntity: Demand::class, mappedBy: 'targetPatient')]
    private Collection $demands;

    public function __construct()
    {
        $this->demands = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getHealthStatus(): ?string
    {
        return $this->healthStatus;
    }

    /**
     * @param string|null $healthStatus
     */
    public function setHealthStatus(?string $healthStatus): void
    {
        $this->healthStatus = $healthStatus;
    }

    /**
     * @return float|null
     */
    public function getFundingNeeded(): ?float
    {
        return $this->fundingNeeded;
    }

    /**
     * @param float|null $fundingNeeded
     */
    public function setFundingNeeded(?float $fundingNeeded): void
    {
        $this->fundingNeeded = $fundingNeeded;
    }

    /**
     * @return string|null
     */
    public function getPatientDetails(): ?string
    {
        return $this->patientDetails;
    }

    /**
     * @param string|null $patientDetails
     */
    public function setPatientDetails(?string $patientDetails): void
    {
        $this->patientDetails = $patientDetails;
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
            $demand->addTargetPatient($this);
        }

        return $this;
    }

    public function removeDemand(Demand $demand): self
    {
        if ($this->demands->removeElement($demand)) {
            $demand->removeTargetPatient($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return 'patient id = '. $this->getId();
    }


}
