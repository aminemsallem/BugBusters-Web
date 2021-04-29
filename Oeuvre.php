<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\DateTime;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Oeuvre
 *
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\OeuvreRepository")
 * @Vich\Uploadable
 */
class Oeuvre
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
     * @var \DateTime
     *
     * @ORM\Column(name="datePub", type="datetime", nullable=false)
     */
    private $datepub;
    /**
     * @var string
     *
     * @ORM\Column(name="nomArtiste", type="string", length=30, nullable=false)
     */
    private $nomartiste;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titre", type="string", length=50, nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=1000, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="oeuvre_images", fileNameProperty="image",size="imageSize")
     * @var File
     */
    private $imageFile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duree", type="time", nullable=false)
     */
    private $duree;

//    /**
//     * @ORM\OneToOne(targetEntity=User::class, inversedBy="oeuvre", cascade={"persist", "remove"})
//     */
//    private $User;

//    /**
//     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="oeuvre")
//     */
//    private $listoeuvre;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="oeuvre")
     */
    private $categorie;
    /**
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $imageSize;



    /**
     * Oeuvre constructor.
     */
    public function __construct()
    {
        $this->datepub = new \DateTime('now');

        $this->imageSize =90000000;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->datepub = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
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
     * @return \DateTime
     */
    public function getDatepub(): ?\DateTime
    {
        return $this->datepub;
    }


    /**
     * @param \DateTime $datepub
     */
    public function setDatepub($datepub): void
    {
        $this->datepub = $datepub;
    }

    /**
     * @return string
     */
    public function getNomartiste(): ?string
    {
        return $this->nomartiste;
    }

    /**
     * @param string $nomartiste
     */
    public function setNomartiste(string $nomartiste): void
    {
        $this->nomartiste = $nomartiste;
    }

    /**
     * @return string|null
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @param string|null $titre
     */
    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }



    /**
     * @return \DateTime
     */
    public function getDuree(): ?\DateTime
    {
        return $this->duree;
    }

    /**
     * @param \DateTime $duree
     */
    public function setDuree(\DateTime $duree): void
    {
        $this->duree = $duree;
    }




//
//    public function getUser(): ?User
//    {
//        return $this->User;
//    }
//
//    public function setUser(?User $User): self
//    {
//        $this->User = $User;
//
//        return $this;
//    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @param int|null $imageSize
     */
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

  /* public function getListoeuvre(): ?Categorie
    {
        return $this->listoeuvre;
    }

    public function setListoeuvre(?Categorie $listoeuvre): self
    {
        $this->listoeuvre = $listoeuvre;

        return $this;
    }*/
//    public function toString()
//    {
//        // TODO: Implement __toString() method.
//        $this->nomartiste;
//    }


}
