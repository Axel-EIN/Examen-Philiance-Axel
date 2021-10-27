<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPersonnageController extends AbstractController
{
    /**
     * @Route("/admin/personnage", name="admin_personnage")
     */
    public function index(): Response
    {
        return $this->render('admin_personnage/index.html.twig', [
            'controller_name' => 'AdminPersonnageController',
        ]);
    }
}
