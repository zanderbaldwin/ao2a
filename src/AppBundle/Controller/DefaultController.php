<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $coordinator = $this->get('app.scraper_coordinator');
        $coordinator->run();
        return $this->render('AppBundle:Default:index.html.twig');
    }
}
