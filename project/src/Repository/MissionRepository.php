<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use stdClass;

/**
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    private WaypointRepository $waypointRepository;

    private CoordinateRepository $coordinateRepository;

    public function __construct(ManagerRegistry $registry, WaypointRepository $waypointRepository, CoordinateRepository $coordinateRepository)
    {
        parent::__construct($registry, Mission::class);
        $this->waypointRepository = $waypointRepository;
        $this->coordinateRepository = $coordinateRepository;
    }

    public function getOne(int $id): stdClass
    {
        $mission = $this->findOneBy(['id' => $id]);
        $waypoints = $mission->getWaypoints();
        $formattedWaypoints = [];

        foreach ($waypoints as $waypoint) {
            $formattedWaypoint = $this->waypointRepository->getOne($waypoint->getId());
            $formattedWaypoints[] = $formattedWaypoint;
        }

        $data = new stdClass();
        $data->id = $mission->getId();
        $data->name = $mission->getName();
        $data->icon = $mission->getIcon();
        $data->coords = $this->coordinateRepository->getOne($mission->getCoords()->getId());
        $data->waypoints = $formattedWaypoints;

        return $data;
    }

    public function getAll(): array
    {
        $missions = $this->findAll();
        $data = [];

        foreach ($missions as $mission) {
            $data[] = $this->getOne($mission->getId());
        }

        return $data;
    }
}
