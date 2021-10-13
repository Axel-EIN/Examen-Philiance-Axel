<?php

namespace App\Controller;

use App\Entity\Saison;
use App\Entity\Episode;
use App\Repository\SaisonRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AventureController extends AbstractController
{
    /**
     * @Route("/aventure", name="aventure")
     */
    public function afficherAventure(SaisonRepository $saisonRepository): Response
    {
        $numero = 1;
        $saison = $saisonRepository->findOneBy(array('numero' => $numero));

        return $this->render('aventure/index.html.twig', [
            'saison' => $saison,
        ]);
    }

    /**
     * @Route("/aventure/{numero}", name="aventure_saison")
     */
    public function afficherSaison(Saison $saison): Response
    {
        return $this->render('aventure/index.html.twig', [
            'saison' => $saison,
        ]);
    }

    /**
     * @Route("/aventure/episode/{id}", name="aventure_episode")
     */
    public function afficherEpisode(Episode $episode): Response
    {
        return $this->render('aventure/un-episode.html.twig', [
            'episode' => $episode,
        ]);
    }
}
