<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment_article;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment_fan_art;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FanArt", inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $fan_art;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentArticle(): ?string
    {
        return $this->comment_article;
    }

    public function setCommentArticle(string $comment_article): self
    {
        $this->comment_article = $comment_article;

        return $this;
    }

    public function getCommentFanArt(): ?string
    {
        return $this->comment_fan_art;
    }

    public function setCommentFanArt(string $comment_fan_art): self
    {
        $this->comment_fan_art = $comment_fan_art;

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

    public function getArticleId(): ?Article
    {
        return $this->article;
    }

    public function setArticleId(?Article $article): self
    {
        $this->article_id = $article;

        return $this;
    }

    public function getFanArtId(): ?FanArt
    {
        return $this->fan_art;
    }

    public function setFanArtId(?FanArt $fan_art): self
    {
        $this->fan_art = $fan_art;

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
}
