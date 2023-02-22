<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
//use App\Http\Resources\UserLoginResource;
use App\Http\Resources\UserLoginResource;
use App\Libraries\Ultilities;
use App\Mail\MailResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //
    public function signUp(SignUpRequest $request, User $userModel)
    {
        $check = $userModel->getUserByEmail($request->email);
        if ($check) {
            return response()->json([
                'message' => __('api.email_existed')
            ], 422);
        }

        $newUser = $userModel->createNewUser($request);
        if (!$newUser) {
            return response()->json([
                'message' => __('api.signup_fail')
            ], 500);
        }

        return response()->json([
            'message' => __('api.signup_success'),
        ], 200);
    }

    public function logIn(Request $request, User $userModel)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:32',
        ]);

        $userData = $userModel->getUserByEmail($request->email);
        $hasher = app('hash');
        if (empty($userData) || !$hasher->check(Ultilities::clearXSS($request->password), $userData->password)) {
            return response()->json([
                'message' => __('api.login_fail')
            ], 404);
        }

        $token = $this->createToken($userData);
        return response()->json([
            'message' => __('api.login_success'),
            'token' => config("constants.TOKEN_TYPE") . $token->accessToken,
            'user_info' => new UserLoginResource($userData),
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
        ], 200);

    }

    public function createToken($user)
    {
        $tokenResult = $user->createToken(config("constants.USER_TOKEN"));
        $tokenResult->token->expires_at = Carbon::now()->addDays(90);
        $tokenResult->token->save();
        return $tokenResult;
    }

    public function sendCodeResetPass(Request $request, User $userModel)
    {
        $request->validate([
            'email' => 'required|email|max:150'
        ]);
        $userData = $userModel->getUserByEmail($request->email);
        if (empty($userData)) {
            return response()->json([
                'message' => __('api.email_not_found'),
            ], 404);
        }
        $code = mt_Rand(1000, 9999);
        $userData->updateUserCode($code);

        Mail::to($userData->email)->send(new MailResetPassword($code));
        return response()->json([
            'message' => __('api.send_mail_success'),
        ], 200);
    }

    public function verifyCode(Request $request, User $userModel)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required|email|max:150'
        ]);
        $userData = $userModel->getUserByEmail($request->email);
        $hasher = app('hash');
        if(!$hasher->check(Ultilities::clearXSS($request->code), $userData->code)) {
            return response()->json([
                'message' => __('api.check_code_fail'),
                'is_correct' => false,
            ], 205);
        }

        $timeNow = Carbon::now();;
        $timeCodeExpired = Carbon::parse($userData->sent_at)->addMinutes(10);
        if ($timeNow > $timeCodeExpired) {
            return response()->json([
                'message' => __('api.code_has_expired'),
                'is_correct' => false,
            ], 406);
        }

        return response()->json([
            'message' => __('api.check_code_success'),
            'is_correct' => true,
        ], 200);
    }

    public function resetPassword(Request $request, User $userModel)
    {
        $request->validate([
            'email' => 'required|email|max:150',
            'password' => 'required|min:6|max:32',
        ]);

        $data = [
            'password' => bcrypt(Ultilities::clearXSS($request->password))
        ];
        $userData = $userModel->getUserByEmail($request->email);
        $userData->update($data);
        return response()->json([
            'message' => __('api.reset_password_success'),
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => __('api.logout.success'),
        ], 200);
    }
}
