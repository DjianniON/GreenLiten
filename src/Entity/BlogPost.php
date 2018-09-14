<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogPostRepository")
 */
class BlogPost
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
    private $post_title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $post_content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $post_tag;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="blogPosts")
     */
    private $Author;

    /**
     * @ORM\Column(type="string")
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BlogComm", mappedBy="Post")
     */
    private $blogComms;

    public function __construct()
    {
        $this->blogComms = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPostTitle(): ?string
    {
        return $this->post_title;
    }

    public function setPostTitle(string $post_title): self
    {
        $this->post_title = $post_title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

  
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getPostTag(): ?string
    {
        return $this->post_tag;
    }

    public function setPostTag(string $post_tag): self
    {
        $this->post_tag = $post_tag;

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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection|BlogComm[]
     */
    public function getBlogComms(): Collection
    {
        return $this->blogComms;
    }

    public function addBlogComm(BlogComm $blogComm): self
    {
        if (!$this->blogComms->contains($blogComm)) {
            $this->blogComms[] = $blogComm;
            $blogComm->setPost($this);
        }

        return $this;
    }

    public function removeBlogComm(BlogComm $blogComm): self
    {
        if ($this->blogComms->contains($blogComm)) {
            $this->blogComms->removeElement($blogComm);
            // set the owning side to null (unless already changed)
            if ($blogComm->getPost() === $this) {
                $blogComm->setPost(null);
            }
        }

        return $this;
    }
   
    public function __toString(){
        // to show the name of the Category in the select
        return $this->post_title;
   
    }
}
