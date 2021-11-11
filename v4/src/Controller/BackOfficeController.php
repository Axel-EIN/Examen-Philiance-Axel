<?php

namespace App\Controller;

use App\Entity\FichePersonnage;
use App\Repository\ArchiveRepository;
use App\Repository\ChapitreRepository;
use App\Repository\ClanRepository;
use App\Repository\ClasseRepository;
use App\Repository\EcoleRepository;
use App\Repository\EpisodeRepository;
use App\Repository\FichePersonnageRepository;
use App\Repository\LieuRepository;
use App\Repository\PersonnageRepository;
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
    public function afficherBackOffice(SaisonRepository $saisonRepository,
                                       ChapitreRepository $chapitreRepository,
                                       EpisodeRepository $episodeRepository,
                                       SceneRepository $sceneRepository,
                                       UtilisateurRepository $utilisateurRepository,
                                       ClanRepository $clanRepository,
                                       ClasseRepository $classeRepository,
                                       EcoleRepository $ecoleRepository,
                                       PersonnageRepository $personnageRepository,
                                       ArchiveRepository $archiveRepository,
                                       LieuRepository $lieuRepository,
                                       FichePersonnageRepository $fichePersonnageRepository
                                       ): Response
    {

        $nbrSaisons = $saisonRepository->countSaisons();
        $dernierSaison = $saisonRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrChapitres = $chapitreRepository->countChapitres();
        $dernierChapitre = $chapitreRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrEpisodes = $episodeRepository->countEpisodes();
        $dernierEpisode = $episodeRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrScenes = $sceneRepository->countScenes();
        $dernierScene = $sceneRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrArchives = $archiveRepository->countArchives();
        $derniereArchive = $archiveRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrClans = $clanRepository->countClans();
        $dernierClan = $clanRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrLieux = $lieuRepository->countLieux();
        $dernierLieu = $lieuRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrClasses = $classeRepository->countClasses();
        $dernierClasse = $classeRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrEcoles = $ecoleRepository->countEcoles();
        $dernierEcole = $ecoleRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrPJs = $personnageRepository->countPJs();
        $dernierPJ = $personnageRepository->findOneBy(array("est_pj" => "1"),array('id' => 'DESC'));

        $nbrPNJs = $personnageRepository->countPNJs();
        $dernierPNJ = $personnageRepository->findOneBy(array("est_pj" => "0"),array('id' => 'DESC'));

        $nbrUtilisateurs = $utilisateurRepository->countUtilisateurs();
        $dernierUtilisateur = $utilisateurRepository->findOneBy(array(),array('id' => 'DESC'));

        $nbrFiches = $fichePersonnageRepository->countFiches();
        $derniereFiche = $fichePersonnageRepository->findOneBy(array(),array('id' => 'DESC'));

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
            'nbrClans' => $nbrClans,
            'nbrArchives' => $nbrArchives,
            'derniereArchive' => $derniereArchive,
            'dernierClan' => $dernierClan,
            'nbrClasses' => $nbrClasses,
            'dernierLieu' => $dernierLieu,
            'nbrLieux' => $nbrLieux,
            'dernierClasse' => $dernierClasse,
            'nbrEcoles' => $nbrEcoles,
            'dernierEcole' => $dernierEcole,
            'nbrPJs' => $nbrPJs,
            'dernierPJ' => $dernierPJ,
            'nbrPNJs' => $nbrPNJs,
            'dernierPNJ' => $dernierPNJ,
            'nbrUtilisateurs' => $nbrUtilisateurs,
            'dernierUtilisateur' => $dernierUtilisateur,
            'nbrFiches' => $nbrFiches,
            'derniereFiche' => $derniereFiche,
        ]);
    }
}
