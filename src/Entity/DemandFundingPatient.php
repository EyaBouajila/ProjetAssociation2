<?php

namespace App\Entity;

use App\Repository\DemandFundingPatientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandFundingPatientRepository::class)]
class DemandFundingPatient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'demandFundingPatients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Demand $Demand = null;

    #[ORM\Column(nullable: true)]
    private ?float $fund = null;

    #[ORM\ManyToOne(inversedBy: 'demandFundingPatients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $Patient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemand(): ?Demand
    {
        return $this->Demand;
    }

    public function setDemand(?Demand $Demand): self
    {
        $this->Demand = $Demand;

        return $this;
    }

    public function getFund(): ?float
    {
        return $this->fund;
    }

    public function setFund(?float $fund): self
    {
        $this->fund = $fund;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->Patient;
    }

    public function setPatient(?Patient $Patient): self
    {
        $this->Patient = $Patient;

        return $this;
    }
}
