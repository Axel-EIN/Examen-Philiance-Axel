<?php

namespace App\Controller;

use App\Entity\Saison;
use App\Form\AdminSaisonType;
use App\Repository\SaisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use App\Service\Uploader;

class AdminSaisonController extends AbstractController
{
    /**
     * @Route("/admin/saison", name="admin_saison")
     * @IsGranted("ROLE_MJ")
     */
    public function afficherAdminSaisons(SaisonRepository $saisonRepository): Response {

        $saisons = $saisonRepository->findBy(array(), array('numero' => 'ASC'));
        return $this->render('admin_saison/index.html.twig', [
            'controller_name' => 'AdminSaisonController',
            'saisons' => $saisons,
        ]);
    }

    /**
     * @Route("/admin/saison/create", name="admin_saison_create")
     * @IsGranted("ROLE_MJ")
     */
    public function creerSaison(Request $request, EntityManagerInterface $em, Uploader $uploadeur) {

        $saison = new Saison;

        if (!empty($request->query->get('numero')) && $request->query->get('numero') > 0)
            $saison->setNumero($request->query->get('numero'));

        $form = $this->createForm(AdminSaisonType::class, $saison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();

            if (!empty($nouvelleImage)) {
                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'saison-' . $saison->getNumero(), 'saisons');
                $nouveauCheminRelatif = 'assets/img/saisons/' . $nouvelleImageNomFichier;
                $saison->setImage($nouveauCheminRelatif);
            } else { $saison->setImage('assets/img/placeholders/1920x1080.jpg'); }

            $em->persist($saison);
            $em->flush();

            $this->addFlash('success', 'La saison a bien été créee !');

            if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
                return $this->redirectToRoute('aventure_saison', ['id' => $saison->getId()]);

            return $this->redirectToRoute('admin_saison');

        } else {
            return $this->render('admin_saison/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/saison/{id}/edit", name="admin_saison_edit")
     * @IsGranted("ROLE_MJ")
     */
    public function editerSaison(Request $request, Saison $saison, Uploader $uploadeur): Response {

        $form = $this->createForm(AdminSaisonType::class, $saison);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();

            if (!empty($nouvelleImage)) {

                $AncienneImageNomFichier = basename($saison->getImage());

                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'saison-' . $saison->getNumero(), 'saisons');
                $nouveauChemingRelatif = 'assets/img/saisons/' . $nouvelleImageNomFichier;
                $saison->setImage($nouveauChemingRelatif);

                $ancienneImageCheminComplet = $this->getParameter('image_directory') . '/saisons/' . $AncienneImageNomFichier;
                $filesystem = new Filesystem();
                $filesystem->remove($ancienneImageCheminComplet);

            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La saison a bien été modifiée !');

            if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
                return $this->redirectToRoute('aventure_saison', ['id' => $saison->getId()]);
            
            return $this->redirectToRoute('admin_saison', [], Response::HTTP_SEE_OTHER);

        }

        return $this->renderForm('admin_saison/edit.html.twig', [
            'saison' => $saison,
            'form' => $form,
            'type' => 'Modifier',
        ]);
        
    }

    /**
     * @Route("/admin/saison/{id}/delete", name="admin_saison_delete", methods={"GET"})
     * @IsGranted("ROLE_MJ")
     */
    public function supprimerSaison(Request $request, Saison $saison): Response {

        if ($this->isCsrfTokenValid('delete' . $saison->getId(), $request->query->get('csrf'))) {

            if (!$saison->getChapitres()->isEmpty()) {
                $this->addFlash('warning', 'Veuillez supprimer les chapitres enfants au prélable !');
                return $this->redirectToRoute('admin_saison', [], Response::HTTP_SEE_OTHER);
            }

            $entityManager = $this->getDoctrine()->getManager();

            $nomImageASupprimer = basename($saison->getImage());
            $cheminImageASupprimer = $this->getParameter('image_directory') . '/saisons/' . $nomImageASupprimer;

            $entityManager->remove($saison);
            $entityManager->flush();

            if (file_exists($cheminImageASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminImageASupprimer);
            }

            $this->addFlash('success', 'La saison a bien été supprimée !');

        }

        if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
            return $this->redirectToRoute('aventure', [], Response::HTTP_SEE_OTHER);

        return $this->redirectToRoute('admin_saison', [], Response::HTTP_SEE_OTHER);
    }
}