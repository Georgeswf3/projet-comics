<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author_name')
            ->add('author_first_name')
            ->add('facebook_page')
            ->add('author_image')
            ->add('creation_image')
            ->add('jobs', EntityType::class, ['class' => Job::class,
                'choice_label'=>'name',
                'multiple'=>true,
                'expanded'=>true
            ])
            ->add('ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
