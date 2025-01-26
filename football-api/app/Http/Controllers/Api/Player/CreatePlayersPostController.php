<?php

namespace App\Http\Controllers\Api\Player;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Src\Shared\Domain\Utils;
use Src\User\Application\Create\CreatTeamRequest;
use Src\User\Application\Create\TeamCreator;

class CreatePlayersPostController extends Controller
{
    public function __construct(private readonly TeamCreator $creator)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param RegisterPostRequest $request
     * @return JsonResponse
     */
    public function __invoke(RegisterPostRequest $request): JsonResponse
    {
        $user = $this->creator->__invoke(new CreatTeamRequest(
            $request->input('name'),
            $request->input('email'),
            $request->enum('role', Roles::class),
            Hash::make($request->input('password')),
        ));

        return response()->json([
            'success' => true,
            'message' => 'User has been registered successfully.',
            'data' => Utils::omitKeys($user->toPrimitives(), ['permissions']),
        ], JsonResponse::HTTP_CREATED);
    }
}
