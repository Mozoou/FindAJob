<?php

namespace App\Entity;

use App\Repository\CandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $linkedin;

    #[ORM\Column(type: 'string', length: 255)]
    private $searched_region;

    #[ORM\OneToMany(mappedBy: 'candidat', targetEntity: Formations::class)]
    private $formations;

    #[ORM\OneToMany(mappedBy: 'candidat', targetEntity: ExpPro::class)]
    private $expPros;

    #[ORM\ManyToOne(targetEntity: Industry::class, inversedBy: 'candidats')]
    private $industry;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->expPros = new ArrayCollection();
    }

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

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(string $linkedin): self
    {
        $this->linkedin = $linkedin;

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

    /**
     * @return Collection<int, Formations>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formations $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setCandidat($this);
        }

        return $this;
    }

    public function removeFormation(Formations $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getCandidat() === $this) {
                $formation->setCandidat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpPro>
     */
    public function getExpPros(): Collection
    {
        return $this->expPros;
    }

    public function addExpPro(ExpPro $expPro): self
    {
        if (!$this->expPros->contains($expPro)) {
            $this->expPros[] = $expPro;
            $expPro->setCandidat($this);
        }

        return $this;
    }

    public function removeExpPro(ExpPro $expPro): self
    {
        if ($this->expPros->removeElement($expPro)) {
            // set the owning side to null (unless already changed)
            if ($expPro->getCandidat() === $this) {
                $expPro->setCandidat(null);
            }
        }

        return $this;
    }

    public function getIndustry(): ?Industry
    {
        return $this->industry;
    }

    public function setIndustry(?Industry $industry): self
    {
        $this->industry = $industry;

        return $this;
    }
}
