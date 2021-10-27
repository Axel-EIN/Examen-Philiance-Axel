<?php

namespace App\Form;

use App\Entity\Clan;
use App\Entity\Ecole;
use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminEcoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('description', TextareaType::class)
            ->add('image', FileType::class, array('mapped' => false, 'data_class' => null, 'required' => false))
            ->add('tech1Nom', TextType::class, ['required' => false])
            ->add('tech1Desc', TextareaType::class, ['required' => false])
            ->add('tech2Nom', TextType::class, ['required' => false])
            ->add('tech2Desc', TextareaType::class, ['required' => false])
            ->add('tech3Nom', TextType::class, ['required' => false])
            ->add('tech3Desc', TextareaType::class, ['required' => false])
            ->add('tech4Nom', TextType::class, ['required' => false])
            ->add('tech4Desc', TextareaType::class, ['required' => false])
            ->add('tech5Nom', TextType::class, ['required' => false])
            ->add('tech5Desc', TextareaType::class, ['required' => false])
            ->add('techSpecialNom', TextType::class, ['required' => false])
            ->add('techSpecialDesc', TextareaType::class, ['required' => false])
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom'
            ])
            ->add('clan', EntityType::class, [
                'class' => Clan::class,
                'choice_label' => 'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ecole::class,
        ]);
    }
}
