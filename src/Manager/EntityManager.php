<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 21:28
 */

namespace App\Manager;


use Doctrine\ORM\EntityManagerInterface;

class EntityManager
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function persist($entity)
    {
        $this->manager->persist($entity);
    }

    public function flush()
    {
        $this->manager->flush();
    }

    public function update($entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }

    public function remove($entity)
    {
        $this->manager->remove($entity);
        $this->manager->flush();
    }

    /**
     * @return EntityManagerInterface
     */
    public function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
}
