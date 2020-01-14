<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EditorRepository")
 */
class Editor
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
    private $editor_brand;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\FanArt", inversedBy="editor_id")
     */
    private $fanArts;

    public function __construct()
    {
        $this->fanArts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEditorBrand(): ?string
    {
        return $this->editor_brand;
    }

    public function setEditorBrand(string $editor_brand): self
    {
        $this->editor_brand = $editor_brand;

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
            $fanArt->addEditorId($this);
        }

        return $this;
    }

    public function removeFanArt(FanArt $fanArt): self
    {
        if ($this->fanArts->contains($fanArt)) {
            $this->fanArts->removeElement($fanArt);
            $fanArt->removeEditorId($this);
        }

        return $this;
    }
}
