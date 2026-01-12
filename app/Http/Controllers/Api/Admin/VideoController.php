<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\VideoResource;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\Video;
use App\Models\VideoDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $videos = Video::query();

        $videos = $this->whereClause($videos);
        $videos = $this->loadRelations($videos);
        $videos = $this->sortingAndLimit($videos);

        return $this->apiSuccessResponse(VideoResource::collection($videos), 'Data Get Successfully!');
    }


    public function show(Video $Video)
    {
        if (isset($_GET['withVideoDetail']) && $_GET['withVideoDetail'] == '1') {
            $Video = $Video->loadMissing('videoDetail');
        }

        return $this->apiSuccessResponse(new VideoResource($Video), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title is required']);
        }
        $validationRule = array_merge($validationRule, ['link' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['link.required' => 'Link is required']);

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        if (isset($request->is_web)) {
            $Video = Video::create([
                'status' => $request->status,
                'featured' => 'no',
                'link' => $request->link,
                'show_on_home_page' => 'no',
                'customer_id' => $request->customer_id,
            ]);
        } else {
            $Video = Video::create([
                'status' => $request->status,
                'featured' => 'no',
                'link' => $request->link,
                'show_on_home_page' => 'no',
            ]);
        }


        if ($Video) {
            foreach ($languages as $language) {
                VideoDetail::create([
                    'video_id' => $Video->id,
                    'language_id' => $language->id,
                    'description' => $request['description']['description_' . $language->id],
                    'title' => $request['title']['title_' . $language->id],
                    'slug' => Str::slug($request['title']['title_' . $language->id]),
                ]);
            }
            return $this->apiSuccessResponse(new VideoResource($Video), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Video $Video)
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
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $Video->id)]]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $Video->id)]]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title is required']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );


        $Video->update([
            'status' => $request->status,
            'featured' => $request->featured,
            'link' => $request->link,
            'show_on_home_page' => $request->show_on_home_page,

        ]);
        foreach ($languages as $language) {
            $VideoDetail = VideoDetail::whereLanguageId($language->id)->whereVideoId($Video->id)->exists();
            if ($VideoDetail) {
                VideoDetail::whereLanguageId($language->id)->whereVideoId($Video->id)->update([
                    'video_id' => $Video->id,
                    'language_id' => $language->id,
                    'description' => $request['description']['description_' . $language->id],
                    'title' => $request['title']['title_' . $language->id],
                    'slug' => Str::slug($request['title']['title_' . $language->id]),
                ]);
            }
             else {
                VideoDetail::create([
                    'video_id' => $Video->id,
                    'language_id' => $language->id,
                    'description' => $request['description']['description_' . $language->id],
                    'title' => $request['title']['title_' . $language->id],
                    'slug' => Str::slug($request['title']['title_' . $language->id]),
                ]);
            }
        }

        if ($Video) {
            return $this->apiSuccessResponse(new VideoResource($Video), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, Video $Video)
    {
        if ($Video->videoDetail()->delete() && $Video->delete()) {
            return $this->apiSuccessResponse(new VideoResource($Video), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($videos)
    {
        $defaultLang = getDefaultLanguage();
        $videos = $videos->with(['videoDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withVideoDetail']) && $_GET['withVideoDetail'] == '1') {
            $videos = $videos->with('videoDetail');
        }
        return $videos;
    }

    protected function sortingAndLimit($videos)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'title', 'abbreviation', 'video_title'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $videos = $videos->addSelect(['video_title' => VideoDetail::whereColumn('videos.id', 'video_details.video_id')->whereLanguageId($defaultLang->id)->select('title')->limit(1)]);


            $videos = $videos->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $videos->paginate($limit);
    }

    protected function whereClause($videos)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $videos = $videos->whereHas('videoDetail', function ($q) {
                $q->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $videos;
    }
}
