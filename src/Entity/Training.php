<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingRepository")
 * @ApiResource()
 */
class Training
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
    private $training_date;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Team", inversedBy="training", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainingDate(): ?\DateTimeInterface
    {
        return $this->training_date;
    }

    public function setTrainingDate(\DateTimeInterface $training_date): self
    {
        $this->training_date = $training_date;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): self
    {
        $this->team = $team;

        return $this;
    }
}
