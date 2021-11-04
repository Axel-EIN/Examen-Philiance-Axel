<?php

namespace App\Controller;

use App\Entity\Clan;
use App\Entity\Lieu;
use App\Entity\Archive;
use App\Repository\ClanRepository;
use App\Repository\LieuRepository;
use App\Repository\ArchiveRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmpireController extends AbstractController
{
    /**
     * @Route("/empire", name="empire")
     */
    public function afficherEmpire(ClanRepository $clanRepository,
                                   ArchiveRepository $archiveRepository,
                                   LieuRepository $lieuRepository): Response
    {

        $clans = $clanRepository->findall();
        $archives = $archiveRepository->findall();
        $lieux = $lieuRepository->findall();

        return $this->render('empire/index.html.twig', [
            'clans' => $clans,
            'archives' => $archives,
            'lieux' => $lieux,
        ]);
    }

    /**
     * @Route("/empire/clan/{id}", name="empire_clan")
     */
    public function afficherClan(Clan $clan): Response
    {
        return $this->render('empire/clan.html.twig', [
            'clan' => $clan,
        ]);
    }

    /**
     * @Route("/empire/archive/{id}", name="empire_archive")
     */
    public function afficherArchive(Archive $archive): Response
    {
        return $this->render('empire/archive.html.twig', [
            'archive' => $archive,
        ]);
    }

    /**
     * @Route("/empire/lieu/{id}", name="empire_lieu")
     */
    public function afficherLieu(Lieu $lieu): Response
    {
        return $this->render('empire/lieu.html.twig', [
            'lieu' => $lieu,
        ]);
    }
}
