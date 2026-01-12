<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DegreeResource;
use Illuminate\Support\Str;
use App\Models\Degree;
use App\Models\DegreeDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $degrees = Degree::query();

        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            $degrees = $this->sortingAndLimit($degrees);
            return $this->successResponse($degrees, 'Data Get Successfully!');
        }
        else{
            $degrees = $this->whereClause($degrees);
            $degrees = $this->loadRelations($degrees);
            $degrees = $this->sortingAndLimit($degrees);
        }

        
        return $this->apiSuccessResponse(DegreeResource::collection($degrees), 'Data Get Successfully!');
    }


    public function show(Degree $Degree)
    {
        if (isset($_GET['withDegreeDetail']) && $_GET['withDegreeDetail'] == '1') {
            $Degree = $Degree->loadMissing('degreeDetail');
        }

        return $this->apiSuccessResponse(new DegreeResource($Degree), 'Data Get Successfully!');
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
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
        }

        $validationRule = array_merge($validationRule, ['degree_image' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['degree_image.required' => 'Image is required']);

        $validationRule = array_merge($validationRule, ['order' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['order.required' => 'Order is required']);

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        if (isset($request->degree_image)) {
            $media = json_decode($request->degree_image, true);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'degree_image');
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } else {
            return response()->json(['error' => 'No degree image provided'], 400);
        }

        $Degree = Degree::create(['degree_image' => isset($files, $files[0]) ? $files[0]->id : null, 'image' => $request->image, 'order' => $request->order, 'url' => 'no url']);


        if ($Degree) {
            foreach ($languages as $language) {
                DegreeDetail::create([
                    'degree_id' => $Degree->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                    'description' => $request['description']['description_' . $language->id],
                    'slug' => Str::slug($request['name']['name_' . $language->id]),
                ]);
            }
            return $this->apiSuccessResponse(new DegreeResource($Degree), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Degree $Degree)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $Degree->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $Degree->id)]]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
        }
        $validationRule = array_merge($validationRule, ['degree_image' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['degree_image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['order' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['order.required' => 'Order is required']);
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        if ($request->has('degree_image') && !empty($request->degree_image)) {
            $media = is_array($request->degree_image)
                ? $request->degree_image
                : json_decode($request->degree_image, true);
        
            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'degree_image');
        
                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files = $existingImagePath ?? null;
            }
        } else {
            $files = $existingImagePath ?? null;
        }

        $Degree->update([
            'degree_image' => !isset($request->degree_image) ? null : (isset($files, $files[0]) ? $files[0]->id : $Degree->degree_image),
            'image' => $request->image,
            'url' => 'no url',
            'order' => $request->order
        ]);

        foreach ($languages as $language) {
            $languageId = $language->id;
            $nameKey = 'name_' . $languageId;
            $descriptionKey = 'description_' . $languageId;
        
            if (isset($request['name'][$nameKey]) && isset($request['description'][$descriptionKey])) {
                $name = $request['name'][$nameKey];
                $description = $request['description'][$descriptionKey];
                $slug = Str::slug($name);
        
                $DegreeDetail = DegreeDetail::whereLanguageId($languageId)
                    ->whereDegreeId($Degree->id)
                    ->exists();
        
                if ($DegreeDetail) {
                    DegreeDetail::whereLanguageId($languageId)
                        ->whereDegreeId($Degree->id)
                        ->update([
                            'name' => $name,
                            'description' => $description,
                            'slug' => $slug,
                        ]);
                } else {
                    DegreeDetail::create([
                        'degree_id' => $Degree->id,
                        'language_id' => $languageId,
                        'name' => $name,
                        'description' => $description,
                        'slug' => $slug,
                    ]);
                }
            } else {
                \Log::warning("Missing data for language ID: {$languageId}");
            }
        }
        

        if ($Degree) {
            return $this->apiSuccessResponse(new DegreeResource($Degree), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }


    public function destroy(Request $request, Degree $Degree)
    {
        if ($Degree->DegreeDetail()->delete() && $Degree->delete()) {
            return $this->apiSuccessResponse(new DegreeResource($Degree), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($degrees)
    {
        $defaultLang = getDefaultLanguage();
        $degrees = $degrees->with(['degreeDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])
        ->addSelect([
            'name' => DegreeDetail::where('language_id', $defaultLang->id)
                ->whereColumn('degree_id', 'degrees.id')
                ->limit(1)
                ->select('name'),
        ]);;
        if (isset($_GET['withDegreeDetail']) && $_GET['withDegreeDetail'] == '1') {
            $degrees = $degrees->with('degreeDetail');
        }
        return $degrees;
    }

    protected function sortingAndLimit($degrees)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'degree_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $degrees = $degrees->addSelect(['degree_name' => DegreeDetail::whereColumn('degrees.id', 'degree_details.degree_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $degrees = $degrees->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $degrees->get();
        }
        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $degrees->paginate($limit);
    }

    protected function whereClause($degrees)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $degrees = $degrees->whereHas('degreeDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $degrees;
    }
}
