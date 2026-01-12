<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Business;
use App\Models\Conversation;
use App\Models\Customer;
use App\Models\CustomerLanguage;
use App\Models\Event;
use App\Models\Favourite;
use App\Models\Network;
use App\Models\OpenDay;
use App\Models\Program;
use App\Models\ProximaRequest;
use App\Models\Quote;
use App\Models\School;
use App\Models\SchoolAmbassador;
use App\Models\SchoolAmbassadorDetail;
use App\Models\SchoolProgram;
use App\Models\SchoolScholarship;
use App\Models\ProgramDetail;
use App\Models\Video;
use App\Models\VirtualTour;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $eventCount = Event::where('customer_id', $customer_id)->count();
        $favEventCount = Favourite::where('customer_id', $customer_id)
            ->where('model', 'event')
            ->count();
        $favBusinessCount = Favourite::where('customer_id', $customer_id)
            ->where('model', 'business')
            ->count();
        $favArticleCount = Favourite::where('customer_id', $customer_id)
            ->where('model', 'article')
            ->count();
        $favSchoolCount = Favourite::where('customer_id', $customer_id)
            ->where('model', 'school')
            ->count();
        $favScholarshipCount = Favourite::where('customer_id', $customer_id)
            ->where('model', 'scholarship')
            ->count();
        $networkCount = Network::where('customer_id', $customer_id)->count();
        $quoteCount = Quote::where('customer_id', $customer_id)->count();
        $schoolProgramCount = Program::where('customer_id', $customer_id)->count();
        $school_slug = isset(\Auth::guard('customers')->user()->school->schoolDetail[0]->school_name) ? \Auth::guard('customers')->user()->school->schoolDetail[0]->school_name : '';
        $school_slug = createSlug($school_slug);
        return view('front.account.account-dashboard', compact('school_slug', 'schoolProgramCount', 'quoteCount', 'networkCount', 'favSchoolCount', 'favScholarshipCount', 'eventCount', 'favEventCount', 'favBusinessCount', 'favArticleCount'));
    }

    public function accountInfo()
    {
        return view('front.account.account-info');
    }




    public function favouriteArticle()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        // dd($customer_id);

        $favArticles = Favourite::where('customer_id', $customer_id)
            ->where('model', 'article')
            ->pluck('record_id');

        $defaultLang = getDefaultLanguage(1);

        $favArticlesQuery = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        })
            ->with([
                'articleDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
                'ArticleImage',
            ])
            ->whereIn('id', $favArticles);

        $articlesWithSchoolId = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        })
            ->with([
                'articleDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
                'ArticleImage',
            ])
            // ->whereNotNull('school_id')
            ->where('customer_id', $customer_id);

        $articles = $articlesWithSchoolId->get()->merge($favArticlesQuery->get());
        // dd($articles);


        return view('front.account.fav-articles', compact('articles'));
    }

    // public function favoriteArticlesStudent()
    // {
    //     $customer_id = Auth::guard('customers')->user()->id;
    //     // dd($customer_id);

    //     $favArticles = Favourite::where('customer_id', $customer_id)
    //         ->where('model', 'article')
    //         ->pluck('record_id');

    //     $defaultLang = getDefaultLanguage(1);

    //     $favArticlesQuery = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
    //         $q->where('language_id', $defaultLang->id);
    //     })
    //         ->with([
    //             'articleDetail' => function ($q) use ($defaultLang) {
    //                 $q->where('language_id', $defaultLang->id);
    //             },
    //             'ArticleImage',
    //         ])
    //         ->whereIn('id', $favArticles);

    //     $articlesWithSchoolId = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
    //         $q->where('language_id', $defaultLang->id);
    //     })
    //         ->with([
    //             'articleDetail' => function ($q) use ($defaultLang) {
    //                 $q->where('language_id', $defaultLang->id);
    //             },
    //             'ArticleImage',
    //         ])
    //         // ->whereNotNull('school_id')
    //         ->where('customer_id', $customer_id);

    //     $articles = $articlesWithSchoolId->get()->merge($favArticlesQuery->get());
    //     // dd($articles);

    //     return view('front.account.fav-student-articles', compact('articles'));
    // }

    public function favoriteArticlesStudent()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $favArticles = Favourite::where('customer_id', $customer_id)
            ->where('model', 'article')
            ->pluck('record_id');

        $defaultLang = getDefaultLanguage(1);

        $favArticlesQuery = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        })
            ->with([
                'articleDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
                'ArticleImage',
            ])
            ->whereIn('id', $favArticles)
            ->get(); 

        return view('front.account.fav-student-articles', compact('favArticlesQuery'));
    }


    // public function myStudentArticles()
    // {
    //     $customer_id = Auth::guard('customers')->user()->id;
    //     $defaultLang = getDefaultLanguage(1);
    //     $articlesWithSchoolId = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
    //         $q->where('language_id', $defaultLang->id);
    //     })
    //         ->with([
    //             'articleDetail' => function ($q) use ($defaultLang) {
    //                 $q->where('language_id', $defaultLang->id);
    //             },
    //             'ArticleImage',
    //         ])
    //         ->where('customer_id', $customer_id)
    //         ->get(); 

    //     return view('front.account.my-student-articles', compact('articlesWithSchoolId'));
    // }
    public function myStudentArticles()
    {
        return view('front.account.article.create');
    }






    //     public function favouriteArticle()
    // {
    //     $customer_id = Auth::guard('customers')->user()->id;

    //     $favArticles = Favourite::where('customer_id', $customer_id)
    //         ->where('model', 'article')
    //         ->pluck('record_id');

    //     $defaultLang = getDefaultLanguage(1);

    //     // Favorite articles
    //     $favArticlesQuery = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
    //         $q->where('language_id', $defaultLang->id);
    //     })
    //         ->with([
    //             'articleDetail' => function ($q) use ($defaultLang) {
    //                 $q->where('language_id', $defaultLang->id);
    //             },
    //             'ArticleImage',
    //         ])
    //         ->whereIn('id', $favArticles)
    //         ->get();

    //     // User-created articles
    //     $articlesWithSchoolId = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
    //         $q->where('language_id', $defaultLang->id);
    //     })
    //         ->with([
    //             'articleDetail' => function ($q) use ($defaultLang) {
    //                 $q->where('language_id', $defaultLang->id);
    //             },
    //             'ArticleImage',
    //         ])
    //         ->whereNotNull('school_id')
    //         ->where('customer_id', $customer_id)
    //         ->get();

    //     return view('front.account.fav-articles', compact('articlesWithSchoolId', 'favArticlesQuery'));
    // }



    public function favouriteBusiness()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $favBusiness = Favourite::where('customer_id', $customer_id)
            ->where('model', 'business')
            ->pluck('record_id');
        $defaultLang = getDefaultLanguage(1);
        $favArticlesQuery = Business::whereHas('businessDetail', function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        })
            ->with([
                'businessDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
            ])
            ->whereIn('id', $favBusiness);

        $businessesWithSchoolId = Business::whereHas('businessDetail', function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        })
            ->with([
                'businessDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
            ])
            // ->whereNotNull('school_id')
            ->where('customer_id', $customer_id);

        $business = $businessesWithSchoolId->get()->merge($favArticlesQuery->get());

        // $businesses = $businesses->whereIn('id', $favBusiness)->get();
        return view('front.account.fav-businesses', compact('business'));
    }
    public function favoriteBusinessesStudent()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $favBusiness = Favourite::where('customer_id', $customer_id)
            ->where('model', 'business')
            ->pluck('record_id');
        $defaultLang = getDefaultLanguage(1);
        $businesses = Business::whereHas('businessDetail', function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        });
        $businesses = $businesses->whereIn('id', $favBusiness)->get();
        return view('front.account.fav-student-businesses', compact('businesses'));
    }

    public function favouriteEvent()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $favevents = Favourite::where('customer_id', $customer_id)
            ->where('model', 'event')
            ->pluck('record_id');
        $defaultLang = getDefaultLanguage(1);
        $favArticlesQuery = Event::whereHas('eventDetail', function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        })
            ->with([
                'eventDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
                'eventImage',
            ])
            ->whereIn('id', $favevents);
        $eventsWithSchoolId = Event::whereHas('eventDetail', function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        })
            ->with([
                'eventDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
                'eventImage',
            ])
            ->whereNotNull('school_id')
            ->where('customer_id', $customer_id);

        $events = $eventsWithSchoolId->get()->merge($favArticlesQuery->get());
        return view('front.account.fav-events', compact('events'));
    }

    public function favoriteScholarshipsStudent()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $favScholarships = Favourite::where('customer_id', $customer_id)
            ->where('model', 'scholarship')
            ->pluck('record_id');

        $defaultLang = getDefaultLanguage(1);
        $scholarships = SchoolScholarship::with([
            'schoolScholarshipDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        $scholarships = $scholarships->whereIn('id', $favScholarships)->get();
        return view('front.account.fav-student-scholarships', compact('scholarships'));
    }
    public function favouriteScholarship()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $favScholarships = Favourite::where('customer_id', $customer_id)
            ->where('model', 'scholarship')
            ->pluck('record_id');

        $defaultLang = getDefaultLanguage(1);
        $favArticlesQuery = SchoolScholarship::whereHas('schoolScholarshipDetail', function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        })
            ->with([
                'schoolScholarshipDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_code', $defaultLang->abbreviation);
                },
            ])
            ->whereIn('id', $favScholarships);
        $scholarshipWithSchoolId = SchoolScholarship::whereHas('schoolScholarshipDetail', function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        })
            ->with([
                'schoolScholarshipDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_code', $defaultLang->abbreviation);
                },
            ])
            ->whereNotNull('school_id')
            ->where('customer_id', $customer_id);

        $scholarships = $scholarshipWithSchoolId->get()->merge($favArticlesQuery->get());
        // $scholarships = $scholarships->whereIn('id', $favScholarships)->get();
        return view('front.account.fav-scholarships', compact('scholarships'));
    }

    public function favouriteSchool()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $favschools = Favourite::where('customer_id', $customer_id)
            ->where('model', 'school')
            ->pluck('record_id');

        $defaultLang = getDefaultLanguage(1);
        $schools = School::with([
            'schoolDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        $schools = $schools->whereIn('id', $favschools)->get();
        return view('front.account.fav-schools', compact('schools'));
    }

    public function myEvents()
    {
        // $customer_id = Auth::guard('customers')->user()->id;
        // $defaultLang = getDefaultLanguage(1);
        // $events = Event::with([
        //     'eventDetail' => function ($q) use ($defaultLang) {
        //         $q = $q->where('language_id', $defaultLang->id);
        //     },
        // ])
        //     ->where('customer_id', $customer_id)
        //     ->get();
        // return view('front.account.my-events', compact('events'));

        $customer_id = Auth::guard('customers')->user()->id;
        $favevents = Favourite::where('customer_id', $customer_id)
            ->where('model', 'event')
            ->pluck('record_id');
        $defaultLang = getDefaultLanguage(1);
        $events = Event::with([
            'eventDetail' => function ($q) use ($defaultLang) {
                $q = $q->where('language_id', $defaultLang->id);
            },
        ])
            ->whereIn('id', $favevents)
            ->get();
        return view('front.account.my-events', compact('events'));
    }

    public function myQoutes()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $defaultLang = getDefaultLanguage(1);
        $quotes = Quote::with([
            'quoteDetail' => function ($q) use ($defaultLang) {
                $q = $q->where('language_id', $defaultLang->id);
            },
            'quoteImage',
            'school',
            'school.schoolDetail',
        ])
            ->where('customer_id', $customer_id)
            ->get();
        return view('front.account.my-qoutes', compact('quotes'));
    }

    public function Networks()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $defaultLang = getDefaultLanguage(1);
        $networks = Network::with([
            'networkDetail' => function ($q) use ($defaultLang) {
                $q = $q->where('language_id', $defaultLang->id);
            },
            'networkImage',
        ])
            ->where('customer_id', $customer_id)
            ->get();
        return view('front.account.networks', compact('networks'));
    }
    // public function NetworksStudent()
    // {
    //     $customer_id = Auth::guard('customers')->user()->id;
    //     $defaultLang = getDefaultLanguage(1);
    //     $networks = Network::with([
    //         'networkDetail' => function ($q) use ($defaultLang) {
    //             $q = $q->where('language_id', $defaultLang->id);
    //         },
    //         'networkImage',
    //     ])
    //         ->where('customer_id', $customer_id)
    //         ->get();
    //     return view('front.account.networks', compact('networks'));
    // }

    public function suggestedPrograms()
    {
        $customer_id = Auth::guard('customers')->user()->id;
        $getSlug = Customer::where('id', $customer_id)->value('slug');
        $defaultLang = getDefaultLanguage(1);
        $programs = ProgramDetail::with(['program'])->where('language_id', $defaultLang->id)
            // ->where('status', 'approved')
            ->where('customer_id', $customer_id)
            ->get();
        return view('front.account.suggested-programs', compact('programs', 'getSlug'));
    }

    public function schoolSetting()
    {
        $customerLangs = CustomerLanguage::whereCustomerId(Auth::guard('customers')->user()->id)->get();
        return view('front.account.school-setting', compact('customerLangs'));
    }

    public function Faq($lang,$slug, $type)
    {
        return view('front.account.faqs', compact('type'));
    }

    public function virtualTour()
    {
        $virtualTours = VirtualTour::with('virtualTourDetail')
            ->whereCustomerId(Auth::guard('customers')->user()->id)
            ->paginate(5);
        return view('front.account.virtual-tour.index', compact('virtualTours'));
    }

    public function virtualTourCreate()
    {
        return view('front.account.virtual-tour.create');
    }

    public function virtualTourEdit($lang, $slug, $virtualTour)
    {
        return view('front.account.virtual-tour.edit', compact('virtualTour'));
    }

    public function openDay()
    {
        $openDays = OpenDay::with('openDayDetail')
            ->whereCustomerId(Auth::guard('customers')->user()->id)
            ->paginate(5);
        return view('front.account.open-day.index', compact('openDays'));
    }

    public function openDayCreate()
    {
        return view('front.account.open-day.create');
    }

    public function openDayEdit($lang, $slug, $openDay)
    {
        return view('front.account.open-day.edit', compact('openDay'));
    }

    public function SchoolProgram()
    {
        return view('front.account.school-program');
    }

    public function SchoolContact()
    {
        return view('front.account.school-contact');
    }
    public function SchoolAmbassadorSetting()
    {
        return view('front.account.school-ambassador-setting');
    }

    public function SchoolScholarship()
    {
        return view('front.account.school-scholarship');
    }

    public function SchoolEmployee()
    {
        return view('front.account.school-employee');
    }

    public function SchoolInformation()
    {
        return view('front.account.school-information');
    }

    public function SchoolQuickFact()
    {
        return view('front.account.school-quick-facts');
    }

    public function SchoolOverview()
    {
        return view('front.account.school-overview');
    }

    public function blogOverview()
    {
        return view('front.account.blog');
    }

    public function schoolTeamsOverview()
    {
        return view('front.account.school-teams');
    }

    public function SchoolFinancial()
    {
        return view('front.account.school-financial');
    }

    public function closeAccount()
    {
        return view('front.account.close-account');
    }

    public function SchoolAmbassador()
    {
        return view('front.account.school-ambassador');
    }

    public function SchoolAmbassadorCreate()
    {
        return view('front.account.school-ambassador-create');
    }

    public function SchoolAmbassadorEdit($lang, $slug, $ambassador)
    {
        return view('front.account.school-ambassador-edit', compact('ambassador'));
    }

    public function SchoolAmbassadorReadMore($lang, $id, $slug)
    {
        if (!Auth::guard('customers')->check()) {
            return redirect('/' . $lang . '/login');
        }

        // Fetch ambassador based on both id and slug
        $ambassadorObject = SchoolAmbassador::with(['schoolAmbassadorDetail','messagingApp.messagingApp.messagingAppDetail'])
            ->where('id', $id)
            ->whereHas('schoolAmbassadorDetail', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->first();

        if (!$ambassadorObject) {
            return redirect('/' . $lang . '/ambassadors')->with('error', 'Ambassador not found');
        }
$language=Language::where('abbreviation',$lang)->first();
$apps=  $ambassadorObject->messagingApp;
        $ambassadorTranslations = getStaticTranslation('ambassadors');

        return view('front.school-ambassador-read-more', [
            'ambassadorObject' => $ambassadorObject,
            'ambassador' => $ambassadorObject->id,
            'ambassadorTranslations' => $ambassadorTranslations,
            'language'=>$language,
            'apps'=>$apps
        ]);
    }


    // public function SchoolAmbassadorReadMore($lang, $ambassador)
    // {
    //     if (!Auth::guard('customers')->check()) {
    //         return redirect('/' . $lang . '/login');
    //     } else {
    //         $ambassadorObject = SchoolAmbassador::with('schoolAmbassadorDetail')
    //             ->whereId($ambassador)
    //             ->first();
    //         $ambassadorTranslations = getStaticTranslation('ambassadors');
    //         return view('front.school-ambassador-read-more', compact('ambassador', 'ambassadorObject', 'ambassadorTranslations'));
    //     }
    // }
    // public function SchoolAmbassadorChat($lang, $ambassador)
    // {
    //     if (!Auth::guard('customers')->check()) {
    //         return redirect('/' . $lang . '/login');
    //     } else {
    //         $ambassadorObject = SchoolAmbassador::with('schoolAmbassadorDetail')
    //             ->whereId($ambassador)
    //             ->first();
    //         return view('front.school-ambassador-chat', compact('ambassador', 'ambassadorObject'));
    //     }
    // }
    public function SchoolAmbassadorChat($lang, $id, $slug)
    {
        if (!Auth::guard('customers')->check()) {
            return redirect('/' . $lang . '/login');
        } else {
            // Fetch ambassador based on both id and slug
            $ambassadorObject = SchoolAmbassador::with('schoolAmbassadorDetail')
                ->where('id', $id)
                ->whereHas('schoolAmbassadorDetail', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                })
                ->first();

            if (!$ambassadorObject) {
                return redirect('/' . $lang . '/ambassadors')->with('error', 'Ambassador not found');
            }

            // Pass both ambassadorObject and ambassador (id)
            return view('front.school-ambassador-chat', [
                'ambassadorObject' => $ambassadorObject,
                'ambassador' => $ambassadorObject->id,
            ]);
        }
    }


    public function SchoolChatInbox()
    {
        if (!Auth::guard('customers')->check()) {
            return redirect('/login');
        } else {
            $customer=Auth::guard('customers')->user();
            if($customer->user_type=='school'){
                $school=School::where('customer_id',$customer->id)->first();
                if($school){
                    $converstions = SchoolAmbassador::where('school_id',$school->id)->with('schoolAmbassadorDetail')->get();

                }
            }else{
                     $converstions = Conversation::with('last_messages')
                ->with('school_ambassador', 'school_ambassador.schoolAmbassadorDetail', 'school_ambassador.school', 'unCustomerSeenmessages')
                ->whereCustomerId(Auth::guard('customers')->user()->id)
                ->get();

            }
     

            
            return view('front.chat-inbox', compact('converstions','customer'));
        }
    }

    public function AllAmbassadorChats($lang,$id)
    {
        $ambassador_id=$id;
        if (!Auth::guard('customers')->check()) {
            return redirect('/login');
        } else {
        $conversations = Conversation::with('customer_last_messages')
            ->with('customer', 'school_ambassador', 'unAmbassadorSeenmessages', 'school_ambassador.schoolAmbassadorDetail', 'school_ambassador.school')
            ->where('school_ambassador_id', $id)
            ->get();
            $ambassador_name=SchoolAmbassadorDetail::where('school_ambassador_id', $id)->first();
            $ambassador_name=$ambassador_name->name;
   
            
            return view('front.ambassador-chat-inbox', compact('conversations','ambassador_id','ambassador_name'));
        }
    }
    public function StudentChat($lang,$ambassador_id,$id)
    {

        $ambassador=$ambassador_id;
        $ambassadorObject = SchoolAmbassador::with('schoolAmbassadorDetail')
            ->whereId($ambassador_id)
            ->first();
            $loggedInCustomer = Auth::guard('customers')->check() ? Auth::guard('customers')->user() : null;
            
            $customer_id = $id;
            $customerObject = Customer::whereId($customer_id)->first();


        return view('front.ambassador-student-chat', compact('customer_id',   'ambassadorObject', 'ambassador', 'customerObject'));
    }

    public function AdminChatInbox()
    {
        if (!Auth::guard('customers')->check()) {
            return redirect('/login');
        } else {
            return view('front.admin-chat');
        }
    }

    public function SchoolChatAmbassadors()
    {
        if (!Auth::guard('customers')->check()) {
            return redirect('/login');
        } else {
            $loggedInCustomer = Auth::guard('customers')->check() ? Auth::guard('customers')->user() : null;

            $schoolId = School::where('customer_id', $loggedInCustomer->id)->value('id');

            $ambassadors = SchoolAmbassador::with('school', 'school.schoolDetail', 'schoolAmbassadorDetail')
                ->where('status', 'active') 
                ->get();
            return view('front.chat-ambassadors', compact('ambassadors', 'schoolId'));
        }
    }

    public function studentProfile()
    {
        return view('front.account.student-profile');
    }

    public function searchStudentProfiles()
    {
        return view('front.account.search-student-profile');
    }

    public function demetraSetting()
    {
        return view('front.account.demetra-setting');
    }

    public function updatePassword()
    {
        return view('front.account.update-password');
    }

    public function webinarSetting()
    {
        return view('front.account.webinar.setting');
    }

    public function businessDashboard()
    {
        $businesses = Business::with('businessDetail')
            ->whereCustomerId(Auth::guard('customers')->user()->id)
            ->paginate(5);
        return view('front.account.business.index', compact('businesses'));
    }
    public function businessCreate()
    {
        return view('front.account.business.create');
    }
    public function businessEdit($lang,$slug, $business)
    {
        return view('front.account.business.edit', compact('business'));
    }

    public function Articles($lang)
    {
        $articles = Article::with('articleDetail', 'ArticleImage')
            ->whereCustomerId(Auth::guard('customers')->user()->id)
            ->paginate(5);
        return view('front.account.article.index', compact('articles'));
    }

    public function articleCreate()
    {
        return view('front.account.article.create');
    }

    public function articleEdit($lang, $slug,$article)
    {
        return view('front.account.article.edit', compact('article'));
    }
    // events
    public function Events($lang)
    {
        $events = Event::with('eventDetail')
            ->whereCustomerId(Auth::guard('customers')->user()->id)
            ->paginate(5);
        return view('front.account.event.index', compact('events'));
    }

    public function eventCreate()
    {
        return view('front.account.event.create');
    }

    public function eventEdit($lang, $event)
    {
        $repost = false;
        return view('front.account.event.edit', compact('event', 'repost'));
    }

    public function eventRepost($lang, $slug, $event)
    {
        $repost = true;
        return view('front.account.event.edit', compact('event', 'repost'));
    }
    public function Videos($lang)
    {
        $videos = Video::with('videoDetail')
            ->whereCustomerId(Auth::guard('customers')->user()->id)
            ->paginate(5);
        return view('front.account.video.index', compact('videos'));
    }

    public function videoCreate()
    {
        return view('front.account.video.create');
    }

    public function videoEdit($lang, $slug, $video)
    {
        return view('front.account.video.edit', compact('video'));
    }

    public function ProximaPayment()
    {
        if (!Auth::guard('customers')->check()) {
            $defaultLang = getDefaultLanguage(1);
            return redirect('/' . $defaultLang['abbreviation'] . '/login?url=' . env('APP_URL') . '/' . $defaultLang['abbreviation'] . '/proxima/checkout');
        }

        $paymentToBeDone = ProximaRequest::where('customer_id', Auth::guard('customers')->user()->id)
            ->where('status', '!=', 'paid')
            ->first();
        if (!$paymentToBeDone) {
            return redirect('/');
        }

        return view('front.proxima-payment', compact('paymentToBeDone'));
    }
}
