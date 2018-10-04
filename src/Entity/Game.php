<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
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
     * @ORM\Column(type="datetime", nullable=true)
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatchDate(): ?\DateTimeInterface
    {
        return $this->match_date;
    }

    public function setMatchDate(?\DateTimeInterface $match_date): self
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
}
