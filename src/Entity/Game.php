<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 * @ApiResource()
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotNull()
     */
    private $match_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $opponent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $winner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $looser;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $winner_score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $looser_score;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="games")
     */
    private $team;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $appointment_location;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $appointment_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatchDate(): ?string
    {
        return $this->match_date;
    }

    public function setMatchDate(?string $match_date): self
    {
        $this->match_date = $match_date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOpponent(): ?string
    {
        return $this->opponent;
    }

    public function setOpponent(string $opponent): self
    {
        $this->opponent = $opponent;

        return $this;
    }

    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function setWinner(?string $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getLooser(): ?string
    {
        return $this->looser;
    }

    public function setLooser(?string $looser): self
    {
        $this->looser = $looser;

        return $this;
    }

    public function getWinnerScore(): ?int
    {
        return $this->winner_score;
    }

    public function setWinnerScore(?int $winner_score): self
    {
        $this->winner_score = $winner_score;

        return $this;
    }

    public function getLooserScore(): ?int
    {
        return $this->looser_score;
    }

    public function setLooserScore(?int $looser_score): self
    {
        $this->looser_score = $looser_score;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getAppointmentLocation(): ?string
    {
        return $this->appointment_location;
    }

    public function setAppointmentLocation(string $appointment_location): self
    {
        $this->appointment_location = $appointment_location;

        return $this;
    }

    public function getAppointmentDate(): ?\DateTimeInterface
    {
        return $this->appointment_date;
    }

    public function setAppointmentDate(\DateTimeInterface $appointment_date): self
    {
        $this->appointment_date = $appointment_date;

        return $this;
    }
}
