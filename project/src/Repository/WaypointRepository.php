<?php

namespace App\Repository;

use App\Entity\Waypoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use stdClass;

/**
 * @method Waypoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Waypoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Waypoint[]    findAll()
 * @method Waypoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WaypointRepository extends ServiceEntityRepository
{
    private CoordinateRepository $coordinateRepository;

    public function __construct(ManagerRegistry $registry, CoordinateRepository $coordinateRepository)
    {
        parent::__construct($registry, Waypoint::class);
        $this->coordinateRepository = $coordinateRepository;
    }

    public function getOne(int $id): stdClass
    {
        $waypoint = $this->findOneBy(['id' => $id]);

        $formattedWaypoint = new stdClass();
        $formattedWaypoint->name = $waypoint->getName();
        $formattedWaypoint->type = $waypoint->getType();
        $formattedWaypoint->coords = $this->coordinateRepository->getOne($waypoint->getCoords()->getId());

        return $formattedWaypoint;
    }
}
