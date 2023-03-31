<?php

namespace App\Entity;

use App\Repository\EmployesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployesRepository::class)]
class Employes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message:"le champ Nom est vide, il doit etre rempli.")]
    #[Assert\Length(min:4)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message:"le champ Prenom est vide, il doit etre rempli.")]
    private ?string $prenom = null;

    #[ORM\Column(length: 1)]
    #[Assert\NotBlank(message:"le champ Genre est vide, il doit etre rempli.")]
    private ?string $sexe = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"le champ Adresse est vide, il doit etre rempli.")]
    private ?string $adresse = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"le champ date de naissance est vide, il doit etre rempli.")]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\ManyToOne]
    #[Assert\NotBlank(message:"le champ NumServ est vide, il doit etre rempli.")]
    private ?Service $NumServ = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'employes')]
    private ?User $CreatedBy = null;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */

    public function getNumServ(): ?Service
    {
        return $this->NumServ;
    }

    public function setNumServ(?Service $NumServ): self
    {
        $this->NumServ = $NumServ;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(?User $CreatedBy): self
    {
        $this->CreatedBy = $CreatedBy;

        return $this;
    }
}
