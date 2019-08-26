<?php


namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class test extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/test")
     */
    public function tets(){

        return $this->render("base.html.twig");

    }

}