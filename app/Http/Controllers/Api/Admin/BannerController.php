<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BannerResource;
use Illuminate\Support\Str;
use App\Models\Banner;
use App\Models\BannerDetail;
use App\Models\Language;

use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $banners = Banner::whereNull('short_code')->get();

        foreach ($banners as $key => $banner) {
            $banner->update([
                'short_code' => '[short_code=widget-' . rand(1, 1000000) . ']',
            ]);
        }

        $banners = Banner::query();

        $banners = $this->whereClause($banners);
        $banners = $this->loadRelations($banners);
        $banners = $this->sortingAndLimit($banners);

        return $this->apiSuccessResponse(BannerResource::collection($banners), 'Data Get Successfully!');
    }


    public function show(Banner $Banner)
    {
        if (isset($_GET['withBannerDetail']) && $_GET['withBannerDetail'] == '1') {
            $Banner = $Banner->loadMissing('BannerDetail');
        }

        return $this->apiSuccessResponse(new BannerResource($Banner), 'Data Get Successfully!');
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
            $validationRule = array_merge($validationRule, ['banner_description.banner_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['banner_description.banner_description_' . $language->id . '.required' => 'Banner description is required']);
            $validationRule = array_merge($validationRule, ['banner_button_text.banner_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['banner_button_text.banner_button_text_' . $language->id . '.required' => 'Banner button text is required']);
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Banner title is required']);
        }

        $validationRule = array_merge($validationRule, ['banner_type' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['banner_type.required' => 'Banner type is required']);
        $validationRule = array_merge($validationRule, ['banner_button_link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['banner_button_link.required' => 'Banner button link  is required']);
        $validationRule = array_merge($validationRule, ['banner_image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['banner_image.required' => 'Banner image is required']);
        $validationRule = array_merge($validationRule, ['banner_image_2' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['banner_image_2.required' => 'Banner image 2 is required']);

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        if (isset($request->banner_image)) {
            $media = json_decode($request->banner_image, true);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'banner_image');
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } else {
            return response()->json(['error' => 'No article category image provided'], 400);
        }

        if (isset($request->banner_image_2)) {
            $media = json_decode($request->banner_image_2, true);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files2 = $this->moveFile($media['media'], 'media/images', 'banner_image_2');
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } else {
            return response()->json(['error' => 'No article category image provided'], 400);
        }

        $Banner = Banner::create([
            'banner_image' => isset($files, $files[0]) ? $files[0]->id : null,
            'banner_image_2' => isset($files2, $files2[0]) ? $files2[0]->id : null,
            'short_code' => '[short_code=widget-' . rand(1, 1000000) . ']',
            'banner_type' => $request->banner_type,
            'banner_button_link' => $request->banner_button_link
        ]);


        if ($Banner) {
            foreach ($languages as $language) {
                BannerDetail::create([
                    'banner_id' => $Banner->id,
                    'language_id' => $language->id,
                    'banner_description' => $request['banner_description']['banner_description_' . $language->id],
                    'banner_button_text' => $request['banner_button_text']['banner_button_text_' . $language->id],
                    'title' => $request['title']['title_' . $language->id],
                ]);
            }
            return $this->apiSuccessResponse(new BannerResource($Banner), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Banner $Banner)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['banner_description.banner_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['banner_description.banner_description_' . $language->id . '.required' => 'Banner description is required']);
            $validationRule = array_merge($validationRule, ['banner_button_text.banner_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['banner_button_text.banner_button_text_' . $language->id . '.required' => 'Banner button text is required']);
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Banner button text is required']);
        }

        $validationRule = array_merge($validationRule, ['banner_type' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['banner_type.required' => 'Banner type is required']);
        $validationRule = array_merge($validationRule, ['banner_button_link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['banner_button_link.required' => 'Banner button link  is required']);
        $validationRule = array_merge($validationRule, ['banner_image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['banner_image.required' => 'Banner image  is required']);
        $validationRule = array_merge($validationRule, ['banner_image_2' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['banner_image_2.required' => 'Banner image 2  is required']);

        if ($request->has('banner_image') && !empty($request->banner_image)) {
            $media = is_array($request->banner_image)
                ? $request->banner_image
                : json_decode($request->banner_image, true);

            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'banner_image');

                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files = $existingImagePath ?? null;
            }
        } else {
            $files = $existingImagePath ?? null;
        }
        if ($request->has('banner_image_2') && !empty($request->banner_image_2)) {
            $media = is_array($request->banner_image_2)
                ? $request->banner_image_2
                : json_decode($request->banner_image_2, true);

            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files2 = $this->moveFile($media['media'], 'media/images', 'banner_image_2');

                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files2 = $existingImagePath ?? null;
            }
        } else {
            $files2 = $existingImagePath ?? null;
        }

        $Banner->update([
            'banner_image' => !isset($request->banner_image) ? null : (isset($files, $files[0]) ? $files[0]->id : $Banner->banner_image),
            'banner_image_2' => !isset($request->banner_image_2) ? null : (isset($files2, $files2[0]) ? $files2[0]->id : $Banner->banner_image_2),
            'banner_type' => $request['banner_type'],
            'banner_button_link' => $request['banner_button_link'],
        ]);
        foreach ($languages as $language) {
            $BannerDetail = BannerDetail::whereLanguageId($language->id)->whereBannerId($Banner->id)->exists();
            if ($BannerDetail) {
                BannerDetail::whereLanguageId($language->id)->whereBannerId($Banner->id)->update([
                    'banner_description' => $request['banner_description']['banner_description_' . $language->id],
                    'banner_button_text' => $request['banner_button_text']['banner_button_text_' . $language->id],
                    'title' => $request['title']['title_' . $language->id],
                ]);
            } else {
                BannerDetail::create([
                    'banner_id' => $Banner->id,
                    'language_id' => $language->id,
                    'title' => $request['title']['title_' . $language->id],
                    'banner_description' => $request['banner_description']['banner_description_' . $language->id],
                    'banner_button_text' => $request['banner_button_text']['banner_button_text_' . $language->id],
                ]);
            }
        }

        if ($Banner) {
            return $this->apiSuccessResponse(new BannerResource($Banner), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, Banner $Banner)
    {
        if ($Banner->BannerDetail()->delete() && $Banner->delete()) {
            return $this->apiSuccessResponse(new BannerResource($Banner), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }

    protected function loadRelations($banners)
    {
        $defaultLang = getDefaultLanguage();
        $banners = $banners->with(['BannerDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withBannerDetail']) && $_GET['withBannerDetail'] == '1') {
            $banners = $banners->with('BannerDetail');
        }
        return $banners;
    }

    protected function sortingAndLimit($banners)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'banner_name', 'banner_type'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $banners = $banners->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $banners->paginate($limit);
    }

    protected function whereClause($banners)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $banners = $banners->whereHas('BannerDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $banners;
    }
}
