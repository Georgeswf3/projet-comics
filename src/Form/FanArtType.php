<?php

namespace App\Form;

use App\Entity\Editor;
use App\Entity\FanArt;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FanArtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fan_art_title')
            ->add('fan_art_hook')
            ->add('fan_art_sketch', FileType::class, ['mapped' => false, 'required' => false])
            ->add('editor_id', EntityType::class, ['class' => Editor::class, 'choice_label' => 'editor_brand'])
            ->add('ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FanArt::class,
        ]);
    }
}
