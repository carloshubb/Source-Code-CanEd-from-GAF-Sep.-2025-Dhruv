<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolMoreLinkResource;
use Illuminate\Support\Str;
use App\Models\SchoolMoreLink;
use App\Models\SchoolMoreLinkDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SchoolMoreLinkController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function index()
    {
        $customer = auth()
            ->guard('customers')
            ->user();
        $openDays = SchoolMoreLink::whereCustomerId($customer->id);
        $openDays = $this->whereClause($openDays);
        $openDays = $this->loadRelations($openDays);
        $openDays = $this->sortingAndLimit($openDays);

        return $this->apiSuccessResponse(SchoolMoreLinkResource::collection($openDays), 'Data Get Successfully!');
    }

    public function show($SchoolMoreLink)
    {
        $SchoolMoreLink = SchoolMoreLink::whereId($SchoolMoreLink)->with('schoolMoreLinkDetail')->first();
        return $this->apiSuccessResponse(new SchoolMoreLinkResource($SchoolMoreLink), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Title is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['link' . '.required' => 'Link is required.']);
        $this->validate($request, $validationRule, $errorMessages);
        $SchoolMoreLink = SchoolMoreLink::create([
            'link' => $request->link,
            'school_id' => $request->school_id,
        ]);

        if ($SchoolMoreLink) {
            foreach ($request->languages as $language) {
                if (!empty($request['name']['name_' . $language['language_code']])) {
                    SchoolMoreLinkDetail::create([
                        'school_more_link_id' => $SchoolMoreLink->id,
                        'language_code' => $language['language_code'],
                        'name' => $request['name']['name_' . $language['language_code']],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new SchoolMoreLinkResource($SchoolMoreLink), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request,$SchoolMoreLink)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Title is required']);
               }
        }
        $validationRule = array_merge($validationRule, ['link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['link' . '.required' => 'Link is required.']);
        $this->validate($request, $validationRule, $errorMessages);

        $SchoolMoreLink = SchoolMoreLink::whereId($SchoolMoreLink)->first();
        $SchoolMoreLink->update([
            'link' => $request->link,
        ]);
        

        foreach ($request->languages as $language) {
            if (!empty($request['name']['name_' . $language['language_code']])) {
                $SchoolMoreLinkDetail = SchoolMoreLinkDetail::whereLanguageCode($language['language_code'])
                    ->whereSchoolMoreLinkId($SchoolMoreLink->id)
                    ->exists();
                if ($SchoolMoreLinkDetail) {
                    
                    SchoolMoreLinkDetail::whereLanguageCode($language['language_code'])
                        ->whereSchoolMoreLinkId($SchoolMoreLink->id)
                        ->update([
                            'language_code' => $language['language_code'],
                            'name' => $request['name']['name_' . $language['language_code']],
                        ]);
                        
                } else {
                    SchoolMoreLinkDetail::create([
                        'school_more_link_id' => $SchoolMoreLink->id,
                        'language_code' => $language['language_code'],
                        'name' => $request['name']['name_' . $language['language_code']],
                    ]);
                }
            }
        }
        // dd($SchoolMoreLink->schoolMoreLinkDetail);
        if ($SchoolMoreLink) {
            return $this->apiSuccessResponse(new SchoolMoreLinkResource($SchoolMoreLink), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy($SchoolMoreLink)
    {
        
        $SchoolMoreLink = SchoolMoreLink::whereId($SchoolMoreLink)->first();
        if ($SchoolMoreLink->schoolMoreLinkDetail()->delete() && $SchoolMoreLink->delete()) {
            return $this->apiSuccessResponse(new SchoolMoreLinkResource($SchoolMoreLink), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($openDays)
    {
        $defaultLang = getDefaultLanguage();
        $openDays = $openDays->with([
            'SchoolMoreLinkDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        if (isset($_GET['withSchoolMoreLinkDetail']) && $_GET['withSchoolMoreLinkDetail'] == '1') {
            $openDays = $openDays->with('SchoolMoreLinkDetail');
        }
        return $openDays;
    }

    protected function sortingAndLimit($openDays)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'link', 'name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $openDays = $openDays->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $openDays->paginate($limit);
    }

    protected function whereClause($openDays)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $openDays = $openDays->whereHas('schoolMoreLinkDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $openDays;
    }
}
