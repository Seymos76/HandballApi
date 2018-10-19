<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 17:14
 */

namespace App\DataFixtures;


use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TeamFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 4; $i++) {
            $team = new Team();
            $team->setName("Equipe $i");
            $team->setLeague("Ligue $i");
            $team->setSeason("2018");
            $this->addReference('team'.$i, $team);
            $manager->persist($team);
        }
        $manager->flush();
    }
}
