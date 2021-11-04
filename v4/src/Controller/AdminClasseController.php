<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Service\Uploader;
use App\Form\AdminClasseType;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminClasseController extends AbstractController
{
    /**
     * @Route("/admin/classe", name="admin_classe")
     */
    public function afficherAdminClasses(ClasseRepository $classeRepository): Response
    {
        $classes = $classeRepository->findAll();
        return $this->render('admin_classe/index.html.twig', [
            'classes' => $classes
        ]);
    }

    /**
     * @Route("/admin/classe/create", name="admin_classe_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ajouterClasse(Request $request, EntityManagerInterface $em, Uploader $uploadeur) {

        $classe = new Classe;
        $form = $this->createForm(AdminClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nouvelleIcone = $form->get('icone')->getData();

            if (!empty($nouvelleIcone)) {
                $nouvelleIconeNomFichier = $uploadeur->upload($nouvelleIcone, 'classe-' . $classe->getNom() . '-icon', 'classes');
                $nouveauCheminRelatif = 'assets/img/classes/' . $nouvelleIconeNomFichier;
                $classe->setIcone($nouveauCheminRelatif);
            } else { $classe->setIcone('assets/img/placeholders/na_class.png'); }

            $em->persist($classe);
            $em->flush();

            $this->addFlash('success', 'La classe a bien été ajoutée !');

            return $this->redirectToRoute('admin_classe');
        } else {
            return $this->render('admin_classe/create.html.twig', [
                'type' => 'Créer',
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/classe/{id}/edit", name="admin_classe_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editerClasse(Request $request, Classe $classe, Uploader $uploadeur): Response {

        $form = $this->createForm(AdminClasseType::class, $classe);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $nouvelleIcone = $form->get('icone')->getData();

            if (!empty($nouvelleIcone)) {

                $ancienneIconeNomFichier = basename($classe->getIcone());

                $nouvelleIconeNomFichier = $uploadeur->upload($nouvelleIcone, 'classe-' . $classe->getNom() . '-icon', 'classes');
                $nouveauChemingRelatif = 'assets/img/classes/' . $nouvelleIconeNomFichier;
                $classe->setIcone($nouveauChemingRelatif);

                $ancienneIconeCheminComplet = $this->getParameter('image_directory') . '/classes/' . $ancienneIconeNomFichier;
                $filesystem = new Filesystem();
                $filesystem->remove($ancienneIconeCheminComplet);

            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La classe a bien été modifiée !');

            return $this->redirectToRoute('admin_classe', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_classe/edit.html.twig', [
            'classe' => $classe,
            'form' => $form,
            'type' => 'Modifier',
        ]);
        
    }

    /**
     * @Route("/admin/classe/{id}/delete", name="admin_classe_delete", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprimerClasse(Request $request, Classe $classe): Response {

        if ($this->isCsrfTokenValid('delete' . $classe->getId(), $request->query->get('csrf'))) {

            if (!$classe->getEcoles()->isEmpty()) {
                $this->addFlash('warning', 'Veuillez supprimer les écoles enfants au prélable !');
                return $this->redirectToRoute('admin_classe', [], Response::HTTP_SEE_OTHER);
            }

            $entityManager = $this->getDoctrine()->getManager();

            // Gestion de l'image
            $nomIconeASupprimer = basename($classe->getIcone());
            $cheminIconeASupprimer = $this->getParameter('image_directory') . '/classes/' . $nomIconeASupprimer;

            if (file_exists($cheminIconeASupprimer)) {
                $filesystem = new Filesystem();
                $filesystem->remove($cheminIconeASupprimer);
            }

            $entityManager->remove($classe);
            $entityManager->flush();

            $this->addFlash('success', 'La classe a bien été supprimée !');
        }

        return $this->redirectToRoute('admin_classe', [], Response::HTTP_SEE_OTHER);
    }
}
