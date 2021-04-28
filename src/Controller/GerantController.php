<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GerantController extends AbstractController
{
    /**
     * @Route("/gerant", name="gerant")
     */
    public function index(): Response
    {
        return $this->render('gerant/index.html.twig', [
            'controller_name' => 'GerantController',
        ]);
    }
}
