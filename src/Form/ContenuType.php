<?php

// src/Form/ContenuType.php
namespace App\Form;

use App\Entity\Contenu;

use FOS\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categories')
            ->add('titre', TextType::class, [])
            ->add('texte', CKEditorType::class)
            ->add('save', SubmitType::class, [])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contenu::class,
        ]);
    }

    public function getName()
    {
        return 'contenuForm';
    }
}