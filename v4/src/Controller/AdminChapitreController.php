<?php

namespace App\Controller;

use App\Entity\Chapitre;
use App\Service\Uploader;
use App\Service\Numeroteur;
use App\Form\AdminChapitreType;
use App\Repository\SaisonRepository;
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
     * @IsGranted("ROLE_MJ")
     */
    public function afficherAdminChapitres(ChapitreRepository $chapitreRepository): Response {
        $chapitres = $chapitreRepository->findBy(array(), array('saisonParent' => 'ASC'));
        return $this->render('admin_chapitre/index.html.twig', [
            'controller_name' => 'AdminChapitreController',
            'chapitres' => $chapitres,
        ]);
    }

    /**
     * @Route("/admin/chapitre/create", name="admin_chapitre_create")
     * @IsGranted("ROLE_MJ")
     */
    public function creerChapitre(Request $request, EntityManagerInterface $em, Uploader $uploadeur, SaisonRepository $saisonRepository, Numeroteur $numeroteur, ChapitreRepository $chapitreRepository) {

        $chapitre = new Chapitre;

        // PRE-REMPLISSAGE FROM FRONT PAGE LINKS
        // -------------------------------------
        if ( !empty($request->query->get('numero')) && $request->query->get('numero') > 0
          && !empty($request->query->get('saisonID')) && $request->query->get('saisonID') > 0 )
        {
                $chapitre->setNumero($request->query->get('numero'));
                $saisonParent = $saisonRepository->find($request->query->get('saisonID'));
                if ($saisonParent !== null)
                    $chapitre->setSaisonParent($saisonParent);
        }

        // FORM VIEW
        //-----------
        $form = $this->createForm(AdminChapitreType::class, $chapitre);
        $form->handleRequest($request);

        // GESTION FORMULAIRE VALIDE
        // -------------------------
        if ($form->isSubmitted() && $form->isValid()) {

            // CREATION FICHIER IMAGE
            // ----------------------
            $nouvelleImage = $form->get('image')->getData();
            if (!empty($nouvelleImage)) {
                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'chapitre-s' . $chapitre->getSaisonParent()->getNumero() . '-ch' . $chapitre->getNumero(), 'chapitres');
                $nouveauCheminRelatif = 'assets/img/chapitres/' . $nouvelleImageNomFichier;
                $chapitre->setImage($nouveauCheminRelatif);
            } else
                $chapitre->setImage('assets/img/placeholders/1920x1080.jpg');

            // CREATION ENTITE
            // ---------------
            $em->persist($chapitre);
            $em->flush();
            $this->addFlash('success', 'Le chapitre a bien été crée !');

            // NUMEROTEUR
            // ----------
            $fratrieArrivee = $chapitreRepository->findBy(['saisonParent' => $chapitre->getSaisonParent()->getId()]);
            $numeroteur->reordonnerNumero($chapitre->getId(), -1, $chapitre->getNumero(), [], $fratrieArrivee);

            // REDIRECTION
            // -----------
            if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
                return $this->redirectToRoute('aventure_saison', ['id' => $chapitre->getSaisonParent()->getId(),'_fragment' => 'tete-lecture-ch-id' . $chapitre->getId()]);
            
            return $this->redirectToRoute('admin_chapitre');

        } else {
            // AFFICHAGE FORMULAIRE
            // --------------------
            return $this->render('admin_chapitre/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/chapitre/{id}/edit", name="admin_chapitre_edit")
     * @IsGranted("ROLE_MJ")
     */
    public function editerChapitre(Request $request, Chapitre $chapitre, Uploader $uploadeur, Numeroteur $numeroteur, ChapitreRepository $chapitreRepository): Response {

        // Stockage du numéro et de l'ID de l'episode avant édition
        $numeroDepart = $chapitre->getNumero();
        $fratrieDepartId = $chapitre->getSaisonParent()->getId();

        // FORM VIEW
        //-----------
        $form = $this->createForm(AdminChapitreType::class, $chapitre);
        $form->handleRequest($request);

        // GESTION FORMULAIRE VALIDE
        // -------------------------
        if($form->isSubmitted() && $form->isValid()) {

            // EDITION FICHIER IMAGE
            // ---------------------
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

            // NUMEROTEUR
            // ----------
            // Si numero change ou parent change
            if ($numeroDepart != $chapitre->getNumero() || $fratrieDepartId != $chapitre->getSaisonParent()->getId())
            {
                $fratrieDepart = $chapitreRepository->findBy(['saisonParent' => $fratrieDepartId]);
                $fratrieArrivee = $chapitreRepository->findBy(['saisonParent' => $chapitre->getSaisonParent()->getId()]);
                $numeroteur->reordonnerNumero($chapitre->getId(), $numeroDepart, $chapitre->getNumero(), $fratrieDepart, $fratrieArrivee);
            }

            // EDITION ENTITE
            // --------------
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le chapitre a bien été modifié !');

            // REDIRECTION
            // -----------
            if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
                return $this->redirectToRoute('aventure_saison', ['id' => $chapitre->getSaisonParent()->getId(),'_fragment' => 'tete-lecture-ch-id' . $chapitre->getId()]);
            
            return $this->redirectToRoute('admin_chapitre');
        }

        // AFFICHAGE FORMULAIRE
        // --------------------
        return $this->renderForm('admin_chapitre/edit.html.twig', [
            'chapitre' => $chapitre,
            'form' => $form,
            'type' => 'Modifier',
        ]);
    }

    /**
     * @Route("/admin/chapitre/{id}/delete", name="admin_chapitre_delete", methods={"GET"})
     * @IsGranted("ROLE_MJ")
     */
    public function supprimerChapitre(Request $request, Chapitre $chapitre, Numeroteur $numeroteur, ChapitreRepository $chapitreRepository): Response {

        $saisonParent = $chapitre->getSaisonParent(); // Stocké pour la redirection

        // GESTION FORMULAIRE VALIDE
        // -------------------------
        if ($this->isCsrfTokenValid('delete' . $chapitre->getId(), $request->query->get('csrf'))) {

            // VERIFICATION ENFANTS
            // --------------------
            if (!$chapitre->getEpisodes()->isEmpty()) {
                $this->addFlash('warning', 'Veuillez supprimer les épisodes enfants au prélable !');
                return $this->redirectToRoute('admin_chapitre');
            }

            // SUPPRESSION FICHIER IMAGE
            // -------------------------
            $nomImageASupprimer = basename($chapitre->getImage());
            $cheminImageASupprimer = $this->getParameter('image_directory') . '/chapitres/' . $nomImageASupprimer;

            if (file_exists($cheminImageASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminImageASupprimer);
            }

            // NUMEROTEUR
            // ----------
            $fratrieDepartId = $chapitre->getSaisonParent()->getId();
            $fratrieDepart = $chapitreRepository->findBy(['saisonParent' => $fratrieDepartId]);
            $numeroteur->reordonnerNumero($chapitre->getId(), $chapitre->getNumero(), -1, $fratrieDepart, []);

            // SUPPRESSION ENTITE
            // ------------------
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chapitre);
            $entityManager->flush();
            $this->addFlash('success', 'Le chapitre a bien été supprimé !');

        } else
            $this->addFlash('danger', 'Token de protection invalide !');

        // REDIRECTION
        // -----------
        if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
            return $this->redirectToRoute('aventure_saison', ['id' => $saisonParent->getId()], Response::HTTP_SEE_OTHER);
        
        return $this->redirectToRoute('admin_chapitre');
    }
}