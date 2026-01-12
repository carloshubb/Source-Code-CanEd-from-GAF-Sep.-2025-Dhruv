<?php

use App\Http\Controllers\Api\Admin\ActivityController;
use App\Http\Controllers\Api\Admin\ArticleCategoryController;
use App\Http\Controllers\Api\Admin\ArticleController;
use App\Http\Controllers\Api\Admin\BusinessCategoryController;
use App\Http\Controllers\Api\Admin\BusinessController as AdminBusinessController;
use App\Http\Controllers\Api\Admin\CareerController;
use App\Http\Controllers\Api\Admin\ComunityServiceController;
use App\Http\Controllers\Api\Admin\CurricularActivityController;
use App\Http\Controllers\Api\Web\AdmissionSettingController;
use App\Http\Controllers\Api\Admin\DegreeController;
use App\Http\Controllers\Api\Admin\EventController;
use App\Http\Controllers\Api\Admin\LanguageController;
use App\Http\Controllers\Api\Admin\LearningLanguageController;
use App\Http\Controllers\Api\Admin\MediaController;
use App\Http\Controllers\Api\Admin\MessagingAppController;
use App\Http\Controllers\Api\Admin\NetworkController;
use App\Http\Controllers\Api\Admin\ProgramController;
use App\Http\Controllers\Api\Admin\ProximaMessageController;
use App\Http\Controllers\Api\Admin\ProximaRequestController;
use App\Http\Controllers\Api\Admin\QuoteController;
use App\Http\Controllers\Api\Admin\SchoolController;
use App\Http\Controllers\Api\Admin\SchoolTypeController;
use App\Http\Controllers\Api\Admin\SponsorController;
use App\Http\Controllers\Api\Admin\SportController;
use App\Http\Controllers\Api\Admin\StoryController;
use App\Http\Controllers\Api\Admin\TestController;
use App\Http\Controllers\Api\Admin\VideoController;
use App\Http\Controllers\Api\Web\{
    AccountController,
    BlogController,
    BusinessController,
    SignupController,
    HelperController,
    SocialMediaController,
    UserProfileController,
    BussinessProfileController,
    SchoolProfileController,
    CustomerController,
    FaqController,
    MasterApplicationController,
    MessageController,
    OpenDayController,
    OverviewProgramController,
    RecaptchaController,
    ScholarshipSettingController,
    SchoolAmbassadorController,
    SchoolAmbassadorSettingController,
    SchoolContactController,
    SchoolContactSettingController,
    SchoolEmployeeController,
    SchoolFinancialController,
    SchoolInformationController,
    SchoolMoreLinkController,
    SchoolOverviewController,
    SchoolProgramController,
    SchoolQuickFactController,
    SchoolScholarshipController,
    VirtualTourController,
    SchoolProgramSettingController,
    SchoolTeamController,
    SectionDataController,
    WebinarController
};
use App\Http\Resources\Admin\ProgramResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'web'], function () {
    Route::post('/signup', [SignupController::class, 'signup']);
    Route::post('/login', [SignupController::class, 'login']);
    Route::post('/social-media', [SocialMediaController::class, 'store']);
    Route::get('/show-social-media', [SocialMediaController::class, 'show']);
    Route::post('/user-profile', [UserProfileController::class, 'store']);
    Route::get('/show-user-profile', [UserProfileController::class, 'show']);
    Route::post('/bussiness-profile', [BussinessProfileController::class, 'store']);
    Route::get('/show-bussiness-profile', [BussinessProfileController::class, 'show']);
    Route::get('/get-registration-packages', [HelperController::class, 'getRegistrationPackages']);
    Route::get('/get-business-categories', [HelperController::class, 'getBusinessCategories']);
    Route::get('/get-reg-page-setting', [HelperController::class, 'getRegPageSetting']);
    Route::post('/check-customer-email', [HelperController::class, 'checkCustomerEmail']);
    Route::post('/contact-us', [HelperController::class, 'contactUS']);
    Route::post('/contact-bussiness', [HelperController::class, 'contactBussiness']);
    Route::post('/contact-school', [HelperController::class, 'contactSchool']);
    Route::post('/contact-openhouse-orgnizer', [HelperController::class, 'contactOpenHouseOrgnizer']);

    
    
    Route::post('/verifyRecaptcha', [RecaptchaController::class, 'verifyRecaptcha']);
    Route::post('/register-business', [BusinessController::class, 'store']);
    Route::post('/register-school', [SchoolProfileController::class, 'store']);
    Route::post('/customer-languages', [SchoolProfileController::class, 'customerLanguage']);
    Route::get('/customer-languages', [SchoolProfileController::class, 'customerLanguages']);
    Route::post('/update-customer', [CustomerController::class, 'updateProfile']);
    Route::post('/validate-customer-email', [CustomerController::class, 'VaidateCustomerEmail']);
    Route::post('/validate-business-email', [CustomerController::class, 'VaidateBusinessEmail']);
    Route::post('/validate-school-email', [CustomerController::class, 'VaidateSchoolEmail']);
    Route::post('/delete-account', [CustomerController::class, 'deleteAccount']);
    Route::post('/proxima-messages', [ProximaMessageController::class, 'index']);
    Route::post('/proxima-save-message', [ProximaMessageController::class, 'store']);
    Route::post('/messages', [MessageController::class, 'index']);
    Route::post('/save-message', [MessageController::class, 'store']);
    Route::post('/update-student-profile', [CustomerController::class, 'updateStudent']);
    Route::post('/update-password', [CustomerController::class, 'updatePassword']);
    Route::post('/search-student-profile', [CustomerController::class, 'searchStudent']);
    Route::post('/demetra-setting', [CustomerController::class, 'schoolDemetraSetting']);
    Route::apiResource('sports', SportController::class);
    Route::apiResource('curricular_activities', CurricularActivityController::class);
    Route::apiResource('activities', ActivityController::class);
    Route::apiResource('comunity_services', ComunityServiceController::class);
    Route::apiResource('learning_languages', LearningLanguageController::class);

    Route::post('/send-email-to-student', [CustomerController::class, 'sendAnEmail']);
    Route::post('/send-email-to-all-students', [CustomerController::class, 'sendAnEmailToAllStudents']);
    Route::post('/save-sport', [SportController::class, 'saveDefaultLanguageSport']);
    Route::post('/save-curricular-activity', [CurricularActivityController::class, 'saveDefaultLanguageCurriculum']);
    Route::post('/save-activity', [ActivityController::class, 'saveDefaultLanguageActivity']);
    Route::post('/save-comunity-service', [ComunityServiceController::class, 'saveDefaultLanguageComunityService']);
    Route::post('/save-learning-language', [LearningLanguageController::class, 'saveDefaultLanguageLearningLanguage']);
    Route::post('/suggested-articles', [ArticleController::class, 'storeSuggestedArticle']);

    Route::apiResource('article_categories', ArticleCategoryController::class);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('videos', VideoController::class);
    Route::apiResource('languages', LanguageController::class);
    Route::post('/get-customer-languages', [LanguageController::class, 'getCustomerLanguages']);
    Route::apiResource('business-categories', BusinessCategoryController::class);
    Route::apiResource('faqs', FaqController::class);
    Route::apiResource('open-days', OpenDayController::class);
    Route::apiResource('virtual_tours', VirtualTourController::class);
    Route::apiResource('school-programs', SchoolProgramController::class);
    Route::apiResource('school-contacts', SchoolContactController::class);
    Route::apiResource('school-scholarships', SchoolScholarshipController::class);
    Route::apiResource('school-employees', SchoolEmployeeController::class);
    Route::apiResource('master-applications', MasterApplicationController::class);
    Route::get('get-master-applications/{id}', [MasterApplicationController::class, 'getMasterApplication']);
    Route::get('get-master-applications-schools/{id}', [MasterApplicationController::class, 'getMasterApplicationSchools']);
    //     Route::get('master-applications/{id}', [MasterApplicationController::class, 'showOnWebsite']);
// Route::put('master-applications/{id}', [MasterApplicationController::class, 'updateOnWebsite']);
    Route::apiResource('networks', NetworkController::class);
    Route::apiResource('quotes', QuoteController::class);
    Route::apiResource('sponsors', SponsorController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('careers', CareerController::class);
    Route::apiResource('stories', StoryController::class);
    Route::apiResource('proxima_requests', ProximaRequestController::class);
    Route::apiResource('overview_program', OverviewProgramController::class);
    Route::apiResource('schools', SchoolController::class);
    Route::apiResource('school_ambassadors', SchoolAmbassadorController::class);
    Route::post('webinar-setting', [SchoolAmbassadorController::class, 'saveZohoCredentials']);
    Route::get('degree-levels', [SchoolAmbassadorController::class, 'DegreeLevels']);
    Route::get('synch-webinars', [WebinarController::class, 'synchWebinars']);
    Route::apiResource('more_links', SchoolMoreLinkController::class);
    Route::apiResource('webinars', WebinarController::class);
    Route::apiResource('school_types', SchoolTypeController::class);
    Route::apiResource('business', AdminBusinessController::class);
    Route::post('/add-to-favorite', [HelperController::class, 'addToFav']);
    Route::apiResource('messaging_apps', MessagingAppController::class);
    Route::get('all_messaging_apps', [MessagingAppController::class, 'allMessagingApps']);
    Route::apiResource('tests', TestController::class);
    Route::group(['prefix' => 'admission-setting'], function () {
        Route::post('/', [AdmissionSettingController::class, 'update']);
        Route::get('/', [AdmissionSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'school-informations'], function () {
        Route::post('/', [SchoolInformationController::class, 'update']);
        Route::get('/', [SchoolInformationController::class, 'index']);
    });

    Route::group(['prefix' => 'school-quick-facts'], function () {
        Route::post('/', [SchoolQuickFactController::class, 'update']);
        Route::get('/', [SchoolQuickFactController::class, 'index']);
    });

    Route::group(['prefix' => 'blogs'], function () {
        Route::post('/', [BlogController::class, 'update']);
        Route::delete('/{id}', [BlogController::class, 'destroy']);
        Route::get('/', [BlogController::class, 'index']);
    });

    Route::group(['prefix' => 'school-teams'], function () {
        Route::post('/', [SchoolTeamController::class, 'update']);
        Route::delete('/{id}', [SchoolTeamController::class, 'destroy']);
        Route::get('/', [SchoolTeamController::class, 'index']);
    });

    Route::group(['prefix' => 'school-overviews'], function () {
        Route::post('/', [SchoolOverviewController::class, 'update']);
        Route::get('/', [SchoolOverviewController::class, 'index']);
    });


    Route::group(['prefix' => 'school-contact-settings'], function () {
        Route::post('/', [SchoolContactSettingController::class, 'update']);
        Route::get('/', [SchoolContactSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'school-ambassador-settings'], function () {
        Route::post('/', [SchoolAmbassadorSettingController::class, 'update']);
        Route::get('/', [SchoolAmbassadorSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'school-program-settings'], function () {
        Route::post('/', [SchoolProgramSettingController::class, 'update']);
        Route::get('/', [SchoolProgramSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'scholarship-settings'], function () {
        Route::post('/', [ScholarshipSettingController::class, 'update']);
        Route::get('/', [ScholarshipSettingController::class, 'index']);
    });

    Route::group(['prefix' => 'school-financials'], function () {
        Route::post('/', [SchoolFinancialController::class, 'update']);
        Route::get('/', [SchoolFinancialController::class, 'index']);
    });

    Route::post('image_again_upload', [MediaController::class, 'uploadImage']);
    Route::apiResource('degrees', DegreeController::class);
    Route::apiResource('programs', ProgramController::class);
    Route::group(['prefix' => 'media'], function () {
        Route::post('/process', [MediaController::class, 'process']);
        Route::post('/revert', [MediaController::class, 'revert']);
        Route::get('/load', [MediaController::class, 'load']);
        Route::post('image_again_upload', [MediaController::class, 'uploadImage']);
    });
});



Route::group(['prefix' => 'web', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        return response()->json(['data' => $user, 'status' => 'Success']);
    });
});

if (env('APP_ENV') != 'local') {
    URL::forceScheme('https');
}
