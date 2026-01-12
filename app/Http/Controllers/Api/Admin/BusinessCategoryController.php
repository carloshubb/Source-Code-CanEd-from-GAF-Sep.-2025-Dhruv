<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BusinessCategoryResource;
use Illuminate\Support\Str;
use App\Models\BusinessCategory;
use App\Models\BusinessCategoryDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class BusinessCategoryController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $businessCategories = BusinessCategory::query();

        $businessCategories = $this->whereClause($businessCategories);
        $businessCategories = $this->loadRelations($businessCategories);
        $businessCategories = $this->sortingAndLimit($businessCategories);

        return $this->apiSuccessResponse(BusinessCategoryResource::collection($businessCategories), 'Data Get Successfully!');
    }

    public function show(BusinessCategory $businessCategory)
    {
        if (isset($_GET['withBusinessCategoryDetail']) && $_GET['withBusinessCategoryDetail'] == '1') {
            $businessCategory = $businessCategory->loadMissing('businessCategoryDetail');
        }

        return $this->apiSuccessResponse(new BusinessCategoryResource($businessCategory), 'Data Get Successfully!');
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
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required.']);  $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'maxwords:10' ,new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required.','description.description_' . $language->id . '.maxwords' => 'Please limit your Business Category description to 10 words']);
     
        }

        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        // $errorMessages = array_merge($errorMessages, ['image.required' => 'image  is required.']);

        $this->validate($request, $validationRule, $errorMessages);
        // $media = json_decode($request->image, 1);
        // $files = $this->moveFile($media, 'media/images', 'image');
        if (isset($request->image)) {
            $media = json_decode($request->image, true);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'image');
            } else {    
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } else {
            return response()->json(['error' => 'No featured image provided'], 400);
        }

        $businessCategory = BusinessCategory::create([
            'image' => isset($files, $files[0]) ? $files[0]->id : null,
        ]);
        // dd($request->all());
        foreach ($languages as $language) {
            BusinessCategoryDetail::create([
                'business_category_id' => $businessCategory->id,
                'language_id' => $language->id,
                'name' => $request['name']['name_' . $language->id],
                'description' => $request['description']['description_' . $language->id],
                'slug' => Str::slug($request['name']['name_' . $language->id]),
            ]);
        }

        if ($businessCategory) {
            return $this->apiSuccessResponse(new BusinessCategoryResource($businessCategory), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, BusinessCategory $businessCategory)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $businessCategory->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
            
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string','maxwords:10', new CheckCategorySlug($language, $businessCategory->id)]]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required','description.description_' . $language->id . '.maxwords' => 'Please limit your Business Category description to 10 words']);
        }
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        // $errorMessages = array_merge($errorMessages, ['image.required' => 'Image  is required']);
        $this->validate($request, $validationRule, $errorMessages);

        if (isset($request->image) && !is_array($request->image)) {
            // $media = json_decode($request->image, 1);
            // $files = $this->moveFile($media, 'media/images', 'business_category_image');
            
        if ($request->has('image') && !empty($request->image)) {
            $media = is_array($request->image)
                ? $request->image
                : json_decode($request->image, true);
        
            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'business_category_image');
        
                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files = $existingImagePath ?? null;
            }
        } else {
            $files = $existingImagePath ?? null;
        }
        }
        $businessCategory->update([
            'image' => !isset($request->image) ? null : (isset($files, $files[0]) ? $files[0]->id : $businessCategory->image),
        ]);
        $businessCategory->touch();
        foreach ($languages as $language) {
            $languageIdKey = 'name_' . $language->id;
            $descLanguageIdKey = 'description_' . $language->id;

            // Check if the key exists in the request
            if (!isset($request['name'][$languageIdKey])) {
                continue; // Skip if key is missing
            }
            if (!isset($request['description'][$descLanguageIdKey])) {
                continue; // Skip if key is missing
            }
            $businessCategoryDetail = BusinessCategoryDetail::whereLanguageId($language->id)
                ->whereBusinessCategoryId($businessCategory->id)
                ->exists();
            if ($businessCategoryDetail) {
                BusinessCategoryDetail::whereLanguageId($language->id)
                    ->whereBusinessCategoryId($businessCategory->id)
                    ->update([
                        // 'name' => $request['name']['name_' . $language->id],
                        // 'slug' => Str::slug($request['name']['name_' . $language->id]),
                        'name' => $request['name'][$languageIdKey],
                        'description' => $request['description'][$descLanguageIdKey],
                        'slug' => Str::slug($request['name'][$languageIdKey]),
                    ]);
            } else {
                BusinessCategoryDetail::create([
                    'business_category_id' => $businessCategory->id,
                    'language_id' => $language->id,
                    // 'name' => $request['name']['name_' . $language->id],
                    // 'slug' => Str::slug($request['name']['name_' . $language->id]),
                    'name' => $request['name'][$languageIdKey],
                    'description' => $request['description'][$descLanguageIdKey],
                    'slug' => Str::slug($request['name'][$languageIdKey]),
                ]);
            }
        }

        if ($businessCategory) {
            return $this->apiSuccessResponse(new BusinessCategoryResource($businessCategory), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }

    public function destroy(Request $request, BusinessCategory $businessCategory)
    {
        if ($businessCategory->businessCategoryDetail()->delete() && $businessCategory->delete()) {
            return $this->apiSuccessResponse(new BusinessCategoryResource($businessCategory), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($businessCategories)
    {
        $defaultLang = getDefaultLanguage();
        $businessCategories = $businessCategories->with([
            'businessCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withBusinessCategoryDetail']) && $_GET['withBusinessCategoryDetail'] == '1') {
            $businessCategories = $businessCategories->with('businessCategoryDetail');
        }
        return $businessCategories;
    }

    protected function sortingAndLimit($businessCategories)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'business_category_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            
            $defaultLang = getDefaultLanguage();
            $businessCategories = $businessCategories->addSelect(['business_category_name' => BusinessCategoryDetail::whereColumn('business_categories.id', 'business_category_detail.business_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $businessCategories = $businessCategories->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $businessCategories->paginate($limit);
    }

    protected function whereClause($businessCategories)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $businessCategories = $businessCategories->whereHas('businessCategoryDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $businessCategories;
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
        $defaultLang = getDefaultLanguage(1);
        foreach ($bsuinesses as $business) {
            if (isset($business['name']) && !BusinessCategoryDetail::whereName($business['name'])->exists()) {
                $businessNew = BusinessCategory::create([
                    'image' => isset($business['image']) ? $business['image'] : '',
                ]);
                if ($businessNew) {
                    BusinessCategoryDetail::create([
                        'language_id' => $defaultLang->id,
                        'name' => isset($business['name']) ? $business['name'] : '',
                        'slug' => Str::slug($business['name']),
                        'business_id' => $businessNew->id,

                    ]);
                }
            }
        }
        return redirect()->back();
    }
}
