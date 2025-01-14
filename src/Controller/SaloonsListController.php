<?php
/* */
namespace App\Controller;

use App\Service\ChatRoomService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SaloonsListController extends AbstractController
{
private HttpClientInterface $httpClient;

public function __construct(HttpClientInterface $httpClient)
{
$this->httpClient = $httpClient;
}

private function fetchMatchesFromApi(): array
{
$apiKey = $this->getParameter('API_KEY');
$response = $this->httpClient->request(
'GET',
"https://apiv2.allsportsapi.com/basketball/?met=Livescore&APIkey=$apiKey",
['timeout' => 30]
);

$data = $response->toArray();
return $data['result'] ?? [];
}

#[Route('/saloons/list', name: 'app_saloons_list')]
public function index(ChatRoomService $chatRoomService): Response
{
$matches = $this->fetchMatchesFromApi();

foreach ($matches as $match) {
$matchId = $match['event_key'];
$chatRoomService->getOrCreateChatRoom($matchId);
}

return $this->render('saloons_list/index.html.twig', [
'matches' => $matches,
]);
}

#[Route('/sync-saloons', name: 'sync_saloons')]
public function syncMatchesFromApi(ChatRoomService $chatRoomService): JsonResponse
{
$matches = $this->fetchMatchesFromApi();

foreach ($matches as $match) {
$matchId = $match['event_key'];
$chatRoomService->getOrCreateChatRoom($matchId);
}

return new JsonResponse(['status' => 'Chat rooms synchronized']);
}
}
