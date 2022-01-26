<?php

namespace App\Controller;

use App\Entity\FichePersonnage;
use App\Form\AdminFichePersonnageType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FichePersonnageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminFicheController extends AbstractController
{
    /**
     * @Route("/admin/fiche", name="admin_fiche")
     */
    public function afficherAdminFiches(FichePersonnageRepository $fichePersonnageRepository): Response {
        $fiches = $fichePersonnageRepository->findAll();
        return $this->render('admin_fiche/index.html.twig', [
            'fiches' => $fiches
        ]);
    }

    /**
     * @Route("/admin/fiche/create", name="admin_fiche_create")
     * @IsGranted("ROLE_MJ")
     */
    public function ajouterFiche(Request $request, EntityManagerInterface $em) {

        $fiche = new FichePersonnage;
        $form = $this->createForm(AdminFichePersonnageType::class, $fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($fiche);
            $em->flush();

            $this->addFlash('success', 'La Fiche a bien été ajoutée !');

            return $this->redirectToRoute('admin_fiche');
        } else {
            return $this->render('admin_fiche/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView()
            ]);
        } 
    }

    /**
     * @Route("/admin/fiche/{id}/edit", name="admin_fiche_edit")
     * @IsGranted("ROLE_MJ")
     */
    public function editerFiche(Request $request, FichePersonnage $fiche): Response {

        $form = $this->createForm(AdminFichePersonnageType::class, $fiche);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La fiche a bien été modifiée !');

            return $this->redirectToRoute('admin_fiche', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_fiche/edit.html.twig', [
            'fiche' => $fiche,
            'form' => $form,
            'type' => 'Modifier',
        ]);
    }

    /**
     * @Route("/admin/fiche/{id}/delete", name="admin_fiche_delete", methods={"GET"})
     * @IsGranted("ROLE_MJ")
     */
    public function supprimerClan(Request $request, FichePersonnage $fiche): Response {

        if ($this->isCsrfTokenValid('delete' . $fiche->getId(), $request->query->get('csrf'))) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fiche);
            $entityManager->flush();

            $this->addFlash('success', 'La fiche a bien été supprimée !');
        }

        return $this->redirectToRoute('admin_fiche', [], Response::HTTP_SEE_OTHER);
    }
}
