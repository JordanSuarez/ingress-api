<?php

namespace App\Entity;

use App\Repository\WaypointRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=WaypointRepository::class)
 */
class Waypoint
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $type;

    /**
     * @ORM\OneToOne(targetEntity=Coordinate::class, cascade={"persist", "remove"}, cascade={"persist"})
     */
    private ?Coordinate $coords;

    /**
     * @ORM\ManyToOne(targetEntity=Mission::class, inversedBy="waypoints", cascade={"persist"}, fetch="EAGER")
     * @JoinColumn(name="mission_id", referencedColumnName="id")
     */
    private ?Mission $mission;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCoords(): ?Coordinate
    {
        return $this->coords;
    }

    public function setCoords(?Coordinate $coords): self
    {
        $this->coords = $coords;

        return $this;
    }

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(?Mission $mission): self
    {
        $this->mission = $mission;

        return $this;
    }
}
