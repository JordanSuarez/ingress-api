<?php

namespace App\Entity;

use App\Repository\CoordinateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoordinateRepository::class)
 */
class Coordinate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="float")
     */
    private float $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private float $longitude;

    /**
     * @ORM\OneToOne(targetEntity=Mission::class, mappedBy="coords", cascade={"persist", "remove"})
     */
    private ?Mission $mission;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(?Mission $mission): self
    {
        // unset the owning side of the relation if necessary
        if ($mission === null && $this->mission !== null) {
            $this->mission->setCoords(null);
        }

        // set the owning side of the relation if necessary
        if ($mission !== null && $mission->getCoords() !== $this) {
            $mission->setCoords($this);
        }

        $this->mission = $mission;

        return $this;
    }
}
