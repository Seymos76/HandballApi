<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingCategoryRepository")
 */
class TrainingCategory
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Training", mappedBy="trainingCategory")
     */
    private $trainings;

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->setTrainingCategory($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->contains($training)) {
            $this->trainings->removeElement($training);
            // set the owning side to null (unless already changed)
            if ($training->getTrainingCategory() === $this) {
                $training->setTrainingCategory(null);
            }
        }

        return $this;
    }
}