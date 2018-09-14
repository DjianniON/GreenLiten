<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DonationRepository")
 */
class Donation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $don_value;

    /**
     * @ORM\Column(type="datetime")
     */
    private $don_date;

    /**
     * @ORM\Column(type="text")
     */
    private $don_comm;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="donations")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="donations")
     */
    private $project;


    public function getId()
    {
        return $this->id;
    }

    public function getDonValue(): ?float
    {
        return $this->don_value;
    }

    public function setDonValue(float $don_value): self
    {
        $this->don_value = $don_value;

        return $this;
    }

    public function getDonDate(): ?\DateTimeInterface
    {
        return $this->don_date;
    }

    public function setDonDate(\DateTimeInterface $don_date): self
    {
        $this->don_date = $don_date;

        return $this;
    }

    public function getDonComm(): ?string
    {
        return $this->don_comm;
    }

    public function setDonComm(string $don_comm): self
    {
        $this->don_comm = $don_comm;

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function __toString(){
        return 'Donation';
     }
}
