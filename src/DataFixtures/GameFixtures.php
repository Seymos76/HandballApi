<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 18:04
 */

namespace App\DataFixtures;


use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $match = new Game();
            $match->setLocation($this->getRandLocation());
            $match->setMatchDate(new \DateTime('10-11-2018'));
            $match->setOpponent($this->getRandLocation());
            $manager->persist($match);
        }
        $manager->flush();
    }

    public function getRandLocation(): ?string
    {
        $locations = array(
            "Forges-les-Eaux",
            "Rouen",
            "Gournay",
            "Neufchâtel",
            "Montville"
        );
        $rand = array_rand($locations, 1);
        return $rand;
    }
}