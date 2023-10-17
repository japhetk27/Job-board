<?php

namespace App\Form;

use App\Entity\People;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email address',
                'attr' => ['name' => 'email',
                'id' => "form1Example1",
                'class'=>"form-control"], // Ajouter cet attribut
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => ['name' => 'password',
                'id' => "form1Example2",
                'class'=>"form-control"], // Ajouter cet attribut
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => People::class,
        ]);
    }
}
