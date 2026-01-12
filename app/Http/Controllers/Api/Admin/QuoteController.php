<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\QuoteResource;
use App\Jobs\NewQuoteEmailJob;
use App\Jobs\NewRecordEmailJob;
use App\Jobs\StatusApprovelEmailJob;
use Illuminate\Support\Str;
use App\Models\Quote;
use App\Models\QuoteDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Services\FomSubmissionCountService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $quotes = Quote::query();

        $quotes = $this->whereClause($quotes);
        $quotes = $this->loadRelations($quotes);
        $quotes = $this->sortingAndLimit($quotes);

        return $this->apiSuccessResponse(QuoteResource::collection($quotes), 'Data Get Successfully!');
    }


    public function show(Quote $Quote)
    {
        if (isset($_GET['withQuoteDetail']) && $_GET['withQuoteDetail'] == '1') {
            $Quote = $Quote->loadMissing('quoteDetail');
        }

        return $this->apiSuccessResponse(new QuoteResource($Quote), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $defaultLang = getDefaultLanguage(1);
        if (isset($request->is_web) && $request->is_web == 1) {
            foreach ($languages as $language) {
                $requiredVal = 'required';
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                }
                $validationRule = array_merge($validationRule, [
                    'quote.quote_' . $defaultLang->id => [
                        $requiredVal,
                        'string',
                        function ($attribute, $value, $fail) {
                            if (str_word_count($value) > 50) {
                                $fail(getStaticTranslation('quote')['quote_word_limit_error_text']);
                            }
                        },
                        new CheckCategorySlug($language, null)
                    ]
                ]);
                $errorMessages = array_merge($errorMessages, ['quote.quote_' . $defaultLang->id . '.required' =>  getStaticTranslation('quote')['quote_error_text']]);
            }
        } else {
            foreach ($languages as $language) {
                $requiredVal = 'nullable';
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                }
                $validationRule = array_merge($validationRule, [
                    'quote.quote_' . $language->id => [
                        $requiredVal,
                        'string',
                        function ($attribute, $value, $fail) {
                            if (str_word_count($value) > 50) {
                                $fail('Quote may not exceed 50 words.');
                            }
                        },
                        new CheckCategorySlug($language, null)
                    ]
                ]);
                $errorMessages = array_merge($errorMessages, ['quote.quote_' . $language->id . '.required' =>  getStaticTranslation('quote')['quote_error_text']]);
            }
        }

        $validationRule = array_merge($validationRule, ['name' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['name.required' => getStaticTranslation('quote')['name_error_text']]);
        $validationRule = array_merge($validationRule, ['location' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['location.required' => getStaticTranslation('quote')['location_error_text']]);
        // $validationRule = array_merge($validationRule, ['image' => ['required']]);
        // $errorMessages = array_merge($errorMessages, ['image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        if (isset($request->is_web)) {
            $formSubmissionService = new FomSubmissionCountService();
            $result = $formSubmissionService->advertiserForm();
            if ($result['status'] == 'Error') {
                return $result;
            }
        }

        // $media = json_decode($request->image, 1);
        // $files = $this->moveFile($media, 'media/images', 'quote_image');
        if (isset($request->image)) {
            $media = json_decode($request->image, true);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'image');
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } 
        // else {
        //     return response()->json(['error' => 'No featured image provided'], 400);
        // }
        $user  = \Auth::id() != null ? \Auth::id() : null;
        $Quote = Quote::create([
            'user_id' => $user,
            'status' => $request->status,
            'name' => $request->name,
            'location' => $request->location,
            'image' => isset($files, $files[0]) ? $files[0]->id : null,
            'school_id' => $request->school_id,
            'customer_id' => $request->customer_id,
        ]);

        if ($Quote) {

            // foreach ($languages as $language) {
                $language = getAllLanguages()->first(); 
                QuoteDetail::create([
                    'quote_id' => $Quote->id,
                    'language_id' => $language->id,
                    'quote' => $request['quote']['quote_' . $language->id],
                    'slug' => Str::slug($request['quote']['quote_' . $language->id]),
                ]);
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
                $emailData = ['customer' => $customer_name, 'record_url' => 'quotes', 'record' => $Quote, 'record_type' => 'quote', 'record_type_string' => 'Quote'];
                dispatch(new NewQuoteEmailJob($emailData));
            }
            return $this->apiSuccessResponse(new QuoteResource($Quote), 'Your changes have been done successfully');
        // }
        return $this->errorResponse();
    }


    public function update(Request $request, Quote $Quote)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['quote.quote_' . $language->id => [$requiredVal, 'string', 
            function ($attribute, $value, $fail) {
                if (str_word_count($value) > 50) {
                    $fail('Quote may not exceed 50 words.');
                }
            },new CheckCategorySlug($language, $Quote->id)]]);
            $errorMessages = array_merge($errorMessages, ['quote.quote_' . $language->id . '.required' =>  getStaticTranslation('quote')['quote_error_text']]);
        }
        $validationRule = array_merge($validationRule, ['name' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['name.required' =>  getStaticTranslation('quote')['name_error_text']]);
        $validationRule = array_merge($validationRule, ['location' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['location.required' =>  getStaticTranslation('quote')['location_error_text']]);
        // $validationRule = array_merge($validationRule, ['image' => ['required']]);
        // $errorMessages = array_merge($errorMessages, ['image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        if ($request->has('image') && !empty($request->image)) {
            $media = is_array($request->image)
                ? $request->image
                : json_decode($request->image, true);
        
            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'image');
        
                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } 
            // else {
            //     $files = $existingImagePath ?? null;
            // }
        } else {
            $files = $existingImagePath ?? null;
        }
        
        $sendEmail = 0;
        if ($request->status != $Quote->status) {
            $sendEmail = 1;
        }
        $Quote->update([
            'user_id' => \Auth::id(),
            'name' => $request->name,
            'location' => $request->location,
            'status' => $request->status,
            'image' => !isset($request->image) ? null : (isset($files, $files[0]) ? $files[0]->id : $Quote->image),
            'school_id' => $request->school_id,

        ]);
        if ($sendEmail && isset($Quote->customer)) {
            $customer = isset($Quote->customer) ? $Quote->customer->first_name . ' ' . $Quote->customer->last_name : '';
            $customer_email = isset($Quote->customer) ? $Quote->customer->email : '';
            $emailData = [
                'customer' => $customer,
                'record_type_string' => isset($Quote->name) ? $Quote->name : '',
                'status' => $request->status,
                'email' => $customer_email
            ];
            $emailData = dispatch(new StatusApprovelEmailJob($emailData));
        }
        foreach ($languages as $language) {
            $QuoteDetail = QuoteDetail::whereLanguageId($language->id)->whereQuoteId($Quote->id)->exists();
            if ($QuoteDetail) {
                QuoteDetail::whereLanguageId($language->id)->whereQuoteId($Quote->id)->update([
                    'quote_id' => $Quote->id,
                    'language_id' => $language->id,
                    'quote' => $request['quote']['quote_' . $language->id],
                    'slug' => Str::slug($request['quote']['quote_' . $language->id]),
                ]);
            } 
            // else {
            //     QuoteDetail::create([
            //         'quote_id' => $Quote->id,
            //         'language_id' => $language->id,
            //         'quote' => $request['quote']['quote_' . $language->id],
            //         'slug' => Str::slug($request['quote']['quote_' . $language->id]),
            //     ]);
            // }
        }

        if ($Quote) {
            return $this->apiSuccessResponse(new QuoteResource($Quote), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }

    public function destroy(Request $request, Quote $Quote)
    {
        if ($Quote->QuoteDetail()->delete() && $Quote->delete()) {
            return $this->apiSuccessResponse(new QuoteResource($Quote), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($quotes)
    {
        $defaultLang = getDefaultLanguage();
        $quotes = $quotes->with(['quoteDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withQuoteDetail']) && $_GET['withQuoteDetail'] == '1') {
            $quotes = $quotes->with('quoteDetail');
        }
        return $quotes;
    }

    protected function sortingAndLimit($quotes)
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
        $quotes = $quotes->addSelect([
            'quote' => function ($query) {
                $query->select('quote')
                    ->from('quote_details')
                    ->whereColumn('quote_details.quote_id', 'quotes.id')
                    ->limit(1);
            }
        ])->orderBy('quote', 'ASC');

        return $quotes->paginate($limit);
    }

    protected function whereClause($quotes)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $quotes = $quotes->whereHas('quoteDetail', function ($q) {
                $q->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $quotes;
    }
}
