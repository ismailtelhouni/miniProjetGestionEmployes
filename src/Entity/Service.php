<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $designationServ = null;

    #[ORM\Column(length: 100)]
    private ?string $descriptionServ = null;

    #[ORM\OneToMany(mappedBy: 'NumServ', targetEntity: Employes::class)]
    private Collection $employes;

    public function __construct()
    {
        $this->employes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignationServ(): ?string
    {
        return $this->designationServ;
    }

    public function setDesignationServ(string $designationServ): self
    {
        $this->designationServ = $designationServ;

        return $this;
    }

    public function getDescriptionServ(): ?string
    {
        return $this->descriptionServ;
    }

    public function setDescriptionServ(string $descriptionServ): self
    {
        $this->descriptionServ = $descriptionServ;

        return $this;
    }

    /**
     * @return Collection<int, Employes>
     */
    public function getEmployes(): Collection
    {
        return $this->employes;
    }

    public function addEmploye(Employes $employe): self
    {
        if (!$this->employes->contains($employe)) {
            $this->employes->add($employe);
            $employe->setNumServ($this);
        }

        return $this;
    }

    public function removeEmploye(Employes $employe): self
    {
        if ($this->employes->removeElement($employe)) {
            // set the owning side to null (unless already changed)
            if ($employe->getNumServ() === $this) {
                $employe->setNumServ(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->designationServ;
    }
}
