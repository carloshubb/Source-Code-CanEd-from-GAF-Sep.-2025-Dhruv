<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\VirtualTourResource;
use Illuminate\Support\Str;
use App\Models\VirtualTour;
use App\Models\VirtualTourDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class VirtualTourController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function index()
    {
        $customer = auth()->guard('customers')->user();
        $vitualTours = VirtualTour::where('customer_id', $customer->id);

        $vitualTours = $this->whereClause($vitualTours);
        $vitualTours = $this->loadRelations($vitualTours);
        $vitualTours = $this->sortingAndLimit($vitualTours);

        return $this->apiSuccessResponse(VirtualTourResource::collection($vitualTours), 'Data Get Successfully!');
    }


    public function show(VirtualTour $VirtualTour)
    {
        // if (isset($_GET['withVirtualTourDetail']) && $_GET['withVirtualTourDetail'] == '1') {
        //     $VirtualTour = $VirtualTour->loadMissing('VirtualTourDetail');
        // }

        return $this->apiSuccessResponse(new VirtualTourResource($VirtualTour), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                // $validationRule = array_merge($validationRule, ['description.description_' . $language->id => ['required', 'string', 'max:20',]]);
                $validationRule = array_merge($validationRule, [
                    'description.description_' . $language->id => [
                        'required',
                        'string',
                        function ($attribute, $value, $fail) {
                            if (str_word_count($value) > 20) {
                                $fail('Only 20 words are allowed for the description');
                            }
                        }
                    ]
                ]);
                $errorMessages = array_merge($errorMessages, [
                    'description.description_' . $language->id . '.required' => 'Description is required',
                ]);
                // $errorMessages = array_merge($errorMessages, [
                //     'description.description_' . $language->id . '.required' => 'Description is required',
                //     'description.description_' . $language->id . '.max' => 'Only 20 characters are allowed for the description.'
                // ]);
            }
        }
        $validationRule = array_merge($validationRule, ['link' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['link.required' => 'Link is required']);
        // $validationRule = array_merge($validationRule, ['date' => ['required']]);
        // $errorMessages = array_merge($errorMessages, ['date.required' => 'Deadline date is required']);
        $validationRule = array_merge($validationRule, ['color' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['color.required' => 'Color is required']);
        $validationRule = array_merge($validationRule, [
            'image' => ['required'],
        ]);
        


        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $VirtualTour = VirtualTour::create([
            'link' => $request->link,
            'deadline_date' => $request->date ?? null,
            'color' => $request->color,
            'image' => $request->image,
            'status' => 'approved',
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
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
            // $validationRule = array_merge($validationRule, ['description.description_' . $language->id => ['required', 'string', 'max:20',]]);
            // $errorMessages = array_merge($errorMessages, [
            //     'description.description_' . $language->id . '.required' => 'Description is required',
            //     'description.description_' . $language->id . '.max' => 'Only 20 characters are allowed for the description.'
            // ]);

            $validationRule = array_merge($validationRule, [
                'description.description_' . $language->id => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        if (str_word_count($value) > 20) {
                            $fail('Only 20 words are allowed for the description');
                        }
                    },
                ],
            ]);
            $errorMessages = array_merge($errorMessages, [
                'description.description_' . $language->id . '.required' => 'Description is required',
            ]);
        }
        $validationRule = array_merge($validationRule, ['link' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['link.required' => 'Link is required']);
        $validationRule = array_merge($validationRule, ['date' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['date.required' => 'Deadline date is required']);
        $validationRule = array_merge($validationRule, ['color' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['color.required' => 'Color is required']);
        $validationRule = array_merge($validationRule, ['image' => ['required'
         ]]);


        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $VirtualTour->update([
            'link' => $request->link,
            'deadline_date' => $request->date,
            'color' => $request->color,
            'image' => $request->image,
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
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


    public function destroy(VirtualTour $VirtualTour)
    {
        if ($VirtualTour->delete()) {
            return $this->apiSuccessResponse(new VirtualTourResource($VirtualTour), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($vitualTours)
    {
        $defaultLang = getDefaultLanguage();
        $vitualTours = $vitualTours->with(['VirtualTourDetail' => function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        }]);
        if (isset($_GET['withVirtualTourDetail']) && $_GET['withVirtualTourDetail'] == '1') {
            $vitualTours = $vitualTours->with('VirtualTourDetail');
        }
        return $vitualTours;
    }

    protected function sortingAndLimit($vitualTours)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'VirtualTour_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $vitualTours = $vitualTours->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $vitualTours->paginate($limit);
    }

    protected function whereClause($vitualTours)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $vitualTours = $vitualTours->whereHas('VirtualTourDetail', function ($q) {
                $q->where('question', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        if (isset($_GET['type']) && $_GET['type'] != '') {
            $vitualTours = $vitualTours->where('type', $_GET['type']);
        }
        return $vitualTours;
    }
}
