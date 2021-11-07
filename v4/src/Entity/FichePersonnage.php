<?php

namespace App\Entity;

use App\Repository\FichePersonnageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichePersonnageRepository::class)
 */
class FichePersonnage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Personnage::class, inversedBy="fichePersonnage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $personnage;

    /**
     * @ORM\Column(type="integer")
     */
    private $creationExp;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $avantages;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $desavantages;

    /**
     * @ORM\Column(type="smallint")
     */
    private $constitution;

    /**
     * @ORM\Column(type="smallint")
     */
    private $volonte;

    /**
     * @ORM\Column(type="smallint")
     */
    private $reflexes;

    /**
     * @ORM\Column(type="smallint")
     */
    private $intuition;

    /**
     * @ORM\Column(type="smallint")
     */
    private $agilite;

    /**
     * @ORM\Column(type="smallint")
     */
    private $intelligence;

    /**
     * @ORM\Column(type="smallint")
     */
    private $forceStat;

    /**
     * @ORM\Column(type="smallint")
     */
    private $perception;

    /**
     * @ORM\Column(type="smallint")
     */
    private $vide;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonnage(): ?Personnage
    {
        return $this->personnage;
    }

    public function setPersonnage(Personnage $personnage): self
    {
        $this->personnage = $personnage;

        return $this;
    }

    public function getCreationExp(): ?int
    {
        return $this->creationExp;
    }

    public function setCreationExp(int $creationExp): self
    {
        $this->creationExp = $creationExp;

        return $this;
    }

    public function getAvantages(): ?string
    {
        return $this->avantages;
    }

    public function setAvantages(?string $avantages): self
    {
        $this->avantages = $avantages;

        return $this;
    }

    public function getDesavantages(): ?string
    {
        return $this->desavantages;
    }

    public function setDesavantages(?string $desavantages): self
    {
        $this->desavantages = $desavantages;

        return $this;
    }

    public function getConstitution(): ?int
    {
        return $this->constitution;
    }

    public function setConstitution(int $constitution): self
    {
        $this->constitution = $constitution;

        return $this;
    }

    public function getVolonte(): ?int
    {
        return $this->volonte;
    }

    public function setVolonte(int $volonte): self
    {
        $this->volonte = $volonte;

        return $this;
    }

    public function getReflexes(): ?int
    {
        return $this->reflexes;
    }

    public function setReflexes(int $reflexes): self
    {
        $this->reflexes = $reflexes;

        return $this;
    }

    public function getIntuition(): ?int
    {
        return $this->intuition;
    }

    public function setIntuition(int $intuition): self
    {
        $this->intuition = $intuition;

        return $this;
    }

    public function getAgilite(): ?int
    {
        return $this->agilite;
    }

    public function setAgilite(int $agilite): self
    {
        $this->agilite = $agilite;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getForceStat(): ?int
    {
        return $this->forceStat;
    }

    public function setForceStat(int $forceStat): self
    {
        $this->forceStat = $forceStat;

        return $this;
    }

    public function getPerception(): ?int
    {
        return $this->perception;
    }

    public function setPerception(int $perception): self
    {
        $this->perception = $perception;

        return $this;
    }

    public function getVide(): ?int
    {
        return $this->vide;
    }

    public function setVide(int $vide): self
    {
        $this->vide = $vide;

        return $this;
    }
}
