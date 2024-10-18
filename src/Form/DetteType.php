<?php

namespace App\Form;

use App\Entity\Dette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', MoneyType::class, [
                'currency' => 'CFA',
                'label' => 'Montant',
            ])
            ->add('montantVerser', MoneyType::class, [
                'currency' => 'CFA',
                'label' => 'Montant Versé',
            ])
            ->add('client')
            ->add('save', SubmitType::class, [
                'label' => 'Créer la dette',
                'attr' => ['class' => 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dette::class,
        ]);
    }
}
