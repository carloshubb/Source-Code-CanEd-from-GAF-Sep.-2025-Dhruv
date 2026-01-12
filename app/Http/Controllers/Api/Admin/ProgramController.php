<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProgramResource;
use App\Jobs\NewRecordEmailJob;
use App\Jobs\CustomerThankYouEmailJob;
use App\Jobs\StatusApprovelEmailJob;
use App\Models\Degree;
use App\Models\DegreeDetail;
use Illuminate\Support\Str;
use App\Models\Program;
use App\Models\ProgramDetail;
use App\Models\Language;
use App\Models\ProgramDegreeLevel;
use App\Models\School;
use App\Models\SchoolProgram;
use App\Models\SchoolProgramDetail;
use App\Rules\CheckCategorySlug;
use App\Services\FomSubmissionCountService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ProgramController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $programs = Program::query();

        if(isset($_GET['degreeId']) && $_GET['degreeId'] != "" && $_GET['degreeId'] != 0){
            $programs =  $programs->where('degree_id', $_GET['degreeId']);
        }

        $programs = $this->whereClause($programs);
        $programs = $this->loadRelations($programs);
        $programs = $this->sortingAndLimit($programs);
        return $this->apiSuccessResponse(ProgramResource::collection($programs), 'Data Get Successfully!');
    }

    public function show(Program $program)
    {
        if (isset($_GET['withProgramDetail']) && $_GET['withProgramDetail'] == '1') {
            $program = $program->loadMissing('programDetail');
        }
        $program = $program->loadMissing('programDegreeLevel');

        return $this->apiSuccessResponse(new ProgramResource($program), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        // dd($request->degree_id);
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $defaultLang = getDefaultLanguage(1);
        $this->checkForDuplicateProgramName($request, $languages);

        if (isset($request->is_web) && $request->is_web == 1) {
            $validationRule = array_merge($validationRule, ['name.name_' . $defaultLang->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $defaultLang->id . '.required' => 'Program name is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $defaultLang->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $defaultLang->id . '.required' => 'Description is required']);
        } else {
            foreach ($languages as $language) {
                $requiredVal = 'nullable';
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                }
                $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Program name is required']);
                $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string']]);
                $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
            }
        }

        // $validationRule = array_merge($validationRule, ['degree_id' => ['required', 'array']]);
        $request->merge(['degree_id' => (array) $request->degree_id]);

        $validationRule = array_merge($validationRule, ['degree_id.*' => ['required', 'exists:degrees,id']]);

        $errorMessages = array_merge($errorMessages, [
            'degree_id.required' => 'Degree level is required',
            'degree_id.*.exists' => 'The selected degree is invalid',
        ]);

        $this->validate($request, $validationRule, $errorMessages);
        if (isset($request->is_web)) {
            $formSubmissionService = new FomSubmissionCountService();
            $result = $formSubmissionService->advertiserForm();
            if ($result['status'] == 'Error') {
                return $result;
            }
        }
        $primaryDegreeId = $request->degree_id[0] ?? null;
        $program = Program::create([
            'customer_id' => isset($request->customer_id) && !empty($request->customer_id) ? $request->customer_id : null,
            'status' => isset($request->status) ? $request->status : 'approved',
            'degree_id' => $primaryDegreeId,
        ]);

        if ($program) {
            foreach ($request->degree_id as $degree_id) {
                ProgramDegreeLevel::create([
                    'degree_id' => $degree_id,
                    'program_id' => $program->id,
                ]);
            }
            foreach ($languages as $language) {
                if (isset($request['name']['name_' . $language->id])) {
                    ProgramDetail::create([
                        'program_id' => $program->id,
                        'language_id' => $language->id,
                        'name' => $request['name']['name_' . $language->id] ?? null,
                        'description' => $request['description']['description_' . $language->id] ?? null,
                        'customer_id' => $request->customer_id ?? null,
                    ]);
                }
            }
            if (isset($request->is_web)) {
                $customer_name =
                    auth()
                    ->guard('customers')
                    ->user()->first_name .
                    ' ' .
                    auth()
                    ->guard('customers')
                    ->user()->last_name;
                    $customer_email = auth()->guard('customers')->user()->email;
                $emailData = ['customer' => $customer_name, 'record' => $program, 'record_url' => 'programs', 'record_type' => 'program', 'record_type_string' => 'Program'];
                // dd($emailData);
                dispatch(new NewRecordEmailJob($emailData));
                dispatch(new CustomerThankYouEmailJob($emailData,$customer_email));
            }
            return $this->apiSuccessResponse(new ProgramResource($program), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
    private function checkForDuplicateProgramName(Request $request, $languages)
{
    foreach ($languages as $language) {
        $programName = $request['name']['name_' . $language->id] ?? null;

        if ($programName) {
            // Check if a program with the same name already exists for this language
            $existingProgram = ProgramDetail::where('name', $programName)
                ->where('language_id', $language->id)
                ->first();

            if ($existingProgram) {
                throw ValidationException::withMessages([
                    'name.name_' . $language->id => ['A program with this name already exists in this language.'],
                ]);
            }
        }
    }
}

    // public function update(Request $request, Program $program)
    // {
    //     $validationRule = [];
    //     $errorMessages = [];
    //     $languages = getAllLanguages();
    //     foreach ($languages as $language) {
    //         $requiredVal = 'nullable';
    //         if ($language->is_default == '1') {
    //             $requiredVal = 'required';
    //         }
    //         $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
    //         $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
    //         $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
    //         $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
    //     }

    //     $validationRule = array_merge($validationRule, ['degree_id' => ['required', 'exists:programs,id']]);
    //     $errorMessages = array_merge($errorMessages, ['degree_id.required' => 'Degree is required']);

    //     $this->validate($request, $validationRule, $errorMessages);
    //     $sendEmail = 0;
    //     if ($request->status != $program->status) {
    //         $sendEmail = 1;
    //     }
    //     $program->update([
    //         'status' => $request->status,
    //     ]);
    //     ProgramDegreeLevel::where('program_id', $program->id)->delete();
    //     foreach ($request->degree_id as $degree_id) {
    //         ProgramDegreeLevel::create([
    //             'degree_id' => $degree_id,
    //             'program_id' => $program->id,
    //         ]);
    //     }
    //     if ($sendEmail && isset($program->customer)) {
    //         $customer = isset($program->customer) ? $program->customer->first_name . ' ' . $program->customer->last_name : '';
    //         $customer_email = isset($program->customer) ? $program->customer->email : '';
    //         $emailData = [
    //             'customer' => $customer,
    //             'record_type_string' => isset($program->programDetail[0]->name) ? $program->programDetail[0]->name : '',
    //             'status' => $request->status,
    //             'email' => $customer_email
    //         ];
    //         $emailData = dispatch(new StatusApprovelEmailJob($emailData));
    //     }
    //     foreach ($languages as $language) {
    //         $programDetail = ProgramDetail::whereLanguageId($language->id)
    //             ->whereProgramId($program->id)
    //             ->exists();
    //         if ($programDetail) {
    //             ProgramDetail::whereLanguageId($language->id)
    //                 ->whereProgramId($program->id)
    //                 ->update([
    //                     'program_id' => $program->id,
    //                     'language_id' => $language->id,
    //                     'name' => $request['name']['name_' . $language->id] ?? null,
    //                     'description' => $request['description']['description_' . $language->id] ?? null,
    //                 ]);
    //         } else {
    //             ProgramDetail::create([
    //                 'program_id' => $program->id,
    //                 'language_id' => $language->id,
    //                 'name' => $request['name']['name_' . $language->id] ?? null,
    //                 'description' => $request['description']['description_' . $language->id] ?? null,
    //             ]);
    //         }
    //     }

    //     if ($program) {
    //         return $this->apiSuccessResponse(new ProgramResource($program), 'Your changes have been done successfully');
    //     }
    //     return $this->errorResponse();
    // }

    public function update(Request $request, Program $program)
{
    $validationRule = [];
    $errorMessages = [];
    $languages = getAllLanguages();

    foreach ($languages as $language) {
        $requiredVal = $language->is_default == '1' ? 'required' : 'nullable';

        $validationRule["name.name_{$language->id}"] = [$requiredVal, 'string', new CheckCategorySlug($language, null)];
        $errorMessages["name.name_{$language->id}.required"] = 'Name is required';

        $validationRule["description.description_{$language->id}"] = [$requiredVal, 'string', new CheckCategorySlug($language, null)];
        $errorMessages["description.description_{$language->id}.required"] = 'Description is required';
    }

    // Validate `degree_id` as an array
    $validationRule = array_merge($validationRule, [
        'degree_id' => ['required', 'array'],
        'degree_id.*' => ['exists:degrees,id']
    ]);
    $errorMessages = array_merge($errorMessages, ['degree_id.required' => 'Degree is required']);

    $this->validate($request, $validationRule, $errorMessages);

    $sendEmail = ($request->status != $program->status) ? 1 : 0;

    $program->update([
        'status' => $request->status,
    ]);
    $program->refresh();

    // Delete existing degrees and re-insert
    ProgramDegreeLevel::where('program_id', $program->id)->delete();

    if (!empty($request->degree_id) && is_array($request->degree_id)) {
        foreach ($request->degree_id as $degree_id) {
            ProgramDegreeLevel::create([
                'degree_id' => $degree_id,
                'program_id' => $program->id,
            ]);
        }
    }

    if ($sendEmail && isset($program->customer)) {
        $customer_name = $program->customer->first_name . ' ' . $program->customer->last_name;
        $customer_email = $program->customer->email ?? '';

        $emailData = [
            'customer' => $customer_name,
            'record_type_string' => $program->programDetail[0]->name ?? '',
            'status' => $request->status,
            'email' => $customer_email
        ];

        dispatch(new StatusApprovelEmailJob($emailData));
    }

    foreach ($languages as $language) {
        $programDetail = ProgramDetail::whereLanguageId($language->id)
            ->whereProgramId($program->id)
            ->exists();

        $data = [
            'program_id' => $program->id,
            'language_id' => $language->id,
            'name' => $request['name']['name_' . $language->id] ?? null,
            'description' => $request['description']['description_' . $language->id] ?? null,
        ];

        if ($programDetail) {
            ProgramDetail::whereLanguageId($language->id)
                ->whereProgramId($program->id)
                ->update($data);
        } else {
            ProgramDetail::create($data);
        }
    }

    return $this->apiSuccessResponse(new ProgramResource($program), 'Your changes have been done successfully');
}


    public function destroy(Request $request, Program $program)
    {
        if ($program->ProgramDetail()->delete() && $program->delete()) {
            return $this->apiSuccessResponse(new ProgramResource($program), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    // protected function loadRelations($programs)
    // {
    //     $defaultLang = getDefaultLanguage();
    //     $programs = $programs->with([
    //         'programDetail' => function ($q) use ($defaultLang) {
    //             $q->where('language_id', $defaultLang->id);
    //         },
    //     ]);
    //     if (isset($_GET['withProgramDetail']) && $_GET['withProgramDetail'] == '1') {
    //         $programs = $programs->with('programDetail');
    //     }
    //     return $programs;
    // }
    protected function loadRelations($programs)
{
    $defaultLang = getDefaultLanguage();
    
    $programs = $programs->with([
        'programDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'programDegreeLevel' // Add this line to include degree levels
    ]);

    if (isset($_GET['withProgramDetail']) && $_GET['withProgramDetail'] == '1') {
        $programs = $programs->with('programDetail');
    }

    return $programs;
}

    protected function sortingAndLimit($programs)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'degree_name', 'program_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $programs = $programs->addSelect(['program_name' => ProgramDetail::whereColumn('programs.id', 'program_details.program_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $programs = $programs->addSelect(['degree_name' => DegreeDetail::whereColumn('programs.degree_id', 'degree_details.degree_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);


            $programs = $programs->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $programs->paginate($limit);
    }

    protected function whereClause($programs)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $programs = $programs->whereHas('programDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $programs;
    }

    public function uploadExcelFile(Request $request)
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
        $programs = [];
        foreach ($data as $key => $value) {
            if ($key != 0) {
                $localData = [];
                foreach ($firstRowKeys as $i => $firstRowKey) {
                    if (isset($value[$i])) {
                        $localData[$firstRowKey] = $value[$i];
                    }
                }

                $programs[] = $localData;
            }
        }
        $defaultLang = getDefaultLanguage(1);
        foreach ($programs as $program) {
            if (isset($program['name'])) {
                if (!ProgramDetail::whereName($program['name'])->exists()) {
                    if (isset($program['degree_level']) && Degree::whereId($program['degree_level'])->exists()) {
                        $programNew = Program::create([
                            'degree_id' => isset($program['degree_level']) ? $program['degree_level'] : '',
                        ]);
                        ProgramDegreeLevel::create([
                            'program_id' => $programNew->id,
                            'degree_id' => $programNew->degree_id,
                        ]);
                    } else {
                        $programNew = Program::create([]);
                    }

                    if ($programNew) {
                        ProgramDetail::create([
                            'language_id' => $defaultLang->id,
                            'program_id' => $programNew->id,
                            'name' => isset($program['name']) ? $program['name'] : '',
                            'description' => isset($program['description']) ? $program['description'] : null,
                        ]);

                    }
                }
            }
        }
        return redirect()->back();
    }

    public function uploadExcelFileSchoolProgram(Request $request)
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
        $programs = [];
        foreach ($data as $key => $value) {
            if ($key != 0) {
                $localData = [];
                foreach ($firstRowKeys as $i => $firstRowKey) {
                    if (isset($value[$i])) {
                        $localData[$firstRowKey] = $value[$i];
                    }
                }

                $programs[] = $localData;
            }
        }
        $defaultLang = getDefaultLanguage(1);
        foreach ($programs as $program) {
            if (
                !SchoolProgram::whereSchoolId($program['school_id'])
                    ->whereProgramId($program['program_id'])
                    ->exists()
            ) {
                $programNew = SchoolProgram::create([
                    'school_id' => isset($program['school_id']) && School::whereId($program['school_id'])->exists() ? $program['school_id'] : null,
                    'program_id' => isset($program['program_id']) && Program::whereId($program['program_id'])->exists() ? $program['program_id'] : null,
                    'degree_id' => isset($program['degree_level']) && Degree::whereId($program['degree_level'])->exists() ? $program['degree_level'] : null,
                ]);

                if ($programNew) {
                    SchoolProgramDetail::create([
                        'school_program_id' => $programNew->id,
                        'language_code' => $defaultLang->abbreviation,
                        'description' => isset($program['description']) ? $program['description'] : null,
                    ]);
                }
            }
        }
        return redirect()->back();
    }
}
