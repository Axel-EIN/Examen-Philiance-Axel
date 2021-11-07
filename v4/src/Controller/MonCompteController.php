<?php

namespace App\Controller;

use App\Form\MonCompteMdpType;
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

    // public function editerClan(Request $request, Clan $clan, Uploader $uploadeur): Response {

        
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()) {

    //         $nouveauMon = $form->get('mon')->getData();

    //         if (!empty($nouveauMon)) {

    //             $ancienMonNomFichier = basename($clan->getMon());

    //             $nouveauMonNomFichier = $uploadeur->upload($nouveauMon, 'clan-' . $clan->getNom() . '-mon', 'clans');
    //             $nouveauChemingRelatif = 'assets/img/clans/' . $nouveauMonNomFichier;
    //             $clan->setMon($nouveauChemingRelatif);

    //             $ancienMonCheminComplet = $this->getParameter('image_directory') . '/clans/' . $ancienMonNomFichier;
    //             $filesystem = new Filesystem();
    //             $filesystem->remove($ancienMonCheminComplet);

    //         }

    //         $this->getDoctrine()->getManager()->flush();
    //         $this->addFlash('success', 'Le clan a bien été modifié !');

    //         return $this->redirectToRoute('admin_clan', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('admin_clan/edit.html.twig', [
    //         'clan' => $clan,
    //         'form' => $form,
    //         'type' => 'Modifier',
    //     ]);
        
    // }
}
