<?php

declare(strict_types=1);

namespace Liberu\AccountingSdk;

final class CrudResource
{
    public function __construct(private Client $client, private string $path) {}

    /** @return array<string, mixed> */
    public function list(array $query = []): array
    {
        return $this->client->request('GET', $this->path, ['query' => $query]);
    }

    /** @return array<string, mixed> */
    public function get(int|string $id): array
    {
        return $this->client->request('GET', $this->path.'/'.$id);
    }

    /** @param array<string, mixed> $data @return array<string, mixed> */
    public function create(array $data): array
    {
        return $this->client->request('POST', $this->path, ['json' => $data]);
    }

    /** @param array<string, mixed> $data @return array<string, mixed> */
    public function update(int|string $id, array $data): array
    {
        return $this->client->request('PUT', $this->path.'/'.$id, ['json' => $data]);
    }

    /** @return array<string, mixed> */
    public function delete(int|string $id): array
    {
        return $this->client->request('DELETE', $this->path.'/'.$id);
    }
}
