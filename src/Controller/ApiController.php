<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/players", name="api_players", methods={"GET"})
     */
    public function getPlayers(PlayerRepository $repository)
    {
        $players = $repository->findAll();
        $data = json_encode($players);
        $response = new Response($data, Response::HTTP_OK,array('Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => 1));
        return $response;
    }
}
