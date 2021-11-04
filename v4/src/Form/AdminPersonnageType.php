<?php

namespace App\Form;

use App\Entity\Clan;
use App\Entity\Ecole;
use App\Entity\Classe;
use App\Entity\Personnage;
use App\Entity\Utilisateur;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminPersonnageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('titres', TextType::class, [
                'required' => false,
            ])
            ->add('icone', FileType::class, array('mapped' => false, 'data_class' => null, 'required' => false))
            ->add('illustration', FileType::class, array('mapped' => false, 'data_class' => null, 'required' => false))
            ->add('description', TextareaType::class)
            ->add('est_pj', CheckboxType::class, [
                'required' => false,
            ])
            ->add('clan', EntityType::class, [
                'class' => Clan::class,
                'choice_label' => 'nom'])
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom'])
            ->add('ecole', EntityType::class, [
                'class' => Ecole::class,
                'choice_label' => 'nom'])
            ->add('joueur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'pseudo',
                'placeholder' => 'PNJ / Aucun Joueur-Défini',
                'required' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnage::class,
        ]);
    }
}
