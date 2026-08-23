<?php

declare(strict_types=1);

namespace Liberu\AccountingSdk;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use Liberu\AccountingSdk\Exception\ApiException;
use Liberu\AccountingSdk\Exception\ForbiddenException;
use Liberu\AccountingSdk\Exception\RateLimitException;
use Liberu\AccountingSdk\Exception\UnauthorizedException;
use Liberu\AccountingSdk\Exception\ValidationException;
use Psr\Http\Client\ClientInterface;

final class Client
{
    private ClientInterface $http;

    public function __construct(private string $baseUrl, private string $token, ?HandlerStack $handler = null)
    {
        $this->http = new HttpClient(['handler' => $handler, 'http_errors' => false]);
    }

    /** @param array<string, mixed> $options @return array<string, mixed> */
    public function request(string $method, string $path, array $options = []): array
    {
        $options['headers'] = array_merge([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->token,
        ], $options['headers'] ?? []);
        $response = $this->http->request($method, rtrim($this->baseUrl, '/').'/api/v1/'.ltrim($path, '/'), $options);
        $body = json_decode((string) $response->getBody(), true);
        $body = is_array($body) ? $body : [];
        $status = $response->getStatusCode();
        if ($status >= 200 && $status < 300) return $body;
        $message = (string) ($body['message'] ?? 'Accounting API request failed');
        if ($status === 401) throw new UnauthorizedException($message, 401);
        if ($status === 403) throw new ForbiddenException($message, 403);
        if ($status === 422) throw new ValidationException($message, is_array($body['errors'] ?? null) ? $body['errors'] : []);
        if ($status === 429) throw new RateLimitException($message, (int) $response->getHeaderLine('Retry-After'));
        throw new ApiException($message, $status);
    }

    public function invoices(): CrudResource { return new CrudResource($this, 'invoices'); }
    public function chartOfAccounts(): CrudResource { return new CrudResource($this, 'chart-of-accounts'); }
    public function generalLedger(): GeneralLedgerResource { return new GeneralLedgerResource($this); }
}
