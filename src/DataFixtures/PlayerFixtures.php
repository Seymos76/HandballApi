<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 17:19
 */

namespace App\DataFixtures;


use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PlayerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 28; $i++) {
            $player = new Player();
            $player->setFirstname("Prénom$i");
            $player->setLastname("NOM$i");
            $player->setFullname($player->getFirstname() . " " . $player->getLastname());
            $player->setPosition($this->getRandPosition());
            $team = $this->getReference('team'.mt_rand(1,4));
            $player->setTeam($team);
            $manager->persist($player);
        }
        $manager->flush();
    }

    public function getRandPosition()
    {
        $positions = [
            "Centre arrière",
            "Ailier droit",
            "Ailier gauche",
            "Demi-centre",
            "Gardien de but",
            "Arrière gauche",
            "Arrière droit"
        ];
        $rand = array_rand($positions, 1);
        return $rand[0];
    }

    public function getDependencies()
    {
        return array(
            TeamFixtures::class
        );
    }
}
