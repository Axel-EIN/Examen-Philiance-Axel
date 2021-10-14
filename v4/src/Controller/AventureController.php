<?php

namespace App\Controller;

use App\Entity\Saison;
use App\Entity\Episode;
use App\Repository\SaisonRepository;
use App\Repository\EpisodeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AventureController extends AbstractController
{
    /**
     * @Route("/", name="aventure")
     */
    public function afficherAventure(SaisonRepository $saisonRepository): Response
    {
        return $this->redirectToRoute('aventure_saison', [ 'numero' => 1 ]);
    }

    /**
     * @Route("/aventure/{numero}", name="aventure_saison")
     */
    public function afficherSaison(Saison $saison, SaisonRepository $saisonRepository): Response
    {
        $precedent = $saisonRepository->findPrevious($saison->getNumero());
        $suivant = $saisonRepository->findNext($saison->getNumero());

        return $this->render('aventure/index.html.twig', [
            'saison' => $saison,
            'saison_precedente' => $precedent,
            'saison_suivante' => $suivant,
        ]);
    }

    /**
     * @Route("/aventure/episode/{id}", name="aventure_episode")
     */
    public function afficherEpisode(Episode $episode, EpisodeRepository $episodeRepository): Response
    {
        $precedent = $episodeRepository->findPrevious($episode->getNumero());
        $suivant = $episodeRepository->findNext($episode->getNumero());

        return $this->render('aventure/un-episode.html.twig', [
            'episode' => $episode,
            'episode_precedent' => $precedent,
            'episode_suivant' => $suivant,
        ]);
    }
}
