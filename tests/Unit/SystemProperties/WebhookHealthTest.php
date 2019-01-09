<?php

/**
 * This file is part of the contentful/contentful-management package.
 *
 * @copyright 2015-2019 Contentful GmbH
 * @license   MIT
 */

declare(strict_types=1);

namespace Contentful\Tests\Delivery\Unit\SystemProperties;

use Contentful\Management\SystemProperties\WebhookHealth;
use Contentful\Tests\Management\BaseTestCase;

class WebhookHealthTest extends BaseTestCase
{
    public function testAll()
    {
        $fixture = $this->getParsedFixture('serialize.json');
        $sys = new WebhookHealth($fixture);

        $this->assertJsonStructuresAreEqual($fixture, $sys);
    }
}
