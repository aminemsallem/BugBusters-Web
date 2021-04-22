<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
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
     * @Assert\Regex(
    pattern="/\d/",
    match=false,
    message="ton nom ne doit pas contenir un numero"
    )
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $datedebut;

    /**
     * @ORM\Column(type="date")
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
     *  @Assert\NotBlank(message="Ajouter une image jpg")
     * @Assert\File(mimeTypes={ "image/jpeg" })

     */
    private $image;

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
}
