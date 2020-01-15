<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FanArtRepository")
 */
class FanArt
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fan_art_title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fan_art_hook;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fan_art_sketch;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="fan_art_id")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="fan_art_id")
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="fanArts")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Editor", mappedBy="fanArts")
     */
    private $editor_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->editor_id = new ArrayCollection();
        $this->setIsConfirmed(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFanArtTitle(): ?string
    {
        return $this->fan_art_title;
    }

    public function setFanArtTitle(string $fan_art_title): self
    {
        $this->fan_art_title = $fan_art_title;

        return $this;
    }

    public function getFanArtHook(): ?string
    {
        return $this->fan_art_hook;
    }

    public function setFanArtHook(?string $fan_art_hook): self
    {
        $this->fan_art_hook = $fan_art_hook;

        return $this;
    }

    public function getFanArtSketch(): ?string
    {
        return $this->fan_art_sketch;
    }

    public function setFanArtSketch(string $fan_art_sketch): self
    {
        $this->fan_art_sketch = $fan_art_sketch;

        return $this;
    }

    public function getIsConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

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
            $comment->setFanArtId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getFanArtId() === $this) {
                $comment->setFanArtId(null);
            }
        }

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Editor[]
     */
    public function getEditorId(): Collection
    {
        return $this->editor_id;
    }

    public function addEditorId(Editor $editorId): self
    {
        if (!$this->editor_id->contains($editorId)) {
            $this->editor_id[] = $editorId;
        }

        return $this;
    }

    public function removeEditorId(Editor $editorId): self
    {
        if ($this->editor_id->contains($editorId)) {
            $this->editor_id->removeElement($editorId);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
