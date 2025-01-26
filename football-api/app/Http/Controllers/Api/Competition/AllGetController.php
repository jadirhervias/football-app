<?php

namespace App\Http\Controllers\Api\Competition;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Competition\Application\FindAll\FindAllCompetitionRequest;
use Src\Competition\Application\FindAll\CompetitionAllFinder;

class AllGetController extends Controller
{
    public function __construct(private readonly CompetitionAllFinder $finder)
    {
    }

//    /**
//     * Handle the incoming request.
//     *
//     * @param LoginPostRequest $request
//     * @return JsonResponse
//     */
    public function __invoke(
//        LoginPostRequest $request
    ): JsonResponse
    {
        $competitions = $this->finder->__invoke(new FindAllCompetitionRequest());

        return response()->json([
            'success' => true,
            'message' => 'Found '. count($competitions) .' competitions',
            'data' => array_map(fn($competition) => $competition->toPrimitives(), $competitions),
        ]);
    }
}
