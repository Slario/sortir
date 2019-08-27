<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("", name="home", methods={"GET"})
     */
    public function home(EntityManagerInterface $entityManager)
    {
        return $this->render("base.html.twig");
    }
}