<?php

namespace App\Entity;

use App\Repository\DemandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandRepository::class)]
class Demand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $demandDate = null;

    #[ORM\Column(length: 255)]
    private ?string $activityType = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $activityDueDate = null;

    #[ORM\Column(length: 255)]
    private ?string $activityGoal = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\ManyToOne(inversedBy: 'demands')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Funder $activityFunder = null;

    #[ORM\ManyToMany(targetEntity: Patient::class, inversedBy: 'demands')]
    private Collection $targetPatient;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'demands')]
    private Collection $targetProject;

    #[ORM\ManyToMany(targetEntity: Worker::class, inversedBy: 'demands')]
    private Collection $workersInvolved;

    public function __construct()
    {
        $this->targetPatient = new ArrayCollection();
        $this->targetProject = new ArrayCollection();
        $this->workersInvolved = new ArrayCollection();
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
     * @return \DateTimeInterface|null
     */
    public function getDemandDate(): ?\DateTimeInterface
    {
        return $this->demandDate;
    }

    /**
     * @param \DateTimeInterface|null $demandDate
     */
    public function setDemandDate(?\DateTimeInterface $demandDate): void
    {
        $this->demandDate = $demandDate;
    }

    /**
     * @return string|null
     */
    public function getActivityType(): ?string
    {
        return $this->activityType;
    }

    /**
     * @param string|null $activityType
     */
    public function setActivityType(?string $activityType): void
    {
        $this->activityType = $activityType;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getActivityDueDate(): ?\DateTimeInterface
    {
        return $this->activityDueDate;
    }

    /**
     * @param \DateTimeInterface|null $activityDueDate
     */
    public function setActivityDueDate(?\DateTimeInterface $activityDueDate): void
    {
        $this->activityDueDate = $activityDueDate;
    }

    /**
     * @return string|null
     */
    public function getActivityGoal(): ?string
    {
        return $this->activityGoal;
    }

    /**
     * @param string|null $activityGoal
     */
    public function setActivityGoal(?string $activityGoal): void
    {
        $this->activityGoal = $activityGoal;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return Funder|null
     */
    public function getActivityFunder(): ?Funder
    {
        return $this->activityFunder;
    }

    /**
     * @param Funder|null $activityFunder
     */
    public function setActivityFunder(?Funder $activityFunder): void
    {
        $this->activityFunder = $activityFunder;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getTargetPatient(): Collection
    {
        return $this->targetPatient;
    }

    public function addTargetPatient(Patient $targetPatient): self
    {
        if (!$this->targetPatient->contains($targetPatient)) {
            $this->targetPatient->add($targetPatient);
        }

        return $this;
    }

    public function removeTargetPatient(Patient $targetPatient): self
    {
        $this->targetPatient->removeElement($targetPatient);

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getTargetProject(): Collection
    {
        return $this->targetProject;
    }

    public function addTargetProject(Project $targetProject): self
    {
        if (!$this->targetProject->contains($targetProject)) {
            $this->targetProject->add($targetProject);
        }

        return $this;
    }

    public function removeTargetProject(Project $targetProject): self
    {
        $this->targetProject->removeElement($targetProject);

        return $this;
    }

    /**
     * @return Collection<int, Worker>
     */
    public function getWorkersInvolved(): Collection
    {
        return $this->workersInvolved;
    }

    public function addWorkersInvolved(Worker $workersInvolved): self
    {
        if (!$this->workersInvolved->contains($workersInvolved)) {
            $this->workersInvolved->add($workersInvolved);
        }

        return $this;
    }

    public function removeWorkersInvolved(Worker $workersInvolved): self
    {
        $this->workersInvolved->removeElement($workersInvolved);

        return $this;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->activityFunder;
    }


}
