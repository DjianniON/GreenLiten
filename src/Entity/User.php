<?php
namespace App\Entity;
 
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
 
 
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email address already used.")
 * @UniqueEntity(fields="username", message="Username already used.")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
 
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $fullName;
 
    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     */
    private $username;
 
    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
 
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;
 
    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Donation", mappedBy="user")
     */
    private $donations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BlogPost", mappedBy="Author")
     */
    private $blogPosts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BlogComm", mappedBy="Author")
     */
    private $blogComms;

    public function __construct()
    {
        $this->donations = new ArrayCollection();
        $this->blogPosts = new ArrayCollection();
        $this->blogComms = new ArrayCollection();
    }

 
 
    public function getId(): int
    {
        return $this->id;
    }
 
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }
 
    // le ? signifie que cela peur aussi retourner null
    public function getFullName(): ?string
    {
        return $this->fullName;
    }
 
    public function getUsername(): ?string
    {
        return $this->username;
    }
 
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
 
    public function getEmail(): ?string
    {
        return $this->email;
    }
 
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
 
    public function getPassword(): ?string
    {
        return $this->password;
    }
 
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
 
    /**
     * Retourne les rôles de l'user
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
 
        // Afin d'être sûr qu'un user a toujours au moins 1 rôle
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }
 
        return array_unique($roles);
    }
 
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
 
    /**
     * Retour le salt qui a servi à coder le mot de passe
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one
 
        return null;
    }
 
    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // Nous n'avons pas besoin de cette methode car nous n'utilions pas de plainPassword
        // Mais elle est obligatoire car comprise dans l'interface UserInterface
        // $this->plainPassword = null;
    }
 
    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return serialize([$this->id, $this->username, $this->password]);
    }
 
    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->fullName;
        // to show the id of the Category in the select
        return $this->username;
    }

    /**
     * @return Collection|Donation[]
     */
    public function getDonations(): Collection
    {
        return $this->donations;
    }

    public function addDonation(Donation $donation): self
    {
        if (!$this->donations->contains($donation)) {
            $this->donations[] = $donation;
            $donation->setUser($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): self
    {
        if ($this->donations->contains($donation)) {
            $this->donations->removeElement($donation);
            // set the owning side to null (unless already changed)
            if ($donation->getUser() === $this) {
                $donation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getBlogPosts(): Collection
    {
        return $this->blogPosts;
    }

    public function addBlogPost(BlogPost $blogPost): self
    {
        if (!$this->blogPosts->contains($blogPost)) {
            $this->blogPosts[] = $blogPost;
            $blogPost->setAuthor($this);
        }

        return $this;
    }

    public function removeBlogPost(BlogPost $blogPost): self
    {
        if ($this->blogPosts->contains($blogPost)) {
            $this->blogPosts->removeElement($blogPost);
            // set the owning side to null (unless already changed)
            if ($blogPost->getAuthor() === $this) {
                $blogPost->setAuthor(null);
            }
        }

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
            $blogComm->setAuthor($this);
        }

        return $this;
    }

    public function removeBlogComm(BlogComm $blogComm): self
    {
        if ($this->blogComms->contains($blogComm)) {
            $this->blogComms->removeElement($blogComm);
            // set the owning side to null (unless already changed)
            if ($blogComm->getAuthor() === $this) {
                $blogComm->setAuthor(null);
            }
        }

        return $this;
    }

}
