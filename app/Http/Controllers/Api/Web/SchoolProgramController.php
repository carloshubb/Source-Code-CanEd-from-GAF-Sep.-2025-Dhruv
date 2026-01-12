<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolProgramResource;
use App\Jobs\NewRecordEmailJob;
use Illuminate\Support\Str;
use App\Models\SchoolProgram;
use App\Models\SchoolProgramDetail;
use App\Models\Language;
use App\Models\Program;
use App\Models\ProgramDegreeLevel;
use App\Models\ProgramDetail;
use App\Models\SchoolProgramDegreeLevel;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SchoolProgramController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $customer = auth()
            ->guard('customers')
            ->user();
        if (isset($_GET['is_admin'])) {
            $schoolPrograms = SchoolProgram::query();
        } else {
            $schoolPrograms = SchoolProgram::whereCustomerId($customer->id);
        }

        $schoolPrograms = $this->whereClause($schoolPrograms);
        $schoolPrograms = $this->loadRelations($schoolPrograms);
        $schoolPrograms = $this->sortingAndLimit($schoolPrograms);

        return $this->apiSuccessResponse(SchoolProgramResource::collection($schoolPrograms), 'Data Get Successfully!');
    }

    public function show(SchoolProgram $SchoolProgram)
    {
        if (isset($_GET['withSchoolProgramDetail']) && $_GET['withSchoolProgramDetail'] == '1') {
            $SchoolProgram = $SchoolProgram->loadMissing('SchoolProgramDetail');
        }

        return $this->apiSuccessResponse(new SchoolProgramResource($SchoolProgram), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['description.description_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['description.description_' . $language->abbreviation . '.required' => 'Description level is required']);
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name level is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['degree_id' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['degree_id.required' => 'Degree level is required.']);
        // $validationRule = array_merge($validationRule, ['program_id'=> ['required']]);
        // $errorMessages = array_merge($errorMessages, ['program_id.required' => 'Program is required.']);
        
        $this->validate($request, $validationRule, $errorMessages);
        $programToSend = Program::where('id', $request->program_id)->first();
        // if (isset($request->already_existed) && $request->already_existed == 0) {
            $primaryDegreeId = $request->degree_id[0] ?? null;
            $programToSend  = Program::create([
                'customer_id' => isset($request->customer_id) && !empty($request->customer_id) ? $request->customer_id : null,
                'status' => isset($request->status) ? $request->status : 'pending',
                'degree_id' => $primaryDegreeId,
            ]);
            if ($programToSend) {
                if(is_array($request->degree_id)){
                    foreach ($request->degree_id as $degree_id) {
                        ProgramDegreeLevel::create([
                            'degree_id' => $degree_id,
                            'program_id' => $programToSend->id,
                        ]);
                    }
                }else{
                    ProgramDegreeLevel::create([
                        'degree_id' => $request->degree_id,
                        'program_id' => $programToSend->id,
                    ]);
                }
                
                foreach ($languages as $language) {
                    if (isset($request['name']['name_' . $language->abbreviation])) {
                        ProgramDetail::create([
                            'program_id' => $programToSend->id,
                            'language_id' => $language->id,
                            'name' => $request['name']['name_' . $language->abbreviation],
                            'description' => $request['description']['description_' . $language->abbreviation],
                        ]);
                    }
                }
            }
            // }
            $customer_name = "";
            $customer = auth()->guard('customers')->user();
            if (isset($customer)) {
                $customer_name = $customer->first_name . ' ' . $customer->last_name;
            }
            
            $emailData = ['customer' => $customer_name, 'record' => $programToSend, 'record_url' => 'programs', 'record_type' => 'program', 'record_type_string' => 'Program'];
            dispatch(new NewRecordEmailJob($emailData));
            $SchoolProgram = SchoolProgram::create([
                'program_id' => $programToSend->id,
                'customer_id' => $request->customer_id,
                'school_id' => $request->school_id,
            ]);
            
            
            if(is_array($request->degree_id)){
                foreach ($request->degree_id as $degree_id) {
                    SchoolProgramDegreeLevel::create([
                        'degree_id' => $degree_id,
                        'school_program_id' => $SchoolProgram->id,
                    ]);
                }
            }else{
                SchoolProgramDegreeLevel::create([
                    'degree_id' => $request->degree_id,
                    'school_program_id' => $SchoolProgram->id,
                ]);
            }
            
            
            if ($SchoolProgram) {
                foreach ($request->languages as $language) {
                    $languageCode = isset($language['language_code']) ? $language['language_code'] : $language['abbreviation'];
                    
                    if (!empty($request['description']['description_' . $languageCode]) && !is_null($request['description']['description_' . $languageCode])) {
                        SchoolProgramDetail::create([
                            'school_program_id' => $SchoolProgram->id,
                            'language_code' => $languageCode,
                            'description' => $request['description']['description_' . $languageCode],
                        ]);
                    }
                }
                return $this->apiSuccessResponse(new SchoolProgramResource($SchoolProgram), 'Your changes have been done successfully');
                dd($request->all());
            }
            
        return $this->errorResponse();
    }

    public function update(Request $request, SchoolProgram $SchoolProgram)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['description.description_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['description.description_' . $language->abbreviation . '.required' => 'Description level is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['degree_id' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['degree_id.required' => 'Degree level is required.']);
        $validationRule = array_merge($validationRule, ['program_id' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['program_id.required' => 'Program is required.']);

        $this->validate($request, $validationRule, $errorMessages);

        $SchoolProgram->update([
            'degree_id' => $request->degree_id,
            'program_id' => $request->program_id,
        ]);
        foreach ($request->languages as $language) {
            $languageCode = (isset($language['language_code']) ? $language['language_code'] : isset($language['abbreviation'])) ? $language['abbreviation'] : '';
            if (!empty($request['description']['description_' . $languageCode])) {
                $SchoolProgramDetail = SchoolProgramDetail::whereLanguageCode($languageCode)
                    ->whereSchoolProgramId($SchoolProgram->id)
                    ->exists();
                if ($SchoolProgramDetail) {
                    SchoolProgramDetail::whereLanguageCode($languageCode)
                        ->whereSchoolProgramId($SchoolProgram->id)
                        ->update([
                            'school_program_id' => $SchoolProgram->id,
                            'language_code' => $languageCode,
                            'description' => $request['description']['description_' . $languageCode],
                        ]);
                } else {
                    SchoolProgramDetail::create([
                        'school_program_id' => $SchoolProgram->id,
                        'language_code' => $languageCode,
                        'description' => $request['description']['description_' . $languageCode],
                    ]);
                }
            }
        }

        if ($SchoolProgram) {
            return $this->apiSuccessResponse(new SchoolProgramResource($SchoolProgram), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, SchoolProgram $SchoolProgram)
    {
        if ($SchoolProgram->SchoolProgramDetail()->delete() && $SchoolProgram->delete()) {
            return $this->apiSuccessResponse(new SchoolProgramResource($SchoolProgram), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($schoolPrograms)
    {
        $defaultLang = getDefaultLanguage();
        $schoolPrograms = $schoolPrograms->with([
            'SchoolProgramDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
            'schoolProgramDegreeLevel'
        ]);
        if (isset($_GET['withSchoolProgramDetail']) && $_GET['withSchoolProgramDetail'] == '1') {
            $schoolPrograms = $schoolPrograms->with('SchoolProgramDetail');
            $schoolPrograms = $schoolPrograms->with('schoolProgramDegreeLevel');
        }
        return $schoolPrograms;
    }

    protected function sortingAndLimit($schoolPrograms)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'SchoolProgram_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $schoolPrograms = $schoolPrograms->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }else{
            $schoolPrograms = $schoolPrograms->OrderBy('name', 'asc');
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $schoolPrograms->paginate($limit);
    }

    protected function whereClause($schoolPrograms)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $schoolPrograms = $schoolPrograms->whereHas('SchoolProgramDetail', function ($q) {
                $q->where('description', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        if (isset($_GET['school_id']) && $_GET['school_id'] != '') {
            $faqs = $schoolPrograms->where('school_id', $_GET['school_id']);
        }
        return $schoolPrograms;
    }
}
