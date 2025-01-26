<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Src\Shared\Domain\Utils;
use Src\User\Application\Create\CreateUserRequest;
use Src\User\Application\Create\UserCreator;

class RegisterPostController extends Controller
{
    public function __construct(private readonly UserCreator $creator)
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
        $user = $this->creator->__invoke(new CreateUserRequest(
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
