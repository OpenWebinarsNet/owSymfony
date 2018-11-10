<?php

namespace  OngBundle\Services;

use Doctrine\ORM\EntityManager;
use OngBundle\Entity\Users;

class UserService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getUsers()
    {

        return $this->em->getRepository('OngBundle:Users')
            ->find(2);
    }

    public function getUsersWhereEmailNotNull() {

        $repo = $this->em->getRepository("OngBundle:Users");
        $query = $repo->createQueryBuilder("qb")
            ->where("email == 'email'")
            ->getQuery();

        $results = $query->getResults();
    }

    public function insertUser() {

        $user = $this->em->getRepository('OngBundle:Users')
            ->find(4);
        $user->setEmail('email de prueba mod');
        $user->setName('nombre de prueba modified');

        $this->em->persist($user);
        $flush=$this->em->flush();
        if ($flush !== null) {
        }
    }

    public function deleteUser($id)
    {

        $user = $this->em->getRepository('OngBundle:Users')
            ->find($id);
        if ($user) {
            $this->em->remove($user);
            $this->em->flush();
            return true;
        } else {
            return false;
        }

    }
}