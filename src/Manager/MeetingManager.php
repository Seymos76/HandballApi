<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 25/10/18
 * Time: 17:37
 */

namespace App\Manager;


use App\Entity\Meeting;

class MeetingManager extends EntityManager
{
    public function saveMeetingGames(Meeting $meeting)
    {
        $games = $meeting->getGames();
        foreach ($games as $game) {
            $game->setMeeting($meeting);
            $this->update($game);
        }
        return true;
    }
}