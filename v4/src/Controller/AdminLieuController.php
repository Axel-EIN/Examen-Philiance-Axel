<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Service\Uploader;
use App\Form\AdminLieuType;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminLieuController extends AbstractController
{
    /**
     * @Route("/admin/lieu", name="admin_lieu")
     */
    public function afficherAdminLieux(LieuRepository $lieuRepository): Response {
        $lieux = $lieuRepository->findAll();
        return $this->render('admin_lieu/index.html.twig', [
            'lieux' => $lieux
        ]);
    }

    /**
     * @Route("/admin/lieu/create", name="admin_lieu_create")
     * @IsGranted("ROLE_MJ")
     */
    public function ajouterLieu(Request $request, EntityManagerInterface $em, Uploader $uploadeur) {

        $lieu = new Lieu;
        $form = $this->createForm(AdminLieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();
            $nouvelleCarte = $form->get('carte')->getData();

            if (!empty($nouvelleImage)) {
                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'lieu-' . $lieu->getNom() . '-image', 'lieux');
                $nouveauCheminRelatif = 'assets/img/lieux/' . $nouvelleImageNomFichier;
                $lieu->setImage($nouveauCheminRelatif);
            } else { $lieu->setImage('assets/img/placeholders/1280x720.png'); }

            if (!empty($nouvelleCarte)) {
                $nouvelleCarteNomFichier = $uploadeur->upload($nouvelleCarte, 'lieu-' . $lieu->getNom() . '-carte', 'lieux');
                $nouveauCheminRelatif = 'assets/img/lieux/' . $nouvelleCarteNomFichier;
                $lieu->setCarte($nouveauCheminRelatif);
            } else { $lieu->setCarte('assets/img/placeholders/1280x720.png'); }

            $em->persist($lieu);
            $em->flush();

            $this->addFlash('success', 'Le Lieu a bien été ajouté !');

            return $this->redirectToRoute('admin_lieu');
        } else {
            return $this->render('admin_lieu/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/lieu/{id}/edit", name="admin_lieu_edit")
     * @IsGranted("ROLE_MJ")
     */
    public function editerLieu(Request $request, Lieu $lieu, Uploader $uploadeur): Response {

        $form = $this->createForm(AdminLieuType::class, $lieu);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();
            $nouvelleCarte = $form->get('carte')->getData();

            if (!empty($nouvelleImage)) {
                $ancienneImageNomFichier = basename($lieu->getImage());

                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'lieu-' . $lieu->getNom() . '-image', 'lieux');
                $nouveauChemingRelatif = 'assets/img/lieux/' . $nouvelleImageNomFichier;
                $lieu->setImage($nouveauChemingRelatif);

                $ancienneImageCheminComplet = $this->getParameter('image_directory') . '/lieux/' . $ancienneImageNomFichier;
                $filesystem = new Filesystem();
                $filesystem->remove($ancienneImageCheminComplet);
            }

            if (!empty($nouvelleCarte)) {
                $ancienneCarteNomFichier = basename($lieu->getCarte());

                $nouvelleCarteNomFichier = $uploadeur->upload($nouvelleCarte, 'lieu-' . $lieu->getNom() . '-carte', 'lieux');
                $nouveauChemingRelatif = 'assets/img/lieux/' . $nouvelleCarteNomFichier;
                $lieu->setCarte($nouveauChemingRelatif);

                $ancienneCarteCheminComplet = $this->getParameter('image_directory') . '/lieux/' . $ancienneCarteNomFichier;
                $filesystem = new Filesystem();
                $filesystem->remove($ancienneCarteCheminComplet);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le Lieu a bien été modifié !');

            return $this->redirectToRoute('admin_lieu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_lieu/edit.html.twig', [
            'lieu' => $lieu,
            'form' => $form,
            'type' => 'Modifier',
        ]);
        
    }

    /**
     * @Route("/admin/lieu/{id}/delete", name="admin_lieu_delete", methods={"GET"})
     * @IsGranted("ROLE_MJ")
     */
    public function supprimerLieu(Request $request, Lieu $lieu): Response {

        if ($this->isCsrfTokenValid('delete' . $lieu->getId(), $request->query->get('csrf'))) {

            $entityManager = $this->getDoctrine()->getManager();

            $nomImageASupprimer = basename($lieu->getImage());
            $cheminImageASupprimer = $this->getParameter('image_directory') . '/lieux/' . $nomImageASupprimer;

            if (file_exists($cheminImageASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminImageASupprimer);
            }

            $entityManager->remove($lieu);
            $entityManager->flush();

            $this->addFlash('success', 'Le Lieu a bien été supprimé !');
        }

        return $this->redirectToRoute('admin_lieu', [], Response::HTTP_SEE_OTHER);
    }
}
