<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class UserPasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.user-forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $existsInCustomers = DB::table('customers')->where('email', $value)->exists();
                    $existsInBusinesses = DB::table('businesses')->where('email', $value)->exists();
                    $existsInUsers = DB::table('users')->where('email', $value)->exists();
        
                    if (!$existsInCustomers && !$existsInBusinesses  && !$existsInUsers) {
                        $fail(trans('validation.exists'));
                    }
                },
            ],
        ]);
        $status = Password::broker('customers')->sendResetLink(
            $request->only('email')
        );
        if ($status !== Password::RESET_LINK_SENT) {
            $status = Password::broker('users')->sendResetLink(
                $request->only('email')
            );
        }

        // return $status === Password::RESET_LINK_SENT
        //     ? back()->with(['status' => __($status)])
        //     : back()->withErrors(['email' => __($status)]);
        $forgetSuccessMsg = getStaticTranslation('forget_password')['forget_password_success_message_text'];

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['status' => 'success', 'message' => $forgetSuccessMsg]);
        } else {
           back()->withErrors(['email' => __($status)]);
            // return response()->json(['status' => 'error', 'message' => __('We could not find a user with that email address.')]);
        }
    }
}
