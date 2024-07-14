<?php

namespace App\Entity;

use App\Repository\ExpertiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpertiseRepository::class)]
class Expertise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, professional>
     */
    #[ORM\ManyToMany(targetEntity: Professional::class, inversedBy: 'expertises')]
    private Collection $professional;

    /**
     * @var Collection<int, Process>
     */
    #[ORM\OneToMany(targetEntity: Process::class, mappedBy: 'requiredExpertise')]
    private Collection $processes;

    public function __construct()
    {
        $this->professional = new ArrayCollection();
        $this->processes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, professional>
     */
    public function getProfessional(): Collection
    {
        return $this->professional;
    }

    public function addProfessional(Professional $professional): static
    {
        if (!$this->professional->contains($professional)) {
            $this->professional->add($professional);
        }

        return $this;
    }

    public function removeProfessional(Professional $professional): static
    {
        $this->professional->removeElement($professional);

        return $this;
    }

    /**
     * @return Collection<int, Process>
     */
    public function getProcesses(): Collection
    {
        return $this->processes;
    }

    public function addProcess(Process $process): static
    {
        if (!$this->processes->contains($process)) {
            $this->processes->add($process);
            $process->setRequiredExpertise($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): static
    {
        if ($this->processes->removeElement($process)) {
            // set the owning side to null (unless already changed)
            if ($process->getRequiredExpertise() === $this) {
                $process->setRequiredExpertise(null);
            }
        }

        return $this;
    }
}
