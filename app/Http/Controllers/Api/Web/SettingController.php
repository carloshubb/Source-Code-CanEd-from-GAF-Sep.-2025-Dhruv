<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SettingResource;
use App\Models\RegistrationPackage;
use App\Models\Setting;
use App\Services\ZohoService;
use App\Traits\StatusResponser;
use Google\Service\ArtifactRegistry\Package;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $settings = Setting::query();
        if(isset($_GET['type']) && $_GET['type'] != ''){
            $settings = $settings->where('type', $_GET['type']);
        }

        return $this->apiSuccessResponse(SettingResource::collection($settings->get()), 'Data Get Successfully!');
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $packages = RegistrationPackage::all();
        foreach ($packages as $package) {
            $validationRule = array_merge($validationRule, ['form_submission_for_package.form_submission_for_package_' . $package->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['form_submission_for_package.form_submission_for_package_' . $package->id . '.required' => 'Form Sumbission limit is required.']);
        }
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        foreach ($packages as $package) {
            RegistrationPackage::where('id',$package->id)->update([
                'form_submission_count' => $request->form_submission_for_package['form_submission_for_package_' . $package->id]
            ]);
        }
        foreach($request->setting as $setting){
            Setting::whereId($setting['id'])->update(['value' => $setting['value']]);
        }

        return $this->successResponse('', 'Data Update Successfully!');
    }

    public function synchAllWebinars(){
        $zohoService = new ZohoService();
        $zohoService->sycnhAllWebinars();
        sleep(1);
        return $this->successResponse('', 'Webinars has been synchronized successfully.');
    }
}
