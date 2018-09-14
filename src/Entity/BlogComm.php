<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogCommRepository")
 */
class BlogComm
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;




    /**
     * @ORM\Column(type="datetime")
     */
    private $post_date;

    /**
     * @ORM\Column(type="text")
     */
    private $post_content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BlogPost", inversedBy="blogComms")
     */
    private $Post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="blogComms")
     */
    private $Author;

    public function getId()
    {
        return $this->id;
    }

    public function getPostId(): ?int
    {
        return $this->post_id_;
    }

    public function setPostId(int $post_id_): self
    {
        $this->post_id_ = $post_id_;

        return $this;
    }

    public function getPostDate(): ?\DateTimeInterface
    {
        return $this->post_date;
    }

    public function setPostDate(\DateTimeInterface $post_date): self
    {
        $this->post_date = $post_date;

        return $this;
    }

    public function getPostContent(): ?string
    {
        return $this->post_content;
    }

    public function setPostContent(string $post_content): self
    {
        $this->post_content = $post_content;

        return $this;
    }

    public function getPost(): ?BlogPost
    {
        return $this->Post;
    }

    public function setPost(?BlogPost $Post): self
    {
        $this->Post = $Post;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): self
    {
        $this->Author = $Author;

        return $this;
    }
    
    public function __toString(){
        // to show the name of the Category in the select
        return 'Comm';
   
    }
}
