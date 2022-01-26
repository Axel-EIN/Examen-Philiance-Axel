<?php

namespace App\Controller;

use App\Service\Uploader;
use App\Entity\Personnage;
use App\Form\AdminPersonnageType;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPersonnageController extends AbstractController
{
    /**
     * @Route("/admin/personnage", name="admin_personnage")
     */
    public function afficherAdminPersonnages(PersonnageRepository $personnageRepository): Response
    {
        $personnages = $personnageRepository->findBy(array(), array('clan' => 'ASC'));
        return $this->render('admin_personnage/index.html.twig', [
            'personnages' => $personnages
        ]);
    }

    /**
     * @Route("/admin/personnage/create", name="admin_personnage_create")
     * @IsGranted("ROLE_MJ")
     */
    public function ajouterPersonnage(Request $request, EntityManagerInterface $em, Uploader $uploadeur) {

        $personnage = new Personnage;
        $form = $this->createForm(AdminPersonnageType::class, $personnage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newIcon = $form->get('icone')->getData();
            $newIllu = $form->get('illustration')->getData();

            // // Gestion de l'image d'icône portrait
            if (!empty($newIcon)) {
                $newIconName = $uploadeur->upload($newIcon, 'personnage-'
                                            . $personnage->getNom()
                                            . '-' . $personnage->getPrenom()
                                            . '-icone', 'personnages');
                $newIconePath = 'assets/img/personnages/' . $newIconName;
                $personnage->setIcone($newIconePath);
            } else { $personnage->setIcone('assets/img/placeholders/na_personnage_icone.jpg'); }

            // Gestion de l'image d'illustration
            
            if (!empty($newIllu)) {
                $newIlluName = $uploadeur->upload($newIllu, 'personnage-'
                                            . $personnage->getNom()
                                            . '-' . $personnage->getPrenom()
                                            . '-illustration', 'personnages');
                $newIlluPath = 'assets/img/personnages/' . $newIlluName;
                $personnage->setIllustration($newIlluPath);
            } else { $personnage->setIllustration('assets/img/placeholders/na_personnage_illustration.jpg'); }

            $em->persist($personnage);
            $em->flush();

            $this->addFlash('success', 'Le personnage a bien été ajouté !');

            return $this->redirectToRoute('admin_personnage');
        } else {
            return $this->render('admin_personnage/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/personnage/{id}/edit", name="admin_personnage_edit")
     * @IsGranted("ROLE_MJ")
     */
    public function editerPersonnage(Request $request, Personnage $personnage, Uploader $uploadeur): Response {

        $form = $this->createForm(AdminPersonnageType::class, $personnage);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $nouvelleIcone = $form->get('icone')->getData();
            $nouvelleIllustration = $form->get('illustration')->getData();

            if (!empty($nouvelleIcone)) {

                $ancienIconeNomFichier = basename($personnage->getIcone());

                $nouvelleIconeNomFichier = $uploadeur->upload($nouvelleIcone, 'personnage-'
                                            . $personnage->getNom()
                                            . '-' . $personnage->getPrenom()
                                            . '-icone', 'personnages');
                $nouveauChemingRelatif = 'assets/img/personnages/' . $nouvelleIconeNomFichier;
                $personnage->setIcone($nouveauChemingRelatif);

                $ancienneIconeCheminComplet = $this->getParameter('image_directory') . '/personnages/' . $ancienIconeNomFichier;
                $filesystem = new Filesystem();
                $filesystem->remove($ancienneIconeCheminComplet);

            }

            if (!empty($nouvelleIllustration)) {

                $ancienIllustrationNomFichier = basename($personnage->getIllustration());

                $nouvelleIllustrationNomFichier = $uploadeur->upload($nouvelleIllustration, 'personnage-'
                                                    . $personnage->getNom()
                                                    . '-' . $personnage->getPrenom()
                                                    . '-illustration', 'personnages');
                $nouveauChemingRelatif = 'assets/img/personnages/' . $nouvelleIllustrationNomFichier;
                $personnage->setIllustration($nouveauChemingRelatif);

                $ancienneIllustrationCheminComplet = $this->getParameter('image_directory') . '/personnages/' . $ancienIllustrationNomFichier;
                $filesystem = new Filesystem();
                $filesystem->remove($ancienneIllustrationCheminComplet);

            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le personnage a bien été modifié !');

            return $this->redirectToRoute('admin_personnage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_personnage/edit.html.twig', [
            'personnage' => $personnage,
            'form' => $form,
            'type' => 'Modifier',
        ]);
        
    }

    /**
     * @Route("/admin/personnage/{id}/delete", name="admin_personnage_delete", methods={"GET"})
     * @IsGranted("ROLE_MJ")
     */
    public function supprimerPersonnage(Request $request, Personnage $personnage): Response {

        if ($this->isCsrfTokenValid('delete' . $personnage->getId(), $request->query->get('csrf'))) {

            $entityManager = $this->getDoctrine()->getManager();

            $nomIconeASupprimer = basename($personnage->getIcone());
            $nomIllustrationASupprimer = basename($personnage->getIllustration());
            $cheminIconeASupprimer = $this->getParameter('image_directory') . '/personnages/' . $nomIconeASupprimer;
            $cheminIllustrationASupprimer = $this->getParameter('image_directory') . '/personnages/' . $nomIllustrationASupprimer;

            if (file_exists($cheminIconeASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminIconeASupprimer);
            }

            if (file_exists($cheminIllustrationASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminIllustrationASupprimer);
            }

            $entityManager->remove($personnage);
            $entityManager->flush();

            $this->addFlash('success', 'Le personnage a bien été supprimé !');
        }

        return $this->redirectToRoute('admin_personnage', [], Response::HTTP_SEE_OTHER);
    }
}
