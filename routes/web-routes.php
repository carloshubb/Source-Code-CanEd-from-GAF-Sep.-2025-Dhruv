<?php

use App\Http\Controllers\Api\Admin\BusinessCategoryController;
use App\Http\Controllers\Api\Admin\ProgramController;
use App\Http\Controllers\Api\Admin\SchoolController;
use App\Http\Controllers\Api\Web\{AccountController, AccountSettingController, AccountUpdateController, AmbassadorController, BusinessController, HelperController, HomeController, PaymentController, ProfileController, SignupController};
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CoffeeWallController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ZoomController;
use Illuminate\Support\Facades\Route;

Route::get('/send-message-to-amb', function () {
    event(new \App\Events\MyEvent('test message 12121'));
    return 1;
});
Route::get('/view-log', function () {
    $log = file_get_contents(storage_path('logs/laravel.log'));
    return response()->view('log-viewer', compact('log'));
});


Route::get('/auth/zoom', [ZoomController::class, 'createMeeting']);
Route::get('/paypal-token', [HomeController::class, 'zohoToken']);
Route::get('/zoho/integration', [HomeController::class, 'ZohoIntegration']);
Route::get('/webinar-create', [HomeController::class, 'liveStromEvent']);
Route::get('/zoho-all-webinar', [HomeController::class, 'zohoAllWebinars']);
Route::get('/proxima-payment/success', [PaymentController::class, 'proximaSuccessResponse']);
Route::get('/proxima-payment/cancel', [PaymentController::class, 'proximaCancelResponse']);

