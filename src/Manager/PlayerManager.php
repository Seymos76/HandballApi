<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 05/10/18
 * Time: 13:51
 */

namespace App\Manager;


use App\Entity\Player;
use Cocur\Slugify\Slugify;

class PlayerManager extends ImageManager
{
    public function createPlayer(array $formData)
    {
        $player = new Player();
        $player->setFirstname(ucfirst($formData['firstname']));
        $player->setLastname(ucwords($formData['lastname']));
        $player->setFullname($player->getFirstname(). " " .$player->getLastname());
        $player->setPosition($formData['position']);
        $player->setTeam($formData['team']);
        $filename = $this->uploadFile($formData['image'], $this->container->getParameter('hb.player_image'));
        $player->setImage($filename);
        $this->update($player);
        return $player;
    }

    public function updatePayer(array $formData)
    {
        if ($formData['image'] !== null) {
            // fetch player
            $player = $this->getManager()->getRepository(Player::class)->findOneBy(
                array(
                    'firstname' => $formData['fistname'],
                    'lastname' => $formData['lastname'],
                )
            );
            if (!$player) {
                return;
            }
            // upload image
            $filename = $this->uploadFile($formData['image'], $this->container->getParameter('hb.player_image'));
            // set new image to player
            $player->setImage($filename);
            $this->update($player);
        }
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
