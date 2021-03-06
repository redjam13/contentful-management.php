<?php

/**
 * This file is part of the contentful/contentful-management package.
 *
 * @copyright 2015-2020 Contentful GmbH
 * @license   MIT
 */

declare(strict_types=1);

namespace Contentful\Management\Resource\ContentType\Validation;

use Contentful\Management\Resource\ContentType\Validation\Nodes\EmbeddedEntryBlockValidationInterface;
use Contentful\Management\Resource\ContentType\Validation\Nodes\EmbeddedEntryInlineValidationInterface;
use Contentful\Management\Resource\ContentType\Validation\Nodes\EntryHyperlinkValidationInterface;

/**
 * LinkContentTypeValidation class.
 *
 * Takes an array of content type IDs and validates that
 * the link points to an entry of one of those content types.
 *
 * Applicable to:
 * - Link (to entries)
 */
class LinkContentTypeValidation extends AbstractCustomMessageValidation implements ValidationInterface,
    EntryHyperlinkValidationInterface,
    EmbeddedEntryBlockValidationInterface,
    EmbeddedEntryInlineValidationInterface
{
    /**
     * @var string[]
     */
    private $contentTypes = [];

    /**
     * LinkContentTypeValidation constructor.
     *
     * @param string[] $contentTypes
     */
    public function __construct(array $contentTypes = [])
    {
        $this->contentTypes = $contentTypes;
    }

    /**
     * @return string[]
     */
    public function getContentTypes(): array
    {
        return $this->contentTypes;
    }

    /**
     * @param string[] $contentTypes
     *
     * @return static
     */
    public function setContentTypes(array $contentTypes)
    {
        $this->contentTypes = $contentTypes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function getValidFieldTypes(): array
    {
        return ['Link'];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'linkContentType' => $this->contentTypes,
            ]
        );
    }
}
