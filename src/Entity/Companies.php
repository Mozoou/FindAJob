<?php

namespace App\Entity;

use App\Repository\CompaniesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompaniesRepository::class)]
class Companies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $siret;

    #[ORM\Column(type: 'integer')]
    private $siren;

    #[ORM\Column(type: 'string', length: 255)]
    private $tva;

    #[ORM\Column(type: 'string', length: 255)]
    private $logo;

    #[ORM\Column(type: 'string', length: 255)]
    private $website;

    #[ORM\Column(type: 'boolean')]
    private $is_searching;

    #[ORM\Column(type: 'array')]
    private $searching_for = [];

    #[ORM\Column(type: 'integer')]
    private $phone;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $fax;

    #[ORM\Column(type: 'string', length: 255)]
    private $linkedin;

    #[ORM\Column(type: 'string', length: 255)]
    private $searched_region;

    #[ORM\OneToMany(mappedBy: 'companies', targetEntity: User::class)]
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getSiren(): ?int
    {
        return $this->siren;
    }

    public function setSiren(int $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function isSearching(): ?bool
    {
        return $this->is_searching;
    }

    public function setIsSearching(bool $is_searching): self
    {
        $this->is_searching = $is_searching;

        return $this;
    }

    public function getSearchingFor(): ?array
    {
        return $this->searching_for;
    }

    public function setSearchingFor(array $searching_for): self
    {
        $this->searching_for = $searching_for;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFax(): ?int
    {
        return $this->fax;
    }

    public function setFax(?int $fax): self
    {
        $this->fax = $fax;

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
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCompanies($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCompanies() === $this) {
                $user->setCompanies(null);
            }
        }

        return $this;
    }
}
