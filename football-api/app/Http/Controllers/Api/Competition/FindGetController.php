<?php

namespace App\Http\Controllers\Api\Competition;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Competition\Application\Find\FindCompetitionRequest;
use Src\Competition\Application\Find\CompetitionFinder;

class FindGetController extends Controller
{
    public function __construct(private readonly CompetitionFinder $finder)
    {
    }

//    /**
//     * Handle the incoming request.
//     *
//     * @param LoginPostRequest $request
//     * @return JsonResponse
//     */
    public function __invoke(
        string $id
//        LoginPostRequest $request
    ): JsonResponse
    {
        $competition = $this->finder->__invoke(new FindCompetitionRequest($id));

        return response()->json([
            'success' => true,
            'message' => 'Competition found',
            'data' => $competition->toPrimitives(),
        ]);
    }
}
