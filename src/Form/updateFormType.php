<?php

namespace App\Form;

use App\Entity\Advertisements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class updateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'data' => $options['info']->getTitle(), 
                'label' => 'Titre',
                'attr' => [
                    "class"=>"form-control", 
                    "placeholder"=>"Titre de l'offre"
                ]
            ])
            ->add('description', TextareaType::class, [
                'data' => $options['info']->getDescription(),
                'label' => 'Description',
                'attr' => [
                    "class"=>"form-control", 
                    "placeholder"=>"Description de l'offre"
                ]
            ])
            ->add('resume', TextType::class, [
                'data' => $options['info']->getResume(),
                'label' => 'Résumé',
                'attr' => [
                    "class"=>"form-control", 
                    "placeholder"=>"Résumé de l'offre"
                ]
            ])
            ->add('salary', NumberType::class, [
                'data' => $options['info']->getSalary(),
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
                'data' => $options['info']->getLocation(),
                'label' => 'Lieu',
                'attr' => [
                    "class"=>"form-control", 
                    "placeholder"=>"Lieu du travail"
                ]
            ])
            ->add('work_schedule', ChoiceType::class, [
                'data' => $options['info']->getWorkSchedule(),
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
            'info' => null,
            'companies' => null, // Add this line
        ]);
    }
}
