<?php

namespace App\Controller;

use App\Entity\Ecole;
use App\Entity\Classe;
use App\Repository\EcoleRepository;
use App\Repository\ClasseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReglesController extends AbstractController
{
    /**
     * @Route("/regles", name="regles")
     */
    public function afficherRegles(EcoleRepository $ecoleRepository, ClasseRepository $classeRepository): Response
    {
        $ecoles = $ecoleRepository->findBy(array(),array('clan' => 'ASC'));
        $classes = $classeRepository->findAll();

        return $this->render('regles/index.html.twig', [
            'ecoles' => $ecoles,
            'classes' => $classes,
        ]);
    }

    /**
     * @Route("/regles/classe/{id}", name="regles_classe")
     */
    public function afficherClasse(Classe $classe): Response
    {
        return $this->render('regles/classe.html.twig', [
            'classe' => $classe,
        ]);
    }

    /**
     * @Route("/regles/ecole/{id}", name="regles_ecole")
     */
    public function afficherEcole(Ecole $ecole): Response
    {
        return $this->render('regles/ecole.html.twig', [
            'ecole' => $ecole,
        ]);
    }
}
