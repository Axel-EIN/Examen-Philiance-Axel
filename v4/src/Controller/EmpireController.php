<?php

namespace App\Controller;

use App\Repository\ClanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpireController extends AbstractController
{
    /**
     * @Route("/empire", name="empire")
     */
    public function afficherEmpire(ClanRepository $clanRepository): Response
    {

        $clans = $clanRepository->findall();

        return $this->render('empire/index.html.twig', [
            'clans' => $clans,
        ]);
    }
}
