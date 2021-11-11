<?php

namespace App\Form;

use App\Entity\Personnage;
use App\Entity\FichePersonnage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminFichePersonnageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('personnage', EntityType::class, [
                'class' => Personnage::class,
                'choice_label' => 'prenom',
                'required' => true
            ])
            ->add('creationExp', IntegerType::class)
            ->add('avantages', TextareaType::class)
            ->add('desavantages', TextareaType::class)
            ->add('constitution', IntegerType::class)
            ->add('volonte', IntegerType::class)
            ->add('reflexes', IntegerType::class)
            ->add('intuition', IntegerType::class)
            ->add('agilite', IntegerType::class)
            ->add('intelligence', IntegerType::class)
            ->add('forceStat', IntegerType::class)
            ->add('perception', IntegerType::class)
            ->add('vide', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FichePersonnage::class,
        ]);
    }
}
