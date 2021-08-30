<?php

// src/Form/CategorieType.php
namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Champ;
use App\Entity\Zone;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'attr' => ['class' => 'page-input'],
                'required' => true,
                'label' => 'Libellé',                   
            ])
            ->add('description', TextAreaType::class, [
                'attr' => ['class' => 'libelle-input'],
                'required' => false,
                'label' => 'Description',                   
            ])
            ->add('champs', EntityType::class, [
                'attr' => ['class' => 'select2-enable'],
                'class' => Champ::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.id', 'ASC');
                },
                'multiple' => true
            ])
            ->add('zone', EntityType::class, [
                'class' => Zone::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('z')
                        ->orderBy('z.id', 'ASC')
                        ->andWhere('z.active = 1');
                }
            ])
            // ->add('order', IntegerType::class, [
            //     'attr' => ['class' => 'page-input'],
            //     'label' => 'Ordre',                   
            // ])
            
            
            ->add('save', SubmitType::class, [
                "attr" => ["class" => "btn btn-success fs-7 p-3 m-1"]
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class
        ]);
    }

    public function getName()
    {
        return 'categorieForm';
    }
}