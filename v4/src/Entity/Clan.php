<?php

namespace App\Entity;

use App\Repository\ClanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClanRepository::class)
 */
class Clan
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
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $est_majeur;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $couleur;

    /**
     * @ORM\OneToMany(targetEntity=Ecole::class, mappedBy="clan")
     */
    private $ecoles;

    /**
     * @ORM\OneToMany(targetEntity=Personnage::class, mappedBy="clan")
     */
    private $personnages;

    /**
     * @ORM\OneToOne(targetEntity=Personnage::class, cascade={"persist", "remove"})
     */
    private $chef;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mon;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct()
    {
        $this->ecoles = new ArrayCollection();
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

    public function getEstMajeur(): ?int
    {
        return $this->est_majeur;
    }

    public function setEstMajeur(?int $est_majeur): self
    {
        $this->est_majeur = $est_majeur;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * @return Collection|Ecole[]
     */
    public function getEcoles(): Collection
    {
        return $this->ecoles;
    }

    public function addEcole(Ecole $ecole): self
    {
        if (!$this->ecoles->contains($ecole)) {
            $this->ecoles[] = $ecole;
            $ecole->setClan($this);
        }

        return $this;
    }

    public function removeEcole(Ecole $ecole): self
    {
        if ($this->ecoles->removeElement($ecole)) {
            // set the owning side to null (unless already changed)
            if ($ecole->getClan() === $this) {
                $ecole->setClan(null);
            }
        }

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
            $personnage->setClan($this);
        }

        return $this;
    }

    public function removePersonnage(Personnage $personnage): self
    {
        if ($this->personnages->removeElement($personnage)) {
            // set the owning side to null (unless already changed)
            if ($personnage->getClan() === $this) {
                $personnage->setClan(null);
            }
        }

        return $this;
    }

    public function getChef(): ?Personnage
    {
        return $this->chef;
    }

    public function setChef(?Personnage $chef): self
    {
        $this->chef = $chef;

        return $this;
    }

    public function getMon(): ?string
    {
        return $this->mon;
    }

    public function setMon(?string $mon): self
    {
        $this->mon = $mon;

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
}
