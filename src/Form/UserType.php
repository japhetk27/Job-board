<?php 
namespace App\Form;

use App\Entity\People;
use App\Entity\Companies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', TextType::class, [
                'label' => 'Prénom',
                'attr' => ["placeholder"=>"Entrez votre prénom"]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de famille',
                'attr' => ["placeholder"=>"Entrez votre nom de famille"]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'attr' => ["placeholder"=>"Entrez votre email"]
            ])
            ->add('phone_number', TextType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => ["placeholder"=>"Entrez votre téléphone"]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => ["placeholder"=>"Entrez votre mot de passe"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => People::class,
            'companies' => null, // Add this line
        ]);
    }
}
