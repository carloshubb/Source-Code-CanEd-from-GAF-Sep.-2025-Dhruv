<?php

use App\Http\Controllers\Api\Admin\{
    ActivityController,
    ArticleCategoryController,
    ArticleController,
    ArticlePageSettingController,
    AuthController,
    BannerController,
    BusDirectorySettingController,
    BusinessCategoryController,
    BusinessDirectoryController,
    CareerController,
    CareerSettingController,
    ContactPageSettingController,
    DegreeController,
    ErrorController,
    FooterSettingController,
    HomePageSettingController,
    IsLoginModalSettingController,
    LanguageController,
    LoginPageSettingController,
    MasterApplicationSettingController,
    MediaController,
    MenuController,
    PageController,
    ProgramController,
    ProgramSettingController,
    RegisterBusinessController,
    RegistrationPackageController,
    RegPageSettingController,
    SchoolRequestSettingController,
    EventController,
    MasterApplicationController,
    NetworkController,
    QuoteController,
    SchoolController,
    BusinessController,
    ComunityServiceController,
    ContactController,
    CookieSettingController,
    CountryStatusController,
    CurricularActivityController,
    CustomerController,
    DashboardController,
    LeadershipSkillController,
    LearningLanguageController,
    SchoolScholarshipController,
    SchoolTypeController,
    SocialServiceController,
    SponsorController,
    SportController,
    SugPageSettingController,
    TeamController,
    VideoController,
    DemetraPageSettingController,
    MessagingAppController,
    OpenDayController,
    ProximaMessageController,
    ProximaRequestController,
    ProximaRequestSettingController,
    SchoolAmbassadorController,
    SitemapSettingController,
    StaticTranslationController,
    StoryController,
    TestController,
    VirtualTourController,
};
use App\Http\Controllers\Api\Web\BusinessController as WebBusinessController;
use App\Http\Controllers\Api\Web\SettingController;
use App\Http\Resources\Admin\UserResource;
use App\Models\LearningLanguage;
use App\Models\MessagingApp;
use App\Models\OpenDay;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        $user = new UserResource($request->user());
        return response()->json(['data' => $user, 'status' => 'Success']);
    });
    Route::get('/synch-all-webinars', [SettingController::class, 'synchAllWebinars']);
    Route::get('suggested-articles', [ArticleController::class, 'suggestedArticles']);
    Route::post('delete-suggested-articles', [ArticleController::class, 'destroySuggestedArticle']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::apiResource('languages', LanguageController::class);
    
    Route::post('/get-customer-languages', [LanguageController::class,'getCustomerLanguages']);
    Route::apiResource('business-categories', BusinessCategoryController::class);
    Route::post('/menus/{id}/menu-builder', [MenuController::class, 'updateMenuBuilder']);
    Route::apiResource('menus', MenuController::class);
    Route::apiResource('degrees', DegreeController::class);
    Route::apiResource('messaging_apps', MessagingAppController::class);
    Route::get('all_messaging_apps', [MessagingAppController::class, 'allMessagingApps']);
    Route::apiResource('tests', TestController::class);


    Route::apiResource('stories', StoryController::class);
    Route::apiResource('article_categories', ArticleCategoryController::class);
    // Route::apiResource('articles', ArticleController::class)->parameter('articles', 'admin');
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('pages', PageController::class);
    Route::apiResource('banners', BannerController::class);
    Route::apiResource('careers', CareerController::class);
    Route::apiResource('programs', ProgramController::class);
    Route::apiResource('registration-packages', RegistrationPackageController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('sponsors', SponsorController::class);
    Route::apiResource('teams', TeamController::class);
    Route::apiResource('business_directories', BusinessDirectoryController::class);
    Route::apiResource('quotes', QuoteController::class);
    Route::apiResource('countries', CountryStatusController::class);
    Route::apiResource('videos', VideoController::class);
    Route::apiResource('networks', NetworkController::class);
    Route::apiResource('master_applications', MasterApplicationController::class);
    Route::apiResource('schools', SchoolController::class);
    Route::apiResource('school_types', SchoolTypeController::class);
    Route::apiResource('school_scholarships', SchoolScholarshipController::class);
    Route::apiResource('sports', SportController::class);
    Route::apiResource('curricular_activities', CurricularActivityController::class);
    Route::apiResource('activities', ActivityController::class);
    Route::apiResource('comunity_services', ComunityServiceController::class);
    Route::apiResource('learning_languages', LearningLanguageController::class);
    Route::apiResource('social_services', SocialServiceController::class);
    Route::apiResource('leadership_skills', LeadershipSkillController::class);
    Route::apiResource('proxima_requests', ProximaRequestController::class);
    Route::post('update-master-threshold', [SchoolController::class, 'updateMasterThreshold']);
    Route::apiResource('virtual_tours', VirtualTourController::class);
    Route::apiResource('open_days', OpenDayController::class);
    Route::apiResource('ambassadors', SchoolAmbassadorController::class);
    Route::get('degree-levels', [SchoolAmbassadorController::class, 'DegreeLevels']);
    Route::apiResource('static-translation', StaticTranslationController::class)->only(['index', 'store']);
    Route::post('/proxima-messages', [ProximaMessageController::class, 'index']);
    Route::post('/proxima-save-message', [ProximaMessageController::class, 'store']);
    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings', [SettingController::class, 'update']);
    Route::get('/dashboard-stats', [DashboardController::class, 'show']);

    Route::post('/schools/deactive-school', [SchoolController::class, 'deactiveSchool']);
    Route::apiResource('businesses', BusinessController::class);
    Route::post('/businesses/deactive-business', [BusinessController::class, 'deactiveBusiness']);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('contacts', ContactController::class);

    
    Route::post('/customers/deactive-customer', [CustomerController::class, 'deactiveCustomer']);
   Route::post('send-business-credentials-email/{customerId}', [CustomerController::class, 'sendBusinessCredentialsEmail']);
   Route::post('send-business-credentials/{businessId}', [WebBusinessController::class, 'sendBusinessCredentials']);

   Route::post('send-credentials-email/{customerId}', [CustomerController::class, 'sendCredentialsEmail']);
   Route::post('send-school-credentials/{schoolId}', [SchoolController::class, 'sendCredentials']);
    Route::group(['prefix' => 'program-settings'], function () {
        Route::post('/', [ProgramSettingController::class, 'update']);
        Route::get('/', [ProgramSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'career-settings'], function () {
        Route::post('/', [CareerSettingController::class, 'update']);
        Route::get('/', [CareerSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'contact-page-setting'], function () {
        Route::post('/', [ContactPageSettingController::class, 'update']);
        Route::get('/', [ContactPageSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'footer-setting'], function () {
        Route::post('/', [FooterSettingController::class, 'update']);
        Route::get('/', [FooterSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'cookie-setting'], function () {
        Route::post('/', [CookieSettingController::class, 'update']);
        Route::get('/', [CookieSettingController::class, 'index']);
    });


    Route::group(['prefix' => 'sitemap-setting'], function () {
        Route::post('/', [SitemapSettingController::class, 'update']);
        Route::get('/', [SitemapSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'master-application-setting'], function () {
        Route::post('/', [MasterApplicationSettingController::class, 'update']);
        Route::get('/', [MasterApplicationSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'article-page-setting'], function () {
        Route::post('/', [ArticlePageSettingController::class, 'update']);
        Route::get('/', [ArticlePageSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'demetra-page-setting'], function () {
        Route::post('/', [DemetraPageSettingController::class, 'update']);
        Route::get('/', [DemetraPageSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'reg-page-setting'], function () {
        Route::post('/', [RegPageSettingController::class, 'update']);
        Route::get('/', [RegPageSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'proxima-request-setting'], function () {
        Route::post('/', [ProximaRequestSettingController::class, 'update']);
        Route::get('/', [ProximaRequestSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'sug-page-setting'], function () {
        Route::post('/', [SugPageSettingController::class, 'update']);
        Route::get('/', [SugPageSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'bus-directory-setting'], function () {
        Route::post('/', [BusDirectorySettingController::class, 'update']);
        Route::get('/', [BusDirectorySettingController::class, 'index']);
    });

    Route::group(['prefix' => 'register-business'], function () {
        Route::post('/', [RegisterBusinessController::class, 'update']);
        Route::get('/', [RegisterBusinessController::class, 'index']);
    });

    Route::group(['prefix' => 'school-request-setting'], function () {
        Route::post('/', [SchoolRequestSettingController::class, 'update']);
        Route::get('/', [SchoolRequestSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'home-page-setting'], function () {
        Route::post('/', [HomePageSettingController::class, 'update']);
        Route::get('/', [HomePageSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'login-page-setting'], function () {
        Route::post('/', [LoginPageSettingController::class, 'update']);
        Route::get('/', [LoginPageSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'is-login-modal-setting'], function () {
        Route::post('/', [IsLoginModalSettingController::class, 'update']);
        Route::get('/', [IsLoginModalSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'errors'], function () {
        Route::post('/', [ErrorController::class, 'update']);
        Route::get('/', [ErrorController::class, 'index']);
    });
    Route::group(['prefix' => 'media'], function () {
        Route::post('/process', [MediaController::class, 'process']);
        Route::post('/revert', [MediaController::class, 'revert']);
        Route::get('/load', [MediaController::class, 'load']);
        Route::post('image_again_upload', [MediaController::class, 'uploadImage']);
        Route::post('upload-multiple-files', [MediaController::class, 'uploadImages']);
    });
});
