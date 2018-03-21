<?php

/**
 * This file is part of the contentful-management.php package.
 *
 * @copyright 2015-2018 Contentful GmbH
 * @license   MIT
 */
declare(strict_types=1);

namespace Contentful\Management\Resource;

use Contentful\Core\Api\DateTimeImmutable;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * WebhookCall class.
 *
 * This class represents a resource with type "WebhookCallOverview" in Contentful.
 *
 * @see https://www.contentful.com/developers/docs/references/content-management-api/#/reference/webhook-calls/webhook-call-overview
 */
class WebhookCall extends BaseResource
{
    /**
     * @var Request|null
     */
    protected $request;

    /**
     * @var Response|null
     */
    protected $response;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string|null
     */
    protected $error;

    /**
     * @var string
     */
    protected $eventType;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var DateTimeImmutable
     */
    protected $requestAt;

    /**
     * @var DateTimeImmutable
     */
    protected $responseAt;

    /**
     * WebhookCallOverview constructor.
     */
    final private function __construct()
    {
    }

    /**
     * Returns an array to be used by "json_encode" to serialize objects of this class.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'sys' => $this->sys,
            'request' => [
                'url' => (string) $this->request->getUri(),
                'method' => $this->request->getMethod(),
                'headers' => $this->formatPsr7Headers($this->request->getHeaders()),
                'body' => (string) $this->request->getBody(),
            ],
            'response' => [
                'url' => (string) $this->request->getUri(),
                'statusCode' => $this->response->getStatusCode(),
                'headers' => $this->formatPsr7Headers($this->response->getHeaders()),
                'body' => (string) $this->response->getBody(),
            ],
            'statusCode' => $this->statusCode,
            'errors' => $this->error ? [$this->error] : [],
            'eventType' => $this->eventType,
            'url' => $this->url,
            'requestAt' => (string) $this->requestAt,
            'responseAt' => (string) $this->responseAt,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function asUriParameters(): array
    {
        return [
            'space' => $this->sys->getSpace()->getId(),
            'webhook' => $this->sys->getCreatedBy()->getId(),
            'call' => $this->sys->getId(),
        ];
    }

    /**
     * PSR-7 Headers can contain multiple values for every key.
     * We simplify management by only defining one.
     *
     * @param array $headers
     *
     * @return \stdClass
     */
    private function formatPsr7Headers(array $headers): \stdClass
    {
        $returnHeaders = [];
        foreach ($headers as $key => $values) {
            // The request object automatically adds a `Host` header, which we don't need
            if ('Host' === $key) {
                continue;
            }

            $returnHeaders[$key] = $values[0];
        }

        return (object) $returnHeaders;
    }

    /**
     * {@inheritdoc}
     */
    public function asRequestBody()
    {
        throw new \LogicException(\sprintf(
            'Trying to convert object of class "%s" to a request body format, but operation is not supported on this class.',
            static::class
        ));
    }

    /**
     * @return Request|null
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getRequestAt(): DateTimeImmutable
    {
        return $this->requestAt;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getResponseAt(): DateTimeImmutable
    {
        return $this->responseAt;
    }
}
