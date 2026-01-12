<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ForgetPasswordEmailJob;
use App\Models\Customer;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showForgetPasswordForm()
    {
        $forgetPassowrdTranslations = getStaticTranslation('forget_password');
        return view('auth.user-forgot-password', compact('forgetPassowrdTranslations'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        $emailData = ['email' => $request->email, 'token' => $token];
        dispatch(new ForgetPasswordEmailJob($emailData));

        $forgetPassowrdTranslations = getStaticTranslation('forget_password');

        session()->flash('success', isset($forgetPassowrdTranslations['forget_password_success_message_text']) ? $forgetPassowrdTranslations['forget_password_success_message_text'] : '');
        return back();

        // return back()->with('message', 'We have e-mailed your password reset link!');
        // return response()->json(['message' => 'We have e-mailed your password reset link!']);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($lang,$token)
    {
        // dd($token);
        $forgetPassowrdTranslations = getStaticTranslation('forget_password');
        return view('auth.forgetPasswordLink', ['lang'=>$lang,'token' => $token, 'forgetPassowrdTranslations' => $forgetPassowrdTranslations]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        $updatePassword = DB::table('password_resets')
        ->where('email', $request->email)
        ->first();
        if (!$updatePassword) {
            return back()
                ->withInput()
                ->with('error', 'Invalid token!');
        }
        $user = Customer::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')
            ->where(['email' => $request->email])
            ->delete();

            // return redirect('/' . $request->lang . '/login')->with('success', 'Your password has been changed!');
            return back()->with('show_success_popup', true);
    }
   
   
}
