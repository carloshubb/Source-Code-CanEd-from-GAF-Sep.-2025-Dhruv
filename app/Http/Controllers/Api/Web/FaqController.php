<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\FaqResource;
use Illuminate\Support\Str;
use App\Models\Faq;
use App\Models\FaqDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class FaqController extends Controller
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
            $faqs = Faq::query();
        } else {
            $faqs = Faq::whereCustomerId($customer->id);
        }

        $faqs = $this->whereClause($faqs);
        $faqs = $this->loadRelations($faqs);
        $faqs = $this->sortingAndLimit($faqs);

        return $this->apiSuccessResponse(FaqResource::collection($faqs), 'Data Get Successfully!');
    }

    public function show(Faq $Faq)
    {
        if (isset($_GET['withFaqDetail']) && $_GET['withFaqDetail'] == '1') {
            $Faq = $Faq->loadMissing('FaqDetail');
        }

        return $this->apiSuccessResponse(new FaqResource($Faq), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        // foreach ($languages as $language) {
        //     if ($language->is_default == 1) {
        //         $validationRule = array_merge($validationRule, ['question.question_' . $language->abbreviation => ['required', 'string']]);
        //         $errorMessages = array_merge($errorMessages, ['question.question_' . $language->abbreviation . '.required' => 'Question is required.']);
        //         $validationRule = array_merge($validationRule, ['answer.answer_' . $language->abbreviation => ['required', 'string']]);
        //         $errorMessages = array_merge($errorMessages, ['answer.answer_' . $language->abbreviation . '.required' => 'Answer is required.']);
        //     }
        // }
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                // Question Validation
                $validationRule = array_merge($validationRule, [
                    'question.question_' . $language->abbreviation => [
                        'required',
                        'string',
                        function ($attribute, $value, $fail) {
                            if (str_word_count($value) > 30) {
                                $fail('Only 30 words are allowed for the question.');
                            }
                        }
                    ]
                ]);
                $errorMessages = array_merge($errorMessages, [
                    'question.question_' . $language->abbreviation . '.required' => 'Question is required.'
                ]);
        
                // Answer Validation
                $validationRule = array_merge($validationRule, [
                    'answer.answer_' . $language->abbreviation => [
                        'required',
                        'string',
                        function ($attribute, $value, $fail) {
                            if (str_word_count($value) > 300) {
                                $fail('Only 300 words are allowed for the answer.');
                            }
                        }
                    ]
                ]);
                $errorMessages = array_merge($errorMessages, [
                    'answer.answer_' . $language->abbreviation . '.required' => 'Answer is required.'
                ]);
            }
        }
        $validationRule = array_merge($validationRule, ['order' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['order' . '.required' => 'Order is required.']);

        $this->validate($request, $validationRule, $errorMessages);
        $Faq = Faq::create([
            'type' => $request->type,
            'order' => $request->order,
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
        ]);

        if ($Faq) {
            foreach ($request->languages as $language) {
                $languageCode = isset($language['language_code']) ? $language['language_code'] : (isset($language['abbreviation']) ? $language['abbreviation'] : '');

                if (!empty($request['question']['question_' . $languageCode]) && !empty($request['answer']['answer_' . $languageCode])) {

                    FaqDetail::create([
                        'faq_id' => $Faq->id,
                        'language_code' => $languageCode,
                        'question' => $request['question']['question_' . $languageCode],
                        'answer' => $request['answer']['answer_' . $languageCode],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new FaqResource($Faq), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Faq $Faq)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['question.question_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['question.question_' . $language->abbreviation . '.required' => 'Question is required.']);
                $validationRule = array_merge($validationRule, ['answer.answer_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['answer.answer_' . $language->abbreviation . '.required' => 'Answer is required.']);
            }
        }
        $validationRule = array_merge($validationRule, ['order' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['order' . '.required' => 'Answer is required.']);

        $this->validate($request, $validationRule, $errorMessages);

        $Faq->update([
            'order' => $request->order,
        ]);
        foreach ($request->languages as $language) {
            $languageCode = isset($language['language_code']) ? $language['language_code'] : (isset($language['abbreviation']) ? $language['abbreviation'] : '');
            if (!empty($request['question']['question_' . $languageCode]) && !empty($request['answer']['answer_' . $languageCode])) {
                $FaqDetail = FaqDetail::whereLanguageCode($languageCode)
                    ->whereFaqId($Faq->id)
                    ->exists();
                if ($FaqDetail) {
                    FaqDetail::whereLanguageCode($languageCode)
                        ->whereFaqId($Faq->id)
                        ->update([
                            'faq_id' => $Faq->id,
                            'language_code' => $languageCode,
                            'question' => $request['question']['question_' . $languageCode],
                            'answer' => $request['answer']['answer_' . $languageCode],
                        ]);
                } else {
                    FaqDetail::create([
                        'faq_id' => $Faq->id,
                        'language_code' => $languageCode,
                        'question' => $request['question']['question_' . $languageCode],
                        'answer' => $request['answer']['answer_' . $languageCode],
                    ]);
                }
            }
        }

        if ($Faq) {
            return $this->apiSuccessResponse(new FaqResource($Faq), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, Faq $Faq)
    {
        if ($Faq->FaqDetail()->delete() && $Faq->delete()) {
            return $this->apiSuccessResponse(new FaqResource($Faq), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($faqs)
    {
        $defaultLang = getDefaultLanguage();
        $faqs = $faqs->with([
            'FaqDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        if (isset($_GET['withFaqDetail']) && $_GET['withFaqDetail'] == '1') {
            $faqs = $faqs->with('FaqDetail');
        }
        return $faqs;
    }

    protected function sortingAndLimit($faqs)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'faq_question'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $faqs = $faqs->addSelect(['faq_question' => FaqDetail::whereColumn('faq_details.faq_id', 'faqs.id')->whereLanguageCode($defaultLang->abbreviation)->select('question')->limit(1)]);


            $faqs = $faqs->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $faqs->paginate($limit);
    }

    protected function whereClause($faqs)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $faqs = $faqs->whereHas('FaqDetail', function ($q) {
                $q->where('question', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        if (isset($_GET['type']) && $_GET['type'] != '') {
            $faqs = $faqs->where('type', $_GET['type']);
        }
        if (isset($_GET['school_id']) && $_GET['school_id'] != '') {
            $faqs = $faqs->where('school_id', $_GET['school_id']);
        }
        return $faqs;
    }
}
