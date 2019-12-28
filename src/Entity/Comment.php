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
     * @ORM\Column(type="text")
     */
    private $comment_article;

    /**
     * @ORM\Column(type="text")
     */
    private $comment_fan_art;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FanArt", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fan_art_id;

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
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getArticleId(): ?Article
    {
        return $this->article_id;
    }

    public function setArticleId(?Article $article_id): self
    {
        $this->article_id = $article_id;

        return $this;
    }

    public function getFanArtId(): ?FanArt
    {
        return $this->fan_art_id;
    }

    public function setFanArtId(?FanArt $fan_art_id): self
    {
        $this->fan_art_id = $fan_art_id;

        return $this;
    }
}
