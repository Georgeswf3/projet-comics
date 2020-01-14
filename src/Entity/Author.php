<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $author_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $author_first_name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $facebook_page;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $author_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $creation_image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", mappedBy="authors")
     */
    private $article_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FanArt", mappedBy="author")
     */
    private $fan_art_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Job", inversedBy="author_id")
     */
    private $jobs;

    public function __construct()
    {
        $this->article_id = new ArrayCollection();
        $this->fan_art_id = new ArrayCollection();
        $this->jobs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorName(): ?string
    {
        return $this->author_name;
    }

    public function setAuthorName(string $author_name): self
    {
        $this->author_name = $author_name;

        return $this;
    }

    public function getAuthorFirstName(): ?string
    {
        return $this->author_first_name;
    }

    public function setAuthorFirstName(string $author_first_name): self
    {
        $this->author_first_name = $author_first_name;

        return $this;
    }

    public function getFacebookPage(): ?string
    {
        return $this->facebook_page;
    }

    public function setFacebookPage(?string $facebook_page): self
    {
        $this->facebook_page = $facebook_page;

        return $this;
    }

    public function getAuthorImage(): ?string
    {
        return $this->author_image;
    }

    public function setAuthorImage(?string $author_image): self
    {
        $this->author_image = $author_image;

        return $this;
    }

    public function getCreationImage(): ?string
    {
        return $this->creation_image;
    }

    public function setCreationImage(?string $creation_image): self
    {
        $this->creation_image = $creation_image;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticleId(): Collection
    {
        return $this->article_id;
    }

    public function addArticleId(Article $articleId): self
    {
        if (!$this->article_id->contains($articleId)) {
            $this->article_id[] = $articleId;
        }

        return $this;
    }

    public function removeArticleId(Article $articleId): self
    {
        if ($this->article_id->contains($articleId)) {
            $this->article_id->removeElement($articleId);
        }

        return $this;
    }

    /**
     * @return Collection|FanArt[]
     */
    public function getFanArtId(): Collection
    {
        return $this->fan_art_id;
    }

    public function addFanArtId(FanArt $fanArtId): self
    {
        if (!$this->fan_art_id->contains($fanArtId)) {
            $this->fan_art_id[] = $fanArtId;
            $fanArtId->setAuthor($this);
        }

        return $this;
    }

    public function removeFanArtId(FanArt $fanArtId): self
    {
        if ($this->fan_art_id->contains($fanArtId)) {
            $this->fan_art_id->removeElement($fanArtId);
            // set the owning side to null (unless already changed)
            if ($fanArtId->getAuthor() === $this) {
                $fanArtId->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
            $job->addAuthorId($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            $job->removeAuthorId($this);
        }

        return $this;
    }
}
