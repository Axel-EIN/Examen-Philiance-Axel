<?php

namespace App\Controller;

use App\Entity\Chapitre;
use App\Service\Uploader;
use App\Form\AdminChapitreType;
use App\Repository\ChapitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminChapitreController extends AbstractController
{
    /**
     * @Route("/admin/chapitre", name="admin_chapitre")
     * @IsGranted("ROLE_ADMIN")
     */
    public function afficherAdminChapitres(ChapitreRepository $chapitreRepository): Response
    {
        $chapitres = $chapitreRepository->findBy(array(), array('saisonParent' => 'ASC'));
        return $this->render('admin_chapitre/index.html.twig', [
            'controller_name' => 'AdminChapitreController',
            'chapitres' => $chapitres,
        ]);
    }

    /**
     * @Route("/admin/chapitre/create", name="admin_chapitre_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function creerChapitre(Request $request, EntityManagerInterface $em, Uploader $uploadeur) {

        $chapitre = new Chapitre;
        $form = $this->createForm(AdminChapitreType::class, $chapitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();

            if (!empty($nouvelleImage)) {
                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'chapitre-s' . $chapitre->getSaisonParent()->getNumero() . '-ch' . $chapitre->getNumero(), 'chapitres');
                $nouveauCheminRelatif = 'assets/img/chapitres/' . $nouvelleImageNomFichier;
                $chapitre->setImage($nouveauCheminRelatif);
            } else { $chapitre->setImage('assets/img/placeholders/1980x1024.png'); }

            $em->persist($chapitre);
            $em->flush();

            $this->addFlash('success', 'Le chapitre a bien été crée !');

            return $this->redirectToRoute('admin_chapitre');
        } else {
            return $this->render('admin_chapitre/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/chapitre/{id}/edit", name="admin_chapitre_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editerChapitre(Request $request, Chapitre $chapitre, Uploader $uploadeur): Response {

        $form = $this->createForm(AdminChapitreType::class, $chapitre);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();

            if (!empty($nouvelleImage)) {

                $AncienneImageNomFichier = basename($chapitre->getImage());

                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'chapitre-s' . $chapitre->getSaisonParent()->getNumero() . '-ch' . $chapitre->getNumero(), 'chapitres');
                $nouveauChemingRelatif = 'assets/img/chapitres/' . $nouvelleImageNomFichier;
                $chapitre->setImage($nouveauChemingRelatif);

                $ancienneImageCheminComplet = $this->getParameter('image_directory') . '/chapitres/' . $AncienneImageNomFichier;
                $filesystem = new Filesystem();
                $filesystem->remove($ancienneImageCheminComplet);

            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le chapitre a bien été modifié !');

            return $this->redirectToRoute('admin_chapitre', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_chapitre/edit.html.twig', [
            'chapitre' => $chapitre,
            'form' => $form,
            'type' => 'Modifier',
        ]);
        
    }

    /**
     * @Route("/admin/chapitre/{id}/delete", name="admin_chapitre_delete", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprimerChapitre(Request $request, Chapitre $chapitre): Response {
        if ($this->isCsrfTokenValid('delete' . $chapitre->getId(), $request->query->get('csrf'))) {

            if (!$chapitre->getEpisodes()->isEmpty()) {
                $this->addFlash('warning', 'Veuillez supprimer les épisodes enfants au prélable !');
                return $this->redirectToRoute('admin_chapitre', [], Response::HTTP_SEE_OTHER);
            }

            $entityManager = $this->getDoctrine()->getManager();

            $nomImageASupprimer = basename($chapitre->getImage());
            $cheminImageASupprimer = $this->getParameter('image_directory') . '/chapitres/' . $nomImageASupprimer;

            if (file_exists($cheminImageASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminImageASupprimer);
            }

            $entityManager->remove($chapitre);
            $entityManager->flush();

            $this->addFlash('success', 'Le chapitre a bien été supprimé !');
        }

        return $this->redirectToRoute('admin_chapitre', [], Response::HTTP_SEE_OTHER);
    }
}