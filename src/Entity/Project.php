<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
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
    private $pr_title;

    /**
     * @ORM\Column(type="text")
     */
    private $pr_desc;

    /**
     * @ORM\Column(type="float")
     */
    private $pr_montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pr_status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Donation", mappedBy="project")
     */
    private $donations;


    public function __construct()
    {
        $this->donations = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPrTitle(): ?string
    {
        return $this->pr_title;
    }

    public function setPrTitle(string $pr_title): self
    {
        $this->pr_title = $pr_title;

        return $this;
    }

    public function getPrDesc(): ?string
    {
        return $this->pr_desc;
    }

    public function setPrDesc(string $pr_desc): self
    {
        $this->pr_desc = $pr_desc;

        return $this;
    }

    public function getPrMontant(): ?float
    {
        return $this->pr_montant;
    }

    public function setPrMontant(float $pr_montant): self
    {
        $this->pr_montant = $pr_montant;

        return $this;
    }

    public function getPrStatus(): ?string
    {
        return $this->pr_status;
    }

    public function setPrStatus(string $pr_status): self
    {
        $this->pr_status = $pr_status;

        return $this;
    }
    
    public function __toString(){
       return $this->pr_title;
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
            $donation->setProject($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): self
    {
        if ($this->donations->contains($donation)) {
            $this->donations->removeElement($donation);
            // set the owning side to null (unless already changed)
            if ($donation->getProject() === $this) {
                $donation->setProject(null);
            }
        }

        return $this;
    }
}
