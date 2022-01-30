<?php

namespace App\Controller;

use App\Entity\Saison;
use App\Service\Uploader;
use App\Service\Numeroteur;
use App\Form\AdminSaisonType;
use App\Repository\SaisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function creerSaison(Request $request, EntityManagerInterface $em, Uploader $uploadeur, SaisonRepository $saisonRepository, Numeroteur $numeroteur) {

        $saison = new Saison;

        // PRE-REMPLISSAGE FROM FRONT PAGE LINKS
        // -------------------------------------
        if (!empty($request->query->get('numero')) && $request->query->get('numero') > 0)
            $saison->setNumero($request->query->get('numero'));

        // FORM VIEW
        //-----------
        $form = $this->createForm(AdminSaisonType::class, $saison);
        $form->handleRequest($request);

        // GESTION FORMULAIRE VALIDE
        // -------------------------
        if ($form->isSubmitted() && $form->isValid()) {

            // CREATION FICHIER IMAGE
            // ----------------------
            $nouvelleImage = $form->get('image')->getData();
            if (!empty($nouvelleImage)) {
                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'saison-' . $saison->getNumero(), 'saisons');
                $nouveauCheminRelatif = 'assets/img/saisons/' . $nouvelleImageNomFichier;
                $saison->setImage($nouveauCheminRelatif);
            } else { $saison->setImage('assets/img/placeholders/1920x1080.jpg'); }

            // CREATION ENTITE
            // ---------------
            $em->persist($saison);
            $em->flush();
            $this->addFlash('success', 'La saison a bien été créee !');

            // NUMEROTEUR
            // ----------
            $fratrieArrivee = $saisonRepository->findAll();
            $numeroteur->reordonnerNumero($saison->getId(), -1, $saison->getNumero(), [], $fratrieArrivee);

            // REDIRECTION
            // -----------
            if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
                return $this->redirectToRoute('aventure_saison', ['id' => $saison->getId()]);

            return $this->redirectToRoute('admin_saison');

        } else {
            // AFFICHAGE FORMULAIRE
            // --------------------
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
    public function editerSaison(Request $request, Saison $saison, Uploader $uploadeur, Numeroteur $numeroteur, SaisonRepository $saisonRepository): Response {

        // Stockage du numéro et de l'ID de l'episode avant édition
        $numeroDepart = $saison->getNumero();
        $fratrieDepart = $saisonRepository->findAll();

        // FORM VIEW
        //-----------
        $form = $this->createForm(AdminSaisonType::class, $saison);
        $form->handleRequest($request);

        // GESTION FORMULAIRE VALIDE
        // -------------------------
        if($form->isSubmitted() && $form->isValid()) {

            // EDITION FICHIER IMAGE
            // ---------------------
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

            // NUMEROTEUR
            // ----------
            // Si numero change ou parent change
            if ($numeroDepart != $saison->getNumero())
            {
                $fratrieDepart = $saisonRepository->findAll();
                $fratrieArrivee = $saisonRepository->findAll();
                $numeroteur->reordonnerNumero($saison->getId(), $numeroDepart, $saison->getNumero(), $fratrieDepart, $fratrieArrivee);
            }

            // EDITION ENTITE
            // --------------
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La saison a bien été modifiée !');

            // REDIRECTION
            // -----------
            if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
                return $this->redirectToRoute('aventure_saison', ['id' => $saison->getId()]);
            
            return $this->redirectToRoute('admin_saison');
        }

        // AFFICHAGE FORMULAIRE
        // --------------------
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
    public function supprimerSaison(Request $request, Saison $saison, Numeroteur $numeroteur, SaisonRepository $saisonRepository): Response {

        // GESTION FORMULAIRE VALIDE
        // -------------------------
        if ($this->isCsrfTokenValid('delete' . $saison->getId(), $request->query->get('csrf'))) {

            // VERIFICATION ENFANTS
            // --------------------
            if (!$saison->getChapitres()->isEmpty()) {
                $this->addFlash('warning', 'Veuillez supprimer les chapitres enfants au prélable !');
                return $this->redirectToRoute('admin_saison');
            }

            // SUPPRESSION FICHIER IMAGE
            // -------------------------
            $nomImageASupprimer = basename($saison->getImage());
            $cheminImageASupprimer = $this->getParameter('image_directory') . '/saisons/' . $nomImageASupprimer;

            if (file_exists($cheminImageASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminImageASupprimer);
            }

            // NUMEROTEUR
            // ----------
            $fratrieDepart = $saisonRepository->findAll();
            $numeroteur->reordonnerNumero($saison->getId(), $saison->getNumero(), -1, $fratrieDepart, []);

            // SUPPRESSION ENTITE
            // ------------------
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($saison);
            $entityManager->flush();
            $this->addFlash('success', 'La saison a bien été supprimée !');
        } else
            $this->addFlash('danger', 'Token de protection invalide !');

        // REDIRECTION
        // -----------
        if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
            return $this->redirectToRoute('aventure');

        return $this->redirectToRoute('admin_saison');
    }
}