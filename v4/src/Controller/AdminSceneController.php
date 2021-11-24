<?php

namespace App\Controller;

use App\Entity\Scene;
use App\Service\Uploader;
use App\Form\AdminSceneType;
use App\Entity\Participation;
use App\Repository\ParticipationRepository;
use App\Repository\SceneRepository;
use App\Repository\PersonnageRepository;
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
    public function creerScene(
                                Request $request,
                                EntityManagerInterface $em,
                                Uploader $uploadeur,
                                PersonnageRepository $personnageRepository) {

        $tout_pjs = $personnageRepository->findBy(array('est_pj' => true));
        $tout_pnjs = $personnageRepository->findBy(array('est_pj' => false));

        $scene = new Scene;
        $form = $this->createForm(AdminSceneType::class, $scene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Gestion de l'IMAGE
            $nouvelleImage = $form->get('image')->getData();

            if (!empty($nouvelleImage)) {
                $nouvelleImageNomFichier = $uploadeur->upload($nouvelleImage,
                    'scene-s' . $scene->getEpisodeParent()->getChapitreParent()->getSaisonParent()->getNumero()
                    . '-ch' . $scene->getEpisodeParent()->getChapitreParent()->getNumero()
                    . '-ep' . $scene->getEpisodeParent()->getNumero() . '-scn' . $scene->getNumero(), 'scenes');
                $nouveauCheminRelatif = 'assets/img/scenes/' . $nouvelleImageNomFichier;
                $scene->setImage($nouveauCheminRelatif);
            } else { $scene->setImage('assets/img/placeholders/1280x720.png'); }

            // Gestion des PARTICIPATIONS
            if(!empty($request->get('participants'))) {
                $participants_pjs = $request->get('participants');
                $participants_pjs_xp = $request->get('participants_xp');
                if(!empty($request->get('participants_mort')))
                    $participants_pjs_mort = $request->get('participants_mort');
                else
                    $participants_pjs_mort = [];
            } else {
                $participants_pjs = [];
                $participants_pjs_xp = [];
                $participants_pjs_mort = [];
            }

            if(!empty($request->get('participants_pnjs'))) {
                $participants_pnjs = $request->get('participants_pnjs');
                if(!empty($request->get('participants_pnjs_mort')))
                    $participants_pnjs_mort = $request->get('participants_pnjs_mort');
                else
                    $participants_pnjs_mort = [];
            } else {
                $participants_pnjs = [];
                $participants_pnjs_mort = [];
            }

            // REGROUPEMENT DES DONNEES POST PJS (ID, XP, MORT) & PNJS (ID, MORT)
            $participants_a_ajoutes = [];
            $compteur = 0;
            
            if(!empty($participants_pjs)) {
                foreach($participants_pjs as $key => $un_participant_pj) {
                    $participants_a_ajoutes[$compteur]['id'] = $participants_pjs[$key];
                    $participants_a_ajoutes[$compteur]['xp'] = $participants_pjs_xp[$key];
                    if (!empty($participants_pjs_mort[$key]))
                        $participants_a_ajoutes[$compteur]['mort'] = 1;
                    else
                        $participants_a_ajoutes[$compteur]['mort'] = 0;
                    $participants_a_ajoutes[$compteur]['estPj'] = 1;
                    $compteur++;
                }
            }
            
            if(!empty($participants_pnjs)) {
                foreach($participants_pnjs as $cle => $un_participant_pnj) {
                    $participants_a_ajoutes[$compteur]['id'] = $participants_pnjs[$cle];
                    $participants_a_ajoutes[$compteur]['xp'] = 0;
                    if (!empty($participants_pnjs_mort[$cle]))
                        $participants_a_ajoutes[$compteur]['mort'] = 1;
                    else
                        $participants_a_ajoutes[$compteur]['mort'] = 0;
                    $participants_a_ajoutes[$compteur]['estPj'] = 0;
                    $compteur++;
                }
            }

            // AJOUT DES PARTICIPANTS
            if (!empty($participants_a_ajoutes)) {
                foreach ($participants_a_ajoutes as $cle => $un_participant_a_ajoute) {
                    // Ajoute un participant à une scène et renvoi le dernier ID inséré dans la table ou false
                    if ( !empty($personnageRepository->find($participants_a_ajoutes[$cle]['id'])) ) {
                        $personnage = $personnageRepository->find($participants_a_ajoutes[$cle]['id']);
                        $nouvelle_participation = new Participation;
                        $nouvelle_participation->setScene($scene);
                        $nouvelle_participation->setPersonnage($personnage);
                        $nouvelle_participation->setXpGagne($participants_a_ajoutes[$cle]['xp']);
                        $nouvelle_participation->setEstMort($participants_a_ajoutes[$cle]['mort']);
                        $nouvelle_participation->setEstPj($participants_a_ajoutes[$cle]['estPj']);
                        $em->persist($nouvelle_participation);
                        $this->addFlash('success', 'Le personnage ' . $personnage->getPrenom() . ' a bien été ajouté en participant !');
                    } else {
                        $this->addFlash('danger', 'Le personnage n\'a pu être ajouté en participant !');
                    }
                }
            }

            // TAG DES PERSONNAGES
            $tableau = [];
            $texte = $scene->getTexte();
            preg_match_all('#\[(.*)\]#Ui', $texte, $tableau); // Capture tout les mots entre [ ]
            $tableau_de_regexp = array_fill(0, count($tableau[1]), '#\[(.*)\]#Ui'); // On crée un tableau de regexp au nbr de matchs
            $tableau_remplacement = [];
            foreach ($tableau[1] as $key => $un_match) {
                $personnage_trouve = $personnageRepository->findOneBy(array('prenom' => $un_match));
                if ($personnage_trouve != null) {
                    $tableau_remplacement[] =
                        '<a class="perso-img" href="../../personnages/profil/' . $personnage_trouve->getId() . '">'
                                    . '<img src="../../' . $personnage_trouve->getIcone()
                                    . '" alt="Icône du personnage" /> ' . $personnage_trouve->getPrenom() . '</a>';
                } else
                    $tableau_remplacement[] = $un_match;
            }

            $scene->setTexte(preg_replace($tableau_de_regexp, $tableau_remplacement, $texte, 1));

            $em->persist($scene);
            $em->flush();

            $this->addFlash('success', 'La scène a bien été crée !');

            return $this->redirectToRoute('admin_scene');
        } else {
            return $this->render('admin_scene/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView(),
                'tout_pjs' => $tout_pjs,
                'tout_pnjs' => $tout_pnjs,
            ]);
        }
    }

    /**
     * @Route("/admin/scene/{id}/edit", name="admin_scene_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editerScene(
                                Request $request,
                                Scene $scene,
                                Uploader $uploadeur,
                                PersonnageRepository $personnageRepository,
                                ParticipationRepository $participationRepository): Response {

        $tout_pjs = $personnageRepository->findBy(array('est_pj' => true));
        $tout_pnjs = $personnageRepository->findBy(array('est_pj' => false));

        $participations_pjs = $participationRepository->findBy(array('scene' => $scene, 'estPj' => true));
        $participations_pnjs = $participationRepository->findBy(array('scene' => $scene, 'estPj' => false));

        // UNTAG PERSONNAGES
        $tableau = [];
        $texte = $scene->getTexte();
        preg_match_all('#<a .*><img .*/> (.*)<\/a>#Ui', $texte, $tableau); // Capture tout les prenoms entre les balises a img
        $tableau_de_regexp = array_fill(0, count($tableau[1]), '#<a .*><img .*/> (.*)<\/a>#Ui'); // On crée un tableau de regexp au nbr de matchs
        $tableau_remplacement = [];
        foreach ($tableau[1] as $key => $un_match) {
            $personnage_trouve = $personnageRepository->findOneBy(array('prenom' => $un_match));
            if ($personnage_trouve != null) {
                $tableau_remplacement[] = '[' . $personnage_trouve->getPrenom() . ']';
            } else
                $tableau_remplacement[] = $un_match;
        }

        $scene->setTexte(preg_replace($tableau_de_regexp, $tableau_remplacement, $texte, 1));

        $form = $this->createForm(AdminSceneType::class, $scene);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            // Gestion de l'IMAGE
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

            // Gestion des PARTICIPATIONS
            if(!empty($request->get('participants'))) {
                $participants_pjs = $request->get('participants');
                $participants_pjs_xp = $request->get('participants_xp');
                if(!empty($request->get('participants_mort')))
                    $participants_pjs_mort = $request->get('participants_mort');
                else
                    $participants_pjs_mort = [];
            } else {
                $participants_pjs = [];
                $participants_pjs_xp = [];
                $participants_pjs_mort = [];
            }

            if(!empty($request->get('participants_pnjs'))) {
                $participants_pnjs = $request->get('participants_pnjs');
                if(!empty($request->get('participants_pnjs_mort')))
                    $participants_pnjs_mort = $request->get('participants_pnjs_mort');
                else
                    $participants_pnjs_mort = [];
            } else {
                $participants_pnjs = [];
                $participants_pnjs_mort = [];
            }

            // REGROUPEMENT DES DONNEES POST PJS (ID, XP, MORT) & PNJS (ID, MORT)
            $participants_modifies = [];
            $compteur = 0;
            
            if(!empty($participants_pjs)) {
                foreach($participants_pjs as $key => $un_participant_pj) {
                    $participants_modifies[$compteur]['id'] = $participants_pjs[$key];
                    $participants_modifies[$compteur]['xp'] = $participants_pjs_xp[$key];
                    if (!empty($participants_pjs_mort[$key]))
                        $participants_modifies[$compteur]['mort'] = 1;
                    else
                        $participants_modifies[$compteur]['mort'] = 0;
                    $participants_modifies[$compteur]['estPj'] = 1;
                    $compteur++;
                }
            }
            
            if(!empty($participants_pnjs)) {
                foreach($participants_pnjs as $cle => $un_participant_pnj) {
                    $participants_modifies[$compteur]['id'] = $participants_pnjs[$cle];
                    $participants_modifies[$compteur]['xp'] = 0;
                    if (!empty($participants_pnjs_mort[$cle]))
                        $participants_modifies[$compteur]['mort'] = 1;
                    else
                        $participants_modifies[$compteur]['mort'] = 0;
                    $participants_modifies[$compteur]['estPj'] = 0;
                    $compteur++;
                }
            }

            $toutes_participations = array_merge($participations_pjs, $participations_pnjs);

            // SUPPRESSION & MODDIFICATION
            foreach ($toutes_participations as $une_participation) {
                $trouvee = false;

                foreach ($participants_modifies as $un_participant_modifie) {
                    if ($une_participation->getPersonnage()->getId() == $un_participant_modifie['id']) {
                        $trouvee = true;
                        break;
                    }
                }

                if ($trouvee == true) {
                    if ($une_participation->getXpGagne() != $un_participant_modifie['xp'] || $une_participation->getEstMort() != $un_participant_modifie['mort'] ) {
                        $une_participation->setXpGagne($un_participant_modifie['xp']);
                        $une_participation->setEstMort($un_participant_modifie['mort']);
                        $this->addFlash('warning', 'Le personnage ' . $une_participation->getPersonnage()->getPrenom() . ' a bien été modifié des participant !');
                    }
                }

                if ($trouvee == false) {
                    $this->addFlash('danger', 'Le personnage ' . $une_participation->getPersonnage()->getPrenom() . ' a bien été retiré des participants !');
                    $this->getDoctrine()->getManager()->remove($une_participation);
                }
            }

            // AJOUT
            foreach ($participants_modifies as $un_participant_modifie) {
                $trouvee = false;

                foreach($toutes_participations as $une_participation) {
                    if($un_participant_modifie['id'] == $une_participation->getPersonnage()->getId()) {
                        $trouvee = true;
                        break;
                    }
                }

                if($trouvee == false) {
                    $personnage = $personnageRepository->find($un_participant_modifie['id']);
                    $nouvelle_participation = new Participation;
                    $nouvelle_participation->setScene($scene);
                    $nouvelle_participation->setPersonnage($personnage);
                    $nouvelle_participation->setXpGagne($un_participant_modifie['xp']);
                    $nouvelle_participation->setEstMort($un_participant_modifie['mort']);
                    $nouvelle_participation->setEstPj($un_participant_modifie['estPj']);
                    $this->getDoctrine()->getManager()->persist($nouvelle_participation);
                    $this->addFlash('success', 'Le personnage ' . $nouvelle_participation->getPersonnage()->getPrenom() . ' a bien été ajouté en participant !');
                }
            }

            // TAG DES PERSONNAGES
            $tableau = [];
            $texte = $scene->getTexte();
            preg_match_all('#\[(.*)\]#Ui', $texte, $tableau); // Capture tout les mots entre [ ]
            $tableau_de_regexp = array_fill(0, count($tableau[1]), '#\[(.*)\]#Ui'); // On crée un tableau de regexp au nbr de matchs
            $tableau_remplacement = [];
            foreach ($tableau[1] as $key => $un_match) {
                $personnage_trouve = $personnageRepository->findOneBy(array('prenom' => $un_match));
                if ($personnage_trouve != null) {
                    $tableau_remplacement[] =
                        '<a class="perso-img" href="../../personnages/profil/' . $personnage_trouve->getId() . '">'
                                    . '<img src="../../' . $personnage_trouve->getIcone()
                                    . '" alt="Icône du personnage" /> ' . $personnage_trouve->getPrenom() . '</a>';
                } else
                    $tableau_remplacement[] = $un_match;
            }

            $scene->setTexte(preg_replace($tableau_de_regexp, $tableau_remplacement, $texte, 1));

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La scène a bien été modifiée !');

            return $this->redirectToRoute('admin_scene', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_scene/edit.html.twig', [
            'scene' => $scene,
            'form' => $form,
            'type' => 'Modifier',
            'tout_pjs' => $tout_pjs,
            'tout_pnjs' => $tout_pnjs,
            'participations_pjs' => $participations_pjs,
            'participations_pnjs' => $participations_pnjs,
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
            if ($nomImageASupprimer != '1280x720.png') {
                $cheminImageASupprimer = $this->getParameter('image_directory') . '/scenes/' . $nomImageASupprimer;
                if (file_exists($cheminImageASupprimer)) {
                    $filesystem = new Filesystem();
                    $filesystem->remove($cheminImageASupprimer);
                }
            }
            $entityManager->remove($scene);
            $entityManager->flush();
            $this->addFlash('success', 'La scène a bien été supprimée !');
        }
        return $this->redirectToRoute('admin_scene', [], Response::HTTP_SEE_OTHER);
    }
}
