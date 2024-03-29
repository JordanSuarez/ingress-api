<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $icon;

    /**
     * @ORM\OneToOne(targetEntity=Coordinate::class, inversedBy="mission", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="coords_id", referencedColumnName="id")
     */
    private Coordinate $coords;

    /**
     * @ORM\OneToMany(targetEntity=Waypoint::class, mappedBy="mission", cascade={"persist"}, fetch="EAGER")
     */
    private Collection $waypoints;

    public function __construct()
    {
        $this->waypoints = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getCoords(): Coordinate
    {
        return $this->coords;
    }

    public function setCoords(Coordinate $coords): self
    {
        $this->coords = $coords;
        return $this;
    }

    /**
     * @return Collection|Waypoint[]
     */
    public function getWaypoints(): Collection
    {
        return $this->waypoints;
    }

    public function addWaypoint(Waypoint $waypoint): self
    {
        if (!$this->waypoints->contains($waypoint)) {
            $this->waypoints[] = $waypoint;
            $waypoint->setMission($this);
        }

        return $this;
    }

    public function removeWaypoint(Waypoint $waypoint): self
    {
        if ($this->waypoints->removeElement($waypoint)) {
            // set the owning side to null (unless already changed)
            if ($waypoint->getMission() === $this) {
                $waypoint->setMission(null);
            }
        }

        return $this;
    }
}
