<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Jobs\RegistrationEmailJob;
use App\Mail\RegistrationInvoiceToCustomerMail;
use App\Models\Business;
use App\Models\Customer;
use App\Models\CustomerBusinessCategory;
use App\Models\CustomerLanguage;
use App\Models\CustomerMedia;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use App\Models\LoginPageSetting;
use App\Models\Order;
use App\Models\Page;
use App\Models\RegistrationPackage;
use App\Models\School;
use App\Models\SchoolAmbassador;
use App\Models\SchoolDetail;
use App\Models\SchoolRequestSetting;
use App\Services\FomSubmissionCountService;
use App\Services\PDFService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SignupController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function signup(Request $request)
    {
        $request['business_categories_id'] = json_decode($request->business_categories_id);
        $validationRule = [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\Customer,email'],
            // 'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
            'password' => ['required', 'confirmed'],
            'registration_package_id' => ['required'],
        ];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            if ($request->user_type == 'school') {
                $regPageSetting = getRegPageSetting();
                $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
                $registerSchool = SchoolRequestSetting::with([
                    'schoolRequestSettingDetail' => function ($q) use ($defaultLang) {
                        $q = $q->where('language_id', $defaultLang->id);
                    },
                ])->first();
                $niceNames = [
                    'first_name' => isset($registerSchool->schoolRequestSettingDetail[0]->name_error) ? $registerSchool->schoolRequestSettingDetail[0]->name_error : '',
                    'last_name' => isset($registerSchool->schoolRequestSettingDetail[0]->description_error) ? $registerSchool->schoolRequestSettingDetail[0]->description_error : '',
                    'email' => isset($registerSchool->schoolRequestSettingDetail[0]->email_error) ? $registerSchool->schoolRequestSettingDetail[0]->email_error : '',
                    'password' => isset($registerSchool->schoolRequestSettingDetail[0]->phone_error) ? $registerSchool->schoolRequestSettingDetail[0]->phone_error : '',
                    'confirm_password' => isset($registerSchool->schoolRequestSettingDetail[0]->time_error) ? $registerSchool->schoolRequestSettingDetail[0]->time_error : '',
                ];
            } else {
                $regPageSetting = getRegPageSetting();
                $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
                $niceNames = [
                    'first_name' => isset($regPageSettingDetail[0]->reg_first_name_error) ? $regPageSettingDetail[0]->reg_first_name_error : '',
                    'last_name' => isset($regPageSettingDetail[0]->reg_last_name_error) ? $regPageSettingDetail[0]->reg_last_name_error : '',
                    'email' => isset($regPageSettingDetail[0]->reg_email_error) ? $regPageSettingDetail[0]->reg_email_error : '',
                    'password' => isset($regPageSettingDetail[0]->reg_passowrd_error) ? $regPageSettingDetail[0]->reg_passowrd_error : '',
                    'confirm_password' => isset($regPageSettingDetail[0]->reg_confirm_passowrd_error) ? $regPageSettingDetail[0]->reg_confirm_passowrd_error : '',
                ];
            }
        }
        $this->validate($request, $validationRule, [], $niceNames);
        $formSubmissionService = new FomSubmissionCountService();
        $result = $formSubmissionService->advertiserForm();
        if ($result['status'] == 'Error') {
            return $result;
        }

        $packagePrice = 'monthly';
        $package_validity = "";
        if ($request->user_type == 'student') {
            $package = RegistrationPackage::where('type', 'student')->where('package_type', 'free')->first();
            if ($request->payment_frequency == 'monthly') {
                $packagePrice = $package->monthly_price;
                $package_validity = date('Y-m-d', strtotime('+1 months'));
                $packageValidity = '1 month';
            } else if ($request->payment_frequency == 'quarterly') {
                $packagePrice = 3 * $package->quarterly_price;
                $package_validity = date('Y-m-d', strtotime('+3 months'));
                $packageValidity = '3 months';
            } else if ($request->payment_frequency == 'semi_annually') {
                $packagePrice = 6 * $package->semi_annually_price;
                $package_validity = date('Y-m-d', strtotime('+6 months'));
                $packageValidity = '6 months';
            } else if ($request->payment_frequency == 'annually') {
                $packagePrice = 12 * $package->annually_price;
                $package_validity = date('Y-m-d', strtotime('+12 months'));
                $packageValidity = '12 months';
            }
        } else {
            $package = RegistrationPackage::whereId($request->registration_package_id)->first();
            if ($request->payment_frequency == 'monthly') {
                $packagePrice = $package->monthly_price;
                $package_validity = date('Y-m-d', strtotime('+1 months'));
                $packageValidity = '1 month';
            } else if ($request->payment_frequency == 'quarterly') {
                $packagePrice = 3 * $package->quarterly_price;
                $package_validity = date('Y-m-d', strtotime('+3 months'));
                $packageValidity = '3 months';
            } else if ($request->payment_frequency == 'semi_annually') {
                $packagePrice = 6 * $package->semi_annually_price;
                $package_validity = date('Y-m-d', strtotime('+6 months'));
                $packageValidity = '6 months';
            } else if ($request->payment_frequency == 'annually') {
                $packagePrice = 12 * $package->annually_price;
                $package_validity = date('Y-m-d', strtotime('+12 months'));
                $packageValidity = '12 months';
            }
        }

        if ($request->user_type == 'school') {
            $slug = Str::slug($request->first_name);
        } else {
            $slug = Str::slug($request->first_name . ' ' . $request->last_name);
        }

        if ($slug) {
            $exist = Customer::where('slug', $slug)->first();
        }

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'slug' => $slug,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'registration_package_id' => $package->id ?? null,
            'package_price' => $packagePrice,
            'free_subscription_days' => isset($package) ? $package->free_subscription_days : null,
            'package_subscribed_date' => date('Y-m-d'),
            'package_expiry_date' => $package_validity,
            'is_package_amount_paid' => $packagePrice <= 0 ? 1 : 0,
            'deactive_account' => 1,
            'is_auto_renew' => $request->is_auto_renew,
            'user_type' => $request->user_type,
            'payment_frequency' => $request->payment_frequency
        ]);

        if ($exist) {
            $customer->slug = $slug . '-' . $customer->id;
            $customer->save();
        }

        CustomerLanguage::create([
            'customer_id' => $customer->id,
            'language_code' => $defaultLang->abbreviation,
        ]);
        // Auth::guard('customers')->login($customer);

        if ($customer && $customer->user_type == 'school') {
            $school = School::create([
                'customer_id' => $customer->id,
                'email' => $request->email,
                'deactive_account' => 0,
            ]);
            if ($school) {
                SchoolDetail::create([
                    'school_id' => $school->id,
                    'language_code' => $defaultLang->abbreviation,
                    'school_name' => $request->first_name,
                ]);
            }
        }

        $page = Page::with([
            'pageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])
            ->where('template', 'login_template')
            ->first();

        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'type' => 'verify_email',
            'created_at' => Carbon::now()
        ]);

        $emailData = ['id' => $customer->id, 'first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'password' => $request->password, 'type' => 'register_customer', 'token' => $token];
        dispatch(new RegistrationEmailJob($emailData));

        if ($request->user_type !== 'student' && $packagePrice <= 0) {

            $order = Order::create([
                'registration_package_id' => $package->id,
                'customer_id' => $customer->id,
                'type' => 'profile',
            ]);
            $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
            $order->update([
                'invoice_no' => $invoiceNo
            ]);

            $customer = $customer->loadMissing('customerProfile');

            $data = ['package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $packagePrice, 'payment_frequency' => $request->payment_frequency, 'package_validity' => $packageValidity, 'customer' => $customer, 'order' => $order, 'package_expiry_date' => $package_validity];

            $PDFService = new PDFService();

            $PDFService->createRegistrationInvoicePDF(null, $data);

            Mail::to($request->email)->send(new RegistrationInvoiceToCustomerMail($data));
        }

        $data['redirect_url'] = route('front.page', ['lang' => $defaultLang['abbreviation'], 'slug' => '']);

        $registerSuccessMessage = getGeneralTranslation()['register_user_message_text'] ? getGeneralTranslation()['register_user_message_text'] : 'Your account has been created and we have sent you a verification email. Please check it to complete your registration';
        return $this->successResponse($data, $registerSuccessMessage);
    }

    public function emailVerify($lang, $token, $email)
    {
        $defaultLang = getDefaultLanguage(1);

        $result = DB::table('password_resets')->where('token', $token)->where('type', 'verify_email')->first();
        $user = Customer::where('email', $email)->first();

        if (!$result) {
            Session::flash('message', 'This email verification token is invalid');
            Session::flash('status', 'success');
            $redirect_url = langBasedURL(null, route('front.page', $defaultLang->abbreviation));
            return Redirect::to($redirect_url);
        }

        $userUpdate = Customer::where('email', $result->email)->update([
            'email_verified_at' => Carbon::now(),
            'deactive_account' => '0'
        ]);

        if ($userUpdate) {
            if ($user->user_type == 'business') {
                $business = Business::where('customer_id', $user->id)->first();
                if ($business) {
                    Business::where('customer_id', $user->id)->update([
                        'deactive_account' => '0'
                    ]);
                }
            }

            DB::table('password_resets')->where('token', $token)->delete();

            $verificationSuccessMessage = getGeneralTranslation()['verification_email_message_text'] ? getGeneralTranslation()['verification_email_message_text'] : 'Thank you. Your registration is now complete';

            if ($user->package_price > 0) {
                Auth::guard('customers')->login($user);
                $redirect_url = langBasedURL(null, route('web.payment.index', $defaultLang->abbreviation));
            } else {
                Session::flash('message', $verificationSuccessMessage ?? 'Thank you. Your registration is now complete');
                Session::flash('status', 'success');

                if ($user->user_type == 'business') {
                    $business = Business::where('customer_id', $user->id)->first();
                    if ($business) {
                        $emailData = ['id' => $business->id, 'email' => $business->email, 'type' => 'register_business'];
                        dispatch(new RegistrationEmailJob($emailData));
                    }
                } else {
                    $emailData = ['id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->email, 'password' => $user->password, 'type' => 'email_verified', 'token' => $token];
                    dispatch(new RegistrationEmailJob($emailData));
                }

                if ($user->user_type == 'school') {
                    Auth::guard('customers')->login($user);
                    $redirect_url = route('web.account.school.information', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]);
                } else {
                    $redirect_url = langBasedURL(null, route('front.page', $defaultLang->abbreviation));
                }
            }
            return Redirect::to($redirect_url);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard('customers')->check()) {
            Auth::guard('customers')->logout();
        }
        if (Auth::guard('school_ambassadors')->check()) {
            Auth::guard('school_ambassadors')->logout();
        }
        // return redirect()->route('front.page', ['lang' => getDefaultLanguage(1)['abbreviation'], 'slug' => '']);
        return redirect()->to($request->logout_last_page . '?' . http_build_query([
            'lang' => getDefaultLanguage(1)['abbreviation'],
            'slug' => ''
        ]));
    }

    public function login(Request $request)
    {
        // $request->validate(['email' => 'required|email|exists:customers']);

        // $sql = Customer::where('email', $request->email)
        //     ->exists();
        //     Validator::extend('exist', function ($attribute, $value, $parameters, $validator) {
        //         return Customer::where('email', $value)->exists();
        //     });

        $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $existsInCustomers = DB::table('customers')->where('email', $value)->exists();
                    $existsInBusinesses = DB::table('school_ambassadors')->where('email', $value)->exists();

                    if (!$existsInCustomers && !$existsInBusinesses) {
                        $fail(trans('validation.exists'));
                    }
                },
            ],
        ]);
        // if (!$sql) {
        //     return $this->errorResponseForLogin('email.exist');

        //     return;
        // }


        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            // $defaultLang = getDefaultLanguage(1);
            $loginPageSetting = LoginPageSetting::with([
                'loginPageSettingDetail' => function ($q) use ($defaultLang) {
                    $q = $q->where('language_id', $defaultLang->id);
                },
            ])->first();
            $niceNames = [
                'email.required' => isset($loginPageSetting->loginPageSettingDetail[0]->login_email_error) ? $loginPageSetting->loginPageSettingDetail[0]->login_email_error : '',
                'email.email' => isset($loginPageSetting->loginPageSettingDetail[0]->email_format_error_text) ? $loginPageSetting->loginPageSettingDetail[0]->email_format_error_text : '',
                'password' => isset($loginPageSetting->loginPageSettingDetail[0]->login_passowrd_error) ? $loginPageSetting->loginPageSettingDetail[0]->login_passowrd_error : '',
            ];
        }
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ],
            [],
            $niceNames,
        );
        $defaultLang = getDefaultLanguage(1);
        // Check if the email exists
        // $customer = Customer::where('email', $request->email)->first();

        // // If email doesn't exist, return custom error message
        // if (!$customer) {
        //     return $this->errorResponse('We cannot find this email in our records. Make sure it is not misspelled, and is written in the correct email format: name@email.com');
        // }
        if (Auth::guard('customers')->attempt($credentials)) {
            $request->session()->regenerate();
            $sql = Customer::where('deactive_account', 0)
                ->whereId(Auth::guard('customers')->id())
                ->first();
            if (!$sql) {
                Auth::guard('customers')->logout();
                return $this->errorResponse('The account is deactivated.');
            }
            // $data['redirect_url'] = route('front.page', ['lang' => $defaultLang['abbreviation'], 'slug' => '']);
            // $data['redirect_url'] = url()->previous() ?: route('front.page', ['lang' => $defaultLang['abbreviation'], 'slug' => '']);

            $redirectUrl = $request->input('redirect_url') ?: route('front.page', ['lang' => $defaultLang['abbreviation'], 'slug' => '']);

            $data['redirect_url'] = $redirectUrl;
            // dd($data);
            return $this->successResponse($data, 'You are Logged in successfully');
        } else {
            if (Auth::guard('school_ambassadors')->attempt($credentials)) {
                $data['redirect_url'] = route('web.ambassador.chat', ['lang' => $defaultLang['abbreviation']]);
                return $this->successResponse($data, 'You are Logged in successfully');
            }
        }
        // return $this->errorResponse('The provided credentials do not match our records.');
        return $this->errorResponseForLogin('');
    }
}
