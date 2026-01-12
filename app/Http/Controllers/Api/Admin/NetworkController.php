<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\NetworkResource;
use Illuminate\Support\Str;
use App\Models\Network;
use App\Models\NetworkDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Services\FomSubmissionCountService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $nwtorks = Network::query();

        $nwtorks = $this->whereClause($nwtorks);
        $nwtorks = $this->loadRelations($nwtorks);
        $nwtorks = $this->sortingAndLimit($nwtorks);

        return $this->apiSuccessResponse(NetworkResource::collection($nwtorks), 'Data Get Successfully!');
    }

    public function show(Network $Network)
    {
        if (isset($_GET['withNetworkDetail']) && $_GET['withNetworkDetail'] == '1') {
            $Network = $Network->loadMissing('networkDetail');
        }

        return $this->apiSuccessResponse(new NetworkResource($Network), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $defaultLang = getDefaultLanguage(1);
        if (isset($request->is_web)) {
            $validationRule = array_merge($validationRule, ['full_name.full_name_' . $defaultLang->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['full_name.full_name_' . $defaultLang->id . '.required' => 'Full name is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $defaultLang->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $defaultLang->id . '.required' => 'Description is required']);
        } else {
            foreach ($languages as $language) {
                $requiredVal = 'nullable';
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                }
                $validationRule = array_merge($validationRule, ['full_name.full_name_' . $language->id => [$requiredVal, 'string']]);
                $errorMessages = array_merge($errorMessages, ['full_name.full_name_' . $language->id . '.required' => 'Full name is required']);
                $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string']]);
                $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        // $errorMessages = array_merge($errorMessages, ['image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['state_province' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['state_province.required' => 'Your location is required']);
        $this->validate($request, $validationRule, $errorMessages);
        if (isset($request->is_web)) {
            $formSubmissionService = new FomSubmissionCountService();
            $result = $formSubmissionService->advertiserForm();
            if ($result['status'] == 'Error') {
                return $result;
            }
        }
        // $media = json_decode($request->image, 1);
        // $files = $this->moveFile($media, 'media/images', 'network_image');

        if (isset($request->image)) {
            $media = json_decode($request->image, true);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'network_image');
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } else {
            return response()->json(['error' => 'No network_image provided'], 400);
        }

        $stateProvince = $request->state_province;
        $parts = explode(',', $stateProvince);
        // Check if both parts exist and trim whitespace
        $state = isset($parts[0]) ? trim($parts[0]) : null;
        $country = isset($parts[1]) ? trim($parts[1]) : null;

        $Network = Network::create([
            'image' => isset($files, $files[0]) ? $files[0]->id : null,
            'banner_location' => $request->banner_location,
            'state_province' => $state,
            'country' => $country,
            'status' => $request->status,
            'customer_id' => isset($request->customer_id) ? $request->customer_id : null,
        ]);

        if ($Network) {
            foreach ($languages as $language) {
                if (isset($request['full_name']['full_name_' . $language->id])) {
                    NetworkDetail::create([
                        'network_id' => $Network->id,
                        'language_id' => $language->id,
                        'full_name' => $request['full_name']['full_name_' . $language->id],
                        'description' => $request['description']['description_' . $language->id],
                        'slug' => Str::slug($request['full_name']['full_name_' . $language->id]),
                    ]);
                }
            }
            return $this->apiSuccessResponse(new NetworkResource($Network), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Network $Network)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['full_name.full_name_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['full_name.full_name_' . $language->id . '.required' => 'Full name is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
        }
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        // $errorMessages = array_merge($errorMessages, ['image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['state_province' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['state_province.required' => 'Your location is required']);
        $this->validate($request, $validationRule, $errorMessages);

        if ($request->has('image') && !empty($request->image)) {
            $media = is_array($request->image)
                ? $request->image
                : json_decode($request->image, true);
        
            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'network_image');
        
                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files = $existingImagePath ?? null;
            }
        } else {
            $files = $existingImagePath ?? null;
        }

        $stateProvince = $request->state_province;
        $parts = explode(',', $stateProvince);
        // Check if both parts exist and trim whitespace
        $state = isset($parts[0]) ? trim($parts[0]) : null;
        $country = isset($parts[1]) ? trim($parts[1]) : null;

        $Network->update([
            'image' => isset($files[0]->id) ? $files[0]->id : $Network->image,
            'banner_location' => $request->banner_location,
            'state_province' => $state,
            'country' => $country,
            'status' => $request->status,
        ]);

        foreach ($languages as $language) {
            $NetworkDetail = NetworkDetail::whereLanguageId($language->id)
                ->whereNetworkId($Network->id)
                ->exists();
        
            $fullNameKey = 'full_name_' . $language->id;
            $descriptionKey = 'description_' . $language->id;
        
            $fullName = $request['full_name'][$fullNameKey] ?? null;
            $description = $request['description'][$descriptionKey] ?? null;
        
            if (is_null($fullName) || is_null($description)) {
                continue;
            }
            if ($NetworkDetail) {
                NetworkDetail::whereLanguageId($language->id)
                    ->whereNetworkId($Network->id)
                    ->update([
                        'network_id' => $Network->id,
                        'language_id' => $language->id,
                        'full_name' => $fullName,
                        'description' => $description,
                        'slug' => Str::slug($fullName),
                    ]);
            } else {
                NetworkDetail::create([
                    'network_id' => $Network->id,
                    'language_id' => $language->id,
                    'full_name' => $fullName,
                    'description' => $description,
                    'slug' => Str::slug($fullName),
                ]);
            }
        }
        
        if ($Network) {
            return $this->apiSuccessResponse(new NetworkResource($Network), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }

    public function destroy(Request $request, Network $Network)
    {
        if ($Network->NetworkDetail()->delete() && $Network->delete()) {
            return $this->apiSuccessResponse(new NetworkResource($Network), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($nwtorks)
    {
        $defaultLang = getDefaultLanguage();
        $nwtorks = $nwtorks->with([
            'networkDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withNetworkDetail']) && $_GET['withNetworkDetail'] == '1') {
            $nwtorks = $nwtorks->with('networkDetail');
        }
        return $nwtorks;
    }

    protected function sortingAndLimit($nwtorks)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'title', 'abbreviation', 'network_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $nwtorks = $nwtorks->addSelect(['network_name' => NetworkDetail::whereColumn('networks.id', 'network_details.network_id')->whereLanguageId($defaultLang->id)->select('full_name')->limit(1)]);


            $nwtorks = $nwtorks->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $nwtorks->paginate($limit);
    }

    protected function whereClause($nwtorks)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $nwtorks = $nwtorks->whereHas('networkDetail', function ($q) {
                $q->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $nwtorks;
    }
}
