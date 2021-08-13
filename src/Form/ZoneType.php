<?php

// src/Form/ZoneType.php
namespace App\Form;

use App\Entity\Zone;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoneType extends AbstractType
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('page', TextType::class, [
                'attr' => ['class' => 'page-input'],
                'required' => true,
                'label' => 'Page',                   
            ])
            ->add('libelle', TextType::class, [
                'attr' => ['class' => 'libelle-input'],
                'required' => false,
                'label' => 'Libellé',                   
            ])
            ->add('url', TextType::class, [
                'attr' => ['class' => 'url-input'],
                'required' => false,
                'label' => 'Url',                   
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $createdAt = new DateTime();

                $form = $event->getForm();
                $form->add('created_at', HiddenType::class, ['data' => $createdAt]);
            })
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                // TO DO : Vérifier les doublons
            })
            
            ->add('save', SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zone::class
        ]);
    }

    public function getName()
    {
        return 'zoneForm';
    }
}