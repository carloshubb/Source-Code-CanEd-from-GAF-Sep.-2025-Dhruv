<?php
namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolOverviewResource;
use App\Models\SchoolOverview;
use App\Models\SchoolOverviewDetail;
use App\Rules\YoutubeUrl;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SchoolOverviewController extends Controller
{
    use StatusResponser;

    public function index()
    {
        if (isset($_GET['is_admin'])) {
            $school = SchoolOverview::where('school_id', $_GET['school_id'])
                ->with('schoolOverviewDetail')
                ->first();
        } else {
            $customer = auth()
                ->guard('customers')
                ->user();
            $school = SchoolOverview::where('customer_id', $customer->id)
                ->with('schoolOverviewDetail')
                ->first();
        }

        return $this->successResponse(new SchoolOverviewResource($school), 'Data get successfully.');
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['blog_pre_description.blog_pre_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['blog_pre_description.blog_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['blog_post_description.blog_post_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['programs_pre_description.programs_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $errorMessages = array_merge($errorMessages, ['programs_post_description.programs_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);
            }
        }
        $validationRule = array_merge($validationRule, ['display_blog' => ['nullable', 'boolean']]);
        if(isset($request->display_blog) && $request->display_blog == true){
            $validationRule = array_merge($validationRule, ['number_of_blog_posts' => ['required', 'integer', 'min:1']]);
            $validationRule = array_merge($validationRule, ['blog_posts_order' => ['required', 'in:random,latest']]);
            
        }
        $validationRule = array_merge($validationRule, ['video_url' => ['required', new YoutubeUrl()]]);
        $this->validate($request, $validationRule, $errorMessages);
        $fields = [
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
            'display_blog' => $request->display_blog ?? 0,
            'number_of_blog_posts' => $request->number_of_blog_posts ?? 0,
            'blog_posts_order' => $request->blog_posts_order ?? null,
            'video_url' => $request->video_url ?? null,
            'school_overviews_apply_button_title' => $request->school_overviews_apply_button_title ?? null,
            'school_overviews_apply_button_link' => $request->school_overviews_apply_button_link ?? null,
            'school_overviews_blue_bar_button_title' => $request->school_overviews_blue_bar_button_title ?? null,
            'school_overviews_blue_bar_button_link' => $request->school_overviews_blue_bar_button_link ?? null,
            'school_overviews_red_bar_button_title' => $request->school_overviews_red_bar_button_title ?? null,
            'school_overviews_red_bar_button_link' => $request->school_overviews_red_bar_button_link ?? null,
            'video_iframe' => isset($request->video_url) ? getVideoHtmlAttribute($request->video_url) : null,
        ];
        $school = SchoolOverview::whereCustomerId($request->customer_id)->first();
        if ($school) {
            $school->update($fields);
            // dd($school);
        } else {
            $school = SchoolOverview::create($fields);
        }

        $school->touch();
        foreach ($languages as $language) {
            if (!empty($request['blog_pre_description']['blog_pre_description_' . $language->abbreviation])) {
                $schoolDetail = SchoolOverviewDetail::whereLanguageCode($language->abbreviation)
                    ->whereSchoolOverviewId($school->id)
                    ->exists();
                $fields = [
                    'blog_pre_description' => $request['blog_pre_description']['blog_pre_description_' . $language->abbreviation],
                    'blog_post_description' => $request['blog_post_description']['blog_post_description_' . $language->abbreviation],
                    'programs_pre_description' => $request['programs_pre_description']['programs_pre_description_' . $language->abbreviation],
                    'programs_post_description' => $request['programs_post_description']['programs_post_description_' . $language->abbreviation],
                ];
                if ($schoolDetail) {
                    SchoolOverviewDetail::whereLanguageCode($language->abbreviation)
                        ->whereSchoolOverviewId($school->id)
                        ->update($fields);
                } else {
                    $fields = array_merge($fields, ['school_overview_id' => $school->id]);
                    $fields = array_merge($fields, ['language_code' => $language->abbreviation]);
                    SchoolOverviewDetail::create($fields);
                }
            }
        }

        if ($school) {
            return $this->apiSuccessResponse(new SchoolOverviewResource($school), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
