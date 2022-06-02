<?php

namespace App\Entity;

use App\Repository\CandidatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatRepository::class)]
class Candidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'boolean')]
    private $is_searching;

    #[ORM\OneToOne(inversedBy: 'candidat', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $profile_picture;

    #[ORM\Column(type: 'date')]
    private $date_birth;

    #[ORM\Column(type: 'string', length: 255)]
    private $studies_level;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $formations;

    #[ORM\Column(type: 'integer')]
    private $pro_exp;

    #[ORM\Column(type: 'array', length: 255, nullable: true)]
    private $hard_skills;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $linkdin;

    #[ORM\Column(type: 'string', length: 255)]
    private $searched_region;

    #[ORM\Column(type: 'array', nullable: true)]
    private $soft_skills = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isIsSearching(): ?bool
    {
        return $this->is_searching;
    }

    public function setIsSearching(bool $is_searching): self
    {
        $this->is_searching = $is_searching;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profile_picture;
    }

    public function setProfilePicture(?string $profile_picture): self
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->date_birth;
    }

    public function setDateBirth(\DateTimeInterface $date_birth): self
    {
        $this->date_birth = $date_birth;

        return $this;
    }

    public function getStudiesLevel(): ?string
    {
        return $this->studies_level;
    }

    public function setStudiesLevel(string $studies_level): self
    {
        $this->studies_level = $studies_level;

        return $this;
    }

    public function getFormations(): ?string
    {
        return $this->formations;
    }

    public function setFormations(string $formations): self
    {
        $this->formations = $formations;

        return $this;
    }

    public function getProExp(): ?int
    {
        return $this->pro_exp;
    }

    public function setProExp(int $pro_exp): self
    {
        $this->pro_exp = $pro_exp;

        return $this;
    }

    public function getHardSkills()
    {
        return $this->hard_skills;
    }

    public function setHardSkills(array $skills): self
    {
        $this->hard_skills = $skills;

        return $this;
    }

    public function getLinkdin(): ?string
    {
        return $this->linkdin;
    }

    public function setLinkdin(string $linkdin): self
    {
        $this->linkdin = $linkdin;

        return $this;
    }

    public function getSearchedRegion(): ?string
    {
        return $this->searched_region;
    }

    public function setSearchedRegion(string $searched_region): self
    {
        $this->searched_region = $searched_region;

        return $this;
    }

    public function getSoftSkills(): ?array
    {
        return $this->soft_skills;
    }

    public function setSoftSkills(?array $soft_skills): self
    {
        $this->soft_skills = $soft_skills;

        return $this;
    }
}
