<?php

namespace App\Entity;

use App\Repository\PubliciteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=PubliciteRepository::class)
 */
class Publicite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min="8", minMessage=" description doit contenir au min 8 caractere")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="8", maxMessage=" pub name doit contenir au max 8 caractere")
     * @Assert\NotBlank
     */
    private $pubnom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbl;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="publicite")
     */
    private $relation;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="relation")
     */
    private $pubfk;

    /**
     * @ORM\OneToMany(targetEntity=Likes::class, mappedBy="pubfk")
     */
    private $likes;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
        $this->pubfk = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(?int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPubnom(): ?string
    {
        return $this->pubnom;
    }

    public function setPubnom(?string $pubnom): self
    {
        $this->pubnom = $pubnom;

        return $this;
    }

    public function getNbl(): ?int
    {
        return $this->nbl;
    }

    public function setNbl(?int $nbl): self
    {
        $this->nbl = $nbl;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Comment $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation[] = $relation;
            $relation->setPublicite($this);
        }

        return $this;
    }

    public function removeRelation(Comment $relation): self
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getPublicite() === $this) {
                $relation->setPublicite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getPubfk(): Collection
    {
        return $this->pubfk;
    }

    public function addPubfk(Comment $pubfk): self
    {
        if (!$this->pubfk->contains($pubfk)) {
            $this->pubfk[] = $pubfk;
            $pubfk->setRelation($this);
        }

        return $this;
    }

    public function removePubfk(Comment $pubfk): self
    {
        if ($this->pubfk->removeElement($pubfk)) {
            // set the owning side to null (unless already changed)
            if ($pubfk->getRelation() === $this) {
                $pubfk->setRelation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Likes[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Likes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setPubfk($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getPubfk() === $this) {
                $like->setPubfk(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->pubnom;
    }




}
