<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Service\Uploader;
use App\Form\AdminEpisodeType;
use App\Repository\ChapitreRepository;
use App\Repository\EpisodeRepository;
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
    public function creerEpisode(Request $request, EntityManagerInterface $em, Uploader $uploadeur, ChapitreRepository $chapitreRepository) {

        $episode = new Episode;

        if ( !empty($request->query->get('numero')) && $request->query->get('numero') > 0
          && !empty($request->query->get('chapitreID')) && $request->query->get('chapitreID') > 0 )
        {
                $episode->setNumero($request->query->get('numero'));

                $chapitreParent = $chapitreRepository->find($request->query->get('chapitreID'));
                if ($chapitreParent !== null)
                    $episode->setChapitreParent($chapitreParent);
        }

        $form = $this->createForm(AdminEpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();

            if (!empty($nouvelleImage)) {
                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage,
                    'episode-s' . $episode->getChapitreParent()->getSaisonParent()->getNumero()
                    . '-ch' . $episode->getChapitreParent()->getNumero() . '-ep' . $episode->getNumero(), 'episodes');
                $nouveauCheminRelatif = 'assets/img/episodes/' . $nouvelleImageNomFichier;
                $episode->setImage($nouveauCheminRelatif);
            } else { $episode->setImage('assets/img/placeholders/960x540.jpg'); }

            $em->persist($episode);
            $em->flush();

            $this->addFlash('success', 'L\'épisode a bien été crée !');

            if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
                return $this->redirectToRoute('aventure_saison', ['id' => $episode->getChapitreParent()->getSaisonParent()->getId(),'_fragment' => 'tete-lecture-ch-id' . $episode->getChapitreParent()->getId()]);
            
            return $this->redirectToRoute('admin_episode');

        } else {
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
    public function editerEpisode(Request $request, Episode $episode, Uploader $uploadeur): Response {

        $form = $this->createForm(AdminEpisodeType::class, $episode);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

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

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'L\'épisode a bien été modifié !');

            if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
                return $this->redirectToRoute('aventure_saison', ['id' => $episode->getChapitreParent()->getSaisonParent()->getId(),'_fragment' => 'tete-lecture-ch-id' . $episode->getChapitreParent()->getId()]);

            return $this->redirectToRoute('admin_episode', [], Response::HTTP_SEE_OTHER);
        }

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
    public function supprimerEpisode(Request $request, Episode $episode): Response {
        if ($this->isCsrfTokenValid('delete' . $episode->getId(), $request->query->get('csrf'))) {

            if (!$episode->getScenes()->isEmpty()) {
                $this->addFlash('warning', 'Veuillez supprimer les scènes enfants au prélable !');
                return $this->redirectToRoute('admin_episode', [], Response::HTTP_SEE_OTHER);
            }

            $chapitreParent = $episode->getChapitreParent();

            $entityManager = $this->getDoctrine()->getManager();

            $nomImageASupprimer = basename($episode->getImage());
            $cheminImageASupprimer = $this->getParameter('image_directory') . '/episodes/' . $nomImageASupprimer;

            if (file_exists($cheminImageASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminImageASupprimer);
            }

            $entityManager->remove($episode);
            $entityManager->flush();

            $this->addFlash('success', 'L\'épisode a bien été supprimé !');
        }

        if (!empty($request->query->get('redirect')) && $request->query->get('redirect') == 'aventure')
            return $this->redirectToRoute('aventure_saison', ['id' => $chapitreParent->getSaisonParent()->getId(), '_fragment' => 'tete-lecture-ch-id' . $chapitreParent->getId()]);

        return $this->redirectToRoute('admin_episode', [], Response::HTTP_SEE_OTHER);
    }
}