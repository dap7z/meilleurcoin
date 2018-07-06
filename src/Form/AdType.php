<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            /*
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('zip', null, [
                'label' => 'Code postal',
            ])
            */
            ->add('city', A3AutoCompleteType::class, [
                'label' => 'Ville',
                'search_property' => 'nom',
                'text_property' => 'nom',
                'class' => City::class,
                'primary_key' => 'id'

                //'choice_translation_domain' => true,
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
