<?php

/**
 * This file is part of the contentful/contentful-management package.
 *
 * @copyright 2015-2020 Contentful GmbH
 * @license   MIT
 */

declare(strict_types=1);

namespace Contentful\Management\Resource\ContentType\Validation;

use Contentful\Management\Resource\ContentType\Validation\Nodes\AssetHyperlinkValidationInterface;
use Contentful\Management\Resource\ContentType\Validation\Nodes\EmbeddedAssetBlockValidationInterface;
use Contentful\Management\Resource\ContentType\Validation\Nodes\EmbeddedEntryBlockValidationInterface;
use Contentful\Management\Resource\ContentType\Validation\Nodes\EmbeddedEntryInlineValidationInterface;
use Contentful\Management\Resource\ContentType\Validation\Nodes\EntryHyperlinkValidationInterface;

/**
 * SizeValidation class.
 *
 * Takes optional min and max parameters and
 * validates the size of an array or a string.
 *
 * Applicable to:
 * - Array
 * - Symbol
 * - Text
 */
class SizeValidation extends AbstractCustomMessageValidation implements ValidationInterface,
    AssetHyperlinkValidationInterface,
    EmbeddedAssetBlockValidationInterface,
    EmbeddedEntryBlockValidationInterface,
    EmbeddedEntryInlineValidationInterface,
    EntryHyperlinkValidationInterface
{
    /**
     * @var int|null
     */
    private $min;

    /**
     * @var int|null
     */
    private $max;

    /**
     * SizeValidation constructor.
     *
     * @param int|null $min
     * @param int|null $max
     */
    public function __construct($min = null, $max = null)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @return int|null
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return static
     */
    public function setMin(int $min = null)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return static
     */
    public function setMax(int $max = null)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function getValidFieldTypes(): array
    {
        return ['Array', 'Text', 'Symbol'];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        $data = [];
        if (null !== $this->min) {
            $data['min'] = $this->min;
        }
        if (null !== $this->max) {
            $data['max'] = $this->max;
        }

        return array_merge(
            parent::jsonSerialize(),
            [
                'size' => $data,
            ]
        );
    }
}
