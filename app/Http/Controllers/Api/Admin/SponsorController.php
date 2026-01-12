<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SponsorResource;
use Illuminate\Support\Str;
use App\Models\Sponsor;
use App\Models\SponsorDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Rules\ValidUrl;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $sponsors = Sponsor::query();

        $sponsors = $this->whereClause($sponsors);
        $sponsors = $this->loadRelations($sponsors);
        $sponsors = $this->sortingAndLimit($sponsors);

        return $this->apiSuccessResponse(SponsorResource::collection($sponsors), 'Data Get Successfully!');
    }


    public function show(Sponsor $Sponsor)
    {
        if (isset($_GET['withSponsorDetail']) && $_GET['withSponsorDetail'] == '1') {
            $Sponsor = $Sponsor->loadMissing('sponsorDetail');
        }

        return $this->apiSuccessResponse(new SponsorResource($Sponsor), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        // dd($request->all());

        $validationRule = [];
        $errorMessages = [];
        $niceNames = [];
        $isWeb = isset($request->is_web) && $request->is_web == 1;
        $languages = getAllLanguages();
        if ($isWeb) {
            $sponsorPageTrans = getStaticTranslation('become_sponsor_page');
        }
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['subsidiary.subsidiary_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['keywords.keywords_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['contact_person_name.contact_person_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:30']]);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.required' => 'Short description is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'maxwords:300']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);            
            $validationRule = array_merge($validationRule, ['service1_name.service1_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service1_url.service1_url_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service2_name.service2_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service2_url.service2_url_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service3_name.service3_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service3_url.service3_url_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service4_name.service4_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service4_url.service4_url_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service5_name.service5_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service5_url.service5_url_' . $language->id => ['nullable', 'string']]);

            if ($isWeb) {
                $niceNames['title.title_' . $language->id] = $sponsorPageTrans['business_name_error'] ?? '';
                $niceNames['subsidiary.subsidiary_' . $language->id] = $sponsorPageTrans['subsidiary_error'] ?? '';
                $niceNames['keywords.keywords_' . $language->id] = $sponsorPageTrans['keywords_error'] ?? '';
                $niceNames['contact_person_name.contact_person_name_' . $language->id] = $sponsorPageTrans['contact_person_name_error'] ?? '';
                $niceNames['short_description.short_description_' . $language->id] = $sponsorPageTrans['short_description_error'] ?? '';
                $niceNames['description.description_' . $language->id] = $sponsorPageTrans['description_error'] ?? '';
                $niceNames['service1_name.service1_name_' . $language->id] = $sponsorPageTrans['service_1_name_error'] ?? '';
                $niceNames['service1_url.service1_url_' . $language->id] = $sponsorPageTrans['service_1_url_error'] ?? '';
                $niceNames['service2_name.service2_name_' . $language->id] = $sponsorPageTrans['service_2_name_error'] ?? '';
                $niceNames['service2_url.service2_url_' . $language->id] = $sponsorPageTrans['service_2_url_error'] ?? '';
                $niceNames['service3_name.service3_name_' . $language->id] = $sponsorPageTrans['service_3_name_error'] ?? '';
                $niceNames['service3_url.service3_url_' . $language->id] = $sponsorPageTrans['service_3_url_error'] ?? '';
                $niceNames['service4_name.service4_name_' . $language->id] = $sponsorPageTrans['service_4_name_error'] ?? '';
                $niceNames['service4_url.service4_url_' . $language->id] = $sponsorPageTrans['service_4_url_error'] ?? '';
                $niceNames['service5_name.service5_name_' . $language->id] = $sponsorPageTrans['service_5_name_error'] ?? '';
                $niceNames['service5_url.service5_url_' . $language->id] = $sponsorPageTrans['service_5_url_error'] ?? '';
            } else {
                $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Business name is required']);

                $niceNames['short_description.short_description_' . $language->id] = 'short description';
                $niceNames['description.description_' . $language->id] = 'description';
            }
        }
        $validationRule = array_merge($validationRule, ['contact_person_phone' => ['required' ]]);
        $validationRule = array_merge($validationRule, ['contact_person_email' => ['required', 'email']]);
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        $validationRule = array_merge($validationRule, ['contact_person_image' => ['nullable']]);
        $validationRule = array_merge($validationRule, ['country' => ['required']]);
        $validationRule = array_merge($validationRule, ['url' => ['required', new ValidUrl()]]);
        if ($isWeb) {
            $niceNames['contact_person_phone'] = $sponsorPageTrans['contact_person_phone_error'] ?? '';
            $niceNames['contact_person_email'] = $sponsorPageTrans['contact_person_email_error'] ?? '';
            $niceNames['country'] = $sponsorPageTrans['location_error'] ?? '';
            $niceNames['image'] = $sponsorPageTrans['logo_error'] ?? '';
            $niceNames['url'] = $sponsorPageTrans['website_error'] ?? '';
        } else {
            $errorMessages = array_merge($errorMessages, ['url.required' => 'Website link is required']);
            $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
            $errorMessages = array_merge($errorMessages, ['country.required' => 'Location is required']);
            // $errorMessages = array_merge($errorMessages, ['image.required' => 'Image is required']);
            $validationRule = array_merge($validationRule, ['status' => ['required']]);
        }
        $this->validate(
            $request,
            $validationRule,
            $errorMessages,
            $niceNames
        );
        // $media = json_decode($request->image, 1);
        // $files = $this->moveFile($media, 'media/images', 'sponsor_image');

        if (isset($request->image)) {
            $media = json_decode($request->image, true);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'image');
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } else {
            return response()->json(['error' => 'No image provided'], 400);
        }

        $Sponsor = Sponsor::create([
            'image' => isset($files, $files[0]) ? $files[0]->id : null,
            'country' => $request->country,
            'contact_person_phone' => $request->contact_person_phone ?? null,
            'contact_person_email' => $request->contact_person_email ?? null,
            'contact_person_image' => $request->contact_person_image ?? null,
            'status' => $request->status ?? 'no',
            'url' => $request->url,
        ]);


        // if ($Sponsor) {
        //     foreach ($languages as $language) {
        //         SponsorDetail::create([
        //             'sponsor_id' => $Sponsor->id,
        //             'language_id' => $language->id,
        //             'title' => $request['title']['title_' . $language->id] ?? null,
        //             'subsidiary' => $request['subsidiary']['subsidiary_' . $language->id] ?? null,
        //             'contact_person_name' => $request['contact_person_name']['contact_person_name_' . $language->id] ?? null,
        //             'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
        //             'description' => $request['description']['description_' . $language->id] ?? null,
        //             'service1_name' => $request['service1_name']['service1_name_' . $language->id] ?? null,
        //             'service1_url' => $request['service1_url']['service1_url_' . $language->id] ?? null,
        //             'service2_name' => $request['service2_name']['service2_name_' . $language->id] ?? null,
        //             'service2_url' => $request['service2_url']['service2_url_' . $language->id] ?? null,
        //             'service3_name' => $request['service3_name']['service3_name_' . $language->id] ?? null,
        //             'service3_url' => $request['service3_url']['service3_url_' . $language->id] ?? null,
        //             'service4_name' => $request['service4_name']['service4_name_' . $language->id] ?? null,
        //             'service4_url' => $request['service4_url']['service4_url_' . $language->id] ?? null,
        //             'service5_name' => $request['service5_name']['service5_name_' . $language->id] ?? null,
        //             'service5_url' => $request['service5_url']['service5_url_' . $language->id] ?? null,
        //             'slug' => isset($request['title']['title_' . $language->id]) ? Str::slug($request['title']['title_' . $language->id]) : null,
        //         ]);
        //     }
        //     return $this->apiSuccessResponse(new SponsorResource($Sponsor), 'Your changes have been done successfully');
        // }
        if ($Sponsor) {
            // Create a single SponsorDetail record
            $language = getAllLanguages()->first();  // Get the first language for the detail
            SponsorDetail::create([
                'sponsor_id' => $Sponsor->id,
                'language_id' => $language->id, // Assuming you're using the default language for details
                'title' => $request['title']['title_' . $language->id] ?? null,
                'subsidiary' => $request['subsidiary']['subsidiary_' . $language->id] ?? null,
                'keywords' => $request['keywords']['keywords_' . $language->id] ?? null,
                'contact_person_name' => $request['contact_person_name']['contact_person_name_' . $language->id] ?? null,
                'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                'description' => $request['description']['description_' . $language->id] ?? null,
                'service1_name' => $request['service1_name']['service1_name_' . $language->id] ?? null,
                'service1_url' => $request['service1_url']['service1_url_' . $language->id] ?? null,
                'service2_name' => $request['service2_name']['service2_name_' . $language->id] ?? null,
                'service2_url' => $request['service2_url']['service2_url_' . $language->id] ?? null,
                'service3_name' => $request['service3_name']['service3_name_' . $language->id] ?? null,
                'service3_url' => $request['service3_url']['service3_url_' . $language->id] ?? null,
                'service4_name' => $request['service4_name']['service4_name_' . $language->id] ?? null,
                'service4_url' => $request['service4_url']['service4_url_' . $language->id] ?? null,
                'service5_name' => $request['service5_name']['service5_name_' . $language->id] ?? null,
                'service5_url' => $request['service5_url']['service5_url_' . $language->id] ?? null,
                'slug' => isset($request['title']['title_' . $language->id]) ? Str::slug($request['title']['title_' . $language->id]) : null,
            ]);
            
            return $this->apiSuccessResponse(new SponsorResource($Sponsor), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Sponsor $Sponsor)
    {
        $validationRule = [];
        $niceNames = [];
        $errorMessages = [];
        $isWeb = isset($request->is_web) && $request->is_web == 1;
        $languages = getAllLanguages();
        if ($isWeb) {
            $sponsorPageTrans = getStaticTranslation('become_sponsor_page');
        }
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['subsidiary.subsidiary_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['keywords.keywords_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['contact_person_name.contact_person_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:30']]);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.required' => 'Short description is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'maxwords:300']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
            $validationRule = array_merge($validationRule, ['service1_name.service1_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service1_url.service1_url_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service2_name.service2_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service2_url.service2_url_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service3_name.service3_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service3_url.service3_url_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service4_name.service4_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service4_url.service4_url_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service5_name.service5_name_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['service5_url.service5_url_' . $language->id => ['nullable', 'string']]);

            if ($isWeb) {
                $niceNames['title.title_' . $language->id] = $sponsorPageTrans['business_name_error'] ?? '';
                $niceNames['subsidiary.subsidiary_' . $language->id] = $sponsorPageTrans['subsidiary_error'] ?? '';
                $niceNames['keywords.keywords_' . $language->id] = $sponsorPageTrans['keywords_error'] ?? '';
                $niceNames['contact_person_name.contact_person_name_' . $language->id] = $sponsorPageTrans['contact_person_name_error'] ?? '';
                $niceNames['short_description.short_description_' . $language->id] = $sponsorPageTrans['short_description_error'] ?? '';
                $niceNames['description.description_' . $language->id] = $sponsorPageTrans['description_error'] ?? '';
                $niceNames['service1_name.service1_name_' . $language->id] = $sponsorPageTrans['service_1_name_error'] ?? '';
                $niceNames['service1_url.service1_url_' . $language->id] = $sponsorPageTrans['service_1_url_error'] ?? '';
                $niceNames['service2_name.service2_name_' . $language->id] = $sponsorPageTrans['service_2_name_error'] ?? '';
                $niceNames['service2_url.service2_url_' . $language->id] = $sponsorPageTrans['service_2_url_error'] ?? '';
                $niceNames['service3_name.service3_name_' . $language->id] = $sponsorPageTrans['service_3_name_error'] ?? '';
                $niceNames['service3_url.service3_url_' . $language->id] = $sponsorPageTrans['service_3_url_error'] ?? '';
                $niceNames['service4_name.service4_name_' . $language->id] = $sponsorPageTrans['service_4_name_error'] ?? '';
                $niceNames['service4_url.service4_url_' . $language->id] = $sponsorPageTrans['service_4_url_error'] ?? '';
                $niceNames['service5_name.service5_name_' . $language->id] = $sponsorPageTrans['service_5_name_error'] ?? '';
                $niceNames['service5_url.service5_url_' . $language->id] = $sponsorPageTrans['service_5_url_error'] ?? '';
            } else {
                $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Business name is required.']);

                $niceNames['short_description.short_description_' . $language->id] = 'short description';
                $niceNames['description.description_' . $language->id] = 'description';
            }
        }
        $validationRule = array_merge($validationRule, ['contact_person_phone' => ['required']]);
        $validationRule = array_merge($validationRule, ['contact_person_image' => ['nullable']]);
        $validationRule = array_merge($validationRule, ['contact_person_email' => ['nullable', 'email']]);
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        $validationRule = array_merge($validationRule, ['country' => ['required']]);
        $validationRule = array_merge($validationRule, ['url' => ['required', new ValidUrl()]]);
        if ($isWeb) {
            $niceNames['contact_person_phone'] = $sponsorPageTrans['contact_person_phone_error'] ?? '';
            $niceNames['contact_person_email'] = $sponsorPageTrans['contact_person_email_error'] ?? '';
            $niceNames['country'] = $sponsorPageTrans['location_error'] ?? '';
            $niceNames['image'] = $sponsorPageTrans['logo_error'] ?? '';
            $niceNames['url'] = $sponsorPageTrans['website_error'] ?? '';
        } else {
            $errorMessages = array_merge($errorMessages, ['url.required' => 'Website link is required']);
            $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
            $errorMessages = array_merge($errorMessages, ['country.required' => 'Location is required']);
            // $errorMessages = array_merge($errorMessages, ['image.required' => 'Image is required']);
            $validationRule = array_merge($validationRule, ['status' => ['required']]);
        }
        $this->validate(
            $request,
            $validationRule,
            $errorMessages,
            $niceNames
        );

        if ($request->has('image') && !empty($request->image)) {
            $media = is_array($request->image)
                ? $request->image
                : json_decode($request->image, true);
        
            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'image');
        
                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files = $existingImagePath ?? null;
            }
        } else {
            $files = $existingImagePath ?? null;
        }

        $Sponsor->update([
            'image' => !isset($request->image) ? null : (isset($files, $files[0]) ? $files[0]->id : $Sponsor->image),
            'country' => $request->country,
            'contact_person_phone' => $request->contact_person_phone ?? null,
            'contact_person_email' => $request->contact_person_email ?? null,
            'contact_person_image' => $request->contact_person_image ?? null,
            'status' => $isWeb ? $Sponsor->status : $request->status,
            'url' => $request->url,

        ]);
        // foreach ($languages as $language) {
        //     $SponsorDetail = SponsorDetail::whereLanguageId($language->id)->whereSponsorId($Sponsor->id)->exists();
        //     $sponsorData = [
        //         'sponsor_id' => $Sponsor->id,
        //         'language_id' => $language->id,
        //         'title' => $request['title']['title_' . $language->id] ?? null,
        //         'slug' => isset($request['title']['title_' . $language->id]) ? Str::slug($request['title']['title_' . $language->id]) : null,
        //         'keywords' => $request['subsidiary']['subsidiary_' . $language->id] ?? null,
        //         'contact_person_name' => $request['contact_person_name']['contact_person_name_' . $language->id] ?? null,
        //         'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
        //         'description' => $request['description']['description_' . $language->id] ?? null,
        //         'service1_name' => $request['service1_name']['service1_name_' . $language->id] ?? null,
        //         'service1_url' => $request['service1_url']['service1_url_' . $language->id] ?? null,
        //         'service2_name' => $request['service2_name']['service2_name_' . $language->id] ?? null,
        //         'service2_url' => $request['service2_url']['service2_url_' . $language->id] ?? null,
        //         'service3_name' => $request['service3_name']['service3_name_' . $language->id] ?? null,
        //         'service3_url' => $request['service3_url']['service3_url_' . $language->id] ?? null,
        //         'service4_name' => $request['service4_name']['service4_name_' . $language->id] ?? null,
        //         'service4_url' => $request['service4_url']['service4_url_' . $language->id] ?? null,
        //         'service5_name' => $request['service5_name']['service5_name_' . $language->id] ?? null,
        //         'service5_url' => $request['service5_url']['service5_url_' . $language->id] ?? null,
        //     ];
        //     if ($SponsorDetail) {
        //         SponsorDetail::whereLanguageId($language->id)->whereSponsorId($Sponsor->id)->update($sponsorData);
        //     } else {
        //         SponsorDetail::create($sponsorData);
        //     }
        // }

        foreach ($languages as $language) {
            // Check if the record exists for the given sponsor and language
            $SponsorDetail = SponsorDetail::whereLanguageId($language->id)
                                          ->whereSponsorId($Sponsor->id)
                                          ->first();
        
            // Prepare the data to update or create
            $sponsorData = [
                'sponsor_id' => $Sponsor->id,
                'language_id' => $language->id,
                'title' => $request['title']['title_' . $language->id] ?? null,
                'slug' => isset($request['title']['title_' . $language->id]) ? Str::slug($request['title']['title_' . $language->id]) : null,
                'subsidiary' => $request['subsidiary']['subsidiary_' . $language->id] ?? null,
                'keywords' => $request['keywords']['keywords_' . $language->id] ?? null,
                'contact_person_name' => $request['contact_person_name']['contact_person_name_' . $language->id] ?? null,
                'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                'description' => $request['description']['description_' . $language->id] ?? null,
                'service1_name' => $request['service1_name']['service1_name_' . $language->id] ?? null,
                'service1_url' => $request['service1_url']['service1_url_' . $language->id] ?? null,
                'service2_name' => $request['service2_name']['service2_name_' . $language->id] ?? null,
                'service2_url' => $request['service2_url']['service2_url_' . $language->id] ?? null,
                'service3_name' => $request['service3_name']['service3_name_' . $language->id] ?? null,
                'service3_url' => $request['service3_url']['service3_url_' . $language->id] ?? null,
                'service4_name' => $request['service4_name']['service4_name_' . $language->id] ?? null,
                'service4_url' => $request['service4_url']['service4_url_' . $language->id] ?? null,
                'service5_name' => $request['service5_name']['service5_name_' . $language->id] ?? null,
                'service5_url' => $request['service5_url']['service5_url_' . $language->id] ?? null,
            ];
        
            // If the record exists, update it; otherwise, create it
            if ($SponsorDetail) {
                // Update the existing record
                $SponsorDetail->update($sponsorData);
            }
        }
        if ($Sponsor) {
            return $this->apiSuccessResponse(new SponsorResource($Sponsor), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }


    public function destroy(Request $request, Sponsor $Sponsor)
    {
        if ($Sponsor->SponsorDetail()->delete() && $Sponsor->delete()) {
            return $this->apiSuccessResponse(new SponsorResource($Sponsor), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($sponsors)
    {
        $defaultLang = getDefaultLanguage();
        $sponsors = $sponsors->with(['sponsorDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withSponsorDetail']) && $_GET['withSponsorDetail'] == '1') {
            $sponsors = $sponsors->with('sponsorDetail');
        }
        return $sponsors;
    }

    protected function sortingAndLimit($sponsors)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'sponsor_title'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $sponsors = $sponsors->addSelect(['sponsor_title' => SponsorDetail::whereColumn('sponsors.id', 'sponsor_details.sponsor_id')->whereLanguageId($defaultLang->id)->select('title')->limit(1)]);

            $sponsors = $sponsors->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $sponsors->paginate($limit);
    }

    protected function whereClause($sponsors)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $sponsors = $sponsors->whereHas('sponsorDetail', function ($q) {
                $q->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $sponsors;
    }
}
