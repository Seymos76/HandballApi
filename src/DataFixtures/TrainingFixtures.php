<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 18:09
 */

namespace App\DataFixtures;


use App\Entity\Training;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TrainingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $training = new Training();
            $training->setTrainingDate(new \DateTime('now'));
            $team = $this->getReference('team'.rand(1,4));
            $training->setTeam($team);
        }
    }

    public function getDependencies()
    {
        return array(
            TeamFixtures::class
        );
    }
}
