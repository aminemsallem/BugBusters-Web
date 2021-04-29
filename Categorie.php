<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomCategorie", type="string", length=50, nullable=false)
     */
    private $nomcategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="date", nullable=false)
     */
    private $datecreation;

//    /**
//     * @ORM\Column(name="user", type="integer", nullable=true)
//     */
//    private $user;

//    /**
//     * @ORM\OneToMany(targetEntity=Oeuvre::class, mappedBy="categorie")
//     */
//    private $oeuvre;

    public function __construct()
    {
        $this->oeuvre = new ArrayCollection();
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNomcategorie(): ?string
    {
        return $this->nomcategorie;
    }

    /**
     * @param string $nomcategorie
     */
    public function setNomcategorie(string $nomcategorie): void
    {
        $this->nomcategorie = $nomcategorie;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     */
    public function getDatecreation(): ?\DateTime
    {
        return $this->datecreation;
    }

    /**
     * @param \DateTime $datecreation
     */
    public function setDatecreation(\DateTime $datecreation): void
    {
        $this->datecreation = $datecreation;
    }

//    /**
//     * @return Collection|Oeuvre[]
//     */
//    public function getOeuvre(): Collection
//    {
//        return $this->oeuvre;
//    }
//
//    public function addOeuvre(Oeuvre $oeuvre): self
//    {
//        if (!$this->oeuvre->contains($oeuvre)) {
//            $this->oeuvre[] = $oeuvre;
//            $oeuvre->setCategorie($this);
//        }
//
//        return $this;
//    }
//
//    public function removeOeuvre(Oeuvre $oeuvre): self
//    {
//        if ($this->oeuvre->removeElement($oeuvre)) {
//            // set the owning side to null (unless already changed)
//            if ($oeuvre->getCategorie() === $this) {
//                $oeuvre->setCategorie(null);
//            }
//        }
//
//        return $this;
//    }


    public function toString()
    {
        // TODO: Implement __toString() method.
        $this->nomcategorie;
    }


}
