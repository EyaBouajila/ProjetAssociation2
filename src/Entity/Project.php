<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $fundingNeeded = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $projectDetails = null;

    #[ORM\ManyToMany(targetEntity: Demand::class, mappedBy: 'targetProject')]
    private Collection $demands;

    #[ORM\OneToMany(mappedBy: 'Project', targetEntity: DemandFundingProject::class, orphanRemoval: true)]
    private Collection $demandFundingProjects;

    public function __construct()
    {
        $this->demands = new ArrayCollection();
        $this->demandFundingProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getProjectDetails(): ?string
    {
        return $this->projectDetails;
    }

    /**
     * @param string|null $projectDetails
     */
    public function setProjectDetails(?string $projectDetails): void
    {
        $this->projectDetails = $projectDetails;
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
            $demand->addTargetProject($this);
        }

        return $this;
    }

    public function removeDemand(Demand $demand): self
    {
        if ($this->demands->removeElement($demand)) {
            $demand->removeTargetProject($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return 'project id = '.$this->getId();
    }

    /**
     * @return Collection<int, DemandFundingProject>
     */
    public function getDemandFundingProjects(): Collection
    {
        return $this->demandFundingProjects;
    }

    public function addDemandFundingProject(DemandFundingProject $demandFundingProject): self
    {
        if (!$this->demandFundingProjects->contains($demandFundingProject)) {
            $this->demandFundingProjects->add($demandFundingProject);
            $demandFundingProject->setProject($this);
        }

        return $this;
    }

    public function removeDemandFundingProject(DemandFundingProject $demandFundingProject): self
    {
        if ($this->demandFundingProjects->removeElement($demandFundingProject)) {
            // set the owning side to null (unless already changed)
            if ($demandFundingProject->getProject() === $this) {
                $demandFundingProject->setProject(null);
            }
        }

        return $this;
    }
}
