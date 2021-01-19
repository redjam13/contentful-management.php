<?php

/**
 * This file is part of the contentful/contentful-management package.
 *
 * @copyright 2015-2020 Contentful GmbH
 * @license   MIT
 */

declare(strict_types=1);

namespace Contentful\Management\Mapper;

use Contentful\Core\ResourceBuilder\MapperInterface;
use Contentful\Core\ResourceBuilder\ObjectHydrator;
use Contentful\Management\Resource\ContentType\Validation\AbstractCustomMessageValidation;
use Contentful\Management\Resource\ContentType\Validation\ValidationInterface;
use Contentful\Management\ResourceBuilder;

/**
 * BaseMapper class.
 */
abstract class BaseMapper implements MapperInterface
{
    /**
     * @var ResourceBuilder
     */
    protected $builder;

    /**
     * @var ObjectHydrator
     */
    protected $hydrator;

    /**
     * BaseMapper constructor.
     */
    public function __construct(ResourceBuilder $builder)
    {
        $this->builder = $builder;
        $this->hydrator = new ObjectHydrator();
    }

    protected function mapValidation(array $data): ?ValidationInterface
    {
        if (empty(array_values($data)[0])) {
            return null;
        }

        $fqcn = '\\Contentful\\Management\\Mapper\\ContentType\\Validation\\'.\ucfirst(\array_keys($data)[0]).'Validation';

        /** @var ValidationInterface $validation */
        $validation = $this->builder->getMapper($fqcn)
            ->map(null, $data);

        if ($validation instanceof AbstractCustomMessageValidation && isset($data['message'])) {
            $validation->setMessage($data['message']);
        }

        return $validation;
    }
}
