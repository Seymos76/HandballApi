<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingRepository")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\TrainingCategory", inversedBy="trainings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trainingCategory;

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

    public function getTrainingCategory(): ?TrainingCategory
    {
        return $this->trainingCategory;
    }

    public function setTrainingCategory(?TrainingCategory $trainingCategory): self
    {
        $this->trainingCategory = $trainingCategory;

        return $this;
    }
}
