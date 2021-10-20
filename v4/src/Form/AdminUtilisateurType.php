<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminUtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class)
            ->add('roles', ChoiceType::class, [
                'label' => 'rôles',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'choices' => [
                    'Joueur' => 'ROLE_JOUEUR',
                    'MJ' => 'ROLE_MJ',
                    'Administrateur' => 'ROLE_ADMIN',
                ]
            ])
            ->add('password', TextType::class)
            ->add('email', EmailType::class)
            ->add('avatar', FileType::class, array('mapped' => false, 'data_class' => null, 'required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
