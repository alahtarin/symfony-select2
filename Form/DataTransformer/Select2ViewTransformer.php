<?php

namespace Alahtarin\Select2Bundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @var object
     */
    protected $opts;

    /**
     * @param object $repository
     * @param object $opts
     */
    public function __construct($repository, $opts)
    {
        $this->repository = $repository;
        $this->opts = $opts;

        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function transform($object)
    {
        if ($object == null) {
            return null;
        }

        if (is_array($object)) {
            $return = [];
            foreach ($object as $item) {
                $return[] = $this->toViewData($item);
            }

            return $return;
        }

        return $this->toViewData($object);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($string)
    {
        if ($string == null) {
            return $this->opts['multiple'] ? [] : null;
        }

        if ($this->opts['multiple']) {
            $ids = explode(',', $string);
            $return = [];

            foreach ($ids as $id) {
                $return[] = $this->toNormData($id);
            }

            return $return;
        } else {
            return $this->toNormData($string);
        }
    }

    /**
     * @param object $item
     *
     * @return array
     */
    private function toViewData($item)
    {
        return [
            'id' => $this->accessor->isReadable($item, 'id')
                ? $this->accessor->getValue($item, 'id')
                : $this->accessor->getValue($item, $this->opts['field']),
            $this->opts['field'] => $this->accessor->getValue($item, $this->opts['field'])];
    }

    /**
     * @param string $id
     *
     * @return object|string
     */
    private function toNormData($id)
    {
        //try to fetch item
        if ($this->repository) {
            $item = $this->repository->get($id);
        } elseif ($this->opts['allow_add']) {
            $item = new $this->opts['class']();
            $this->accessor->setValue($item, $this->opts['field'], $id);
        }

        return $item;
    }
}
