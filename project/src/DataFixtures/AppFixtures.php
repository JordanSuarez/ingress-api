<?php

namespace App\DataFixtures;

use App\Entity\Coordinate;
use App\Entity\Mission;
use App\Entity\Waypoint;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $missionsJson = json_decode(file_get_contents('missions.json'), true);

        for ($i = 0; $i < count($missionsJson); $i++) {
              $mission = new Mission();
              $coords = new Coordinate();

              for ($j = 0; $j < count($missionsJson[$i]['waypoints']); $j++) {
                  $waypoint = new Waypoint();
                  $waypointCoords = new Coordinate();
                  $waypointCoords->setLatitude($missionsJson[$i]['waypoints'][$j]['coords'][0]);
                  $waypointCoords->setLongitude($missionsJson[$i]['waypoints'][$j]['coords'][1]);

                  $waypoint->setName($missionsJson[$i]['waypoints'][$j]['name']);
                  $waypoint->setType($missionsJson[$i]['waypoints'][$j]['type']);
                  $waypoint->setType($missionsJson[$i]['waypoints'][$j]['type']);
                  $waypoint->setCoords($waypointCoords);

                  $mission->addWaypoint($waypoint);
              }

                  $coords->setLatitude($missionsJson[$i]['coords'][0]);
                  $coords->setLongitude($missionsJson[$i]['coords'][1]);

                  $mission->setName($missionsJson[$i]['name']);
                  $mission->setIcon($missionsJson[$i]['icon']);
                  $mission->setCoords($coords);

              $manager->persist($mission);
        }

        $manager->flush();
    }
}
