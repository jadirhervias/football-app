<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Team\Application\Find\FindTeamRequest;
use Src\Team\Application\Find\TeamFinder;

class FindTeamGetController extends Controller
{
    public function __construct(private readonly TeamFinder $finder)
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
        $team = $this->finder->__invoke(new FindTeamRequest($id));

        return response()->json([
            'success' => true,
            'message' => 'Found team',
            'data' => $team->toPrimitives(),
        ]);
    }
}
