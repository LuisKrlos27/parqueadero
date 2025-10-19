<?php

namespace App\Form;

use App\Entity\Pagos;
use App\Entity\Registros;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('monto')
            ->add('fecha_pago')
            ->add('metodo_pago')
            ->add('registro', EntityType::class, [
                'class' => Registros::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pagos::class,
        ]);
    }
}
