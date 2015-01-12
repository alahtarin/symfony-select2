<?php

namespace Alahtarin\Select2Bundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class Select2Transformer
 * @package Z\Bundle\ApiBundle\Form\DataTransformer
 */
class Select2ViewTransformer implements DataTransformerInterface
{
    /**
     * @var
     */
    protected $repository;

    /**
     * @var string
     */
    protected $field;

    /**
     * @param  $repository
     * @param string                 $field
     */
    public function __construct($repository, $field)
    {
        $this->repository = $repository;
        $this->field = $field;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($object)
    {
        if ($object == null || is_array($object)) {
            return null;
        }

        $getter = 'get' . ucfirst($this->field);

        return ['id' => $object->getId(), 'text' => $object->$getter()];
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($id)
    {
        if ($id == null) {
            return null;
        }

        return $this->repository->get($id);
    }
}
