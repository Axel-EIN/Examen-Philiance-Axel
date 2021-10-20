<?php

namespace App\Controller;

use App\Entity\Scene;
use App\Entity\Episode;
use App\Service\Uploader;
use App\Form\AdminSceneType;
use App\Repository\SceneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminSceneController extends AbstractController
{
    /**
     * @Route("/admin/scene", name="admin_scene")
     * @IsGranted("ROLE_ADMIN")
     */
    public function afficherAdminScenes(SceneRepository $sceneRepository): Response
    {
        $scenes = $sceneRepository->findBy(array(), array('episodeParent' => 'ASC'));

        return $this->render('admin_scene/index.html.twig', [
            'controller_name' => 'AdminSceneController',
            'scenes' => $scenes,
        ]);
    }

    /**
     * @Route("/admin/scene/create", name="admin_scene_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function creerScene(Request $request, EntityManagerInterface $em, Uploader $uploadeur) {

        $scene = new Scene;
        $form = $this->createForm(AdminSceneType::class, $scene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();

            if (!empty($nouvelleImage)) {
                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage,
                    'scene-s' . $scene->getEpisodeParent()->getChapitreParent()->getSaisonParent()->getNumero()
                    . '-ch' . $scene->getEpisodeParent()->getChapitreParent()->getNumero()
                    . '-ep' . $scene->getEpisodeParent()->getNumero() . '-scn' . $scene->getNumero(), 'scenes');
                $nouveauCheminRelatif = 'assets/img/scenes/' . $nouvelleImageNomFichier;
                $scene->setImage($nouveauCheminRelatif);
            } else { $scene->setImage('assets/img/placeholders/1280x720.png'); }

            $em->persist($scene);
            $em->flush();

            $this->addFlash('success', 'La scène a bien été crée !');

            return $this->redirectToRoute('admin_scene');
        } else {
            return $this->render('admin_scene/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/scene/{id}/edit", name="admin_scene_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editerScene(Request $request, Scene $scene, Uploader $uploadeur): Response {

        $form = $this->createForm(AdminSceneType::class, $scene);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $nouvelleImage = $form->get('image')->getData();

            if (!empty($nouvelleImage)) {

                $AncienneImageNomFichier = basename($scene->getImage());

                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage, 'scene-s'
                    . $scene->getEpisodeParent()->getChapitreParent()->getSaisonParent()->getNumero()
                    . '-ch' . $scene->getEpisodeParent()->getChapitreParent()->getNumero()
                    . '-ep' . $scene->getEpisodeParent()->getNumero()
                    . '-scn' . $scene->getNumero(), 'scenes');
                $nouveauChemingRelatif = 'assets/img/scenes/' . $nouvelleImageNomFichier;
                $scene->setImage($nouveauChemingRelatif);

                $ancienneImageCheminComplet = $this->getParameter('image_directory') . '/scenes/' . $AncienneImageNomFichier;
                $filesystem = new Filesystem();
                $filesystem->remove($ancienneImageCheminComplet);

            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La scène a bien été modifiée !');

            return $this->redirectToRoute('admin_scene', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_scene/edit.html.twig', [
            'scene' => $scene,
            'form' => $form,
            'type' => 'Modifier',
        ]); 
    }

    /**
     * @Route("/admin/scene/{id}/delete", name="admin_scene_delete", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprimerScene(Request $request, Scene $scene): Response {
        if ($this->isCsrfTokenValid('delete' . $scene->getId(), $request->query->get('csrf'))) {

            $entityManager = $this->getDoctrine()->getManager();

            $nomImageASupprimer = basename($scene->getImage());
            $cheminImageASupprimer = $this->getParameter('image_directory') . '/scenes/' . $nomImageASupprimer;

            if (file_exists($cheminImageASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminImageASupprimer);
            }

            $entityManager->remove($scene);
            $entityManager->flush();

            $this->addFlash('success', 'La scène a bien été supprimée !');
        }

        return $this->redirectToRoute('admin_scene', [], Response::HTTP_SEE_OTHER);
    }
}
