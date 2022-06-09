<?php

namespace App\Entity;

use App\Repository\SchoolDegreeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SchoolDegreeRepository::class)]
class SchoolDegree
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $level;

    #[ORM\OneToMany(mappedBy: 'school_degree', targetEntity: Formations::class)]
    private $formations;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->getLevel();
    }
    public function getId(): ?int
    {
        return $this->id;
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
            $formation->setSchoolDegree($this);
        }

        return $this;
    }

    public function removeFormation(Formations $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getSchoolDegree() === $this) {
                $formation->setSchoolDegree(null);
            }
        }

        return $this;
    }
}
