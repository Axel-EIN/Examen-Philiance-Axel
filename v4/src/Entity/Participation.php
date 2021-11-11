<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipationRepository::class)
 */
class Participation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Scene::class, inversedBy="participations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scene;

    /**
     * @ORM\Column(type="integer")
     */
    private $xpGagne;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estMort;

    /**
     * @ORM\ManyToOne(targetEntity=Personnage::class, inversedBy="yes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personnage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScene(): ?Scene
    {
        return $this->scene;
    }

    public function setScene(?Scene $scene): self
    {
        $this->scene = $scene;

        return $this;
    }

    public function getXpGagne(): ?int
    {
        return $this->xpGagne;
    }

    public function setXpGagne(int $xpGagne): self
    {
        $this->xpGagne = $xpGagne;

        return $this;
    }

    public function getEstMort(): ?bool
    {
        return $this->estMort;
    }

    public function setEstMort(bool $estMort): self
    {
        $this->estMort = $estMort;

        return $this;
    }

    public function getPersonnage(): ?Personnage
    {
        return $this->personnage;
    }

    public function setPersonnage(?Personnage $personnage): self
    {
        $this->personnage = $personnage;

        return $this;
    }
}
