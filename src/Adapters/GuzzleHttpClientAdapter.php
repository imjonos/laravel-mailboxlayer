<?php

namespace Nos\Mailboxlayer\Adapters;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleRetry\GuzzleRetryMiddleware;
use Nos\Mailboxlayer\Interfaces\Adapters\HttpClientAdapterInterface;

final class GuzzleHttpClientAdapter implements HttpClientAdapterInterface
{
    private GuzzleHttpClient $guzzleHttpClient;

    public function __construct()
    {
        $apiKey = config('mailboxlayer.api_key');
        $maxRetryAttempts = (int) config('mailboxlayer.max_retry_attempts');
        $stack = HandlerStack::create();
        $stack->push(
            GuzzleRetryMiddleware::factory([
                'max_retry_attempts' => $maxRetryAttempts
            ])
        );

        $params = [
            'handler' => $stack,
            'headers' => [
                'Content-Type' => 'text/plain',
                'apikey' => $apiKey
            ]
        ];

        $this->guzzleHttpClient = new GuzzleHttpClient($params);
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $url, array $params = []): array
    {
        $response = $this->guzzleHttpClient->get($url, $params);

        return json_decode((string) $response->getBody(), true);
    }
}
