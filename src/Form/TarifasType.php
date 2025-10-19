<?php

namespace App\Form;

use App\Entity\Tarifas;
use App\Entity\TiposVehiculos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TarifasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('valor_hora')
            ->add('valor_dia')
            ->add('estado')
            ->add('tipo', EntityType::class, [
                'class' => TiposVehiculos::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tarifas::class,
        ]);
    }
}
