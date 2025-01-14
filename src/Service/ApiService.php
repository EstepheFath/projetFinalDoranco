<?php
/* */
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchDataFromApi(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.example.com/data'
        );

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('API request failed with status: ' . $response->getStatusCode());
        }

        return $response->toArray(); // Décode automatiquement le JSON en tableau PHP
    }
}
