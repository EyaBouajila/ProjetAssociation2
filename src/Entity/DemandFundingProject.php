<?php

namespace App\Entity;

use App\Repository\DemandFundingProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandFundingProjectRepository::class)]
class DemandFundingProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'demandFundingProjects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Demand $Demand = null;

    #[ORM\ManyToOne(inversedBy: 'demandFundingProjects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $Project = null;

    #[ORM\Column(nullable: true)]
    private ?float $fund = null;

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

    public function getProject(): ?Project
    {
        return $this->Project;
    }

    public function setProject(?Project $Project): self
    {
        $this->Project = $Project;

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
}
