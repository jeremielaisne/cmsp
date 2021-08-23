<?php

// src/Form/ContenuType.php
namespace App\Form;

use App\Entity\Contenu;

use FOS\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('langue', TextType::class, [
                'attr' => ['class' => 'mb-5'],
                'required' => true,
                'label' => 'Choix de la langue',                   
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options)
        {
            $data = $event->getData();
            $form = $event->getForm();
            
            $options['categorie']->getChamps() ? $champs = $options['categorie']->getChamps() : $champs = null;

            if(!is_null($champs))
            {
                foreach ($champs as $champ)
                {
                    $libelle = $champ->getLibelle();

                    switch($libelle) 
                    {
                        case 'Titre':
                            $form->add('titre', TextType::class, [
                                'attr' => ['class' => 'contenu-titre mb-5'],
                                'label' => 'Titre',
                                'mapped' => false                
                            ]);
                            break;
                        case 'Sous-Titre':
                            $form->add('sous-titre', TextType::class, [
                                'attr' => ['class' => 'contenu-sous-titre mb-5'],
                                'label' => 'Sous-Titre',
                                'mapped' => false                
                            ]);
                            break;
                        case 'Texte':
                            $form->add('texte', CKEditorType::class, [
                                'attr' => ['class' => 'contenu-texte mb-5'],
                                'label' => 'Texte',
                                'mapped' => false                
                            ]);
                            break;
                        case 'Liste':
                            $form->add('liste', CKEditorType::class, [
                                'attr' => ['class' => 'contenu-liste mb-5'],
                                'label' => 'Liste',
                                'mapped' => false                
                            ]);
                            break;
                        case 'Url':
                            $form->add('url', TextType::class, [
                                'attr' => ['class' => 'contenu-url mb-5'],
                                'label' => 'Url',
                                'mapped' => false                
                            ]);
                            break;
                        case 'Illustration':
                            $form->add('illustration', FileType::class, [
                                'attr' => ['class' => 'contenu-illustration mb-5'],
                                'label' => 'Url',
                                'mapped' => false                
                            ]);
                            break;
                    }
                }
            }

            $form->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success mb-10'],
                'label' => 'Valider'               
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contenu::class,
            'categorie' => null
        ]);
    }

    public function getName()
    {
        return 'contenuForm';
    }
}