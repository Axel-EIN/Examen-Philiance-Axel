<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AventureController extends AbstractController
{
    /**
     * @Route("/aventure", name="aventure")
     */
    public function index(): Response
    {
        return $this->render('aventure/index.html.twig', [
            'controller_name' => 'AventureController',
        ]);
    }
}
