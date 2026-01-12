<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ArticlePageSettingResource;
use App\Models\ArticlePageSetting;
use App\Models\ArticlePageSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class ArticlePageSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $articlePageSetting = ArticlePageSetting::with('articlePageSettingDetail')->first();

        if(!$articlePageSetting){
            $articlePageSetting = ArticlePageSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                ArticlePageSettingDetail::create([
                    'article_page_setting_id' => $articlePageSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $articlePageSetting = $articlePageSetting->loadMissing('articlePageSettingDetail');
        }

        return $this->successResponse(new ArticlePageSettingResource($articlePageSetting), 'Data get successfully.');
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['page_title.page_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_title.page_title_' . $language->id . '.required' => 'This field is required.']);
            
            $validationRule = array_merge($validationRule, ['search_placeholder.search_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['search_placeholder.search_placeholder_' . $language->id . '.required' => 'This field is required.']); 
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $articlePageSetting = ArticlePageSetting::first();
        $articlePageSetting->touch();
        foreach ($languages as $language) {
            $articlePageSettingDetail = ArticlePageSettingDetail::whereLanguageId($language->id)->whereArticlePageSettingId($articlePageSetting->id)->exists();
            
            $fields = [
                'page_title' => $request['page_title']['page_title_' . $language->id],
                'search_placeholder' => $request['search_placeholder']['search_placeholder_' . $language->id],
            ];
            if ($articlePageSettingDetail) {
                ArticlePageSettingDetail::whereLanguageId($language->id)->whereArticlePageSettingId($articlePageSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['article_page_setting_id' => $articlePageSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                ArticlePageSettingDetail::create($fields);
            }
        }

        if ($articlePageSetting) {
            return $this->apiSuccessResponse(new ArticlePageSettingResource($articlePageSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
