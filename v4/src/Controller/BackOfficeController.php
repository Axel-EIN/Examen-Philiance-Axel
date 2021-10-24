<?php

namespace App\Controller;

use App\Repository\ChapitreRepository;
use App\Repository\ClanRepository;
use App\Repository\EpisodeRepository;
use App\Repository\SaisonRepository;
use App\Repository\SceneRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class BackOfficeController extends AbstractController
{
    /**
     * @Route("/back-office", name="back_office")
     * @IsGranted("ROLE_ADMIN")
     */
    public function afficherBackOffice(SaisonRepository $saisonRepository, ChapitreRepository $chapitreRepository,
                                       EpisodeRepository $episodeRepository, SceneRepository $sceneRepository,
                                       UtilisateurRepository $utilisateurRepository, ClanRepository $clanRepository): Response
    {

        $nbrSaisons = $saisonRepository->countSaisons();
        $dernierSaison = $saisonRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrChapitres = $chapitreRepository->countChapitres();
        $dernierChapitre = $chapitreRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrEpisodes = $episodeRepository->countEpisodes();
        $dernierEpisode = $episodeRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrScenes = $sceneRepository->countScenes();
        $dernierScene = $sceneRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrUtilisateurs = $utilisateurRepository->countUtilisateurs();
        $dernierUtilisateur = $utilisateurRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrClans = $clanRepository->countClans();
        $dernierClan = $clanRepository->findOneBy(array(),array('id' => 'DESC'));

        return $this->render('back_office/index.html.twig', [
            'controller_name' => 'BackOfficeController',
            'nbrSaisons' => $nbrSaisons,
            'dernierSaison' => $dernierSaison,
            'nbrChapitres' => $nbrChapitres,
            'dernierChapitre' => $dernierChapitre,
            'nbrEpisodes' => $nbrEpisodes,
            'dernierEpisode' => $dernierEpisode,
            'nbrScenes' => $nbrScenes,
            'dernierScene' => $dernierScene,
            'nbrUtilisateurs' => $nbrUtilisateurs,
            'dernierUtilisateur' => $dernierUtilisateur,
            'nbrClans' => $nbrClans,
            'dernierClan' => $dernierClan,
        ]);
    }
}
