<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use App\User;
use App\Jobs\SendVerificationEmail;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_token' => base64_encode($request->email)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Пользователь успешно зарегестрирован'
        ], 201);
    }
    public function verify(Request $request)
    {
        $user = User::where('email_token', $request->token)->where('verified', 0)->first();
        if ($user->email_token != null) {
            $user->verified = 1;
            $user->email_token = null;
            if ($user->save()) {
                return response()->json([
                    'message' => 'Почта успешно подтверждена'
                ], 201);
            }
        }
    }
    public function verify_from_site(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            if (empty($user))
                throw new Exception('Ошибка при подтверждении почты');
            else {
                if ($user->email_token != null) {
                    $user->verified = 1;
                    $user->email_token = null;
                    if ($user->save()) {
                        return response()->json([
                            'message' => 'Почта успешно подтверждена'
                        ], 201);
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        if ($request->email) {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ]);
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials))
                return response()->json([
                'message' => 'Ошибка входа'
            ], 401);
        } else {
            $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ]);
            $credentials = request(['name', 'password']);
            if (!Auth::attempt($credentials))
                return response()->json([
                'message' => 'Ошибка входа'
            ], 401);

        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
