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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    public function getOne(int $id): stdClass
    {
        $mission = $this->findOneBy(['id' => $id]);

        $waypoints = $mission->getWaypoints();
        $formattedWaypoints = [];

        foreach ($waypoints as $waypoint) {
            $formattedWaypoint = new stdClass();
            $formattedWaypoint->name = $waypoint->getName();
            $formattedWaypoint->type = $waypoint->getType();
            $formattedWaypoint->coords = [
                0 => $waypoint->getCoords()->getLatitude(),
                1 => $waypoint->getCoords()->getLongitude(),
            ];

            $formattedWaypoints[] = $formattedWaypoint;
        }

        $data = new stdClass();

        $data->id = $mission->getId();
        $data->name = $mission->getName();
        $data->icon = $mission->getIcon();
        $data->coords = [
            0 => $mission->getCoords()->getLatitude(),
            1 => $mission->getCoords()->getLongitude(),
        ];
        $data->waypoints = $formattedWaypoints;

        return $data;
    }
}
