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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Author", mappedBy="jobs")
     */
    private $author_id;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Job
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function __construct()
    {
        $this->author_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
