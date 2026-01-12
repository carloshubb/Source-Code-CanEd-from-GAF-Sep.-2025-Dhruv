<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\VirtualTourResource;
use Illuminate\Support\Str;
use App\Models\VirtualTour;
use App\Models\Language;
use App\Models\VirtualTourDetail;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class VirtualTourController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $VirtualTours = VirtualTour::query();

        $VirtualTours = $this->whereClause($VirtualTours);
        $VirtualTours = $this->loadRelations($VirtualTours);
        $VirtualTours = $this->sortingAndLimit($VirtualTours);

        return $this->apiSuccessResponse(VirtualTourResource::collection($VirtualTours), 'Data Get Successfully!');
    }

    public function show(VirtualTour $VirtualTour)
    {
        return $this->apiSuccessResponse(new VirtualTourResource($VirtualTour), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            // $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'max:20', new CheckCategorySlug($language, null)]]);
            // $errorMessages = array_merge($errorMessages, [
            //     'description.description_' . $language->id . '.required' => 'Description is required.',
            //     'description.description_' . $language->id . '.max' => 'Only 20 characters are allowed for the description.'
            // ]);
            $validationRule = array_merge($validationRule, [
                'description.description_' . $language->id => [
                    $requiredVal,
                    'string',
                    function ($attribute, $value, $fail) {
                        if (str_word_count($value) > 20) {
                            $fail('Only 20 words are allowed for the description');
                        }
                    },
                    new CheckCategorySlug($language, null),
                ],
            ]);
            
            $errorMessages = array_merge($errorMessages, [
                'description.description_' . $language->id . '.required' => 'Description is required',
            ]);
        }
        $validationRule = array_merge($validationRule, ['link' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['link.required' => 'Link is required']);
        // $validationRule = array_merge($validationRule, ['date' => ['required']]);
        // $errorMessages = array_merge($errorMessages, ['date.required' => 'Deadline date is required']);
        $validationRule = array_merge($validationRule, ['color' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['color.required' => 'Color is required']);
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        // $validationRule = array_merge($validationRule, ['image' => ['required', 'mimes:jpeg,jpg,png', 'max:2000' ]]);
        // $errorMessages = [
        //     'image.required' => 'Image is required.',
        //     'image.mimes' => 'Only JPEG, JPG, PNG images are allowed.',
        //     'image.max' => 'The image size must not exceed 5MB.',
        // ];
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);

        $this->validate($request, $validationRule, $errorMessages);
        $VirtualTour = VirtualTour::create([
            'link' => $request->link,
            'deadline_date' => $request->date ?? null,
            'color' => $request->color,
            'image' => $request->image,
            'status' => $request->status,
        ]);
        if ($VirtualTour) {
            // foreach ($languages as $language) {
            //     VirtualTourDetail::create([
            //         'virtual_tour_id' => $VirtualTour->id,
            //         'language_id' => $language->id,
            //         'description' => $request['description']['description_' . $language->id],
            //     ]);
            // }
            foreach ($languages as $language) {
                $description = $request['description']['description_' . $language->id] ?? null;

                if (!is_null($description)) {
                    VirtualTourDetail::create([
                        'virtual_tour_id' => $VirtualTour->id,
                        'language_id' => $language->id,
                        'description' => $description,
                    ]);
                }
            }
            return $this->apiSuccessResponse(new VirtualTourResource($VirtualTour), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, VirtualTour $VirtualTour)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            // $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [
            //     $requiredVal,
            //     'string',
            //     'max:20',
            //     new CheckCategorySlug($language, null)
            // ]]);
            // $errorMessages = array_merge($errorMessages, [
            //     'description.description_' . $language->id . '.required' => 'Description is required.',
            //     'description.description_' . $language->id . '.max' => 'Only 20 characters are allowed for the description.'
            // ]);
            $validationRule = array_merge($validationRule, [
                'description.description_' . $language->id => [
                    $requiredVal,
                    'string',
                    function ($attribute, $value, $fail) {
                        if (str_word_count($value) > 20) {
                            $fail('The description may not contain more than 20 words.');
                        }
                    },
                    new CheckCategorySlug($language, null),
                ],
            ]);
            
            $errorMessages = array_merge($errorMessages, [
                'description.description_' . $language->id . '.required' => 'Description is required.',
            ]);
        }
        $validationRule = array_merge($validationRule, ['link' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['link.required' => 'link is required.']);
        $validationRule = array_merge($validationRule, ['date' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['date.required' => 'Deadline date is required.']);
        $validationRule = array_merge($validationRule, ['color' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['color.required' => 'color is required.']);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'max:5120',
        // 'file',
        //  'mimes:jpeg,jpg,png'
         ]]);
        
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'this field is required.']);

        $this->validate($request, $validationRule, $errorMessages);

        $VirtualTour->update([
            'link' => $request->link,
            'deadline_date' => $request->date,
            'color' => $request->color,
            'image' => $request->image,
            'status' => $request->status,
        ]);
        if ($VirtualTour) {
            foreach ($languages as $language) {
                $description = $request['description']['description_' . $language->id] ?? null;
                if (!is_null($description)) {
                    $VirtTourDetail = VirtualTourDetail::where('language_id', $language->id)
                        ->where('virtual_tour_id', $VirtualTour->id)
                        ->first();
    
                    if ($VirtTourDetail) {
                        $VirtTourDetail->update([
                            // 'virtual_tour_id' => $VirtualTour->id,
                            // 'language_id' => $language->id,
                            'description' => $description,
                        ]);
                    } else {
                        VirtualTourDetail::create([
                            'virtual_tour_id' => $VirtualTour->id,
                            'language_id' => $language->id,
                            'description' => $description,
                        ]);
                    }
                }
                // $VirtTour = VirtualTourDetail::whereLanguageId($language->id)
                //     ->where('virtual_tour_id', $VirtualTour->id)
                //     ->exists();
                // if ($VirtTour) {
                //     VirtualTourDetail::whereLanguageId($language->id)
                //         ->whereVirtualTourId($VirtualTour->id)
                //         ->update([
                //             'virtual_tour_id' => $VirtualTour->id,
                //             'language_id' => $language->id,
                //             'description' => $request['description']['description_' . $language->id],
                //         ]);
                // } else {
                //     VirtualTourDetail::create([
                //         'virtual_tour_id' => $VirtualTour->id,
                //         'language_id' => $language->id,
                //         'description' => $request['description']['description_' . $language->id],
                //     ]);
                // }
            }
            return $this->apiSuccessResponse(new VirtualTourResource($VirtualTour), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, VirtualTour $VirtualTour)
    {
        if ($VirtualTour->delete()) {
            return $this->apiSuccessResponse(new VirtualTourResource($VirtualTour), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($VirtualTours)
    {
        return $VirtualTours;
    }

    protected function sortingAndLimit($VirtualTours)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'city', 'country', 'province', 'virtual_tour_desc'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $VirtualTours = $VirtualTours->addSelect(['virtual_tour_desc' => VirtualTourDetail::whereColumn('virtual_tours.id', 'virtual_tour_details.virtual_tour_id')->whereLanguageId($defaultLang->id)->select('description')->limit(1)]);

            $VirtualTours = $VirtualTours->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $VirtualTours->paginate($limit);
    }

    protected function whereClause($VirtualTours)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $VirtualTours = $VirtualTours
                ->whereHas('virtualTourDetail', function ($q) {
                    $q->where('description', 'LIKE', '%' . $_GET['searchParam'] . '%');
                })
                ->orWhere('status', $_GET['searchParam']);
        }
        return $VirtualTours;
    }
}
