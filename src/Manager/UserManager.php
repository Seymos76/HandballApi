<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 05/10/18
 * Time: 23:56
 */

namespace App\Manager;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager extends EntityManager
{
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager);
    }

    /**
     * @param string $email
     * @param string $role
     * @return User|null|object
     */
    public function upgradeUser(string $email, string $role)
    {
        $user = $this->getManager()->getRepository(User::class)->findOneBy(['email' => $email]);
        $user->addRole($role);
        $this->update($user);
        return $user;
    }
}