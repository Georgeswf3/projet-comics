<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar_image;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user_id")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FanArt", mappedBy="user_id")
     */
    private $fanArts;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->fanArts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatarImage(): ?string
    {
        return $this->avatar_image;
    }

    public function setAvatarImage(?string $avatar_image): self
    {
        $this->avatar_image = $avatar_image;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUserId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUserId() === $this) {
                $comment->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FanArt[]
     */
    public function getFanArts(): Collection
    {
        return $this->fanArts;
    }

    public function addFanArt(FanArt $fanArt): self
    {
        if (!$this->fanArts->contains($fanArt)) {
            $this->fanArts[] = $fanArt;
            $fanArt->setUserId($this);
        }

        return $this;
    }

    public function removeFanArt(FanArt $fanArt): self
    {
        if ($this->fanArts->contains($fanArt)) {
            $this->fanArts->removeElement($fanArt);
            // set the owning side to null (unless already changed)
            if ($fanArt->getUserId() === $this) {
                $fanArt->setUserId(null);
            }
        }

        return $this;
    }
}
