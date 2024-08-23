<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(UserRequest $request)
    {
        $status = Password::sendResetLink($request->only('email'));

        return new UserResource(
            ['status' => $status == Password::RESET_LINK_SENT ? 200 : 500],
            'sendResetLinkEmail'
        );
    }

    public function resetPassword(UserRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return new UserResource(
            ['status' => $status == Password::PASSWORD_RESET ? 200 : 500],
            'resetPassword'
        );
    }
}