Route::get('/subscription/success', [PaymentController::class, 'paypalSuccessResponse'])->name('paypal.subscription.success');
Route::get('/subscription/cancel', [PaymentController::class, 'paypalCancelResponse'])->name('paypal.subscription.cancel');
Route::post('/process-registration-payment', [PaymentController::class, 'processRegistrationPayment']);
Route::post('/process-update-plan', [PaymentController::class, 'processUpgradeAccount']);
Route::post('/cancel-subscription', [PaymentController::class, 'cancelSubscription']);
Route::post('/resume-subscription', [PaymentController::class, 'resumeSubscription']);
Route::post('password-reset', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::post('/upload-schools', [HomeController::class, 'uploadSchoolExcelFile'])->name('web.upload.schools');
Route::post('/upload-business', [BusinessController::class, 'uploadBusinessDirectoryExcelFile'])->name('web.upload.bussiness');
Route::post('/upload-programs', [ProgramController::class, 'uploadExcelFile'])->name('web.upload.school');
Route::post('/upload-school-programs', [ProgramController::class, 'uploadExcelFileSchoolProgram'])->name('web.upload.program');
Route::post('/upload-school-types', [SchoolController::class, 'uploadExcelFileSchoolType'])->name('web.upload.school.type');
Route::post('/upload-scholarship', [SchoolController::class, 'uploadExcelFileScholarship'])->name('web.upload.scholarship');
Route::post('/upload-business-category', [BusinessCategoryController::class, 'uploadExcelFileBusinessCategory'])->name('web.upload.business.category');
Route::post('/upload-businesses', [BusinessController::class, 'uploadExcelFileBusiness'])->name('web.upload.business');
Route::group(['prefix' => 'user'], function () {
    Route::post('/logout', [SignupController::class, 'logout'])->name('web.user.logout');
});
Route::post('/update-livestrom-token', [AmbassadorController::class, 'updateLiveStromToken']);



Route::get('/', function () {
    return redirect()->route('front.page', ['lang' => getDefaultLanguage(1)['abbreviation'], 'slug' => '']);
});

Route::get('/sitemap', [SitemapController::class, 'generate']);
Route::get('/set-language/{language}', [HelperController::class, 'setLanguage'])->name('web.set-lang');
Route::get('/set-cookies', [HomeController::class, 'setCookies']);
Route::prefix('{lang}')->group(function () {
    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::get('/login/google', [HomeController::class, 'redirectToGoogle']);
    Route::get('/google/login', [HomeController::class, 'handleGoogleCallback']);
    Route::get('/login/linkedin', [HomeController::class, 'redirectToLinkedIn']);
    Route::get('/linked/login', [HomeController::class, 'handleLinkedInCallback']);
    Route::get('/login/facebook', [HomeController::class, 'redirectToFacebook']);
    Route::get('/facebook/login', [HomeController::class, 'handleFacebookCallback']);
    Route::get('/scholarship-advanced-search', [HomeController::class, 'scholarshipAdancedSearch'])->name('scholarship.search.results');
    Route::get('/demetra-search-results', [HomeController::class, 'DemetraSearchResults'])->name('chat.demetra.search.results');
    Route::get('/article/{id}/{slug}', [HomeController::class, 'viewArticle'])->name('web.view.article');
    Route::get('/articles/category/{id}', [HomeController::class, 'articlesByCategory'])->name('web.category.article');
    Route::get('/articles/categories', [HomeController::class, 'articlesCategories'])->name('web.categories.articles');
    Route::get('/articles/subcategories', [HomeController::class, 'articlesSubCategories'])->name('web.subcategories.articles');
    Route::get('/videos/categories', [HomeController::class, 'videosCategories'])->name('web.categories.videos');
    Route::get('/videos/subcategories', [HomeController::class, 'videosSubCategories'])->name('web.subcategories.videos');
    Route::get('/career-search', [HomeController::class, 'searchCareer'])->name('front.career.search');
    // Route::get('/ambassador-search', [HomeController::class, 'searchAmbassador'])->name('front.ambassador.search');
    Route::get('/school/school-degree/{id}/{slug}', [HomeController::class, 'schoolByDegree'])->name('web.view.school.degree');
    Route::get('/importcsv', [HomeController::class, 'ImportCSV']);
    Route::get('/search/business-directory', [HomeController::class, 'businessDirectorySearch'])->name('web.business.directory.search');
    Route::get('/add-event', [HomeController::class, 'addEvent'])->name('web.event.create')->middleware('auth.user');
    Route::get('/add-career', [HomeController::class, 'addCareer'])->name('web.career.create');
    Route::get('/add-story', [HomeController::class, 'addStory'])->name('web.story.create');
    Route::get('/become-sponsor', [HomeController::class, 'becomeSponsorForm'])->name('web.event.becomeSponsorForm');
    Route::get('/sponsor/{id}/{slug}', [HomeController::class, 'sponsorDetail'])->name('web.sponsor.detail');

    Route::get('/event/{id}', [HomeController::class, 'eventDetail'])->name('web.event.detail');
    Route::get('/open-house/{id}', [HomeController::class, 'openDayDetail'])->name('web.open.day.detail');
    Route::get('/webinar/{id}', [HomeController::class, 'webinarDetail'])->name('web.webinar.detail');
    Route::get('/story/{id}', [HomeController::class, 'viewStory'])->name('web.view.story');

    Route::get('/school/{id}/{slug}', [HomeController::class, 'viewSchool'])->name('web.view.school');
    Route::get('/blog-detail/{id}', [HomeController::class, 'blogDetail'])->name('web.view.blog-detail');
    Route::get('/search-results', [HomeController::class, 'searchResults'])->name('web.search');
    Route::get('/school-advance-search', [HomeController::class, 'advanceSearchSchool'])->name('web.school.advance.search');
    Route::get('/advance-school-search-results', [HomeController::class, 'advanceSearchSchoolResults'])->name('web.advance.school.search.results');
    Route::get('/busines-categories/{id}/{slug}', [HomeController::class, 'viewBusiness'])->name('web.view.business');
    Route::get('/business/{id}', [HomeController::class, 'viewBusinessDetail'])->name('web.view.business.detail');
    Route::get('/scholarsip/{id}', [HomeController::class, 'viewScholarshipDetail'])->name('web.view.scholarship.detail');
    Route::get('/ambassador/{id}/{slug}/chat', [AccountController::class, 'SchoolAmbassadorChat'])->name('web.school.ambassador.chat');
    Route::get('/ambassador/{id}/{slug}/ambassador-chats', [AccountController::class, 'AllAmbassadorChats'])->name('web.school.ambassador.chat');
    Route::get('/ambassador/{ambassador_id}/student/{id}/ambassadorchat', [AccountController::class, 'StudentChat'])->name('web.all.ambassador.student.chat');

    //     Route::get('/article/{id}/{slug}', [HomeController::class, 'viewArticle'])->name('web.view.article');
    Route::get('/ambassador/{id}/{slug}/more', [AccountController::class, 'SchoolAmbassadorReadMore'])->name('web.school.ambassador.read.more');
    Route::get('/my-ambassadors', [AccountController::class, 'SchoolChatInbox'])->name('chat-inbox');
    Route::get('/chat-with-proxima', [AccountController::class, 'AdminChatInbox'])->name('chat-admin');
    Route::get('/proxima/checkout', [AccountController::class, 'ProximaPayment']);

    Route::get('/chat/ambassadors', [AccountController::class, 'SchoolChatAmbassadors'])->name('chat.school-ambassadors');
    Route::get('/program/{id}', [HomeController::class, 'schoolByProgram'])->name('school-by-program');
    Route::get('/payment-detail', [PaymentController::class, 'index'])->name('web.payment.index');
    Route::get('/membership-package', [PaymentController::class, 'updatePlan']);
    Route::get('/paid-services', [PaymentController::class, 'updatePlan']);
    Route::get('/set-school-lang/{school_lang}', [HelperController::class, 'setSchoolLang']);
    Route::group(['prefix' => '{slug}/our-profile', 'middleware' => ['auth.user.customer', 'auth.user']], function () {
        Route::get('/', [AccountController::class, 'index'])->name('web.account');
        Route::get('/reverse-admissions-settings', [AccountController::class, 'demetraSetting'])->name('web.account.demetra');
        Route::get('/student-profile', [AccountController::class, 'studentProfile'])->name('web.account.student.profile');
        Route::get('/search-students', [AccountController::class, 'searchStudentProfiles'])->name('web.account.search.student');
        Route::get('/information', [AccountController::class, 'accountInfo'])->name('web.account.info');
        Route::get('/our-articles', [AccountController::class, 'favouriteArticle'])->name('web.account.fav.article');
        Route::get('/our-businesses', [AccountController::class, 'favouriteBusiness'])->name('web.account.fav.business');
        // Route::get('/our-events', [AccountController::class, 'favouriteEvent'])->name('web.account.fav.event');
        Route::get('/our-scholarships', [AccountController::class, 'favouriteScholarship'])->name('web.account.fav.scholarship');
        Route::get('/favorite-schools', [AccountController::class, 'favouriteSchool'])->name('web.account.fav.school');
        Route::get('/favourite-events', [AccountController::class, 'favouriteSchool'])->name('web.account.fav.events');
        Route::get('/favorite-events', [AccountController::class, 'myEvents'])->name('web.account.my.events');
        Route::get('/favorite-articles', [AccountController::class, 'favoriteArticlesStudent'])->name('web.account.fav.articles');
        Route::get('/favorite-businesses', [AccountController::class, 'favoriteBusinessesStudent'])->name('web.account.fav.businesses');
        Route::get('/favorite-scholarships', [AccountController::class, 'favoriteScholarshipsStudent'])->name('web.account.fav.scholarships');
        Route::get('/favorite-networks', [AccountController::class, 'favoriteNetworksStudent'])->name('web.account.fav.networks');
        Route::get('/my-articles', [AccountController::class, 'Articles'])->name('web.account.my.articles');
        Route::get('/our-article', [AccountController::class, 'Articles'])->name('web.account.our.articles');
        Route::get('/our-qoutes', [AccountController::class, 'myQoutes'])->name('web.account.my.qoutes');
        Route::get('/our-networks', [AccountController::class, 'Networks'])->name('web.account.networks');
        Route::get('/suggested-programs', [AccountController::class, 'suggestedPrograms'])->name('web.account.suggested.programs');
        Route::get('/languages', [AccountController::class, 'schoolSetting'])->name('web.account.school.setting');
        Route::get('/faq/{type}', [AccountController::class, 'Faq'])->name('web.account.admission.faq');
        Route::get('/school-ambassador', [AccountController::class, 'SchoolAmbassador'])->name('web.account.school.ambassador');
        Route::get('/school-ambassador/create', [AccountController::class, 'SchoolAmbassadorCreate'])->name('web.account.school.ambassador.create');
        Route::get('/school-ambassador/edit/{ambassador}', [AccountController::class, 'SchoolAmbassadorEdit'])->name('web.account.school.ambassador.edit');

        Route::get('/virtual-tour', [AccountController::class, 'virtualTour'])->name('web.account.virtual.tour');
        Route::get('/virtual-tour/create', [AccountController::class, 'virtualTourCreate'])->name('web.account.virtual.tour.create');
        Route::get('/virtual-tour/edit/{virtual_tour}', [AccountController::class, 'virtualTourEdit'])->name('web.account.virtual.tour.edit');
        Route::get('/open-house', [AccountController::class, 'openDay'])->name('web.account.open.house');
        Route::get('/open-house/create', [AccountController::class, 'openDayCreate'])->name('web.account.open.house.create');
        Route::get('/open-house/edit/{open_day}', [AccountController::class, 'openDayEdit'])->name('web.account.open.house.edit');
        Route::get('/school-program', [AccountController::class, 'SchoolProgram'])->name('web.account.school.program');
        Route::get('/school-contact', [AccountController::class, 'SchoolContact'])->name('web.account.school.contact');
        Route::get('/school-ambassador-setting', [AccountController::class, 'SchoolAmbassadorSetting'])->name('web.account.school.ambassador.setting');
        Route::get('/school-scholarship', [AccountController::class, 'SchoolScholarship'])->name('web.account.school.scholarship');
        Route::get('/school-employee', [AccountController::class, 'SchoolEmployee'])->name('web.account.school.employee');
        Route::get('/school-information', [AccountController::class, 'SchoolInformation'])->name('web.account.school.information');
        Route::get('/school-quick-fact', [AccountController::class, 'SchoolQuickFact'])->name('web.account.school.quick-fact');
        Route::get('/school-overview', [AccountController::class, 'SchoolOverview'])->name('web.account.school.overview');
        Route::get('/blog', [AccountController::class, 'blogOverview'])->name('web.account.school.blog');
        Route::get('/school-teams', [AccountController::class, 'schoolTeamsOverview'])->name('web.account.school.school-teams');
        Route::get('/school-financial', [AccountController::class, 'SchoolFinancial'])->name('web.account.school.financial');
        Route::get('/close', [AccountController::class, 'closeAccount'])->name('web.account.close');
        Route::get('/update-password', [AccountController::class, 'updatePassword'])->name('web.update.password');
        Route::get('/business', [AccountController::class, 'BusinessDashboard'])->name('web.account.business');
        Route::get('/business/create', [AccountController::class, 'businessCreate'])->name('web.account.business.create');
        Route::get('/business/edit/{business}', [AccountController::class, 'businessEdit'])->name('web.account.business.edit');
        Route::get('/articles', [AccountController::class, 'Articles'])->name('web.account.school.articles');
        Route::get('/article/create', [AccountController::class, 'articleCreate'])->name('web.account.article.create');
        Route::get('/article/edit/{article}', [AccountController::class, 'articleEdit'])->name('web.account.article.edit');
        // event web account
        Route::get('/our-events', [AccountController::class, 'Events'])->name('web.account.school.events');
        Route::get('/event/create', [AccountController::class, 'eventCreate'])->name('web.account.event.create');
        Route::get('/event/edit/{event}', [AccountController::class, 'eventEdit'])->name('web.account.event.edit');
        Route::get('/event/edit/repost/{event}', [AccountController::class, 'eventRepost'])->name('web.account.event.repsot');

        Route::get('/videos', [AccountController::class, 'Videos'])->name('web.account.school.videos');
        Route::get('/video/create', [AccountController::class, 'videoCreate'])->name('web.account.video.create');
        Route::get('/video/edit/{video}', [AccountController::class, 'videoEdit'])->name('web.account.video.edit');
    });
    Route::group(['prefix' => '/ambassador', 'middleware' => ['auth.ambassador']], function () {
        Route::get('/student-chat', [AmbassadorController::class, 'index'])->name('web.ambassador.chat');
        Route::get('/webinars', [AmbassadorController::class, 'webinar'])->name('web.account.webinar');
        Route::get('/webinar/create', [AmbassadorController::class, 'webinarCreate'])->name('web.account.webinar.create');
        Route::get('/webinar/edit/{webinar}', [AmbassadorController::class, 'webinarEdit'])->name('web.account.webinar.edit');
        Route::get('/webinar-settings', [AmbassadorController::class, 'webinarSetting'])->name('web.ambassador.webinar.setting');
        Route::get('/student/{customer_id}/student-chat', [AmbassadorController::class, 'StudentChat'])->name('web.ambassador.student.chat');
    });

    Route::get('email-verify/{token}/{email}', [SignupController::class, 'emailVerify']);
    Route::group(['prefix' => '', 'middleware' => ['auth.user']], function () {
        Route::get('coffee-on-the-wall', [CoffeeWallController::class, 'index'])->name('web.coffee.index');
        Route::get('updateSchoolsFromExcel', [HomeController::class, 'updateSchoolsFromExcel']);
        Route::post('/coffee-on-wall', [CoffeeWallController::class, 'store'])->name('coffee-on-wall.store');

        Route::get('/{slug?}', function ($lange, string $slug = null) {
            $defaultSlug = App\Models\Page::where('set_as_home', '1')->value('slug');
            if ($defaultSlug == $slug) {
                return redirect('/');
            }
            if ($slug == 'signin') {
                $defaultLang = getDefaultLanguage(1);
                $page = App\Models\Page::with([
                    'pageDetail' => function ($q) use ($defaultLang) {
                        $q->where('language_id', $defaultLang->id);
                    },
                ])
                    ->where('template', 'login_template')
                    ->first();
                if (isset($page->pageDetail[0]->slug)) {
                    return redirect($page->pageDetail[0]->slug);
                }
            }
            return view('front.page', compact('slug', 'lange'));
        })->name('front.page');
    });
});
