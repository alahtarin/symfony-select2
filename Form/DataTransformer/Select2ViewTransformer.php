<?php

namespace Alahtarin\Select2Bundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

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
     * @var boolean
     */
    protected $multiple;

    /**
     * @param object  $repository
     * @param string  $field
     * @param boolean $multiple
     */
    public function __construct($repository, $field, $multiple)
    {
        $this->repository = $repository;
        $this->field = $field;
        $this->multiple = $multiple;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($object)
    {
        if ($object == null) {
            return null;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        if (is_array($object)) {
            $return = [];
            foreach ($object as $item) {
                $return[] = [
                    'id' => $accessor->getValue($item, 'id'),
                    $this->field => $accessor->getValue($item, $this->field)];
            }

            return $return;
        }

        return [
            'id' => $accessor->getValue($object, 'id'),
            $this->field => $accessor->getValue($object, $this->field)
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($string)
    {
        if ($string == null) {
            return null;
        }

        if ($this->multiple) {
            $ids = explode(',', $string);
            $return = [];

            foreach ($ids as $id) {
                $return[] = $this->repository->get($id);
            }

            return $return;
        } else {
            return $this->repository->get($string);
        }
    }
}
