<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MissionController extends BaseController
{
    /** @var MissionRepository  */
    private MissionRepository $missionRepository;

    /**
     * MissionController constructor.
     * @param MissionRepository $missionRepository
     * @param SerializerInterface $serialize
     */
    public function __construct(MissionRepository $missionRepository, SerializerInterface $serialize)
    {
        parent::__construct($serialize);
        $this->missionRepository = $missionRepository;
    }

    /**
     * @Route("/mission/{mission_id}", name="get_one_mission", requirements={"mission_id": "\d+"}, methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getOne(Request $request): Response
    {
        $id = $request->attributes->get('mission_id');
        $mission = $this->missionRepository->getOne($id);

        return new JsonResponse($mission, Response::HTTP_OK);
    }

    /**
     * @Route("/missions", name="mission", methods={"GET"})
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $missions = $this->missionRepository->findAll();
        $data = [];

        foreach ($missions as $mission) {
            $data[] = $this->missionRepository->getOne($mission->getId());
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
