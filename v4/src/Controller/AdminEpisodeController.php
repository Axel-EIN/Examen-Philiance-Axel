<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Service\Uploader;
use App\Service\Numeroteur;
use App\Form\AdminEpisodeType;
use App\Repository\EpisodeRepository;
use App\Repository\ChapitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminEpisodeController extends AbstractController
{
    /**
     * @Route("/admin/episode", name="admin_episode")
     * @IsGranted("ROLE_MJ")
     */
    public function afficherAdminEpisodes(EpisodeRepository $episodeRepository): Response
    {
        $episodes = $episodeRepository->findBy(array(), array('chapitreParent' => 'ASC'));
        return $this->render('admin_episode/index.html.twig', [
            'controller_name' => 'AdminEpisodeController',
            'episodes' => $episodes,
        ]);
    }

    /**
     * @Route("/admin/episode/create", name="admin_episode_create")
     * @IsGranted("ROLE_MJ")
     */
    public function creerEpisode(Request $request, EntityManagerInterface $em, Uploader $uploadeur, ChapitreRepository $chapitreRepository, Numeroteur $numeroteur, EpisodeRepository $episodeRepository) {

        $episode = new Episode;

        // PRE-REMPLISSAGE FROM FRONT PAGE LINKS
        // -------------------------------------
        if ( !empty($request->query->get('numero')) && $request->query->get('numero') > 0
          && !empty($request->query->get('chapitreID')) && $request->query->get('chapitreID') > 0 )
        {
                $episode->setNumero($request->query->get('numero'));
                $chapitreParent = $chapitreRepository->find($request->query->get('chapitreID'));
                if ($chapitreParent !== null)
                    $episode->setChapitreParent($chapitreParent);
        }

        // FORM VIEW
        //-----------
        $form = $this->createForm(AdminEpisodeType::class, $episode);
        $form->handleRequest($request);

        // GESTION FORMULAIRE VALIDE
        // -------------------------
        if ($form->isSubmitted() && $form->isValid()) {

            // CREATION FICHIER IMAGE
            // ---------------------
            $nouvelleImage = $form->get('image')->getData();
            if (!empty($nouvelleImage)) {
                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage,
                    'episode-s' . $episode->getChapitreParent()->getSaisonParent()->getNumero()
                    . '-ch' . $episode->getChapitreParent()->getNumero() . '-ep' . $episode->getNumero(), 'episodes');
                $nouveauCheminRelatif = 'assets/img/episodes/' . $nouvelleImageNomFichier;
                $episode->setImage($nouveauCheminRelatif);
            } else { $episode->setImage('assets/img/placeholders/960x540.jpg'); }

            // CREATION ENTITE
            // ---------------
            $em->persist($episode);
            $em->flush();
            $this->addFlash('success', 'L\'épisode a bien été crée !');

            // NUMEROTEUR
            // ----------
            $fratrieArrivee = $episodeRepository->findBy(['chapitreParent' => $episode->getChapitreParent()->getId()]);
            $numeroteur->reordonnerNumero($episode->getId(), -1, $episode->getNumero(), [], $fratrieArrivee);

            // REDIRECTION
            // -----------
            if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
                return $this->redirectToRoute('aventure_saison', ['id' => $episode->getChapitreParent()->getSaisonParent()->getId(),'_fragment' => 'tete-lecture-ch-id' . $episode->getChapitreParent()->getId()]);
            
            return $this->redirectToRoute('admin_episode');

        } else {
            // AFFICHAGE FORMULAIRE
            // --------------------
            return $this->render('admin_episode/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView()
            ]);
        }
    }

     /**
     * @Route("/admin/episode/{id}/edit", name="admin_episode_edit")
     * @IsGranted("ROLE_MJ")
     */
    public function editerEpisode(Request $request, Episode $episode, Uploader $uploadeur, Numeroteur $numeroteur, EpisodeRepository $episodeRepository): Response {

        // Stockage du numéro et de l'ID de l'episode avant édition
        $numeroDepart = $episode->getNumero();
        $fratrieDepartId = $episode->getChapitreParent()->getId();

        // FORM VIEW
        //-----------
        $form = $this->createForm(AdminEpisodeType::class, $episode);
        $form->handleRequest($request);

        // GESTION FORMULAIRE VALIDE
        // -------------------------
        if($form->isSubmitted() && $form->isValid()) {

            // EDITION FICHIER IMAGE
            // ---------------------
            $nouvelleImage = $form->get('image')->getData();
            if (!empty($nouvelleImage)) {
                $AncienneImageNomFichier = basename($episode->getImage());

                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'episode-s'
                    . $episode->getChapitreParent()->getSaisonParent()->getNumero()
                    . '-ch' . $episode->getChapitreParent()->getNumero() . '-ep' . $episode->getNumero(), 'episodes');
                $nouveauChemingRelatif = 'assets/img/episodes/' . $nouvelleImageNomFichier;
                $episode->setImage($nouveauChemingRelatif);

                $ancienneImageCheminComplet = $this->getParameter('image_directory') . '/episodes/' . $AncienneImageNomFichier;
                $filesystem = new Filesystem();
                $filesystem->remove($ancienneImageCheminComplet);

            }

            // NUMEROTEUR
            // ----------
            // Si numero change ou parent change
            if ($numeroDepart != $episode->getNumero() || $fratrieDepartId != $episode->getChapitreParent()->getId())
            {
                $fratrieDepart = $episodeRepository->findBy(['chapitreParent' => $fratrieDepartId]);
                $fratrieArrivee = $episodeRepository->findBy(['chapitreParent' => $episode->getChapitreParent()->getId()]);
                $numeroteur->reordonnerNumero($episode->getId(), $numeroDepart, $episode->getNumero(), $fratrieDepart, $fratrieArrivee);
            }

            // EDITION ENTITE
            // --------------
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'L\'épisode a bien été modifié !');

            // REDIRECTION
            // -----------
            if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
                return $this->redirectToRoute('aventure_saison', ['id' => $episode->getChapitreParent()->getSaisonParent()->getId(),'_fragment' => 'tete-lecture-ch-id' . $episode->getChapitreParent()->getId()]);

            return $this->redirectToRoute('admin_episode');
        }

        // AFFICHAGE FORMULAIRE
        // --------------------
        return $this->renderForm('admin_episode/edit.html.twig', [
            'episode' => $episode,
            'form' => $form,
            'type' => 'Modifier',
        ]);
        
    }

    /**
     * @Route("/admin/episode/{id}/delete", name="admin_episode_delete", methods={"GET"})
     * @IsGranted("ROLE_MJ")
     */
    public function supprimerEpisode(Request $request, Episode $episode, Numeroteur $numeroteur, EpisodeRepository $episodeRepository): Response {
        $chapitreParent = $episode->getChapitreParent(); // Stocké pour la redirection

        // GESTION FORMULAIRE VALIDE
        // -------------------------
        if ($this->isCsrfTokenValid('delete' . $episode->getId(), $request->query->get('csrf'))) {

            // VERIFICATION ENFANTS
            // --------------------
            if (!$episode->getScenes()->isEmpty()) {
                $this->addFlash('warning', 'Veuillez supprimer les scènes enfants au prélable !');
                return $this->redirectToRoute('admin_episode');
            }

            // SUPPRESSION FICHIER IMAGE
            // -------------------------
            $nomImageASupprimer = basename($episode->getImage());
            $cheminImageASupprimer = $this->getParameter('image_directory') . '/episodes/' . $nomImageASupprimer;

            if (file_exists($cheminImageASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminImageASupprimer);
            }

            // NUMEROTEUR
            // ----------
            $fratrieDepartId = $episode->getChapitreParent()->getId();
            $fratrieDepart = $episodeRepository->findBy(['chapitreParent' => $fratrieDepartId]);
            $numeroteur->reordonnerNumero($episode->getId(), $episode->getNumero(), -1, $fratrieDepart, []);

            // SUPPRESSION ENTITE
            // ------------------
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($episode);
            $entityManager->flush();
            $this->addFlash('success', 'L\'épisode a bien été supprimé !');
        }

        // REDIRECTION
        // -----------
        if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
            return $this->redirectToRoute('aventure_saison', ['id' => $chapitreParent->getSaisonParent()->getId(), '_fragment' => 'tete-lecture-ch-id' . $chapitreParent->getId()]);

        return $this->redirectToRoute('admin_episode');
    }
}