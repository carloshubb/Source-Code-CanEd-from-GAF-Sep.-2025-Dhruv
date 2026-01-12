<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BusinessResource;
use Illuminate\Support\Str;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessCategoryDetail;
use App\Models\BusinessDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Rules\MaxKeywords;
use App\Rules\YoutubeUrl;

class BusinessController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $teams = Business::query();

        $teams = $this->whereClause($teams);
        $teams = $this->loadRelations($teams);
        $teams = $this->sortingAndLimit($teams);

        return $this->apiSuccessResponse(BusinessResource::collection($teams), 'Data Get Successfully!');
    }

    public function show(Business $Business)
    {
        if (isset($_GET['withBusinessDetail']) && $_GET['withBusinessDetail'] == '1') {
            $Business = $Business->loadMissing('businessDetail');
        }

        return $this->apiSuccessResponse(new BusinessResource($Business), 'Data Get Successfully!');
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
            $validationRule = array_merge($validationRule, ['business_name.business_name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_name.business_name_' . $language->id . '.required' => 'Business name is required.']);
            // $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'description is required.']);
            $validationRule = array_merge($validationRule, [
                'description.description_' . $language->id => [
                    $requiredVal,
                    'string',
                    function ($attribute, $value, $fail) {
                        $plainText = trim(strip_tags(html_entity_decode($value)));
                        if (str_word_count($plainText) > 30) {
                            $fail('Only 30 words are allowed for the description.');
                        }
                    }
                ]
            ]);
            
            $errorMessages = array_merge($errorMessages, [
                'description.description_' . $language->id . '.required' => 'Description is required.',
            ]);
            
            // $validationRule = array_merge($validationRule, ['detail_description.detail_description_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['detail_description.detail_description_' . $language->id . '.required' => 'detail_description is required.']);
            $validationRule = array_merge($validationRule, [
                'detail_description.detail_description_' . $language->id => [
                    $requiredVal,
                    'string',
                    function ($attribute, $value, $fail) {
                        $plainText = trim(strip_tags(html_entity_decode($value)));
                        if (str_word_count($plainText) > 300) {
                            $fail('Only 300 words are allowed for the detailed description.');
                        }
                    }
                ]
            ]);
            
            $errorMessages = array_merge($errorMessages, [
                'detail_description.detail_description_' . $language->id . '.required' => 'Detailed description is required.',
            ]);
            $validationRule = array_merge($validationRule, ['media_section_title.media_section_title_' . $language->id => [$requiredVal, 'string','maxwords:10']]);
            $errorMessages = array_merge($errorMessages, ['media_section_title.media_section_title_' . $language->id . '.required' => ' Title of the media is required .','media_section_title.media_section_title_' . $language->id . '.maxwords' => 'Please limit your event media section title to 10 words']);
            $validationRule = array_merge($validationRule, ['media_section_description.media_section_description_' . $language->id => [$requiredVal, 'string','maxwords:50']]);
            $errorMessages = array_merge($errorMessages, ['media_section_description.media_section_description_' . $language->id . '.required' => 'Description of media is required.','media_section_description.media_section_description_' . $language->id . '.maxwords' => 'Please limit your event media section description to 50 words']);
        }

        $validationRule = array_merge($validationRule, ['phone' => ['required' , 'digits_between:1,15']]);
        $errorMessages = array_merge($errorMessages, ['phone.required' => 'Phone is required',
        'phone.digits_between' => 'Phone number cannot exceed 15 digits']);

        
        $validationRule = array_merge($validationRule, ['welcome_video' => [new YoutubeUrl()]]);
        $validationRule = array_merge($validationRule, ['keywords' => [new MaxKeywords]]);
        $this->validate($request, $validationRule, $errorMessages);
        $Business = Business::create([
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'youtube_url' => $request->youtube_url,
            'linked_url' => $request->linked_url,
            'other_social_url' => $request->other_social_url,
            'keywords' => $request->keywords,
            'welcome_video' => $request->welcome_video,
            'logo' => $request->logo,
            'image' => isset($request->image) && is_array($request->image) ? implode(',', $request->image) : null,
            'contact_name' => $request->contact_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'website_url' => $request->website_url,
            'business_catagory_1' => $request->business_catagory_1 ?? null,
            'business_catagory_2' => $request->business_catagory_2 ?? null,
            'business_catagory_3' => $request->business_catagory_3 ?? null,
            'deactive_account' => 0,
        ]);

        if ($Business) {
            // foreach ($languages as $language) {
                $language = getAllLanguages()->first();
                BusinessDetail::create([
                    'business_id' => $Business->id,
                    'language_id' => $language->id,
                    'business_name' => $request['business_name']['business_name_' . $language->id],
                    'description' => $request['description']['description_' . $language->id],
                    'detail_description' => $request['detail_description']['detail_description_' . $language->id],
                    'media_section_title' => $request['media_section_title']['media_section_title_' . $language->id],
                    'media_section_description' => $request['media_section_description']['media_section_description_' . $language->id],
                ]);
            // }
            return $this->apiSuccessResponse(new BusinessResource($Business), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Business $Business)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['business_name.business_name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_name.business_name_' . $language->id . '.required' => 'Business name is required.']);

            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string','maxwords:30']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'description is required.','description.description_' . $language->id . '.maxwords' => 'Please limit your event media section description to 30 words']);
            
            $validationRule = array_merge($validationRule, ['detail_description.detail_description_' . $language->id => [$requiredVal, 'string','maxwords:300']]);
            $errorMessages = array_merge($errorMessages, ['detail_description.detail_description_' . $language->id . '.required' => 'detail description is required.','detail_description.detail_description_' . $language->id . '.maxwords' => 'Please limit your event media section description to 300 words']);

            $validationRule = array_merge($validationRule, ['media_section_title.media_section_title_' . $language->id => [$requiredVal, 'string','maxwords:10']]);
            $errorMessages = array_merge($errorMessages, ['media_section_title.media_section_title_' . $language->id . '.required' => 'media section title is required.','media_section_title.media_section_title_' . $language->id . '.maxwords' => 'Please limit your event media section title to 10 words']);

            $validationRule = array_merge($validationRule, ['media_section_description.media_section_description_' . $language->id => [$requiredVal, 'string','maxwords:30']]);
            $errorMessages = array_merge($errorMessages, ['media_section_description.media_section_description_' . $language->id . '.required' => 'media section description is required.','media_section_description.media_section_description_' . $language->id . '.maxwords' => 'Please limit your event media section description to 30 words']);
      
        }
        $validationRule = array_merge($validationRule, ['phone' => ['required' , 'digits_between:1,15']]);
        $errorMessages = array_merge($errorMessages, ['phone.required' => 'Phone is required',
        'phone.digits_between' => 'Phone number cannot exceed 15 digits']);

        $validationRule = array_merge($validationRule, ['welcome_video' => [new YoutubeUrl()]]);
        $validationRule = array_merge($validationRule, ['keywords' => [new MaxKeywords]]);

        $this->validate($request, $validationRule, $errorMessages);

        $Business->update([
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'youtube_url' => $request->youtube_url,
            'linked_url' => $request->linked_url,
            'welcome_video' => $request->welcome_video,
            'other_social_url' => $request->other_social_url,
            'keywords' => $request->keywords,
            'image' => isset($request->image) && is_array($request->image) ? implode(',', $request->image) : null,
            'contact_name' => $request->contact_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'logo' => $request->logo,
            'website_url' => $request->website_url,
            'business_catagory_1' => $request->business_catagory_1,
            'business_catagory_2' => $request->business_catagory_2,
            'business_catagory_3' => $request->business_catagory_3,
        ]);
        foreach ($languages as $language) {
            $BusinessDetail = BusinessDetail::whereLanguageId($language->id)
                ->whereBusinessId($Business->id)
                ->exists();
            if ($BusinessDetail) {
                BusinessDetail::whereLanguageId($language->id)
                    ->whereBusinessId($Business->id)
                    ->update([
                        'business_id' => $Business->id,
                        'language_id' => $language->id,
                        'business_name' => $request['business_name']['business_name_' . $language->id] ?? null,
                        'description' => $request['description']['description_' . $language->id] ?? null,
                        'detail_description' => $request['detail_description']['detail_description_' . $language->id] ?? null,
                        'media_section_title' => $request['media_section_title']['media_section_title_' . $language->id] ?? null,
                        'media_section_description' => $request['media_section_description']['media_section_description_' . $language->id] ?? null,
                    ]);
            } else {
                BusinessDetail::create([
                    'business_id' => $Business->id,
                    'language_id' => $language->id,
                    'business_name' => $request['business_name']['business_name_' . $language->id] ?? null,
                    'description' => $request['description']['description_' . $language->id] ?? null,
                    'detail_description' => $request['detail_description']['detail_description_' . $language->id] ?? null,
                    'media_section_title' => $request['media_section_title']['media_section_title_' . $language->id] ?? null,
                    'media_section_description' => $request['media_section_description']['media_section_description_' . $language->id] ?? null,
                ]);
            }
        }

        if ($Business) {
            return $this->apiSuccessResponse(new BusinessResource($Business), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, Business $Business)
    {
        if ($Business->delete()) {
            return $this->apiSuccessResponse(new BusinessResource($Business), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    public function deactiveBusiness(Request $request)
    {
        $sql = Business::whereId($request->id)->update(['deactive_account' => $request->type]);
        return $this->successResponse('', 'Business status update successfully.');
    }

    protected function loadRelations($teams)
    {
        $defaultLang = getDefaultLanguage();
        $teams = $teams->with([
            'businessDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->abbreviation);
            },
        ]);
        if (isset($_GET['withBusinessDetail']) && $_GET['withBusinessDetail'] == '1') {
            $teams = $teams->with('businessDetail');
        }
        return $teams;
    }

    protected function sortingAndLimit($teams)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'business_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {

            $defaultLang = getDefaultLanguage();
            $teams = $teams->addSelect(['business_name' => BusinessDetail::whereColumn('businesses.id', 'business_details.business_id')->whereLanguageId($defaultLang->id)->select('business_name')->limit(1)]);

            $teams = $teams->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $teams->paginate($limit);
    }

    protected function whereClause($teams)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $teams = $teams->whereHas('BusinessDetail', function ($q) {
                $q->where('business_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $teams;
    }

    public function uploadExcelFileBusinessCategory(Request $request)
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
        $categories = [];
        foreach ($data as $key => $value) {
            if ($key != 0) {
                $localData = [];
                foreach ($firstRowKeys as $i => $firstRowKey) {
                    if (isset($value[$i])) {
                        $localData[$firstRowKey] = $value[$i];
                    }
                }

                $categories[] = $localData;
            }
        }
        // dd($categories);
        $defaultLang = getDefaultLanguage(1);
        foreach ($categories as $category) {
            if (isset($category['name']) && !BusinessCategoryDetail::whereName($category['name'])->exists()) {
                $categoryNew = BusinessCategory::create([
                    'image' => isset($category['image']) ? $category['image'] : '',
                ]);
                if ($categoryNew) {
                    BusinessCategoryDetail::create([
                        'language_id' => $defaultLang->id,
                        'name' => isset($category['name']) ? $category['name'] : '',
                        'slug' => Str::slug($category['name']),
                        'business_category_id' => $categoryNew->id,
                    ]);
                }
            }
        }
        return redirect()->back();
    }
}
