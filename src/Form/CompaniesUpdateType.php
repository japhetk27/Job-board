<?php 
namespace App\Form;

use App\Entity\Companies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CompaniesUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'attr' => ["placeholder"=>"Entrez le nom de l'entreprise"]
            ])
            ->add('industry', TextType::class, [
                'label' => 'Secteur d\'activité',
                'attr' => ["placeholder"=>"Entrez le secteur d'activité"]
            ])
            ->add('location', TextType::class, [
                'label' => 'Localisation',
                'attr' => ["placeholder"=>"Entrez la localisation"]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => ["placeholder"=>"Entrez votre mot de passe"]
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ["class"=>"btn btn-primary"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Companies::class,
            'user' => null,
        ]);
    }
}
