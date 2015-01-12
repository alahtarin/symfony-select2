<?php

namespace Alahtarin\Select2Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Alahtarin\Select2Bundle\Form\DataTransformer\Select2ModelTransformer;
use Alahtarin\Select2Bundle\Form\DataTransformer\Select2ViewTransformer;

/**
* Class Select2Type
 *
 * Adds support for select2 input.
 *
 */
class Select2Type extends AbstractType
{
    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $modelTransformer = new Select2ModelTransformer();
        $viewTransformer = new Select2ViewTransformer($options['repository'], $options['field']);

        $builder->addModelTransformer($modelTransformer);
        $builder->addViewTransformer($viewTransformer);
    }

    /**
     * {@inheritdoc}
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, [
            'field' => $options['field'],
            'url' => $options['url']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
            'repository' => null,
            'field' => 'label',
            'url' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'select2';
    }
}
