<?php

namespace App\Controller;

use App\Repository\PersonnageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonnageController extends AbstractController
{
    /**
     * @Route("/personnages", name="personnages")
     */
    public function afficherPersonnages(PersonnageRepository $personnageRepository): Response
    {
        $pjs = $personnageRepository->findBy(array("est_pj" => "1"),array('est_pj' => 'ASC'));
        $pnjs = $personnageRepository->findBy(array("est_pj" => "0"),array('est_pj' => 'ASC'));

        return $this->render('personnage/index.html.twig', [
            'pjs' => $pjs,
            'pnjs' => $pnjs,
        ]);
    }
}
