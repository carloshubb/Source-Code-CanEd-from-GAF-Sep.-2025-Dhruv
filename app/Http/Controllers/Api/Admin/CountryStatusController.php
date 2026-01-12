<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CountryResource;
use App\Models\Country;
use App\Models\CountryDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class CountryStatusController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        //$this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $countries = Country::query();

        $countries = $this->whereClause($countries);
        $countries = $this->loadRelations($countries);
        $countries = $this->sortingAndLimit($countries);

        return $this->apiSuccessResponse(CountryResource::collection($countries), 'Data Get Successfully!');
    }


    public function show(Country $country)
    {
        if (isset($_GET['withCountryDetail']) && $_GET['withCountryDetail'] == '1') {
            $country = $country->loadMissing('countryDetail');
        }

        return $this->apiSuccessResponse(new CountryResource($country), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        // dd($request->degree_id);
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $defaultLang = getDefaultLanguage(1);
        // $this->checkForDuplicateProgramName($request, $languages);

        if (isset($request->is_web) && $request->is_web == 1) {
            $validationRule = array_merge($validationRule, ['country_name.country_' . $defaultLang->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_name.country_' . $defaultLang->id . '.required' => 'Country name is required']);
        } else {
            foreach ($languages as $language) {
                $requiredVal = 'nullable';
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                }
                $validationRule = array_merge($validationRule, ['country_name.country_' . $language->id => [$requiredVal, 'string']]);
                $errorMessages = array_merge($errorMessages, ['country_name.country_' . $language->id . '.required' => 'Country name is required']);
            }
        }

        $this->validate($request, $validationRule, $errorMessages);
        if (isset($request->is_web)) {
            // $formSubmissionService = new FomSubmissionCountService();
            // $result = $formSubmissionService->advertiserForm();
            // if ($result['status'] == 'Error') {
            //     return $result;
            // }
        }

        $user = \Auth::id() != null ? \Auth::id() : null;
        $Country = Country::create([
            'user_id' => $user,
            'status' => $request->status,
            'name' => $request->name ?? NULL,
        ]);

        if ($Country) {
            foreach ($languages as $language) {
                if (isset($request['country_name']['country_' . $language->id])) {
                    CountryDetail::create([
                        'country_id' => $Country->id,
                        'language_id' => $language->id,
                        'name' => $request['country_name']['country_' . $language->id] ?? null,
                    ]);
                }
            }
            return $this->apiSuccessResponse(new CountryResource($Country), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, $id)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $defaultLang = getDefaultLanguage(1);

        if (isset($request->is_web) && $request->is_web == 1) {
            $validationRule = array_merge($validationRule, [
                'country_name.country_' . $defaultLang->id => ['required', 'string'],
            ]);
            $errorMessages = array_merge($errorMessages, [
                'country_name.country_' . $defaultLang->id . '.required' => 'Country name is required',
            ]);
        } else {
            foreach ($languages as $language) {
                $requiredVal = 'nullable';
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                }
                $validationRule = array_merge($validationRule, [
                    'country_name.country_' . $language->id => [$requiredVal, 'string'],
                ]);
                $errorMessages = array_merge($errorMessages, [
                    'country_name.country_' . $language->id . '.required' => 'Country name is required',
                ]);
            }
        }

        $this->validate($request, $validationRule, $errorMessages);

        $Country = Country::findOrFail($id);
        $Country->status = $request->status;
        $Country->name = $request->name ?? NULL;
        $Country->save();

        foreach ($languages as $language) {
            $langId = $language->id;
            $name = $request['country_name']['country_' . $langId] ?? null;

            if ($name !== null) {
                CountryDetail::updateOrCreate(
                    ['country_id' => $Country->id, 'language_id' => $langId],
                    ['name' => $name]
                );
            }
        }

        return $this->apiSuccessResponse(new CountryResource($Country), 'Your changes have been done successfully');
    }


    public function destroy(Request $request, Country $country)
    {
        if ($country->countryDetail()->delete() && $country->delete()) {
            return $this->apiSuccessResponse(new CountryResource($country), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($countries)
    {
        $defaultLang = getDefaultLanguage();
        $countries = $countries->with([
            'countryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            }
        ]);
        if (isset($_GET['withCountryDetail']) && $_GET['withCountryDetail'] == '1') {
            $countries = $countries->with('countryDetail');
        }
        return $countries;
    }

    protected function sortingAndLimit($countries)
    {
        // $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        // $sortBy = ['id', 'quote'];
        // if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
        //     $defaultLang = getDefaultLanguage();
        //     $quotes = $quotes->addSelect(['quote' => QuoteDetail::whereColumn('quotes.id', 'quote_details.quote_id')->whereLanguageId($defaultLang->id)->select('quote')->limit(1)]);


        //     $quotes = $quotes->OrderBy($_GET['sortBy'], $_GET['sortType']);
        // }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }
        $countries = $countries->addSelect([
            'country' => function ($query) {
                $query->select('name')
                    ->from('country_details')
                    ->whereColumn('country_details.country_id', 'countries.id')
                    ->limit(1);
            }
        ])->orderBy('name', 'ASC');

        return $countries->paginate($limit);
    }

    protected function whereClause($countries)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $countries = $countries->whereHas('countryDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $countries;
    }
}
