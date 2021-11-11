<?php

namespace App\Controller;

use App\Service\Uploader;
use App\Form\MonCompteMdpType;
use App\Entity\FichePersonnage;
use App\Form\MonCompteAvatarType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MonCompteController extends AbstractController
{
    /**
     * @Route("/mon_compte", name="mon_compte")
     */
    public function afficherMonCompte(): Response
    {
        return $this->render('mon_compte/index.html.twig');
    }

    /**
     * @Route("/mon_compte/password/edit", name="mon_compte_mdp")
     */
    public function modifierMotDePasse(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(MonCompteMdpType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // encode the plain password
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre mot de passe a bien été modifié !');
            return $this->redirectToRoute('mon_compte');
        }

        return $this->render('mon_compte/modifier_mdp.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mon_compte/avatar/edit", name="mon_compte_avatar")
     */
    public function modifierAvatar(Request $request, Uploader $uploadeur): Response
    {
        $utilisateur = $this->getUser();
        $form = $this->createForm(MonCompteAvatarType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $nouveauAvatar = $form->get('avatar')->getData();

            if (!empty($nouveauAvatar)) {

                $ancienAvatarNomFichier = basename($utilisateur->getAvatar());

                $nouveauAvatarNomFichier = $uploadeur->upload($nouveauAvatar, 'avatar-' . $utilisateur->getPseudo(), 'avatars');
                $nouveauChemingRelatif = 'assets/img/avatars/' . $nouveauAvatarNomFichier;
                $utilisateur->setAvatar($nouveauChemingRelatif);

                $ancienneAvatarCheminComplet = $this->getParameter('image_directory') . '/avatars/' . $ancienAvatarNomFichier;
                $filesystem = new Filesystem();
                if ($ancienneAvatarCheminComplet != $this->getParameter('image_directory') . '/avatars/')
                    $filesystem->remove($ancienneAvatarCheminComplet);

            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            $this->addFlash('success', 'Votre avatar a bien été modifié !');
            return $this->redirectToRoute('mon_compte');
        }

        return $this->render('mon_compte/modifier_avatar.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mon_compte/fiche/{id}", name="mon_compte_fiche")
     */
    public function afficherMonCompteFichePersonnage(FichePersonnage $fiche): Response
    {
        $utilisateur = $this->getUser();

        if ($fiche->getPersonnage()->getJoueur()->getId() != $utilisateur->getId())
            return $this->redirectToRoute('mon_compte');

        return $this->render('mon_compte/fiche_personnage.html.twig', [
            'fiche' => $fiche,
        ]);
    }
}
