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
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class GameFixtures extends Fixture implements DependentFixtureInterface
{
    private $serviceDate;

    public function __construct(\App\Service\Date $serviceDate)
    {
        $this->serviceDate = $serviceDate;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 7; $i++) {
            $match = new Game();
            $match->setMatchDate($this->serviceDate->getSaturday());
            $match->setLocation($this->getRandLocation());
            $match->setOpponent($this->getRandLocation());
            $team = $this->getReference("team".mt_rand(1,4));
            $match->setTeam($team);
            $manager->persist($match);
        }
        for ($i = 8; $i <= 16; $i++) {
            $match = new Game();
            $match->setMatchDate("20-10-2018");
            $match->setLocation($this->getRandLocation());
            $match->setOpponent($this->getRandLocation());
            $team = $this->getReference("team".mt_rand(1,4));
            $match->setWinnerScore(20);
            $match->setLooserScore(15);
            $match->setTeam($team);
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

    public function getDependencies()
    {
        return array(
            TeamFixtures::class
        );
    }
}