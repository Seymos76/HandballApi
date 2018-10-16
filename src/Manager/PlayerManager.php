<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 05/10/18
 * Time: 13:51
 */

namespace App\Manager;


use Doctrine\ORM\EntityManagerInterface;

class PlayerManager extends EntityManager
{
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager);
    }

    public function formatToJson(array $players)
    {
        $json = [];
        foreach ($players as $player) {
            $json[] = [
                'id' => $player->getId(),
                'firstname' => $player->getFirstname(),
                'lastname' => $player->getLastname(),
                'fullname' => $player->getFullname(),
                'position' => $player->getPosition(),
                'team' => $player->getTeam()->getName(),
                'image' => $player->getImage()
            ];
        }
        return $json;
    }
}
