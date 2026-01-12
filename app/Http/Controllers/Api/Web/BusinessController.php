<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Api\Admin\CustomerController;
use App\Http\Controllers\Controller;
use App\Jobs\RegistrationEmailJob;
use App\Mail\RegistrationInvoiceToCustomerMail;
use App\Models\Business;
use App\Models\BusinessCategoryDetail;
use App\Models\BusinessDetail;
use App\Models\BusinessDirectory;
use App\Models\BusinessDirectoryDetail;
use App\Models\Customer;
use App\Models\CustomerLanguage;
use App\Models\Order;
use App\Models\RegisterBusiness;
use App\Models\RegistrationPackage;
use App\Rules\MaxKeywords;
use App\Rules\ValidUrl;
use App\Rules\YoutubeUrl;
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
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class BusinessController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function show()
    {
        $data = Business::whereCustomerId(Auth::guard('customers')->user()->id)->first();
        if ($data) {
            return $this->successResponse($data, 'Business Profile has been Update successfully!');
        }
        return $this->errorResponse('Something Went Wrong!');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $languageCount = count(getAllLanguages());
        if (isset($request->is_web)) {
            $validationRule = [
                'customer_id' => ['nullable', 'exists:customers,id'],
                'contact_name' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required', 'confirmed', 'min:6'],
                'registration_package_id' => ['required'],
                // 'phone' => ['required'],
                'logo' => ['nullable'],
                'address' => ['required'],
                'website_url' => [new ValidUrl()],
                'welcome_video' => ['nullable', new YoutubeUrl()],
                'keywords' => [new MaxKeywords],
                'business_catagory_1' => ['required'],
                // 'business_catagory_2' => ['required'],
                // 'business_catagory_3' => ['required'],
                'media_section_title' => 'array',
                'media_section_title.0' => 'maxwords:10',
                'media_section_description' => 'array',
                'media_section_description.0' => 'maxwords:50',
                'business_name' => 'required|array',
                'business_name.0' => 'required',
                'description' => 'required|array',
                'description.0' => 'required|maxwords:30',
                'detail_description' => 'required|array',
                'detail_description.0' => 'required|maxwords:300',
            ];
        } else {
            $validationRule = [
                'customer_id' => ['nullable', 'exists:customers,id'],
                'contact_name' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'address' => ['required'],
                'logo' => ['nullable'],
                'website_url' => ['required', new ValidUrl()],
                'business_catagory_1' => ['required'],
                'business_catagory_2' => ['required'],
                'business_catagory_3' => ['required'],
                'business_name' => 'required|array|min:' . $languageCount,
                'business_name.*' => 'required',
                'description' => 'required|array|min:' . $languageCount,
                'description.*' => 'required',
            ];
        }
        $defaulLang = getDefaultLanguage(1);
        if ($defaulLang) {
            App::setLocale($defaulLang->abbreviation);
            $registerBusiness = RegisterBusiness::with([
                'registerBusinessDetail' => function ($q) use ($defaulLang) {
                    $q = $q->where('language_id', $defaulLang->id);
                },
            ])->first();
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'contact_name' => isset($registerBusiness->registerBusinessDetail[0]->contact_error) ? $registerBusiness->registerBusinessDetail[0]->contact_error : '',
                'email' => isset($registerBusiness->registerBusinessDetail[0]->email_error) ? $registerBusiness->registerBusinessDetail[0]->email_error : '',
                'password' => isset($registerBusiness->registerBusinessDetail[0]->password_error) ? $registerBusiness->registerBusinessDetail[0]->password_error : '',
                'confirm_password' => isset($registerBusiness->registerBusinessDetail[0]->confirm_password_error) ? $registerBusiness->registerBusinessDetail[0]->confirm_password_error : '',
                'phone' => isset($registerBusiness->registerBusinessDetail[0]->phone_error) ? $registerBusiness->registerBusinessDetail[0]->phone_error : '',
                // 'phone' => isset($registerBusiness->registerBusinessDetail[0]->phone_error) 
                // ? $registerBusiness->registerBusinessDetail[0]->phone_error 
                // : 'Phone number cannot exceed 15 digits',
                'address' => isset($registerBusiness->registerBusinessDetail[0]->address_error) ? $registerBusiness->registerBusinessDetail[0]->address_error : '',
                // 'website_url' => isset($registerBusiness->registerBusinessDetail[0]->file_error) ? $registerBusiness->registerBusinessDetail[0]->file_error : '',
                'business_catagory_1' => isset($registerBusiness->registerBusinessDetail[0]->business_category_1_error) ? $registerBusiness->registerBusinessDetail[0]->business_category_1_error : '',
                'business_catagory_2' => isset($registerBusiness->registerBusinessDetail[0]->business_category_2_error) ? $registerBusiness->registerBusinessDetail[0]->business_category_2_error : '',
                'business_catagory_3' => isset($registerBusiness->registerBusinessDetail[0]->business_category_3_error) ? $registerBusiness->registerBusinessDetail[0]->business_category_3_error : '',
                'business_name' => isset($registerBusiness->registerBusinessDetail[0]->name_error) ? $registerBusiness->registerBusinessDetail[0]->name_error : '',
                'business_name.0' => isset($registerBusiness->registerBusinessDetail[0]->name_error) ? $registerBusiness->registerBusinessDetail[0]->name_error : '',
                'description' => isset($registerBusiness->registerBusinessDetail[0]->description_error) ? $registerBusiness->registerBusinessDetail[0]->description_error : '',
                'description.0' => isset($registerBusiness->registerBusinessDetail[0]->description_error) ? $registerBusiness->registerBusinessDetail[0]->description_error : '',
                'detail_description' => isset($registerBusiness->registerBusinessDetail[0]->detail_description_error) ? $registerBusiness->registerBusinessDetail[0]->detail_description_error : '',
                'detail_description.0' => isset($registerBusiness->registerBusinessDetail[0]->detail_description_error) ? $registerBusiness->registerBusinessDetail[0]->detail_description_error : '',
            ];
        }
        $this->validate($request, $validationRule, [], $niceNames);
        if ($request->customer_id == '') {
            $package = RegistrationPackage::whereId($request->registration_package_id)->first();
            $packagePrice = 'monthly';
            $package_validity = "";
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

            $businessNames = array_filter($request->business_name);

            if (!empty($businessNames)) {
                $businessName = reset($businessNames);
                $slug = Str::slug($businessName);
            } else {
                $slug = Str::slug($request->first_name);
            }

            if ($slug) {
                $exist = Customer::where('slug', $slug)->first();
            }

            $customer = Customer::create([
                'first_name' => $request->contact_name,
                'last_name' => $request->contact_name,
                'slug' => $slug,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'registration_package_id' => $request->registration_package_id,
                'package_price' => $packagePrice,
                'free_subscription_days' => isset($package) ? $package->free_subscription_days : null,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_validity,
                'is_package_amount_paid' => $packagePrice <= 0 ? 1 : 0,
                'deactive_account' => 1,
                'is_auto_renew' => $request->is_auto_renew,
                'user_type' => 'business',
                'payment_frequency' => $request->payment_frequency
            ]);

            if ($exist) {
                $customer->slug = $slug . '-' . $customer->id;
                $customer->save();
            }

            CustomerLanguage::create([
                'customer_id' => $customer->id,
                'language_code' => $defaulLang->abbreviation,
            ]);

            $customer_id = $customer->id;

            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'type' => 'verify_email',
                'created_at' => Carbon::now()
            ]);

            $emailData = ['id' => $customer->id, 'first_name' => $request->first_name, 'last_name' => '', 'email' => $request->email, 'password' => $request->password, 'type' => 'register_customer', 'token' => $token];
            dispatch(new RegistrationEmailJob($emailData));

            if ($packagePrice <= 0) {

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
        } else {
            $customer_id = $request->customer_id;
        }

        $registrationPackage = RegistrationPackage::find($request->registration_package_id);
        $business = Business::create([
            'customer_id' => $customer_id,
            'facebook_url' => $request->facebook_url,
            'welcome_video' => $request->welcome_video,
            'keywords' => $request->keywords,
            'twitter_url' => $request->twitter_url,
            'youtube_url' => $request->youtube_url,
            'linked_url' => $request->linked_url,
            'other_social_url' => $request->other_social_url,
            'image' => isset($request->image) && is_array($request->image) ? implode(',', $request->image) : null,
            'contact_name' => $request->contact_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'website_url' => $request->website_url,
            'logo' => $request->logo,
            'business_catagory_1' => $request->business_catagory_1,
            'business_catagory_2' => $request->business_catagory_2,
            'business_catagory_3' => $request->business_catagory_3,
            'deactive_account' => 0,
            'registration_package_id' => $request->registration_package_id,
            'registration_package_duration' => $request->payment_frequency, // From customer
            'auto_renew' => $request->is_auto_renew, // From customer
            'registration_package' => $registrationPackage ? $registrationPackage->package_type : null,
        ]);
        if ($business) {
            foreach ($request->language_id as $key => $lang) {
                if (isset($request->business_name[$key])) {
                    BusinessDetail::create([
                        'business_id' => $business->id,
                        'language_id' => $lang,
                        'business_name' => $request->business_name[$key],
                        'description' => $request->description[$key],
                        'detail_description' => $request->detail_description[$key] ?? null,
                        'media_section_title' => $request->media_section_title[$key] ?? null,
                        'media_section_description' => $request->media_section_description[$key] ?? null,
                    ]);
                }
            }
        }

        $registerSuccessMessage = getGeneralTranslation()['register_user_message_text'] ? getGeneralTranslation()['register_user_message_text'] : 'Your account has been created and we have sent you a verification email. Please check it to complete your registration';
        return $this->successResponse($business, $registerSuccessMessage);
    }

    public function uploadBusinessDirectoryExcelFile(Request $request)
    {
        $image = $request->file('excel_file');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($destinationPath . '/' . $name);
        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        $firstRowKeys = $data[0];
        $directories = [];
        foreach ($data as $key => $value) {
            if ($key != 0) {
                $localData = [];
                foreach ($firstRowKeys as $i => $firstRowKey) {
                    if (isset($value[$i])) {
                        $localData[$firstRowKey] = $value[$i];
                    }
                }

                $directories[] = $localData;
            }
        }
        $defaultLang = getDefaultLanguage(1);
        foreach ($directories as $directory) {
            if (isset($directory['name'])) {
                if (!BusinessDirectoryDetail::whereName($directory['name'])->exists()) {
                    $directoryNew = BusinessDirectory::create([
                        'address' => isset($directory['address']) ? $directory['address'] : '',
                        'city' => isset($directory['city']) ? $directory['city'] : '',
                        'province' => isset($directory['province']) ? $directory['province'] : '',
                        'postal_code' => isset($directory['postal_code']) ? $directory['postal_code'] : '',
                        'fax' => isset($directory['fax']) ? $directory['fax'] : '',
                        'phone' => isset($directory['phone']) ? $directory['phone'] : '',
                        'industry' => isset($directory['industry']) ? $directory['industry'] : '',
                    ]);
                    if ($directoryNew) {
                        BusinessDirectoryDetail::create([
                            'language_id' => $defaultLang->id,
                            'business_directory_id' => $directoryNew->id,
                            'name' => isset($directory['name']) ? $directory['name'] : '',
                            'description' => isset($directory['name']) ? $directory['name'] : '',
                        ]);
                    }
                }
            }
        }
        return redirect()->back();
    }

    public function uploadExcelFileBusiness(Request $request)
    {
        $image = $request->file('excel_file');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($destinationPath . '/' . $name);
        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        $firstRowKeys = $data[0];
        $bsuinesses = [];
        foreach ($data as $key => $value) {
            if ($key != 0) {
                $localData = [];
                foreach ($firstRowKeys as $i => $firstRowKey) {
                    if (isset($value[$i])) {
                        $localData[$firstRowKey] = $value[$i];
                    }
                }

                $bsuinesses[] = $localData;
            }
        }
        // dd($bsuinesses);
        $defaultLang = getDefaultLanguage(1);
        foreach ($bsuinesses as $business) {

            if (isset($business['business_name']) && !BusinessDetail::where('business_name', $business['business_name'])->exists()) {
                $category1Id = null;
                if (isset($business['business_category_1']) && !empty($business['business_category_1'])) {
                    $category1 = BusinessCategoryDetail::where('name', 'like', '%'.$business['business_category_1'].'%')
                        ->first();
                    $category1Id = $category1 ? $category1->business_category_id : null;
                }
    
                $category2Id = null;
                if (isset($business['business_category_2']) && !empty($business['business_category_2'])) {
                    $category2 = BusinessCategoryDetail::where('name', 'like', '%'.$business['business_category_2'].'%')
                        ->first();
                    $category2Id = $category2 ? $category2->business_category_id : null;
                }
    
                $category3Id = null;
                if (isset($business['business_category_3']) && !empty($business['business_category_3'])) {
                    $category3 = BusinessCategoryDetail::where('name', 'like', '%'.$business['business_category_3'].'%')
                        ->first();
                    $category3Id = $category3 ? $category3->business_category_id : null;
                }

                $images = [];
                $i = 1;
                while (isset($business["image-{$i}"])) {
                    if (!empty($business["image-{$i}"])) {
                        $images[] = $business["image-{$i}"];
                    }
                    $i++;
                }
                $imageString = !empty($images) ? implode(',', $images) : '';

                if (!empty($business['registration_package'])) {
                    $package = RegistrationPackage::where('package_type', $business['registration_package'])
                        ->where('type', 'business')
                        ->first();
                    $registrationPackageId = $package ? $package->id : null;
                }

                $businessNew = Business::create([
                    // 'image' => isset($business['image']) ? $business['image'] : '',
                    'image' => $imageString,
                    'contact_name' => isset($business['contact_name']) ? $business['contact_name'] : '',
                    'facebook_url' => isset($business['facebook_url']) ? $business['facebook_url'] : '',
                    'twitter_url' => isset($business['twitter_url']) ? $business['twitter_url'] : '',
                    'youtube_url' => isset($business['youtube_url']) ? $business['youtube_url'] : '',
                    'linked_url' => isset($business['linkedin_url']) ? $business['linkedin_url'] : '',
                    'other_social_url' => isset($business['other_social_url']) ? $business['other_social_url'] : '',
                    'welcome_video' => isset($business['welcome_video']) ? $business['welcome_video'] : '',
                    'keywords' => isset($business['keywords']) ? $business['keywords'] : '',
                    'contact_name' => isset($business['contact_name']) ? $business['contact_name'] : '',
                    'email' => isset($business['business_email']) ? $business['business_email'] : '',
                    'phone' => isset($business['phone']) ? $business['phone'] : '',
                    'address' => isset($business['address']) ? $business['address'] : '',
                    'website_url' => isset($business['website_url']) ? $business['website_url'] : '',
                    'logo' => isset($business['logo']) ? $business['logo'] : '',
                    'registration_package_duration' => isset($business['registration_package_duration']) ? $business['registration_package_duration'] : '',
                    'registration_package' => isset($business['registration_package']) ? $business['registration_package'] : '',
                    'registration_package_id' => $registrationPackageId,
                    // 'auto_renew' => isset($business['auto_renew']) ? $business['auto_renew'] : '',
                    'auto_renew' => isset($business['auto_renew']) && strtolower($business['auto_renew']) === 'yes' ? 1 : 0,
                    'business_catagory_1' => $category1Id,
                    'business_catagory_2' => $category2Id,
                    'business_catagory_3' => $category3Id,
                    'deactive_account' => isset($directory['deactive_account']) ? $directory['deactive_account'] : 0,


                ]);
                if ($businessNew) {
                    BusinessDetail::create([
                        'language_id' => $defaultLang->id,
                        'business_name' => isset($business['business_name']) ? $business['business_name'] : '',
                        'description' => isset($business['description']) ? $business['description'] : '',
                        'detail_description' => isset($business['detail_description']) ? $business['detail_description'] : '',
                        'media_section_title' => isset($business['media_section_title']) ? $business['media_section_title'] : '',
                        'media_section_description' => isset($business['media_section_description']) ? $business['media_section_description'] : '',
                        'business_id' => $businessNew->id,
                    ]);
                }
            }
        }
        return redirect()->back();
    }



    public function sendBusinessCredentials(Request $request, $businessId)
{
    $business = Business::with(['businessDetail', 'customer'])->findOrFail($businessId);

    if (!$business->customer) {
        $registrationPackageId = null;
        $packagePrice = 0;
        $package = null;
        
        if ($business->registration_package) {
            $package = RegistrationPackage::where('package_type', $business->registration_package)
                ->where('type', 'business')
                ->first();

            if ($package) {
                $registrationPackageId = $package->id;
                
                // Calculate package price based on payment frequency
                $paymentFrequency = $business->registration_package_duration ?? 'monthly';
                
                switch ($paymentFrequency) {
                    case 'monthly':
                        $packagePrice = $package->monthly_price;
                        break;
                    case 'quarterly':
                        $packagePrice = 3 * $package->quarterly_price;
                        break;
                    case 'semi_annually':
                        $packagePrice = 6 * $package->semi_annually_price;
                        break;
                    case 'annually':
                        $packagePrice = 12 * $package->annually_price;
                        break;
                    default:
                        $packagePrice = $package->monthly_price;
                }
            }
        }

        $customerData = [
            'first_name' => $business->businessDetail->first()->business_name ?? 'business',
            'last_name' => $business->businessDetail->first()->business_name ?? 'Admin',
            'email' => $business->email,
            'password' => bcrypt(Str::random(10)),
            'user_type' => 'business',
            'slug' => Str::slug($business->businessDetail->first()->business_name ?? 'business-' . $business->id),
            'deactive_account' => 0,
            'is_package_amount_paid' => 1,
            'is_auto_renew' => $business->auto_renew ?? 0,
            'payment_frequency' => $business->registration_package_duration ?? 'monthly',
            'package_price' => $packagePrice, // Add calculated package price
        ];

        // Only add registration_package_id if we found a matching package
        if ($registrationPackageId) {
            $customerData['registration_package_id'] = $registrationPackageId;
        }

        $customer = Customer::create($customerData);

        $business->customer_id = $customer->id;
        $business->save();
    } else {
        $customer = $business->customer;

        if ($business->auto_renew !== null) {
            $customer->is_auto_renew = $business->auto_renew;
        }
        if ($business->registration_package_duration !== null) {
            $customer->payment_frequency = $business->registration_package_duration;
            
            if ($customer->registration_package_id) {
                $package = RegistrationPackage::find($customer->registration_package_id);
                
                if ($package) {
                    $paymentFrequency = $business->registration_package_duration;
                    
                    switch ($paymentFrequency) {
                        case 'monthly':
                            $customer->package_price = $package->monthly_price;
                            break;
                        case 'quarterly':
                            $customer->package_price = 3 * $package->quarterly_price;
                            break;
                        case 'semi_annually':
                            $customer->package_price = 6 * $package->semi_annually_price;
                            break;
                        case 'annually':
                            $customer->package_price = 12 * $package->annually_price;
                            break;
                    }
                }
            }
        }

        // Handle registration package update if needed
        if ($business->registration_package) {
            $package = RegistrationPackage::where('package_type', $business->registration_package)
                ->where('type', 'business')
                ->first();

            if ($package) {
                $customer->registration_package_id = $package->id;
                
                // Recalculate package price with new package
                $paymentFrequency = $customer->payment_frequency ?? 'monthly';
                
                switch ($paymentFrequency) {
                    case 'monthly':
                        $customer->package_price = $package->monthly_price;
                        break;
                    case 'quarterly':
                        $customer->package_price = 3 * $package->quarterly_price;
                        break;
                    case 'semi_annually':
                        $customer->package_price = 6 * $package->semi_annually_price;
                        break;
                    case 'annually':
                        $customer->package_price = 12 * $package->annually_price;
                        break;
                }
            }
        }

        $customer->save();
    }

    return app(CustomerController::class)->sendBusinessCredentialsEmail($request, $customer->id);
}



    



}
