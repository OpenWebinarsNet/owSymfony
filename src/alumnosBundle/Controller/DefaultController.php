<?php

namespace alumnosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('alumnosBundle:Default:index.html.twig');
    }
}
