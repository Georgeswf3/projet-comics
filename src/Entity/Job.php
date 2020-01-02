<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $job_writer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $job_penciler;

    /**
     * @ORM\Column(type="boolean")
     */
    private $job_inker;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Author", inversedBy="jobs")
     */
    private $author_id;

    public function __construct()
    {
        $this->author_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobWriter(): ?bool
    {
        return $this->job_writer;
    }

    public function setJobWriter(bool $job_writer): self
    {
        $this->job_writer = $job_writer;

        return $this;
    }

    public function getJobPenciler(): ?bool
    {
        return $this->job_penciler;
    }

    public function setJobPenciler(bool $job_penciler): self
    {
        $this->job_penciler = $job_penciler;

        return $this;
    }

    public function getJobInker(): ?bool
    {
        return $this->job_inker;
    }

    public function setJobInker(bool $job_inker): self
    {
        $this->job_inker = $job_inker;

        return $this;
    }

    /**
     * @return Collection|Author[]
     */
    public function getAuthorId(): Collection
    {
        return $this->author_id;
    }

    public function addAuthorId(Author $authorId): self
    {
        if (!$this->author_id->contains($authorId)) {
            $this->author_id[] = $authorId;
        }

        return $this;
    }

    public function removeAuthorId(Author $authorId): self
    {
        if ($this->author_id->contains($authorId)) {
            $this->author_id->removeElement($authorId);
        }

        return $this;
    }
}
