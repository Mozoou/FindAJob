<?php

namespace App\Entity;

use App\Repository\ExpProRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpProRepository::class)]
class ExpPro
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

    #[ORM\Column(type: 'string', length: 255)]
    private $job_description;

    #[ORM\Column(type: 'string', length: 255)]
    private $company_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $job_field;

    #[ORM\ManyToOne(targetEntity: Candidat::class, inversedBy: 'expPros')]
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

    public function setEndingDate(?\DateTimeInterface $ending_date): self
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

    public function getJobDescription(): ?string
    {
        return $this->job_description;
    }

    public function setJobDescription(string $job_description): self
    {
        $this->job_description = $job_description;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    public function setCompanyName(string $company_name): self
    {
        $this->company_name = $company_name;

        return $this;
    }

    public function getJobField(): ?string
    {
        return $this->job_field;
    }

    public function setJobField(string $job_field): self
    {
        $this->job_field = $job_field;

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
