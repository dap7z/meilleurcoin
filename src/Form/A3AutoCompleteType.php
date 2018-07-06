<?php

namespace App\Form;

use App\Form\DataTransformer\EntitiesToPropertyTransformer;
use App\Form\DataTransformer\EntityToPropertyTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\Common\Persistence\ObjectManager;



class A3AutoCompleteType extends AbstractType
{
    /** @var RouterInterface */
    protected $router;

    /** @var  ObjectManager */
    protected $em;

    public function __construct(RouterInterface $router, ObjectManager $em)
    {
        $this->router = $router;
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = $options['multiple']
            ? new EntitiesToPropertyTransformer($this->em, $options['class'], $options['text_property'], $options['primary_key'])
            : new EntityToPropertyTransformer($this->em, $options['class'], $options['text_property'], $options['primary_key'])
        ;

        $builder->addViewTransformer($transformer, true);
    }


    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        parent::finishView($view, $form, $options);

        $view->vars['class'] = $options['class'];
        $view->vars['primary_key'] = $options['primary_key'];
        $view->vars['text_property'] = $options['text_property'];
        $view->vars['search_property'] = $options['search_property'];
        $view->vars['allow_clear'] = $options['allow_clear'];
        $view->vars['placeholder'] = $options['placeholder'];
        $view->vars['multiple'] = $options['multiple'];
        $view->vars['param'] = $options['param'];
        $view->vars['route'] = $this->router->generate($options['route'],array('param' => $options['param']),RouterInterface::ABSOLUTE_PATH);

        if ($options['multiple']) {
            $view->vars['full_name'] .= '[]';
        }
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'param' => '',
            'route' => 'a3_commun_uibundle_ajax_entity',
            'primary_key' => 'id',
            'compound' => false,
            'text_property' => null,
            'multiple' => false,
            'placeholder' => '',
            'allow_clear' => true,
        ));

        $resolver->setRequired(array('class','search_property'));
    }

}