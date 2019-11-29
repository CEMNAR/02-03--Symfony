<?php
// src/Controller/DefaultController.php
namespace App\Controller;


use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/",name="app_index")
     * @return Response A response instance
     */

    public function index():Response
    {
        return $this->render('home.html.twig', ['website' => 'Bienvenue sur notre site']);
    }

}