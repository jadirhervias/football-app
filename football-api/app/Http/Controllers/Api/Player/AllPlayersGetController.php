<?php

namespace App\Http\Controllers\Api\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Player\Application\FindAll\FindAllPlayersRequest;
use Src\Player\Application\FindAll\PlayersAllFinder;

class AllPlayersGetController extends Controller
{
    public function __construct(private readonly PlayersAllFinder $finder)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $players = $this->finder->__invoke(new FindAllPlayersRequest());

        return response()->json([
            'success' => true,
            'message' => 'Found '. count($players) .' players',
            'data' => array_map(fn($player) => $player->toPrimitives(), $players),
        ]);
    }
}
