<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="categories")
     */
    private $idevenement;

    public function __construct()
    {
        $this->idevenement = new ArrayCollection();
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

    /**
     * @return Collection|Evenement[]
     */
    public function getIdevenement(): Collection
    {
        return $this->idevenement;
    }

    public function addIdevenement(Evenement $idevenement): self
    {
        if (!$this->idevenement->contains($idevenement)) {
            $this->idevenement[] = $idevenement;
            $idevenement->setCategories($this);
        }

        return $this;
    }

    public function removeIdevenement(Evenement $idevenement): self
    {
        if ($this->idevenement->removeElement($idevenement)) {
            // set the owning side to null (unless already changed)
            if ($idevenement->getCategories() === $this) {
                $idevenement->setCategories(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom ;
    }





}





