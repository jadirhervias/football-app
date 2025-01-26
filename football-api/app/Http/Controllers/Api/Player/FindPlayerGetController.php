<?php

namespace App\Http\Controllers\Api\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Player\Application\Find\FindPlayerRequest;
use Src\Player\Application\Find\PlayerFinder;

class FindPlayerGetController extends Controller
{
    public function __construct(private readonly PlayerFinder $finder)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function __invoke(string $id): JsonResponse
    {
        $player = $this->finder->__invoke(new FindPlayerRequest($id));

        return response()->json([
            'success' => true,
            'message' => 'Found player',
            'data' => $player->toPrimitives(),
        ]);
    }
}
