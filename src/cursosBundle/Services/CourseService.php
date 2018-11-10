<?php

namespace cursosBundle\Services;

use Doctrine\ORM\EntityManager;
use cursosBundle\Entity\Cursos;

class CourseService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getCourse($id) {
        $course = $this->em->getRepository('cursosBundle:Cursos')
            ->find($id);
        return ($course !== null) ? $course : false;
    }

    public function createCourse($course) {

        $this->em->persist($course);
        $this->em->flush();
        return ($course->getId() !== null) ? true : false;
    }

    public function putCourse($id) {
        $course = $this->em->getRepository('cursosBundle:Cursos')
            ->find($id);
        $course->setName('nombre modificado');
        $course->setDescription('descripcion modificada');

        $this->em->persist($course);
        $this->em->flush();
        return true;
    }

    public function deleteCourse($id) {
        $course = $this->em->getRepository('cursosBundle:Cursos')
            ->find($id);
        if ($course !== null) {
            $this->em->remove($course);
            $this->em->flush();
            return true;
        }
        return false;
    }
}