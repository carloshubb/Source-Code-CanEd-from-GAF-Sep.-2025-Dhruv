<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\BlogResource;
use App\Models\Blog;
use App\Models\BlogDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $blog = Blog::query();

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'blog_title'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $blog = $blog->addSelect(['blog_title' => BlogDetail::whereColumn('blogs.id', 'blog_detail.blog_id')->whereLanguageId($defaultLang->id)->select('title')->limit(1)]);

            $blog = $blog->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['is_admin'])) {
            $blog = $blog->where('school_id', $_GET['school_id'])
                ->with('blogDetail')
                ->get();
        } else {
            $customer = auth()
                ->guard('customers')
                ->user();
            $customerId = $customer->id;
            $blog = $blog->where('school_id', $_GET['school_id'])
                ->with('blogDetail')
                ->get();
        }

        return $this->successResponse(isset($blog) ? BlogResource::collection($blog) : null, 'Data get successfully.');
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['title.title_' . $language->id => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'This field is required.']);
                // $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => ['required', 'string']]);
                // $errorMessages = array_merge($errorMessages, ['short_description.short_description_' . $language->id . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, [
                    'short_description.short_description_' . $language->id => [
                        'required',
                        'string',
                        function ($attribute, $value, $fail) {
                            $plainText = trim(strip_tags(html_entity_decode($value)));
                
                            if (str_word_count($plainText) > 30) {
                                $fail('Only 30 words are allowed for the short description.');
                            }
                        }
                    ]
                ]);
                
                $errorMessages = array_merge($errorMessages, [
                    'short_description.short_description_' . $language->id . '.required' => 'This field is required.',
                ]);
                
                // $validationRule = array_merge($validationRule, ['detail_description.detail_description_' . $language->id => ['required', 'string']]);
                // $errorMessages = array_merge($errorMessages, ['detail_description.detail_description_' . $language->id . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, [
                    'detail_description.detail_description_' . $language->id => [
                        'required',
                        'string',
                        function ($attribute, $value, $fail) {
                            $plainText = trim(strip_tags(html_entity_decode($value)));
                
                            if (str_word_count($plainText) > 300) {
                                $fail('Only 300 words are allowed for the detail description.');
                            }
                        }
                    ]
                ]);
                
                $errorMessages = array_merge($errorMessages, [
                    'detail_description.detail_description_' . $language->id . '.required' => 'This field is required.',
                ]);
                $validationRule = array_merge($validationRule, ['category_name.category_name_' . $language->id => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['category_name.category_name_' . $language->id . '.required' => 'This field is required.']);
            }
        }
        $this->validate($request, $validationRule, $errorMessages);
        $fields = [
            'school_id' => $request->school_id,
            'image' => isset($request->image) && is_array($request->image) ? implode(',', $request->image) : null,
            'publised_at' => date('Y-m-d'),
        ];
        if (isset($request->id)) {
            Blog::whereId($request->id)->update($fields);
            $blog = Blog::whereId($request->id)->first();
        } else {
            $blog = Blog::create($fields);
        }

        $blog->touch();
        foreach ($languages as $language) {
            if (!empty($request['title']['title_' . $language->id])) {
                $blogDetail = BlogDetail::whereLanguageId($language->id)
                    ->whereBlogId($blog->id)
                    ->exists();
                $fields = [
                    'title' => $request['title']['title_' . $language->id],
                    'short_description' => $request['short_description']['short_description_' . $language->id],
                    'detail_description' => $request['detail_description']['detail_description_' . $language->id],
                    'category_name' => $request['category_name']['category_name_' . $language->id],
                ];
                if ($blogDetail) {
                    BlogDetail::whereLanguageId($language->id)
                        ->whereBlogId($blog->id)
                        ->update($fields);
                } else {
                    $fields = array_merge($fields, ['blog_id' => $blog->id]);
                    $fields = array_merge($fields, ['language_id' => $language->id]);
                    BlogDetail::create($fields);
                }
            }
        }

        if ($blog) {
            return $this->apiSuccessResponse(new BlogResource($blog), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, $blogId)
    {
        $blog = Blog::find($blogId);
        if ($blog->blogDetail()->delete() && $blog->delete()) {
            return $this->apiSuccessResponse(new BlogResource($blog), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }
}
