<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'block w-full px-4 py-3 bg-gray-50 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none',
                    'placeholder' => '77XXXXXXX ou 78XXXXXXX ou 76XXXXXXX',
                    'pattern' => '^(77|78|76)[0-9]{7}$', // Validation HTML en plus de la validation Symfony
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un numéro de téléphone valide.',
                    ]),
                    new NotNull([
                        'message' => 'Le téléphone ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^(77|78|76)[0-9]{7}$/',
                        'message' => 'Le numéro de téléphone doit être au format 77XXXXXXX, 78XXXXXXX ou 76XXXXXXX.',
                    ]),
                ],
            ])
            ->add('surname', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'block w-full px-4 py-3 bg-gray-50 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none',
                    'placeholder' => 'Prénom du client',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un prénom.',
                    ]),
                ],
            ])
            ->add('adresse', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'block w-full px-4 py-3 bg-gray-50 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none',
                    'placeholder' => 'Adresse du client',
                ],
            ])
            ->add('Save', SubmitType::class, [
                'attr' => [
                    'class' => 'bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
