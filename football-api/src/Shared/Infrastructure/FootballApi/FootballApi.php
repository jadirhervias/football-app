<?php

namespace Src\Shared\Infrastructure\FootballApi;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Src\Shared\Domain\AggregateRoot;
use Symfony\Component\HttpFoundation\Response;

abstract class FootballApi
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('FOOTBALL_API_BASE_URL');
    }

    /**
     * Define the resource name to be appended to the base URL.
     */
    abstract public function resourceName(): string;

    /**
     * Serialize the response data into a specific model.
     */
    abstract public function responseSerializer(array $data): AggregateRoot;

    /**
     * Get the full resource endpoint URL.
     */
    protected function getResourceEndpoint(): string
    {
        return $this->baseUrl . '/' . $this->resourceName();
    }

    /**
     * Get a single resource by its ID.
     */
    public function fetchOneById(string $resourceId): ?AggregateRoot
    {
        try {
            $response = Http::withHeader('X-Auth-Token', env('FOOTBALL_API_TOKEN'))
                ->get("{$this->getResourceEndpoint()}/$resourceId");

            if ($response->status() === Response::HTTP_NOT_FOUND) {
                return null;
            }

            if ($response->failed()) {
                throw new FetchApiDataFailed($response->reason());
            }

            return $this->responseSerializer($response->json());
        } catch (ConnectionException $e) {
            throw new FetchApiDataFailed($e->getMessage());
        }
    }

    /**
     * Search all resources using pagination.
     */
    public function fetchAll(int $limit, int $offset): array
    {
        try {
            $response = Http::withHeader('X-Auth-Token', env('FOOTBALL_API_TOKEN'))
                ->get($this->getResourceEndpoint(), [
                    'limit' => $limit,
                    'offset' => $offset,
                ]);

            return array_map(fn($item) => $this->responseSerializer($item), $response->json($this->resourceName()));
        } catch (ConnectionException $e) {
            throw new FetchApiDataFailed($e->getMessage());
        }
    }
}
