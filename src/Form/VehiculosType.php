<?php

namespace App\Form;

use App\Entity\Clientes;
use App\Entity\TiposVehiculos;
use App\Entity\Vehiculos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('placa')
            ->add('color')
            ->add('marca')
            ->add('tipo_vehiculo')
            ->add('cliente', EntityType::class, [
                'class' => Clientes::class,
                'choice_label' => 'id',
            ])
            ->add('tipo', EntityType::class, [
                'class' => TiposVehiculos::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehiculos::class,
        ]);
    }
}
