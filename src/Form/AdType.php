<?php

namespace App\Form;

use App\Entity\Advertisements;
use App\Entity\Companies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    "class"=>"form-control", 
                    "placeholder"=>"Titre de l'offre"
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    "class"=>"form-control", 
                    "placeholder"=>"Description de l'offre"
                ]
            ])
            ->add('resume', TextType::class, [
                'label' => 'Résumé',
                'attr' => [
                    "class"=>"form-control", 
                    "placeholder"=>"Résumé de l'offre"
                ]
            ])
            ->add('salary', NumberType::class, [
                'label' => 'Salaire',
                'html5' => true,
                'attr' => [
                    'min' => 0, // Définir la valeur minimale
                    'step' => 100, // Définir l'incrément
                    "class"=>"form-control", 
                    "placeholder"=>"Salaire par an"
                ]
            ])
            ->add('location', TextType::class, [
                'label' => 'Lieu',
                'attr' => [
                    "class"=>"form-control", 
                    "placeholder"=>"Lieu du travail"
                ]
            ])
            ->add('work_schedule', ChoiceType::class, [
                'label' => 'Type de travail',
                'choices' => [
                    'Stage' => 'stage',
                    'Alternance' => 'alternance',
                    'CDI' => 'cdi',
                    'CDD' => 'cdd',
                    'Freelance' => 'freelance',
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advertisements::class,
            'companies' => null, // Add this line
        ]);
    }
}
