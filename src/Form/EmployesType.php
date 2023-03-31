<?php

namespace App\Form;

use App\Entity\Employes;
use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class EmployesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('sexe')
            ->add('adresse')
            ->add('dateNaissance',DateType::class,[
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'html5' => false,
                'attr' => [
                    'class' => 'my-custom-class']])
            ->add('NumServ',EntityType::class,[
                'expanded' => true,
                'class'    => Service::class,
                'multiple' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('S')
                        ->orderBy('S.designationServ', 'ASC');
                },
                'choice_label'=>'designationServ' // meme role de l'ajoute dde la fonction toString
                //,'attr'     =>[
                //   'class'=>'select2'
                //]
            ])
            ->add('photo', FileType::class, [
                'label' => 'Votre image de profil (Des fichies images uniquement)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image',
                    ])
                ],
            ])
            ->add('save',type:SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employes::class,
        ]);
    }
}
