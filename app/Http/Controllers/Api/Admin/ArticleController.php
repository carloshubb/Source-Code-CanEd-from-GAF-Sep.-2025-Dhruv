<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ArticleResource;
use App\Http\Resources\Admin\SuggestedArticleResource;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\ArticleDetail;
use App\Models\Customer;
use App\Jobs\SuggestedArticleEmailJob;
use App\Models\Language;
use App\Models\SuggestedArticle;
use App\Models\User;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use App\Rules\MaxKeywords;
use App\Rules\ValidUrlFormat;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $articles = Article::query();

        $articles = $this->whereClause($articles);
        $articles = $this->loadRelations($articles);
        $articles = $this->sortingAndLimit($articles);

        return $this->apiSuccessResponse(ArticleResource::collection($articles), 'Data Get Successfully!');
    }

    public function show(Article $Article)
    {
        if (isset($_GET['withArticleDetail']) && $_GET['withArticleDetail'] == '1') {
            $Article = $Article->loadMissing('articleDetail');
        }

        // dd($Article);
        return $this->apiSuccessResponse(new ArticleResource($Article), 'Data Get Successfully!');
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
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.required' => 'Short description is required']);

            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:50']]);
            $errorMessages = array_merge($errorMessages, [
                'short_description.short_description_' . $language->id . '.required' => 'Short description is required.',
                'short_description.short_description_' . $language->id . '.maxwords' => 'Please limit your short description to 50 words.'
            ]);


            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'maxwords:2000']]);
            $errorMessages = array_merge($errorMessages, [
                'description.description_' . $language->id . '.required' => 'Description is required.',
                'description.description_' . $language->id . '.maxwords' => 'Please limit your short description to 2000 words.'
            ]);
        }
        $validationRule = array_merge($validationRule, ['article_image' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['article_image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['article_category_id' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['article_category_id.required' => 'Article category is required']);
        $validationRule = array_merge($validationRule, ['type' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['type.required' => 'Category type is required']);

        $validationRule = array_merge($validationRule, ['keyword' => ['required', 'string', new MaxKeywords]]);
        $errorMessages = array_merge(
            $errorMessages,
            [
                'keyword.required' => 'Keywords are required',
            ]
        );

        $this->validate($request, $validationRule, $errorMessages);
        // $media = json_decode($request->article_image, 1);
        // $files = $this->moveFile($media, 'media/images', 'article_image');

        if (isset($request->article_image)) {
            $media = json_decode($request->article_image, true);
            // dd($media);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'article_image');
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } else {
            return response()->json(['error' => 'No article category image provided'], 400);
        }
        if (isset($request->is_web)) {
            $customer_id = json_decode($request->customer_id, true);
            $customer = Customer::where('id', $customer_id['id'])->first();
            if ($customer->user_type == 'school' || $customer->user_type == 'business') {
                $count = Article::where('customer_id', $customer_id)->count();

                if ($customer->payment_frequency == 'annually') {
                    $allowedArticles = $customer->registrationPackage->articles * 12;
                } elseif ($customer->payment_frequency == 'semi_annually') {
                    $allowedArticles = $customer->registrationPackage->articles * 6;
                } elseif ($customer->payment_frequency == 'quarterly') {
                    $allowedArticles = $customer->registrationPackage->articles * 3;
                } else {
                    $allowedArticles = $customer->registrationPackage->articles;
                }

                if ($allowedArticles <= $count) {
                    return $this->errorResponse('Form submission limit exceeded. Please try again later.');
                }
            }
            $Article = Article::create([
                'article_image' => isset($files, $files[0]) ? $files[0]->id : null,
                'article_category' => $request->article_category_id,
                'original_source' => $request->original_source,
                'name_title' => $request->name_title,
                'organization' => $request->organization,
                'type' => $request->type,
                'website' => $request->website,
                'created_by' => Auth::id(),
                'customer_id' => $customer_id['id'],
                'school_id' => $request->school_id,
                'keyword' => $request->keyword,

            ]);
        } else {
            $Article = Article::create([
                'article_image' => isset($files, $files[0]) ? $files[0]->id : null,
                'article_category' => $request->article_category_id,
                // 'article_category_id' => $request->article_category_id,  
                'original_source' => $request->original_source,
                'name_title' => $request->name_title,
                'organization' => $request->organization,
                'type' => $request->type,
                'website' => $request->website,
                'keyword' => $request->keyword,
                'created_by' => Auth::id(),
            ]);
        }

        if ($Article) {
            foreach ($languages as $language) {
                // Ensure there's valid data before creating an ArticleDetail entry
                $name = $request['name']['name_' . $language->id] ?? null;
                $shortDescription = $request['short_description']['short_description_' . $language->id] ?? null;
                $description = $request['description']['description_' . $language->id] ?? null;

                // Skip creating ArticleDetail if all fields are null
                if ($name || $shortDescription || $description) {
                    ArticleDetail::create([
                        'article_id' => $Article->id,
                        'language_id' => $language->id,
                        'name' => $name,
                        'slug' => $name ? Str::slug($name) : null,
                        'description' => $description,
                        'short_description' => $shortDescription,
                    ]);
                }
            }

            return $this->apiSuccessResponse(new ArticleResource($Article), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Article $Article)
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
            $errorMessages = array_merge($errorMessages, [
                'short_description.short_description_' . $language->id . '.required' => 'Short description is required.',
                'short_description.short_description_' . $language->id . '.maxwords' => 'Please limit your short description to 50 words.'
            ]);


            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'maxwords:2000']]);
            $errorMessages = array_merge($errorMessages, [
                'description.description_' . $language->id . '.required' => 'Description is required.',
                'description.description_' . $language->id . '.maxwords' => 'Please limit your short description to 2000 words.'
            ]);
        }
        $validationRule = array_merge($validationRule, ['article_image' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['article_image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['article_category_id' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['article_category_id.required' => 'Article category is required']);
        $validationRule = array_merge($validationRule, ['type' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['type.required' => 'Category type is required']);
        $this->validate($request, $validationRule, $errorMessages);

        $validationRule = array_merge($validationRule, ['keyword' => ['required', 'string', new MaxKeywords]]);
        $errorMessages = array_merge(
            $errorMessages,
            [
                'keyword.required' => 'Keywords are required',
            ]
        );

        if ($request->has('article_image') && !empty($request->article_image)) {
            $media = is_array($request->article_image)
                ? $request->article_image
                : json_decode($request->article_image, true);

            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'article_image');

                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files = $existingImagePath ?? null;
            }
        } else {
            $files = $existingImagePath ?? null;
        }
        $Article->update([
            'article_image' => !isset($request->article_image) ? null : (isset($files, $files[0]) ? $files[0]->id : $Article->article_image),
            'article_category' => $request->article_category_id,
            'original_source' => $request->original_source,
            'name_title' => $request->name_title,
            'organization' => $request->organization,
            'type' => $request->type,
            'website' => $request->website,
            'updated_by' => Auth::id(),
            'product_search' => $request->product_search,
            'keyword' => $request->keyword,
        ]);


        foreach ($languages as $language) {
            $name = $request['name']['name_' . $language->id] ?? null;
            $shortDescription = $request['short_description']['short_description_' . $language->id] ?? null;
            $description = $request['description']['description_' . $language->id] ?? null;

            // Skip if no meaningful data is provided
            if ($name || $shortDescription || $description) {
                ArticleDetail::updateOrCreate(
                    [
                        'article_id' => $Article->id,
                        'language_id' => $language->id,
                    ],
                    [
                        'name' => $name,
                        'slug' => $name ? Str::slug($name) : null,
                        'description' => $description,
                        'short_description' => $shortDescription,
                    ]
                );
            }
        }

        if ($Article) {
            return $this->apiSuccessResponse(new ArticleResource($Article), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }

    public function destroy(Request $request, Article $Article)
    {
        if ($Article->ArticleDetail()->delete() && $Article->delete()) {
            return $this->apiSuccessResponse(new ArticleResource($Article), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($articles)
    {
        $defaultLang = getDefaultLanguage();
        $articles = $articles->with([
            'articleDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },

        ]);
        if (isset($_GET['withArticleDetail']) && $_GET['withArticleDetail'] == '1') {
            $articles = $articles->with('articleDetail');
        }
        return $articles;
    }

    protected function sortingAndLimit($articles)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'article_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {

            $defaultLang = getDefaultLanguage();
            $articles = $articles->addSelect(['article_name' => ArticleDetail::whereColumn('articles.id', 'article_details.article_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);


            $articles = $articles->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $articles->paginate($limit);
    }

    protected function whereClause($articles)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $articles = $articles->whereHas('articleDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $articles;
    }

    // public function storeSuggestedArticle(Request $request)
    // {
    //     $validationRule = [];
    //     $errorMessages = [];
    //     $languages = getAllLanguages();
    //     foreach ($languages as $language) {
    //         $requiredVal = 'nullable';
    //         if ($language->is_default == '1') {
    //             $requiredVal = 'required';
    //         }
    //         $validationRule = array_merge($validationRule, ['suggested_article' => [$requiredVal, 'string','url', new CheckCategorySlug($language, null)]]);
    //         $errorMessages = array_merge($errorMessages, ['suggested_article' . '.url' => getStaticTranslation('post_article_modal')['suggest_article_error_message']]);

    //     }

    //     $this->validate($request, $validationRule, $errorMessages);



    //         $Article = SuggestedArticle::create([
    //             'suggested_article' => $request->suggested_article,
    //         ]);


    //     return $this->errorResponse();
    // }
    public function storeSuggestedArticle(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();

        foreach ($languages as $language) {
            $requiredVal = $language->is_default == '1' ? 'required' : 'nullable';

            $validationRule = array_merge($validationRule, [
                'suggested_article' => [$requiredVal, 'string', new ValidUrlFormat(), new CheckCategorySlug($language, null)]
            ]);

            $errorMessages = array_merge($errorMessages, [
                'suggested_article' => getStaticTranslation('post_article_modal')['suggest_article_error_message']
            ]);
        }

        $this->validate($request, $validationRule, $errorMessages);

        $article = SuggestedArticle::create([
            'suggested_article' => $request->suggested_article,
        ]);

        $adminEmail = User::first()->email;
        // Prepare email data
        $emailData = [
            // 'suggested_article' => $article->suggested_article,
            'suggested_article' => $article->suggested_article,
            'email' => $adminEmail,
        ];

        // Dispatch email job
        dispatch(new SuggestedArticleEmailJob($emailData));

        return $this->successResponse('', 'Your suggested article has been submitted successfully!');
    }

    public function suggestedArticles(Request $request)
    {
        $articles = SuggestedArticle::query();

        if (isset($request->search) && $request->search != '') {
            $articles = $articles->where('suggested_article', $request->search);
        }


        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'article_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {

            $defaultLang = getDefaultLanguage();
            $articles = $articles->addSelect(['article_name' => ArticleDetail::whereColumn('articles.id', 'article_details.article_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);


            $articles = $articles->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }
        // if (isset($request->limit) && $request->limit != '') {
        //     $limit = $request->limit;
        // } else {
        //     $limit = 10;
        // }
        $limit = 10; // default
        if (isset($request->limit) && $request->limit != '') {
            $limit = (int)$request->limit;
        }

        $articles = $articles->paginate($limit);
        return $this->apiSuccessResponse(SuggestedArticleResource::collection($articles), 'Data Get Successfully!');
    }
    public function destroySuggestedArticle(Request $request)
    {
        $articleId = $request->input('article');
        $article = SuggestedArticle::where('id', $articleId)->first();

        if ($article) {
            if ($article->delete()) {
                return $this->apiSuccessResponse(new SuggestedArticleResource($article), 'The selected item has been deleted successfully');
            }
        }

        return $this->errorResponse('Failed to delete the article.');
    }
}
