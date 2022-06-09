<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormationsRepository;

#[ORM\Entity(repositoryClass: FormationsRepository::class)]
class Formations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $starting_date;

    #[ORM\Column(type: 'date', nullable: true)]
    private $ending_date;

    #[ORM\Column(type: 'boolean')]
    private $currently;

    #[ORM\ManyToOne(targetEntity: SchoolDegree::class, inversedBy: 'formations')]
    #[ORM\JoinColumn(nullable: false)]
    private $school_degree;

    #[ORM\ManyToOne(targetEntity: Candidat::class, inversedBy: 'formations')]
    private $candidat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->starting_date;
    }

    public function setStartingDate(\DateTimeInterface $starting_date): self
    {
        $this->starting_date = $starting_date;

        return $this;
    }

    public function getEndingDate(): ?\DateTimeInterface
    {
        return $this->ending_date;
    }

    public function setEndingDate(\DateTimeInterface $ending_date): self
    {
        $this->ending_date = $ending_date;

        return $this;
    }

    public function isCurrently(): ?bool
    {
        return $this->currently;
    }

    public function setCurrently(bool $currently): self
    {
        $this->currently = $currently;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getSchoolDegree(): ?SchoolDegree
    {
        return $this->school_degree;
    }

    public function setSchoolDegree(?SchoolDegree $school_degree): self
    {
        $this->school_degree = $school_degree;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }
}
