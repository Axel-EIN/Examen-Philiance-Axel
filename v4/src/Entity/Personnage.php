<?php

namespace App\Entity;

use App\Repository\PersonnageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonnageRepository::class)
 */
class Personnage
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
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $icone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $illustration;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $est_pj;

    /**
     * @ORM\ManyToOne(targetEntity=Clan::class, inversedBy="personnages")
     */
    private $clan;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="personnages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\ManyToOne(targetEntity=Ecole::class, inversedBy="personnages")
     */
    private $ecole;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="personnages")
     */
    private $joueur;

    /**
     * @ORM\OneToMany(targetEntity=Archive::class, mappedBy="auteur")
     */
    private $archives;

    /**
     * @ORM\OneToOne(targetEntity=FichePersonnage::class, mappedBy="personnage", cascade={"persist", "remove"})
     */
    private $fichePersonnage;

    /**
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="personnage", orphanRemoval=true)
     */
    private $yes;

    public function __construct()
    {
        $this->archives = new ArrayCollection();
        $this->yes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTitres(): ?string
    {
        return $this->titres;
    }

    public function setTitres(?string $titres): self
    {
        $this->titres = $titres;

        return $this;
    }

    public function getIcone(): ?string
    {
        return $this->icone;
    }

    public function setIcone(string $icone): self
    {
        $this->icone = $icone;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

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

    public function getEstPj(): ?bool
    {
        return $this->est_pj;
    }

    public function setEstPj(bool $est_pj): self
    {
        $this->est_pj = $est_pj;

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

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getEcole(): ?Ecole
    {
        return $this->ecole;
    }

    public function setEcole(?Ecole $ecole): self
    {
        $this->ecole = $ecole;

        return $this;
    }

    public function getJoueur(): ?Utilisateur
    {
        return $this->joueur;
    }

    public function setJoueur(?Utilisateur $joueur): self
    {
        $this->joueur = $joueur;

        return $this;
    }

    /**
     * @return Collection|Archive[]
     */
    public function getArchives(): Collection
    {
        return $this->archives;
    }

    public function addArchive(Archive $archive): self
    {
        if (!$this->archives->contains($archive)) {
            $this->archives[] = $archive;
            $archive->setAuteur($this);
        }

        return $this;
    }

    public function removeArchive(Archive $archive): self
    {
        if ($this->archives->removeElement($archive)) {
            // set the owning side to null (unless already changed)
            if ($archive->getAuteur() === $this) {
                $archive->setAuteur(null);
            }
        }

        return $this;
    }

    public function getFichePersonnage(): ?FichePersonnage
    {
        return $this->fichePersonnage;
    }

    public function setFichePersonnage(FichePersonnage $fichePersonnage): self
    {
        // set the owning side of the relation if necessary
        if ($fichePersonnage->getPersonnage() !== $this) {
            $fichePersonnage->setPersonnage($this);
        }

        $this->fichePersonnage = $fichePersonnage;

        return $this;
    }

    /**
     * @return Collection|Participation[]
     */
    public function getYes(): Collection
    {
        return $this->yes;
    }

    public function addYe(Participation $ye): self
    {
        if (!$this->yes->contains($ye)) {
            $this->yes[] = $ye;
            $ye->setPersonnage($this);
        }

        return $this;
    }

    public function removeYe(Participation $ye): self
    {
        if ($this->yes->removeElement($ye)) {
            // set the owning side to null (unless already changed)
            if ($ye->getPersonnage() === $this) {
                $ye->setPersonnage(null);
            }
        }

        return $this;
    }
}
