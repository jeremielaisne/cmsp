<?php

// src/Form/ContenuType.php
namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Contenu;
use App\Enum\ContenuEnum;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContenuType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
       $this->em = $em; 
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('langue', ChoiceType::class, [
                'attr' => ['class' => 'mb-5'],
                'required' => true,
                'label' => 'Choix de la langue',
                'choices' => [
                    'Français' => "FR",
                    'Anglais' => "EN",
                    'Allemand' => "ALL",
                    'Espagnol' => "ES",
                    'Italien' => "IT",
                    'Non déterminé' => "OT"
                ],
                'data' => $options['data']->getLangue()    
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options)
        {
            $data = $event->getData();
            $form = $event->getForm();
            
            $options['categorie']->getChamps() ? $champs = $options['categorie']->getChamps() : $champs = null;
            $edit_contenu = json_decode($options['data']->getContenu());

            if(!is_null($champs))
            {
                foreach ($champs as $champ)
                {
                    $champ_id = $champ->getId();

                    switch($champ_id) 
                    {
                        case ContenuEnum::Titre:
                            $titre = null;
                            empty($edit_contenu->{'titre'}) ?: $titre = $edit_contenu->{'titre'};
                            $form->add('titre', TextType::class, [
                                'attr' => ['class' => 'contenu-titre mb-5'],
                                'label' => 'Titre',
                                'required' => false,
                                'mapped' => false,
                                'data' => $titre     
                            ]);
                            break;
                        case ContenuEnum::SousTitre:
                            $sous_titre = null;
                            empty($edit_contenu->{'sous-titre'}) ?: $sous_titre = $edit_contenu->{'sous-titre'};
                            $form->add('sous-titre', TextType::class, [
                                'attr' => ['class' => 'contenu-sous-titre mb-5'],
                                'label' => 'Sous-Titre',
                                'required' => false,
                                'mapped' => false,
                                'data' => $sous_titre          
                            ]);
                            break;
                        case ContenuEnum::Texte:
                            $texte = null;
                            empty($edit_contenu->{'texte'}) ?: $texte = $edit_contenu->{'texte'};
                            $form->add('texte', CKEditorType::class, [
                                'attr' => ['class' => 'contenu-texte mb-5'],
                                'label' => 'Texte',
                                'required' => false,
                                'mapped' => false,
                                'data' => $texte          
                            ]);
                            break;
                        case ContenuEnum::Url:
                            $url = null;
                            empty($edit_contenu->{'url'}) ?: $url = $edit_contenu->{'url'};
                            $form->add('url', TextType::class, [
                                'attr' => ['class' => 'contenu-url mb-5'],
                                'label' => 'Url',
                                'required' => false,
                                'mapped' => false,
                                'data' => $url             
                            ]);
                            break;
                        case ContenuEnum::Illustration:
                            //$illustration = null;
                            //empty($edit_contenu->{'illustration'}) ?: $illustration = $edit_contenu->{'illustration'};
                            $form->add('illustration', FileType::class, [
                                'attr' => ['class' => 'contenu-illustration mb-5'],
                                'label' => 'Illustration',
                                'required' => false,
                                'mapped' => false
                                //'data' => $illustration               
                            ]);
                            break;
                    }
                }
            }

            // $form->add('order', IntegerType::class, [
            //     'attr' => ['class' => 'page-input'],
            //     'label' => 'Ordre',                   
            // ]);
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {

            $data = $event->getData();
            $form = $event->getForm();

            $options['categorie']->getChamps() ? $champs = $options['categorie']->getChamps() : $champs = null;
            $categorie = $this->em->getRepository(Categorie::class)->find($options['categorie']->getId());

            if (is_null($options['data']->getId())){
                $contenu = new Contenu();
            } else {
                $contenu = $this->em->getRepository(Contenu::class)->find($options['data']->getId());
            }
            
            $contenu->setLangue($data->getLangue());
            $contenu->setCategorie($categorie);
            $contenu->setCreatedAt(new DateTime());
            $contenu->setCreatedBy("1");

            $contenu_json = array();
            $type = array();

            if(!is_null($champs))
            {
                foreach ($champs as $champ)
                {
                    $libelle = strtolower($champ->getLibelle());

                    $contenu_data = $form->get($libelle)->getData();
                    $contenu_json[$libelle] = $contenu_data;

                    array_push($type, $libelle);
                }

                $contenu->setType($type);
                $contenu->setContenu(json_encode($contenu_json));

                $this->em->persist($contenu);
                $this->em->flush();
            }
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