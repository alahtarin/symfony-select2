<?php

namespace Alahtarin\Select2Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\InvalidArgumentException;
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
        if ($options['url'] != null && $options['list_data'] != null) {
            throw new InvalidArgumentException('Parameters data and url can not be specified both');
        }

        $modelTransformer = new Select2ModelTransformer();
        $viewTransformer = new Select2ViewTransformer($options['repository'], $options);

        $builder->addModelTransformer($modelTransformer);
        $builder->addViewTransformer($viewTransformer);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, [
            'field' => $options['field'],
            'url' => $options['url'],
            'list_data' => $options['list_data'],
            'multiple' => $options['multiple'],
            'allow_add' => $options['allow_add'],
            'dropdown_class' => $options['dropdown_class'],
            'placeholder' => $options['placeholder'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound'          => false,
            'repository'        => null,
            'field'             => 'label',
            'url'               => null,
            'list_data'         => null,
            'multiple'          => false,
            'allow_add'         => false,
            'class'             => null,
            'dropdown_class'    => false,
            'placeholder'       => 'select an option'
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
