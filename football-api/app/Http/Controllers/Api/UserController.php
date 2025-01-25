<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $url = env('APP_URL') . '/oauth/token';
//        $url = 'http://laravel.test/oauth/token';

        $response = Http::post($url, [
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]);

        if ($response->failed()) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'User has been logged successfully.',
            'data' => $response->json(),
        ]);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => "required|string",
//            'email' => "required|string|unique:users",
//            'phone' => "required | numeric|digits:10",
            'email' => "required|string",
            'password' => "required|min:4",
            'role' => "required|in:admin,guest"
        ]);

        if ($validator->fails()) {
            $result = array(
                'status' => false,
                'message' => "Validation error occured",
                'error_message' => $validator->errors()
            );
            return response()->json($result, 400);
        }

        $user = User::query()->where('email', $request->email)->first();

        if (is_null($user)) {
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
//            'phone'=>$request->phone,
                'password'=>$request->password,
                'email_verified_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'User has been registered successfully.',
            'data' => $user,
        ], 201);
    }

    public function refreshToken(Request $request): JsonResponse
    {
        $response = Http::asForm()->post(env('APP_URL') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
            'scope' => '',
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Refreshed token.',
            'data' => $response->json(),
        ]);
    }

    public function me(Request $request): JsonResponse {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'User data retrieved successfully.',
            'data' => $user,
        ]);
    }

    public function logout(Request $request) {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.',
            ], 401);
        }

        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json([
            'success' => true,
            'statusCode' => 204,
            'message' => 'Logged out successfully.',
        ], 204);
    }

    public function passwordResetLink(Request $request)
    {
        // Validate email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Use Laravel's built-in functionality to send the reset link.
        // Generate the reset token and send the reset email
        $status = Password::sendResetLink(['email' => $request->email]);

        if ($status !== Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to send reset link.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Password reset link has been sent to your email.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        // Validate the input data
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Use Laravel's built-in password reset functionality to update password
        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();

                // Optionally, you can issue a new Passport token after password reset.
                // This step will be needed if you want users to continue to use the same token
                // or generate a new token for them after the password reset.
                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired reset token.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully.',
        ]);
    }
}
