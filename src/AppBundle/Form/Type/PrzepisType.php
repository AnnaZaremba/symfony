<?php
namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PrzepisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('nazwa', TextType::class)
            ->add('skladniki', TextareaType::class)
            ->add('wykonanie', TextareaType::class)
            ->add('zrodlo', TextType::class)
            ->add('uwagi', TextType::class)
            ->add('kategorie', EntityType::class, [
                'class' => 'AppBundle:Kategoria',
                'choice_label' => 'nazwa',
                'multiple' => true,
                'expanded' => true,
            ]);
    }
}