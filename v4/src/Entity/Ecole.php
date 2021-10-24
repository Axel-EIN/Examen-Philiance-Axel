<?php

namespace App\Entity;

use App\Repository\EcoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EcoleRepository::class)
 */
class Ecole
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tech1Nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tech1Desc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tech2Nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tech2Desc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tech3Nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tech3Desc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tech4Nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tech4Desc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tech5Nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tech5Desc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $techSpecialNom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $techSpecialDesc;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="ecoles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\ManyToOne(targetEntity=Clan::class, inversedBy="ecoles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clan;

    /**
     * @ORM\OneToMany(targetEntity=Personnage::class, mappedBy="ecole")
     */
    private $personnages;

    public function __construct()
    {
        $this->personnages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTech1Nom(): ?string
    {
        return $this->tech1Nom;
    }

    public function setTech1Nom(?string $tech1Nom): self
    {
        $this->tech1Nom = $tech1Nom;

        return $this;
    }

    public function getTech1Desc(): ?string
    {
        return $this->tech1Desc;
    }

    public function setTech1Desc(?string $tech1Desc): self
    {
        $this->tech1Desc = $tech1Desc;

        return $this;
    }

    public function getTech2Nom(): ?string
    {
        return $this->tech2Nom;
    }

    public function setTech2Nom(?string $tech2Nom): self
    {
        $this->tech2Nom = $tech2Nom;

        return $this;
    }

    public function getTech2Desc(): ?string
    {
        return $this->tech2Desc;
    }

    public function setTech2Desc(?string $tech2Desc): self
    {
        $this->tech2Desc = $tech2Desc;

        return $this;
    }

    public function getTech3Nom(): ?string
    {
        return $this->tech3Nom;
    }

    public function setTech3Nom(?string $tech3Nom): self
    {
        $this->tech3Nom = $tech3Nom;

        return $this;
    }

    public function getTech3Desc(): ?string
    {
        return $this->tech3Desc;
    }

    public function setTech3Desc(?string $tech3Desc): self
    {
        $this->tech3Desc = $tech3Desc;

        return $this;
    }

    public function getTech4Nom(): ?string
    {
        return $this->tech4Nom;
    }

    public function setTech4Nom(?string $tech4Nom): self
    {
        $this->tech4Nom = $tech4Nom;

        return $this;
    }

    public function getTech4Desc(): ?string
    {
        return $this->tech4Desc;
    }

    public function setTech4Desc(?string $tech4Desc): self
    {
        $this->tech4Desc = $tech4Desc;

        return $this;
    }

    public function getTech5Nom(): ?string
    {
        return $this->tech5Nom;
    }

    public function setTech5Nom(?string $tech5Nom): self
    {
        $this->tech5Nom = $tech5Nom;

        return $this;
    }

    public function getTech5Desc(): ?string
    {
        return $this->tech5Desc;
    }

    public function setTech5Desc(?string $tech5Desc): self
    {
        $this->tech5Desc = $tech5Desc;

        return $this;
    }

    public function getTechSpecialNom(): ?string
    {
        return $this->techSpecialNom;
    }

    public function setTechSpecialNom(?string $techSpecialNom): self
    {
        $this->techSpecialNom = $techSpecialNom;

        return $this;
    }

    public function getTechSpecialDesc(): ?string
    {
        return $this->techSpecialDesc;
    }

    public function setTechSpecialDesc(?string $techSpecialDesc): self
    {
        $this->techSpecialDesc = $techSpecialDesc;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getClan(): ?Clan
    {
        return $this->clan;
    }

    public function setClan(?Clan $clan): self
    {
        $this->clan = $clan;

        return $this;
    }

    /**
     * @return Collection|Personnage[]
     */
    public function getPersonnages(): Collection
    {
        return $this->personnages;
    }

    public function addPersonnage(Personnage $personnage): self
    {
        if (!$this->personnages->contains($personnage)) {
            $this->personnages[] = $personnage;
            $personnage->setEcole($this);
        }

        return $this;
    }

    public function removePersonnage(Personnage $personnage): self
    {
        if ($this->personnages->removeElement($personnage)) {
            // set the owning side to null (unless already changed)
            if ($personnage->getEcole() === $this) {
                $personnage->setEcole(null);
            }
        }

        return $this;
    }
}
