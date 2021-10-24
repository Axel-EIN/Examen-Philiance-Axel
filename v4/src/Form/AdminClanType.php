<?php

namespace App\Form;

use App\Entity\Clan;
use App\Entity\Personnage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AdminClanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('est_majeur', CheckboxType::class, ['required' => false])
            ->add('couleur', ColorType::class)
            ->add('mon', FileType::class, array('mapped' => false, 'data_class' => null, 'required' => false))
            ->add('chef', EntityType::class, [
                'class' => Personnage::class,
                'choice_label' => 'prenom'
            ])
        ;

        $builder
            ->get('est_majeur')
            ->addModelTransformer(new CallbackTransformer(
                function ($activeAsString) {
                    // transform the string to boolean
                    return (bool)(int)$activeAsString;
                },
                function ($activeAsBoolean) {
                    // transform the boolean to string
                    return (string)(int)$activeAsBoolean;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clan::class,
        ]);
    }
}
