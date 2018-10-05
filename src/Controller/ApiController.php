<?php

namespace App\Controller;

use App\Entity\Game;
use App\Manager\GameManager;
use App\Manager\PlayerManager;
use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 * @Rest\Prefix("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/players", name="api_players", methods={"GET"})
     */
    public function getPlayers(PlayerRepository $repository, PlayerManager $playerManager)
    {
        $players = $repository->findAll();
        $json = $playerManager->formatToJson($players);
        $data = json_encode($json);
        $response = new Response($data, Response::HTTP_OK, array('Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => 1));
        return $response;
    }

    /**
     * @Rest\Route("/future-game", methods={"GET"})
     */
    public function home(GameRepository $gameRepository, GameManager $gameManager)
    {
        $futureGame = $gameManager->getFutureGame();
        dump($futureGame);
        die;
        $json = $gameManager->formatObjectToJson($futureGame);
        $data = json_encode($json);
        $response = new Response($data, Response::HTTP_OK, array('Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => 1));
        return $response;
    }
}
