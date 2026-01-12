<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\StoryResource;
use Illuminate\Support\Str;
use App\Models\Story;
use App\Models\StoryDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $stories = Story::query();

        $stories = $this->whereClause($stories);
        $stories = $this->loadRelations($stories);
        $stories = $this->sortingAndLimit($stories);

        return $this->apiSuccessResponse(StoryResource::collection($stories), 'Data Get Successfully!');
    }

    public function show(Story $Story)
    {
        if (isset($_GET['withStoryDetail']) && $_GET['withStoryDetail'] == '1') {
            $Story = $Story->loadMissing('storyDetail');
        }

        return $this->apiSuccessResponse(new StoryResource($Story), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $defaultLang = getDefaultLanguage(1);
        if (isset($request->is_web) && $request->is_web == 1) {
            // $validationRule = array_merge($validationRule, ['title.title_' . $defaultLang->id => ['required', 'string']]);
            // $errorMessages = array_merge($errorMessages, ['title.title_' . $defaultLang->id . '.required' => 'Title is required']);
            // $validationRule = array_merge($validationRule, ['story.story_' . $defaultLang->id => ['required', 'string']]);
            // $errorMessages = array_merge($errorMessages, ['story.story_' . $defaultLang->id . '.required' => 'Story is required']);
            $validationRule = array_merge($validationRule, [
                'title.title_' . $defaultLang->id => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        $plainText = trim(strip_tags(html_entity_decode($value))); 
                        if (str_word_count($plainText) > 10) {
                            $fail('Only 10 words are allowed for the title.');
                        }
                    }
                ]
            ]);
            
            $errorMessages = array_merge($errorMessages, [
                'title.title_' . $defaultLang->id . '.required' => 'Title is required.'
            ]);
            $validationRule = array_merge($validationRule, [
                'story.story_' . $defaultLang->id => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        $plainText = trim(strip_tags(html_entity_decode($value))); 
                        if (str_word_count($plainText) > 1000) {
                            $fail('Only 1000 words are allowed for the story.');
                        }
                    }
                ]
            ]);
            
            $errorMessages = array_merge($errorMessages, [
                'story.story_' . $defaultLang->id . '.required' => 'story is required.'
            ]);
        }
        else{
            foreach ($languages as $language) {
                $requiredVal = 'nullable';
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                }
                $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
                $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title is required']);
                $validationRule = array_merge($validationRule, ['story.story_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
                $errorMessages = array_merge($errorMessages, ['story.story_' . $language->id . '.required' => 'Story is required']);
            }
        }
    
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
       
        $validationRule = array_merge($validationRule, ['student_name' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['student_name.required' => 'Student name is required']);
        $validationRule = array_merge($validationRule, ['email' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['email.required' => 'email is required']);

        $this->validate($request, $validationRule, $errorMessages);
        // $media = json_decode($request->image, 1);
        // $files = $this->moveFile($media, 'media/images', 'story_image');
        
        if (isset($request->image)) {
            $media = json_decode($request->image, true);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'image');
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } else {
            return response()->json(['error' => 'No image provided'], 400);
        }

        $Story = Story::create([
            'image' => isset($files, $files[0]) ? $files[0]->id : null,
            'student_name' => $request->student_name,
            'email' => $request->email,
            'country_of_origin' => $request->country_of_origin,
        ]);

        if ($Story) {
            // foreach ($languages as $language) {
                $language = getAllLanguages()->first();
                StoryDetail::create([
                    'story_id' => $Story->id,
                    'language_id' => $language->id,
                    'title' => $request['title']['title_' . $language->id] ?? null,
                    'story' => $request['story']['story_' . $language->id] ?? null,
                    'slug' => isset($request['title']['title_' . $language->id]) ? Str::slug($request['title']['title_' . $language->id]) : null,
                ]);
            // }
            return $this->apiSuccessResponse(new StoryResource($Story), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Story $Story)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title is required']);
            $validationRule = array_merge($validationRule, ['story.story_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['story.story_' . $language->id . '.required' => 'Story is required']);
        }
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        $validationRule = array_merge($validationRule, ['student_name' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['student_name.required' => 'Student name is required']);

        $this->validate($request, $validationRule, $errorMessages);

        if ($request->has('image') && !empty($request->image)) {
            $media = is_array($request->image)
                ? $request->image
                : json_decode($request->image, true);
        
            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'image');
        
                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files = $existingImagePath ?? null;
            }
        } else {
            $files = $existingImagePath ?? null;
        }

        $Story->update([
            'image' => !isset($request->image) ? null : (isset($files, $files[0]) ? $files[0]->id : $Story->image),
            'student_name' => $request->student_name,
            'email' => $request->email,
            'country_of_origin' => $request->country_of_origin,
        ]);
        foreach ($languages as $language) {
            $StoryDetail = StoryDetail::whereLanguageId($language->id)
                ->whereStoryId($Story->id)
                ->exists();
            if ($StoryDetail) {
                StoryDetail::whereLanguageId($language->id)
                    ->whereStoryId($Story->id)
                    ->update([
                        'title' => $request['title']['title_' . $language->id],
                        'story' => $request['story']['story_' . $language->id],
                        'slug' => Str::slug($request['title']['title_' . $language->id]),
                    ]);
            } else {
                // StoryDetail::create([
                //     'story_id' => $Story->id,
                //     'language_id' => $language->id,
                //     'title' => $request['title']['title_' . $language->id] ?? null,
                //     'story' => $request['story']['story_' . $language->id] ?? null,
                //     'slug' => isset($request['title']['title_' . $language->id]) ? Str::slug($request['title']['title_' . $language->id]) : null,
                // ]);
            }
        }

        if ($Story) {
            return $this->apiSuccessResponse(new StoryResource($Story), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }
    public function destroy(Request $request, Story $Story)
    {
        if ($Story->StoryDetail()->delete() && $Story->delete()) {
            return $this->apiSuccessResponse(new StoryResource($Story), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($stories)
    {
        $defaultLang = getDefaultLanguage();
        $stories = $stories->with([
            'storyDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withStoryDetail']) && $_GET['withStoryDetail'] == '1') {
            $stories = $stories->with('storyDetail');
        }
        return $stories;
    }

    protected function sortingAndLimit($stories)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'title', 'abbreviation', 'story_title'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $stories = $stories->addSelect(['story_title' => StoryDetail::whereColumn('stories.id', 'story_details.story_id')->whereLanguageId($defaultLang->id)->select('title')->limit(1)]);

            $stories = $stories->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $stories->paginate($limit);
    }

    protected function whereClause($stories)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $stories = $stories->whereHas('storyDetail', function ($q) {
                $q->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $stories;
    }
}
