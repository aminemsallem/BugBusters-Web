<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $nomC;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="categories")
     */
    private $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomC(): ?string
    {
        return $this->nomC;
    }

    public function setNomC(string $nomC): self
    {
        $this->nomC = $nomC;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenements(Evenement $evenements): self
    {
        if (!$this->evenements->contains($evenements)) {
            $this->evenements[] = $evenements;
            $evenements->setCategories($this);
        }

        return $this;
    }

    public function removeEvenements(Evenement $evenements): self
    {
        if ($this->evenements->removeElement($evenements)) {
            // set the owning side to null (unless already changed)
            if ($evenements->getCategories() === $this) {
                $evenements->setCategories(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nomC ;
    }
}
