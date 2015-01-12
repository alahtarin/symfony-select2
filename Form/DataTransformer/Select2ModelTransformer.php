<?php

namespace Alahtarin\Select2Bundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Z\Bundle\ApiBundle\Repository\RemoteObjectRepository;

/**
 * Class Select2Transformer
 *
 * @package Alahtarin\Select2Bundle\Form\DataTransformer
 */
class Select2ModelTransformer implements DataTransformerInterface
{
    /**
     * @var RemoteObjectRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $field;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function transform($object)
    {
        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($object)
    {
        return $object;
    }
}
