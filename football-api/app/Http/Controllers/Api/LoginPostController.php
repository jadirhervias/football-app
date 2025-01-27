<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Src\User\Application\Find\FindUserRequest;
use Src\User\Application\Find\UserFinder;
use Symfony\Component\HttpFoundation\Response;

class LoginPostController extends Controller
{
    public function __construct(private readonly UserFinder $finder)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param LoginPostRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginPostRequest $request): JsonResponse
    {
        $url = env('APP_URL') . '/oauth/token';

        $client = DB::table('oauth_clients')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $response = Http::post($url, [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->input('email'),
            'password' => $request->input('password'),
            'scope' => '',
        ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $this->finder->__invoke(new FindUserRequest($request->input('email')));

        return response()->json([
            'success' => true,
            'message' => 'User has been logged successfully.',
            'data' => array_merge(
                $response->json(),
                ['user' => $user->toPrimitives()]
            ),
        ]);
    }
}
