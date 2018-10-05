<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 18:11
 */

namespace App\DataFixtures;


use App\Entity\TrainingCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TrainingCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 8; $i++) {
            $category = new TrainingCategory();
            $category->setName("Category $i");
            $this->addReference('category'.$i, $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
