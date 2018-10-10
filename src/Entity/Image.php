<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ApiResource()
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $extension;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mime_type;

    /**
     * @ORM\Column(type="float")
     */
    private $size;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", mappedBy="image", cascade={"persist", "remove"})
     */
    private $player;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Team", mappedBy="image", cascade={"persist", "remove"})
     */
    private $team;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Slide", mappedBy="image", cascade={"persist", "remove"})
     */
    private $slide;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Galery", inversedBy="images")
     */
    private $gallery;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mime_type;
    }

    public function setMimeType(string $mime_type): self
    {
        $this->mime_type = $mime_type;

        return $this;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(float $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        // set (or unset) the owning side of the relation if necessary
        $newImage = $player === null ? null : $this;
        if ($newImage !== $player->getImage()) {
            $player->setImage($newImage);
        }

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        // set (or unset) the owning side of the relation if necessary
        $newImage = $team === null ? null : $this;
        if ($newImage !== $team->getImage()) {
            $team->setImage($newImage);
        }

        return $this;
    }

    public function getSlide(): ?Slide
    {
        return $this->slide;
    }

    public function setSlide(Slide $slide): self
    {
        $this->slide = $slide;

        // set the owning side of the relation if necessary
        if ($this !== $slide->getImage()) {
            $slide->setImage($this);
        }

        return $this;
    }

    public function getGallery(): ?Galery
    {
        return $this->gallery;
    }

    public function setGallery(?Galery $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
