<?php

namespace App\Controller;

use App\Repository\SaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminSaisonController extends AbstractController
{
    /**
     * @Route("/admin/saison", name="admin_saison")
     * @IsGranted("ROLE_ADMIN")
     */
    public function afficherAdminSaisons(SaisonRepository $saisonRepository): Response
    {
        $saisons = $saisonRepository->findAll();
        return $this->render('admin_saison/index.html.twig', [
            'controller_name' => 'AdminSaisonController',
            'saisons' => $saisons,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_saison_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editerSaison(Saison $saison): Response {
        
    }
}
