<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Repository\PersonnageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonnageController extends AbstractController
{
    /**
     * @Route("/personnages", name="personnages")
     */
    public function afficherPersonnages(PersonnageRepository $personnageRepository): Response {
        $pjs = $personnageRepository->findBy(array("est_pj" => "1"),array('clan' => 'ASC'));
        $pnjs = $personnageRepository->findBy(array("est_pj" => "0"),array('clan' => 'ASC'));

        return $this->render('personnage/index.html.twig', [
            'pjs' => $pjs,
            'pnjs' => $pnjs,
        ]);
    }

    /**
     * @Route("/personnages/profil/{id}", name="personnage_profil")
     */
    public function afficherPersonnageProfil(Personnage $personnage): Response {
        return $this->render('personnage/profil.html.twig', [
            'personnage' => $personnage,
        ]);
    }
}
