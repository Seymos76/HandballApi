<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 05/10/18
 * Time: 14:09
 */

namespace App\Manager;


use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;

class GameManager extends EntityManager
{
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager);
    }

    /**
     * @return Game
     */
    public function getFutureGame()
    {
        $future = $this->getManager()->getRepository(Game::class)->findFutureGame();
        return $future;
    }

    public function formatObjectToJson(Game $game)
    {
        $json = array(
            'id' => $game->getId(),
            'match_date' => $game->getMatchDate(),
            'location' => $game->getLocation(),
            'opponent' => $game->getOpponent(),
            'winner' => $game->getWinner(),
            'looser' => $game->getLooser(),
            'winner_score' => $game->getWinnerScore(),
            'looser_score' => $game->getLooserScore()
        );
        return $json;
    }

    public function formatArrayToJson(array $games)
    {
        $json = [];
        foreach ($games as $game) {
            $json[] = [
                'id' => $game->getId(),
                'match_date' => $game->getMatchDate(),
                'location' => $game->getLocation(),
                'opponent' => $game->getOpponent(),
                'winner' => $game->getWinner(),
                'looser' => $game->getLooser(),
                'winner_score' => $game->getWinnerScore(),
                'looser_score' => $game->getLooserScore(),
            ];
        }
        return $json;
    }
}
