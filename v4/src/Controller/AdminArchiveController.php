<?php

namespace App\Controller;

use App\Entity\Archive;
use App\Service\Uploader;
use App\Form\AdminArchiveType;
use App\Repository\ArchiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminArchiveController extends AbstractController
{

    /**
     * @Route("/admin/archive", name="admin_archive")
     */
    public function afficherAdminArchives(ArchiveRepository $archiveRepository): Response {
        $archives = $archiveRepository->findAll();
        return $this->render('admin_archive/index.html.twig', [
            'archives' => $archives
        ]);
    }

    /**
     * @Route("/admin/archive/create", name="admin_archive_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ajouterArchive(Request $request, EntityManagerInterface $em, Uploader $uploadeur) {

        $archive = new Archive;
        $form = $this->createForm(AdminArchiveType::class, $archive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();

            if (!empty($nouvelleImage)) {
                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'archive-' . $archive->getTitre() . '-image', 'archives');
                $nouveauCheminRelatif = 'assets/img/archives/' . $nouvelleImageNomFichier;
                $archive->setImage($nouveauCheminRelatif);
            } else { $archive->setImage('assets/img/placeholders/1280x720.png'); }

            $em->persist($archive);
            $em->flush();

            $this->addFlash('success', 'L\'Archive a bien été ajoutée !');

            return $this->redirectToRoute('admin_archive');
        } else {
            return $this->render('admin_archive/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView()
            ]);
        }
    }

     /**
     * @Route("/admin/archive/{id}/edit", name="admin_archive_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editerArchive(Request $request, Archive $archive, Uploader $uploadeur): Response {

        $form = $this->createForm(AdminArchiveType::class, $archive);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();

            if (!empty($nouvelleImage)) {

                $ancienneImageNomFichier = basename($archive->getImage());

                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'archive-' . $archive->getTitre() . '-image', 'archives');
                $nouveauChemingRelatif = 'assets/img/archives/' . $nouvelleImageNomFichier;
                $archive->setImage($nouveauChemingRelatif);

                $ancienneImageCheminComplet = $this->getParameter('image_directory') . '/archives/' . $ancienneImageNomFichier;
                $filesystem = new Filesystem();
                $filesystem->remove($ancienneImageCheminComplet);

            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'L\'Archive a bien été modifiée !');

            return $this->redirectToRoute('admin_archive', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_archive/edit.html.twig', [
            'archive' => $archive,
            'form' => $form,
            'type' => 'Modifier',
        ]);
        
    }

    /**
     * @Route("/admin/archive/{id}/delete", name="admin_archive_delete", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprimerArchive(Request $request, Archive $archive): Response {

        if ($this->isCsrfTokenValid('delete' . $archive->getId(), $request->query->get('csrf'))) {

            $entityManager = $this->getDoctrine()->getManager();

            $nomImageASupprimer = basename($archive->getImage());
            $cheminImageASupprimer = $this->getParameter('image_directory') . '/archives/' . $nomImageASupprimer;

            if (file_exists($cheminImageASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminImageASupprimer);
            }

            $entityManager->remove($archive);
            $entityManager->flush();

            $this->addFlash('success', 'L\'archive a bien été supprimée !');
        }

        return $this->redirectToRoute('admin_archive', [], Response::HTTP_SEE_OTHER);
    }
}
