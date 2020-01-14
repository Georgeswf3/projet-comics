<?php

namespace App\Form;

use App\Entity\FanArt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FanArtAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fan_art_title')
            ->add('fan_art_hook')
            ->add('fan_art_sketch', FileType::class, ['mapped' => false, 'required' => false])
            ->add('isConfirmed')
            ->add('ajouter', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FanArt::class,
        ]);
    }
}
