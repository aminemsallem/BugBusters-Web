<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="tapez votre nom")
     * @Assert\Type("string")

     */
    private $nom;

    /**
     * @ORM\Column(type="date")

     */
    private $datedebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="datedebut")
     */
    private $datefin;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="le nombre doit etre positive")
     * @Assert\NotBlank(message="tapez le nombre maximale de participants")
     */
    private $nbrparticipant;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Ajouter une image")

     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="evenements")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="idevenement")
     */
    private $commentaires;



    public function __construct()
    {
        $this->commentaires = new ArrayCollection();

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDateDebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDateFin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getNbrParticipant(): ?int
    {
        return $this->nbrparticipant;
    }

    public function setNbrParticipant(int $nbrparticipant): self
    {
        $this->nbrparticipant = $nbrparticipant;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage( $image)
    {
        $this->image = $image;

        return $this;
    }

    public function getCategories(): ?Categorie
    {
        return $this->categories;
    }

    public function setCategories(?Categorie $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setIdevenement($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdevenement() === $this) {
                $commentaire->setIdevenement(null);
            }
        }

        return $this;
    }
}
