<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\RegistrationPackageResource;
use App\Models\Customer;
use App\Models\RegistrationPackage;
use App\Models\RegistrationPackageDetail;
use App\Models\RegistrationPackageFeature;
use App\Rules\CheckCategorySlug;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegistrationPackageController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $registrationPackages = RegistrationPackage::query();

        $registrationPackages = $this->whereClause($registrationPackages);
        $registrationPackages = $this->loadRelations($registrationPackages);
        $registrationPackages = $this->sortingAndLimit($registrationPackages);

        return $this->apiSuccessResponse(RegistrationPackageResource::collection($registrationPackages), 'Data Get Successfully!');
    }

    public function show(RegistrationPackage $registrationPackage)
    {
        if (isset($_GET['withRegistrationPackageDetail']) && $_GET['withRegistrationPackageDetail'] == '1') {
            $registrationPackage = $registrationPackage->loadMissing('registrationPackageDetail');
        }
        if (isset($_GET['withRegistrationPackageFeature']) && $_GET['withRegistrationPackageFeature'] == '1') {
            $registrationPackage = $registrationPackage->loadMissing('registrationPackageFeature');
        }

        return $this->apiSuccessResponse(new RegistrationPackageResource($registrationPackage), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.required' => 'Short description in ' . $language->name . ' is required.']);
        }
        $validationRule = array_merge($validationRule, ['type' => ['required', 'in:school,business,student']]);
        $validationRule = array_merge($validationRule, ['package_type' => ['required', 'in:free,featured,premium']]);
        $validationRule = array_merge($validationRule, ['is_default' => ['boolean']]);
        $validationRule = array_merge($validationRule, ['events' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        $validationRule = array_merge($validationRule, ['images' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        $validationRule = array_merge($validationRule, ['ambassadors' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        $validationRule = array_merge($validationRule, ['webinars' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        $validationRule = array_merge($validationRule, ['articles' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);

        if (isset($request->package_type) && in_array($request->package_type, ['featured', 'premium'])) {
            $validationRule = array_merge($validationRule, ['monthly_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
            $validationRule = array_merge($validationRule, ['quarterly_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
            $validationRule = array_merge($validationRule, ['semi_annually_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
            $validationRule = array_merge($validationRule, ['annually_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        }

        $this->validate($request, $validationRule, $errorMessages);

        // $registrationPackage = RegistrationPackage::where('type', $request->type)
        //     ->where('package_type', $request->package_type)
        //     ->exists();
        // if ($registrationPackage) {
        //     return $this->errorResponse('Package has been already created.');
        // }

        $registrationPackage = RegistrationPackage::create([
            'type' => $request->type,
            'package_type' => $request->package_type,
            // 'sorting_order' => 0,
            'is_default' => $request->is_default,
            'events' => $request->events,
            'images' => $request->images,
            'ambassadors' => $request->ambassadors,
            'webinars' => $request->webinars,
            'articles' => $request->articles,
            'monthly_price' => isset($request->monthly_price) ? $request->monthly_price : 0,
            'quarterly_price' => isset($request->quarterly_price) ? $request->quarterly_price : 0,
            'semi_annually_price' => isset($request->semi_annually_price) ? $request->semi_annually_price : 0,
            'annually_price' => isset($request->annually_price) ? $request->annually_price : 0,
        ]);
        $packageName = null;
        foreach ($languages as $language) {
            if ($language->is_default == '1') {
                $packageName = $request['name']['name_' . $language->id];
            }
            RegistrationPackageDetail::create([
                'registration_package_id' => $registrationPackage->id,
                'language_id' => $language->id,
                'name' => $request['name']['name_' . $language->id] ?? null,
                'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
            ]);

            $features = isset($request['features']['features_' . $language->id]) ? $request['features']['features_' . $language->id] : null;
            if ($features) {
                foreach ($features as $key => $feature) {
                    RegistrationPackageFeature::create([
                        'registration_package_id' => $registrationPackage->id,
                        'language_id' => $language->id,
                        'name' => $feature,
                    ]);
                }
            }
        }

        if ($registrationPackage) {
            if (in_array($request->package_type, ['featured', 'premium'])) {
                $stripeService = new StripeService();
                $stripeService->createPrices($request, $packageName, $registrationPackage);

                $paypal = new PaypalService();
                $token = $paypal->paypalToken();
                $paypalService = new PaypalService();
                $paypalService->createPlan($request, $packageName, $registrationPackage);
            }

            if ($request->is_default == true) {
                $this->removeDefaultPackage($registrationPackage, $request->type);
            }
            return $this->apiSuccessResponse(new RegistrationPackageResource($registrationPackage), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, RegistrationPackage $registrationPackage)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $registrationPackage->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.required' => 'Short description in ' . $language->name . ' is required.']);
        }
        $validationRule = array_merge($validationRule, ['type' => ['required', 'in:school,business,student']]);
        $validationRule = array_merge($validationRule, ['package_type' => ['required', 'in:free,featured,premium']]);
        $validationRule = array_merge($validationRule, ['is_default' => ['boolean']]);
        $validationRule = array_merge($validationRule, ['events' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        $validationRule = array_merge($validationRule, ['images' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        $validationRule = array_merge($validationRule, ['ambassadors' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        $validationRule = array_merge($validationRule, ['webinars' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        $validationRule = array_merge($validationRule, ['articles' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);

        if (isset($request->package_type) && in_array($request->package_type, ['featured', 'premium'])) {
            $validationRule = array_merge($validationRule, ['monthly_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
            $validationRule = array_merge($validationRule, ['quarterly_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
            $validationRule = array_merge($validationRule, ['semi_annually_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
            $validationRule = array_merge($validationRule, ['annually_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        }

        $this->validate($request, $validationRule, $errorMessages);

        DB::beginTransaction();
        try {
            $isRegistrationPackageExist = RegistrationPackage::where('type', $request->type)
                ->where('package_type', $request->package_type)
                ->where('id', '!=', $registrationPackage->id)
                ->exists();
            if ($isRegistrationPackageExist) {
                return $this->errorResponse('Package has been already created.');
            }

            $old_monthly_price = $registrationPackage->monthly_price;
            $old_quarterly_price = $registrationPackage->quarterly_price;
            $old_semi_annually_price = $registrationPackage->semi_annually_price;
            $old_annually_price = $registrationPackage->annually_price;

            if (isset($request->package_type) && in_array($request->package_type, ['free'])) {
                $request['monthly_price'] = 0;
                $request['quarterly_price'] = 0;
                $request['semi_annually_price'] = 0;
                $request['annually_price'] = 0;
            }

            $registrationPackage->update([
                'type' => $request->type,
                'package_type' => $request->package_type,
                'sorting_order' => 0,
                'is_default' => $request->is_default,
                'events' => $request->events,
                'images' => $request->images,
                'ambassadors' => $request->ambassadors,
                'webinars' => $request->webinars,
                'articles' => $request->articles,
                'monthly_price' => isset($request->monthly_price) ? $request->monthly_price : 0,
                'quarterly_price' => isset($request->quarterly_price) ? $request->quarterly_price : 0,
                'semi_annually_price' => isset($request->semi_annually_price) ? $request->semi_annually_price : 0,
                'annually_price' => isset($request->annually_price) ? $request->annually_price : 0,
            ]);
            $packageName = null;

            RegistrationPackageFeature::whereRegistrationPackageId($registrationPackage->id)->delete();

            foreach ($languages as $language) {
                if ($language->is_default == '1') {
                    $packageName = $request['name']['name_' . $language->id];
                }
                $registrationPackageDetail = RegistrationPackageDetail::whereLanguageId($language->id)
                    ->whereRegistrationPackageId($registrationPackage->id)
                    ->exists();
                if ($registrationPackageDetail) {
                    RegistrationPackageDetail::whereLanguageId($language->id)
                        ->whereRegistrationPackageId($registrationPackage->id)
                        ->update([
                            'name' => $request['name']['name_' . $language->id] ?? null,
                            'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                        ]);
                } else {
                    RegistrationPackageDetail::create([
                        'registration_package_id' => $registrationPackage->id,
                        'language_id' => $language->id,
                        'name' => $request['name']['name_' . $language->id] ?? null,
                        'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                    ]);
                }

                $features = isset($request['features']['features_' . $language->id]) ? $request['features']['features_' . $language->id] : null;
                if ($features) {
                    foreach ($features as $key => $feature) {
                        RegistrationPackageFeature::create([
                            'registration_package_id' => $registrationPackage->id,
                            'language_id' => $language->id,
                            'name' => $feature,
                        ]);
                    }
                }
            }

            if ($registrationPackage) {
                if (in_array($request->package_type, ['featured', 'premium'])) {
                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                    $stripeService = new StripeService();

                    $new_monthly_price = $request->monthly_price;
                    if (isset($registrationPackage->stripe_monthly_id)) {
                        if ($old_monthly_price != $new_monthly_price) {
                            $stripe->prices->update($registrationPackage->stripe_monthly_id, ['active' => false]);
                            $stripeService->createMonthlyStripePrices($request, $packageName, $registrationPackage);
                        }
                    } else {
                        $stripeService->createMonthlyStripePrices($request, $packageName, $registrationPackage);
                    }

                    $new_quarterly_price = $request->quarterly_price;
                    if (isset($registrationPackage->stripe_quarterly_id)) {
                        if ($old_quarterly_price != $new_quarterly_price) {
                            $stripe->prices->update($registrationPackage->stripe_quarterly_id, ['active' => false]);
                            $stripeService->createQuarterlyStripePrices($request, $packageName, $registrationPackage);
                        }
                    } else {
                        $stripeService->createQuarterlyStripePrices($request, $packageName, $registrationPackage);
                    }

                    $new_semi_annually_price = $request->semi_annually_price;
                    if (isset($registrationPackage->stripe_semi_annually_id)) {
                        if ($old_semi_annually_price != $new_semi_annually_price) {
                            $stripe->prices->update($registrationPackage->stripe_semi_annually_id, ['active' => false]);
                            $stripeService->createSemiAnnuallyStripePrices($request, $packageName, $registrationPackage);
                        }
                    } else {
                        $stripeService->createSemiAnnuallyStripePrices($request, $packageName, $registrationPackage);
                    }

                    $new_annually_price = $request->annually_price;
                    if (isset($registrationPackage->stripe_annually_id)) {
                        if ($old_annually_price != $new_annually_price) {
                            $stripe->prices->update($registrationPackage->stripe_annually_id, ['active' => false]);
                            $stripeService->createAnnuallyStripePrices($request, $packageName, $registrationPackage);
                        }
                    } else {
                        $stripeService->createAnnuallyStripePrices($request, $packageName, $registrationPackage);
                    }

                    if ($new_monthly_price > 0) {
                        $paypalService = new PaypalService();
                        if (isset($registrationPackage->paypal_auto_renew_monthly_id) && !empty($registrationPackage->paypal_auto_renew_monthly_id)) {
                            if ($old_monthly_price <= 0) {
                                $paypalService->createPayPalMonthly($request, $packageName, $registrationPackage);
                            } elseif ($old_monthly_price != $new_monthly_price) {
                                $paypalService->deavtivePlan($registrationPackage->paypal_auto_renew_monthly_id);

                                $paypalService->deavtivePlan($registrationPackage->paypal_non_auto_renew_monthly_id);

                                $paypalService->createPayPalMonthly($request, $packageName, $registrationPackage);
                            }
                        } elseif (!isset($registrationPackage->paypal_auto_renew_monthly_id) || empty($registrationPackage->paypal_auto_renew_monthly_id)) {
                            $paypalService->createPayPalMonthly($request, $packageName, $registrationPackage);
                        }
                    }

                    if ($new_quarterly_price > 0) {
                        $paypalService = new PaypalService();
                        if (isset($registrationPackage->paypal_auto_renew_quarterly_id) && !empty($registrationPackage->paypal_auto_renew_quarterly_id)) {
                            if ($old_quarterly_price <= 0) {
                                $paypalService->createPayPalQuarterly($request, $packageName, $registrationPackage);
                            } elseif ($old_quarterly_price != $new_quarterly_price) {
                                $paypalService->deavtivePlan($registrationPackage->paypal_auto_renew_quarterly_id);

                                $paypalService->deavtivePlan($registrationPackage->paypal_non_auto_renew_quarterly_id);

                                $paypalService->createPayPalQuarterly($request, $packageName, $registrationPackage);
                            }
                        } elseif (!isset($registrationPackage->paypal_auto_renew_quarterly_id) || empty($registrationPackage->paypal_auto_renew_quarterly_id)) {
                            $paypalService->createPayPalQuarterly($request, $packageName, $registrationPackage);
                        }
                    }

                    if ($new_semi_annually_price > 0) {
                        $paypalService = new PaypalService();
                        if (isset($registrationPackage->paypal_auto_renew_semi_annually_id) && !empty($registrationPackage->paypal_auto_renew_semi_annually_id)) {
                            if ($old_semi_annually_price <= 0) {
                                $paypalService->createPayPalSemiAnnually($request, $packageName, $registrationPackage);
                            } elseif ($old_semi_annually_price != $new_semi_annually_price) {
                                $paypalService->deavtivePlan($registrationPackage->paypal_auto_renew_semi_annually_id);

                                $paypalService->deavtivePlan($registrationPackage->paypal_non_auto_renew_semi_annually_id);

                                $paypalService->createPayPalSemiAnnually($request, $packageName, $registrationPackage);
                            }
                        } elseif (!isset($registrationPackage->paypal_auto_renew_semi_annually_id) || empty($registrationPackage->paypal_auto_renew_semi_annually_id)) {
                            $paypalService->createPayPalSemiAnnually($request, $packageName, $registrationPackage);
                        }
                    }

                    if ($new_annually_price > 0) {
                        $paypalService = new PaypalService();
                        if (isset($registrationPackage->paypal_auto_renew_annually_id) && !empty($registrationPackage->paypal_auto_renew_annually_id)) {
                            if ($old_annually_price <= 0) {
                                $paypalService->createPayPalAnnually($request, $packageName, $registrationPackage);
                            } elseif ($old_annually_price != $new_annually_price) {
                                $paypalService->deavtivePlan($registrationPackage->paypal_auto_renew_annually_id);

                                $paypalService->deavtivePlan($registrationPackage->paypal_non_auto_renew_annually_id);

                                $paypalService->createPayPalAnnually($request, $packageName, $registrationPackage);
                            }
                        } elseif (!isset($registrationPackage->paypal_auto_renew_annually_id) || empty($registrationPackage->paypal_auto_renew_annually_id)) {
                            $paypalService->createPayPalAnnually($request, $packageName, $registrationPackage);
                        }
                    }
                } elseif (in_array($request->package_type, ['free'])) {
                    $registrationPackage->update([
                        'stripe_monthly_id' => null,
                        'stripe_quarterly_id' => null,
                        'stripe_semi_annually_id' => null,
                        'stripe_annually_id' => null,
                        'paypal_auto_renew_monthly_id' => null,
                        'paypal_auto_renew_quarterly_id' => null,
                        'paypal_auto_renew_semi_annually_id' => null,
                        'paypal_auto_renew_annually_id' => null,
                        'paypal_non_auto_renew_monthly_id' => null,
                        'paypal_non_auto_renew_quarterly_id' => null,
                        'paypal_non_auto_renew_semi_annually_id' => null,
                        'paypal_non_auto_renew_annually_id' => null,
                    ]);
                }

                if ($request->is_default == true) {
                    $this->removeDefaultPackage($registrationPackage, $request->type);
                }
                DB::commit();
                return $this->apiSuccessResponse(new RegistrationPackageResource($registrationPackage), 'Your changes have been done successfully');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, RegistrationPackage $registrationPackage)
    {
        $customerExists = Customer::whereRegistrationPackageId($registrationPackage->id)->exists();
        if ($customerExists) {
            return $this->errorResponse('Sorry, you can not delete this because its already used in customer.');
        }
        if ($registrationPackage->registrationPackageDetail()->delete() && $registrationPackage->delete()) {
            return $this->apiSuccessResponse(new RegistrationPackageResource($registrationPackage), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function removeDefaultPackage($registrationPackage, $type)
    {
        RegistrationPackage::where('id', '!=', $registrationPackage->id)
            ->where('type', $type)
            ->update([
                'is_default' => 0,
            ]);
    }

    protected function loadRelations($registrationPackages)
    {
        $defaultLang = getDefaultLanguage(0);
        $registrationPackages = $registrationPackages->with([
            'registrationPackageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withRegistrationPackageDetail']) && $_GET['withRegistrationPackageDetail'] == '1') {
            $registrationPackages = $registrationPackages->with('registrationPackageDetail');
        }
        if (isset($_GET['withRegistrationPackageFeature']) && $_GET['withRegistrationPackageFeature'] == '1') {
            $registrationPackages = $registrationPackages->with('registrationPackageFeature');
        }
        if (isset($_GET['getPackagesOnly']) && $_GET['getPackagesOnly'] == '1') {
            return $registrationPackages->whereIn('package_type', ['free', 'featured', 'premium']);
        }
        return $registrationPackages;
    }

    protected function sortingAndLimit($registrationPackages)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'price', 'free_subscription_days', 'package_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $registrationPackages = $registrationPackages->addSelect(['package_name' => RegistrationPackageDetail::whereColumn('registration_packages.id', 'registration_package_detail.registration_package_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);


            $registrationPackages = $registrationPackages->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $registrationPackages->get();
        }

        return $registrationPackages->paginate($limit);
    }

    protected function whereClause($registrationPackages)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $registrationPackages = $registrationPackages->whereHas('registrationPackageDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $registrationPackages;
    }
}
