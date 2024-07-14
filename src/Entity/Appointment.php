<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateIn = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $timeIn = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    private ?Professional $given_Professional = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateIn(): ?\DateTimeInterface
    {
        return $this->dateIn;
    }

    public function setDateIn(\DateTimeInterface $dateIn): static
    {
        $this->dateIn = $dateIn;

        return $this;
    }

    public function getTimeIn(): ?\DateTimeInterface
    {
        return $this->timeIn;
    }

    public function setTimeIn(\DateTimeInterface $timeIn): static
    {
        $this->timeIn = $timeIn;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getGivenProfessional(): ?Professional
    {
        return $this->given_Professional;
    }

    public function setGivenProfessional(?Professional $given_Professional): static
    {
        $this->given_Professional = $given_Professional;

        return $this;
    }
}
