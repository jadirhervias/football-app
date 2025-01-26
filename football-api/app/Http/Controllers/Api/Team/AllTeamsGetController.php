<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Team\Application\FindAll\FindAllTeamsRequest;
use Src\Team\Application\FindAll\TeamsAllFinder;

class AllTeamsGetController extends Controller
{
    public function __construct(private readonly TeamsAllFinder $finder)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $teams = $this->finder->__invoke(new FindAllTeamsRequest());

        return response()->json([
            'success' => true,
            'message' => 'Found '. count($teams) .' teams',
            'data' => array_map(fn($team) => $team->toPrimitives(), $teams),
        ]);
    }
}
