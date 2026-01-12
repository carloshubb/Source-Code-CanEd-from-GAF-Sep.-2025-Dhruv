<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Jobs\RegistrationEmailJob;
use App\Models\Activity;
use App\Models\AdmissionSetting;
use App\Models\AdmissionSettingDetail;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleCategoryDetail;
use App\Models\ArticleDetail;
use App\Models\Blog;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessDetail;
use App\Models\BusinessDirectory;
use App\Models\BusinessDirectoryDetail;
use App\Models\Career;
use App\Models\Customer;
use App\Models\CustomerLanguage;
use App\Models\Degree;
use App\Models\DegreeDetail;
use App\Models\Event;
use App\Models\Favourite;
use App\Models\OpenDay;
use App\Models\Page;
use App\Models\Program;
use App\Models\ProgramDetail;
use App\Models\RegistrationPackage;
use App\Models\ScholarshipSetting;
use App\Models\ScholarshipSettingDetail;
use App\Models\School;
use App\Models\SchoolAmbassador;
use App\Models\SchoolContactSetting;
use App\Models\SchoolContactSettingDetail;
use App\Models\SchoolDemetraSetting;
use App\Models\SchoolDetail;
use App\Models\SchoolFinancial;
use App\Models\SchoolFinancialDetail;
use App\Models\SchoolMoreImage;
use App\Models\SchoolOverview;
use App\Models\SchoolOverviewDetail;
use App\Models\SchoolProgramSetting;
use App\Models\SchoolProgramSettingDetail;
use App\Models\SchoolQuickFact;
use App\Models\SchoolQuickFactDetail;
use App\Models\SchoolQuickFactsFeature;
use App\Models\SchoolScholarship;
use App\Models\SchoolScholarshipDetail;
use App\Models\SchoolType;
use App\Models\SchoolTypeDetail;
use App\Models\Sponsor;
use App\Models\Story;
use App\Models\Webinar;
use App\Services\ZohoService;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    use StatusResponser;

    public function setCookies()
    {
        // Session::put('cookies_allow', 1);
        Cookie::queue('cookies_allow', true, 20160);
        return redirect()->back();
    }
    public function viewArticle($lang, $id, $slug)
    {
        $defaultLang = getDefaultLanguage(1);
        $article = Article::with([
            'articleDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleImage',
            'createdByUser',
            'updatedByUser',
        ])
            ->whereId($id)
            ->first();

        $premiumArticles = [];
        $freeArticles = [];

        $featuredArticles = $this->getArticles($defaultLang, $article, 8, 'featured');
        if (count($featuredArticles) < 8) {
            $remaingLimit = 8 - count($featuredArticles);
            $premiumArticles = $this->getArticles($defaultLang, $article, $remaingLimit, 'premium');

            if ((count($premiumArticles) + count($featuredArticles)) < 8) {
                $remaingLimit = 8 - (count($featuredArticles) + count($premiumArticles));
                $freeArticles = $this->getArticles($defaultLang, $article, $remaingLimit, '');
            }
        }

        $favorite = Auth::guard('customers')->check()
            ? Favourite::where('record_id', $id)
            ->where('model', 'article')
            ->where('customer_id', Auth::guard('customers')->user()->id)
            ->count()
            : 0;

        return view('front.article', compact('article', 'premiumArticles', 'featuredArticles', 'freeArticles', 'favorite'));
    }


    public function getArticles($defaultLang, $article, $limit, $packageType)
    {
        $articles = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        });

        if (isset($packageType) && !empty($packageType) && $packageType != "") {
            $articles = $articles->whereHas('school.customer.registrationPackage', function ($q) use ($packageType) {
                $q->where('package_type', $packageType);
            });
        } else {
            $articles = $articles->whereNull('school_id');
        }

        $articles = $articles->with([
            'articleDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleImage',
            'createdByUser',
            'updatedByUser',
        ])
            ->addSelect([
                'customer_match' => Article::selectRaw('1')
                    ->whereColumn('customer_id', 'articles.customer_id')
                    ->orWhere(function ($q) use ($article) {
                        $q->whereNull('customer_id')
                            ->whereNull('articles.customer_id');
                    })
                    ->limit(1),
                'category_match' => Article::selectRaw('1')
                    ->whereColumn('article_category', 'articles.article_category')
                    ->where('id', $article->id)
                    ->limit(1),
                'name_match' => ArticleDetail::select('name')
                    ->where('language_id', $defaultLang->id)
                    ->whereColumn('article_id', 'articles.id')
                    ->where('name', 'LIKE', '%' . $article->articleDetail->first()->name . '%')
                    ->limit(1),
                'description_match' => ArticleDetail::select('description')
                    ->where('language_id', $defaultLang->id)
                    ->whereColumn('article_id', 'articles.id')
                    ->where(function ($q) use ($article) {
                        $q->where('short_description', 'LIKE', '%' . $article->articleDetail->first()->name . '%')
                            ->orWhere('description', 'LIKE', '%' . $article->articleDetail->first()->name . '%');
                    })
                    ->limit(1),
            ])
            ->orderByDesc('customer_match')
            ->orderByDesc('category_match')
            ->orderByDesc('name_match')
            ->orderByDesc('description_match')
            ->limit($limit)
            ->get();
        return $articles;
    }

    public function viewStory($lang, $id)
    {
        $defaultLang = getDefaultLanguage(1);
        $story = Story::with([
            'storyDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])
            ->whereId($id)
            ->first();
        return view('front.story_detail', compact('story'));
    }

    public function blogDetail($lang, $blogId)
    {
        $defaultLang = getDefaultLanguage(1);
        $blog = Blog::whereId($blogId)->with([
            'blogDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])->firstOrFail();
        return view('front.blog-detail', compact('blog'));
    }

    public function viewSchool($lang, $id, $slug)
    {
        $defaultLang = getDefaultLanguage(1);

        $school = School::findOrFail($id);

        // Fetch latest articles created by the school
        $articles = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        })
            ->with(['articleDetail', 'ArticleImage', 'createdByUser', 'updatedByUser'])
            ->where('school_id', $id)
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->get();

        // If less than 3, fetch other latest articles
        if ($articles->count() < 3) {
            $missingCount = 3 - $articles->count();

            $extraArticles = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            })
                ->where('school_id', '!=', $id) // Exclude this school’s articles
                ->with(['articleDetail', 'ArticleImage', 'createdByUser', 'updatedByUser'])
                ->orderBy('created_at', 'DESC')
                ->take($missingCount)
                ->get();

            $articles = $articles->concat($extraArticles);
        }

        // If still less than 3, fetch general articles about studying in Canada
        if ($articles->count() < 3) {
            $missingCount = 3 - $articles->count();

            $canadaArticles = Article::whereHas('articleDetail', function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id)
                    ->where('name_title', 'LIKE', '%studying in Canada%');
            })
                ->with(['articleDetail', 'ArticleImage', 'createdByUser', 'updatedByUser'])
                ->orderBy('created_at', 'DESC')
                ->take($missingCount)
                ->get();

            $articles = $articles->concat($canadaArticles);
        }




        $schoolLang = Session::has('school_lang') ? Session::get('school_lang') : getDefaultLanguage()->abbreviation;
        $school = School::with([
            'schoolDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'schoolScholarships',
            'schoolScholarships.schoolScholarshipDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'schoolQuickFact',
            'schoolQuickFact.schoolQuickFactDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'schoolOverview',
            'schoolOverview.schoolOverviewDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'schoolOverview.overviewPrograms',
            'admissionSetting',
            'admissionSetting.admissionSettingDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'schoolEmployees',
            'schoolEmployees.schoolEmployeeDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'schoolFinancial',
            'schoolFinancial.schoolFinancialDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'schoolContacts',
            'schoolContacts.schoolContactDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'schoolContactSetting',
            'schoolContactSetting.SchoolContactSettingDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'schoolPrograms',
            'schoolPrograms.schoolProgramDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },

            'schoolPrograms.Program',
            'schoolProgramSetting',
            'schoolProgramSetting.SchoolProgramSettingDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'scholarshipSetting',
            'scholarshipSetting.scholarshipSettingDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'schoolAmbassador',
            'schoolAmbassador.schoolAmbassadorDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
            'faqs',
            'schoolMoreImages',
            'schoolMoreLinks',
            'schoolMoreLinks.schoolMoreLinkDetail' => function ($q) use ($schoolLang) {
                $q->where('language_code', $schoolLang);
            },
        ])
            ->where('deactive_account', 0)
            ->whereId($id)
            ->first();
        $customerLangs = CustomerLanguage::where('customer_id', $school->customer_id)->get();

        $schoolContactTranslations = getStaticTranslation('contact_school');

        $favorite = Auth::guard('customers')->check()
            ? Favourite::where('record_id', $id)
            ->where('model', 'school')
            ->where('customer_id', Auth::guard('customers')->user()->id)
            ->count()
            : 0;

        return view('front.school', compact('schoolLang', 'customerLangs', 'favorite', 'school', 'articles', 'schoolContactTranslations'));
    }
    public function schoolByDegree($lang, $id, $slug)
    {
        $defaultLang = getDefaultLanguage(1);

        $degree = Degree::with('degreeDetail')
            ->where('id', $id)
            ->whereHas('degreeDetail', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->firstOrFail();

        $schools = School::query();
        $schools = $schools->with(['schoolDetail' => function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        }]);
        $schools = $schools->addSelect(['package_type' => RegistrationPackage::whereColumn('registration_package_id', 'registration_packages.id')->select('package_type')]);
        $schools = $schools->where('schools.deactive_account', 0);
        $schools = $schools->where('schools.deleted_at', null);
        $schools = $schools->where('schools.degree_id', $id);
        $schools = $schools->addSelect(['name_order' => SchoolDetail::whereColumn('school_id', 'schools.id')->where('school_details.language_code', $defaultLang->abbreviation)->select('school_name')]);
        $schools = $schools->orderByRaw("ISNULL(package_type),FIELD(package_type, 'featured', 'premium', 'free') ASC");
        $schools = $schools->orderBy('name_order');

        $search = request('search');
        if ($search) {
            $schools = $schools->whereHas('schoolDetail', function ($query) use ($search) {
                $query->where('school_name', 'LIKE', "%{$search}%");
            });
        }
        $schools = $schools->paginate(5);
        // dd($schools);
        return view('front.school-by-degree', compact('schools', 'degree'));
    }
    public function addEvent()
    {
        return view('front.add-event');
    }
    public function addCareer()
    {
        return view('front.add-career');
    }
    public function addStory()
    {
        return view('front.add-story');
    }
    public function eventDetail($lang, $id)
    {
        $defaultLang = getDefaultLanguage(1);

        $event = Event::with([
            'eventDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'eventImage',
            'customer.school.schoolDetail',
            'eventContact',
        ])
            ->whereSlug($id)
            ->firstOrFail();

        $events = Event::with([
            'eventDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'eventImage',
        ])
            ->limit(6)
            ->get();
        $favs = Favourite::where('model', 'event')->count();
        $eventTranslations = getStaticTranslation('events');
        $favorite = Auth::guard('customers')->check()
            ? Favourite::where('record_id', $id)
            ->where('model', 'event')
            ->where('customer_id', Auth::guard('customers')->user()->id)
            ->count()
            : 0;
        return view('front.event-detail', compact('favorite', 'event', 'events', 'favs', 'eventTranslations'));
    }

    public function becomeSponsorForm()
    {
        return view('front.become-sponsor');
    }

    public function sponsorDetail($lang, $id)
    {
        $defaultLang = getDefaultLanguage(1);

        $sponsor = Sponsor::with([
            'sponsorDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])
            ->whereId($id)
            ->firstOrFail();

        $sponsors = Sponsor::with([
            'sponsorDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])
            ->limit(6)
            ->get();
        // $eventTranslations = getStaticTranslation('event');
        return view('front.sponsor-detail', compact('sponsor', 'sponsors'));
    }

    public function openDayDetail($lang, $id)
    {
        $defaultLang = getDefaultLanguage(1);
        $openDay = OpenDay::with(['openDayDetail', 'school', 'school.schoolDetail'])
            ->whereId($id)
            ->first();
        $openDays = OpenDay::with([
            'openDayDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
            'favourite',
        ])
            ->where('city', 'LIKE', "%{$openDay->city}%")
            ->where('school_id', $openDay->school_id)
            ->whereNot('id', $id)
            ->where('date', '>=', now()->toDateString())
            ->take(6)
            ->get();
        $location = isset($openDay->school->province) ? $openDay->school->province : '';
        // $location = isset($openDay->city) ? $openDay->city : '';
        if ($location) {
            $count = count($openDays);
            if ($count < 6) {
                $additionalRecords = OpenDay::with([
                    'openDayDetail' => function ($q) use ($defaultLang) {
                        $q->where('language_code', $defaultLang->abbreviation);
                    },
                    'favourite',
                    'school' => function ($q) use ($openDay) {
                        $q->where('province', $openDay->school->province);
                        // $q->where('city', $openDay->city);
                    },
                ])
                    ->where('country', 'LIKE', "%{$openDay->country}%") // Same country
                    ->whereNot('city', 'LIKE', "%{$openDay->city}%")
                    ->whereNot('id', $id)
                    ->where('date', '>=', now()->toDateString())
                    ->whereNotIn('id', $openDays->pluck('id'))
                    ->take(6 - $count)
                    ->get();

                $openDays = $openDays->concat($additionalRecords)->unique('id')->values();
            }
        }

        $count = count($openDays);

        if ($count < 6) {
            $additionalRecords = OpenDay::with([
                'openDayDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_code', $defaultLang->abbreviation);
                },
                'favourite',
            ])
                ->inRandomOrder()
                ->take(6 - $count)
                ->where('date', '>=', now()->toDateString())
                ->whereNotIn('id', $openDays->pluck('id'))
                ->whereNot('id', $id)
                ->get();

            $openDays = $openDays->concat($additionalRecords)->unique('id')->values();
        }
        $openDayContactTranslations = getStaticTranslation('open_houses');
        $favorite = Auth::guard('customers')->check()
            ? Favourite::where('record_id', $id)
            ->where('model', 'openday')
            ->where('customer_id', Auth::guard('customers')->user()->id)
            ->count()
            : 0;
        return view('front.open-day-detail', compact('favorite', 'openDay', 'openDays', 'openDayContactTranslations'));
    }

    public function webinarDetail($lang, $id)
    {
        $defaultLang = getDefaultLanguage(1);
        $webinars = Webinar::inRandomOrder()
            ->limit(6)
            ->get();
        $webinar = Webinar::with(['schoolAmbassador', 'schoolAmbassador.school', 'schoolAmbassador.school.schoolDetail'])
            ->whereId($id)
            ->first();
        $webinarTranslations = getStaticTranslation('webinar_page');
        return view('front.webinar-detail', compact('webinar', 'webinars', 'webinarTranslations'));
    }

    public function searchResults(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        if ($request->search_type == 'school') {
            // $schools = \DB::table('schools')
            //     ->join('school_details', function ($join) use ($defaultLang, $request) {
            //         $join->on('schools.id', '=', 'school_details.school_id')->where('school_details.language_code', '=', $defaultLang->abbreviation);
            //         if (!empty($request->search)) {
            //             $join->where('school_details.school_name', 'LIKE', '%' . $request->search . '%');
            //         }
            //     })
            //     ->leftjoin('customers', 'schools.customer_id', '=', 'customers.id')
            //     ->leftjoin('registration_packages', 'customers.registration_package_id', '=', 'registration_packages.id')
            //     ->select(['schools.id as  school_id', 'schools.*', 'school_details.*', 'school_details.school_name as name_order', 'customers.registration_package_id', 'registration_packages.package_type'])
            //     ->where('schools.deactive_account', 0)
            //     ->where('schools.deleted_at', null)
            //     // ->where('package_type','!=',null)
            //     ->orderByRaw("ISNULL(package_type),FIELD(package_type, 'featured', 'premium', 'free') ASC")

            //     ->orderBy('name_order');
            // $schools = $schools->paginate(10);

            $schools = School::query();
            $schools = $schools->with(['schoolDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            }]);
            $schools = $schools->whereHas('schoolDetail', function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
                if (!empty(request('search'))) {
                    $q->where('school_name', 'LIKE', '%' . request('search') . '%');
                }
            });
            $schools = $schools->addSelect(['package_type' => RegistrationPackage::whereColumn('registration_package_id', 'registration_packages.id')->select('package_type')]);
            $schools = $schools->where('schools.deactive_account', 0);
            $schools = $schools->where('schools.deleted_at', null);
            $schools = $schools->addSelect(['name_order' => SchoolDetail::whereColumn('school_id', 'schools.id')->where('school_details.language_code', $defaultLang->abbreviation)->select('school_name')]);
            $schools = $schools->orderByRaw("ISNULL(package_type),FIELD(package_type, 'featured', 'premium', 'free') ASC");
            $schools = $schools->orderBy('name_order');

            $schools = $schools->paginate(10);
            return view('front.school-search', compact('schools'));
        }
        if ($request->search_type == 'articles') {
            $articles = Article::whereHas('articleDetail', function ($q) use ($defaultLang, $request) {
                $q->where('language_id', $defaultLang->id);
                if (!empty($request->search)) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('keyword', 'LIKE', '%' . $request->search . '%');
                }
            })->with([
                'articleDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
                'ArticleImage',
                'createdByUser',
                'updatedByUser',
            ]);
            if (isset($request->category)) {
                $articles = $articles->where('article_category', $request->category);
            }
            $articles = $articles->addSelect([
                'name_order' => ArticleDetail::where('language_id', $defaultLang->id)
                    ->whereColumn('article_id', 'articles.id')
                    ->limit(1)
                    ->select('name'),
            ]);
            $articles = $articles->orderBy('name_order')->paginate(12);
            return view('front.article-search', compact('articles'));
        }

        if ($request->search_type == 'business') {
            $businesses = \DB::table('businesses')
                ->join('business_details', function ($join) use ($defaultLang, $request) {
                    $join->on('businesses.id', '=', 'business_details.business_id')->where('business_details.language_id', '=', $defaultLang->id);

                    if (!empty($request->search)) {
                        $join->where(function ($query) use ($request) {
                            $query->where('business_details.business_name', 'LIKE', '%' . $request->search . '%')
                                ->orWhere('business_details.description', 'LIKE', '%' . $request->search . '%')
                                ->orWhere('business_details.detail_description', 'LIKE', '%' . $request->search . '%')
                                ->orWhere('business_details.media_section_description', 'LIKE', '%' . $request->search . '%');
                        });
                    }
                })
                ->leftjoin('customers', 'businesses.customer_id', '=', 'customers.id')
                ->leftjoin('registration_packages', 'customers.registration_package_id', '=', 'registration_packages.id')
                ->select(['businesses.id as business_id', 'businesses.*', 'business_details.*', 'business_details.business_name as name_order', 'customers.registration_package_id', 'registration_packages.package_type'])
                ->where('businesses.deactive_account', 0)
                ->where('businesses.deleted_at', null)
                ->orderByRaw("ISNULL(package_type),FIELD(package_type, 'featured', 'premium', 'free') ASC")
                ->orderBy('name_order');
            // dd($businesses);
            $businesses = $businesses->paginate(10);
            return view('front.business-search', compact('businesses'));
        }
        if ($request->search_type == 'programs') {
            $programs = Program::with([
                'programDetail' => function ($q) use ($defaultLang, $request) {
                    $q->where('language_id', $defaultLang->id);
                    // if (!empty($request->search)) {
                    //     $q->where('name', 'LIKE', '%' . $request->search . '%');
                    // }
                },
            ]);
            if (!empty($request->search)) {
                $programs->whereHas('programDetail', function ($q) use ($request, $defaultLang) {
                    $q->where('language_id', $defaultLang->id)
                        ->where('name', 'LIKE', '%' . $request->search . '%');
                });
            }
            $programs = $programs->addSelect([
                'name_order' => ProgramDetail::whereColumn('program_id', 'programs.id')
                    ->where('language_id', $defaultLang->id)
                    ->limit(1)
                    ->select('name'),
            ]);
            $programs = $programs->with('Degree', 'Degree.degreeDetail', 'SchoolPrograms', 'SchoolPrograms.schoolProgramDetail', 'SchoolPrograms.School');
            $programs = $programs->where('status', 'approved');

            $programs = $programs->orderBy('name_order');

            $programs = $programs->get();
            $programTranslations = getStaticTranslation('program');
            return view('front.search-programs', compact('programs', 'programTranslations'));
        }

        if ($request->search_type == 'scholarship') {
            $scholarships = SchoolScholarship::with([
                'schoolScholarshipDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_code', $defaultLang->abbreviation);
                },
                'school',
                'school.schoolDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_code', $defaultLang->abbreviation);
                },
            ])->whereHas('schoolScholarshipDetail', function ($q) use ($defaultLang, $request) {
                $q->where('language_code', $defaultLang->abbreviation);
                if (!empty($request->search)) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                }
            });

            $scholarships = $scholarships->addSelect([
                'name_order' => SchoolScholarshipDetail::where('language_code', $defaultLang->abbreviation)
                    ->whereColumn('school_scholarship_id', 'school_scholarships.id')
                    ->limit(1)
                    ->select('name'),
            ]);
            $scholarships = $scholarships->orderBy('name_order')->paginate(12);
            return view('front.search-scholarships', compact('scholarships'));
        }
    }

    public function advanceSearchSchool()
    {
        $defaultLang = getDefaultLanguage(1);
        $degrees = Degree::with([
            'degreeDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'degreeImage',
        ])
            ->addSelect([
                'name_order' => DegreeDetail::where('language_id', $defaultLang->id)->whereColumn('degree_id', 'degrees.id')
                    ->limit(1)
                    ->select('name'),
            ])


            ->orderBy('name_order')
            ->get();
        $schoolTypes = SchoolType::with([
            'schoolTypeDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])->addSelect([
            'name_order' => SchoolTypeDetail::where('language_id', $defaultLang->id)
                ->whereColumn('school_type_id', 'school_types.id')
                ->limit(1)
                ->select('name'),
        ])->orderBy('name_order')->get();
        $programs = Program::with([
            'programDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])->addSelect([
            'name_order' => ProgramDetail::where('language_id', $defaultLang->id)
                ->whereColumn('program_id', 'programs.id')
                ->limit(1)
                ->select('name'),
        ])->orderBy('name_order')->where('status', 'approved')->get();
        $langs = getRawLanguages();
        $advanceSearchTranslations = getStaticTranslation('advance_search');
        return view('front.school-advance-search', compact('degrees', 'langs', 'schoolTypes', 'programs', 'advanceSearchTranslations'));
    }

    public function advanceSearchSchoolResults(Request $request)
    {
        $schoolQuickFacts = SchoolQuickFact::query();
        if (isset($request->online_or_distance_education) && $request->online_or_distance_education != null && $request->online_or_distance_education != 'all' && $request->online_or_distance_education != '') {
            $schoolQuickFacts->where('online_or_distance_education', $request->online_or_distance_education);
        }
        if (isset($request->school_type) && $request->school_type != null && $request->school_type != 'all' && $request->school_type != '') {
            $schoolQuickFacts->where('school_type', $request->school_type);
        }

        if (isset($request->conditional_admission) && $request->conditional_admission != null && $request->conditional_admission != 'all' && $request->conditional_admission != '') {
            $schoolQuickFacts->where('conditional_admission', $request->conditional_admission);
        }

        if (isset($request->study_method) && $request->study_method != null && $request->study_method != 'all' && $request->study_method != '') {
            $schoolQuickFacts->where('study_method', $request->study_method);
        }

        if (isset($request->delivery_mode) && $request->delivery_mode != null && $request->delivery_mode != 'all' && $request->delivery_mode != '') {
            $schoolQuickFacts->where('delivery_mode', $request->delivery_mode);
        }

        if (isset($request->accomodation) && $request->accomodation != null && $request->accomodation != 'all' && $request->accomodation != '') {
            $schoolQuickFacts->where('accomodation', $request->accomodation);
        }

        if (isset($request->work_on_campus) && $request->work_on_campus != null && $request->work_on_campus != 'all' && $request->work_on_campus != '') {
            $schoolQuickFacts->where('work_on_campus', $request->work_on_campus);
        }

        if (isset($request->work_during_holidays) && $request->work_during_holidays != null && $request->work_during_holidays != 'all' && $request->work_during_holidays != '') {
            $schoolQuickFacts->where('work_during_holidays', $request->work_during_holidays);
        }

        if (isset($request->internship) && $request->internship != null && $request->internship != 'all' && $request->internship != '') {
            $schoolQuickFacts->where('internship', $request->internship);
        }

        if (isset($request->co_op_education) && $request->co_op_education != null && $request->co_op_education != 'all' && $request->co_op_education != '') {
            $schoolQuickFacts->where('co_op_education', $request->co_op_education);
        }

        if (isset($request->job_placement) && $request->job_placement != null && $request->job_placement != 'all' && $request->job_placement != '') {
            $schoolQuickFacts->where('job_placement', $request->job_placement);
        }
        $selectedOptions = $_GET['financial_aid_programs_for_domastic_students'] ?? null;
        if (isset($selectedOptions) && !in_array('all', $selectedOptions) && is_array($selectedOptions) && count($selectedOptions) > 0) {
            $schoolQuickFacts->where(function ($q) use ($selectedOptions) {
                foreach ($selectedOptions as $key => $selectedOption) {
                    if ($key == 0) {
                        $q->where('financial_aid_programs_for_domastic_students', 'Like', '%' . $selectedOption . '%');
                    } else {
                        $q->orWhere('financial_aid_programs_for_domastic_students', 'Like', '%' . $selectedOption . '%');
                    }
                }
            });
        }

        $selectedOptions = $_GET['financial_aid_programs_for_province_students'] ?? null;
        if (isset($selectedOptions) && !in_array('all', $selectedOptions) && is_array($selectedOptions) && count($selectedOptions) > 0) {
            $schoolQuickFacts->where(function ($q) use ($selectedOptions) {
                foreach ($selectedOptions as $key => $selectedOption) {
                    if ($key == 0) {
                        $q->where('financial_aid_programs_for_province_students', 'Like', '%' . $selectedOption . '%');
                    } else {
                        $q->orWhere('financial_aid_programs_for_province_students', 'Like', '%' . $selectedOption . '%');
                    }
                }
            });
        }

        $selectedOptions = $_GET['financial_aid_programs_for_international_students'] ?? null;
        if (isset($selectedOptions) && !in_array('all', $selectedOptions) && is_array($selectedOptions) && count($selectedOptions) > 0) {
            $schoolQuickFacts->where(function ($q) use ($selectedOptions) {
                foreach ($selectedOptions as $key => $selectedOption) {
                    if ($key == 0) {
                        $q->where('financial_aid_programs_for_international_students', 'Like', '%' . $selectedOption . '%');
                    } else {
                        $q->orWhere('financial_aid_programs_for_international_students', 'Like', '%' . $selectedOption . '%');
                    }
                }
            });
        }

        if (isset($request->research_and_dissertaion) && $request->research_and_dissertaion != null && $request->research_and_dissertaion != 'all' && $request->research_and_dissertaion != '') {
            $schoolQuickFacts->where('research_and_dissertaion', $request->research_and_dissertaion);
        }

        if (isset($request->exchange_program) && $request->exchange_program != null && $request->exchange_program != 'all' && $request->exchange_program != '') {
            $schoolQuickFacts->where('exchange_program', $request->exchange_program);
        }

        if (isset($request->degree_modifier) && $request->degree_modifier != null && $request->degree_modifier != 'all' && $request->degree_modifier != '') {
            $schoolQuickFacts->where('degree_modifier', $request->degree_modifier);
        }

        if (isset($request->daycare_for_students_with_kids) && $request->daycare_for_students_with_kids != null && $request->daycare_for_students_with_kids != 'all' && $request->daycare_for_students_with_kids != '') {
            $schoolQuickFacts->where('daycare_for_students_with_kids', $request->daycare_for_students_with_kids);
        }

        if (isset($request->elementary_school_for_students_with_kids) && $request->elementary_school_for_students_with_kids != null && $request->elementary_school_for_students_with_kids != 'all' && $request->elementary_school_for_students_with_kids != '') {
            $schoolQuickFacts->where('elementary_school_for_students_with_kids', $request->elementary_school_for_students_with_kids);
        }

        if (isset($request->immigration_office_on_campus) && $request->immigration_office_on_campus != null && $request->immigration_office_on_campus != 'all' && $request->immigration_office_on_campus != '') {
            $schoolQuickFacts->where('immigration_office_on_campus', $request->immigration_office_on_campus);
        }

        if (isset($request->career_planing) && $request->career_planing != null && $request->career_planing != 'all' && $request->career_planing != '') {
            $schoolQuickFacts->where('career_planing', $request->career_planing);
        }

        if (isset($request->pathway_programs) && $request->pathway_programs != null && $request->pathway_programs != 'all' && $request->pathway_programs != '') {
            $schoolQuickFacts->where('pathway_programs', $request->pathway_programs);
        }

        if (isset($request->employeement_rates) && $request->employeement_rates != null && $request->employeement_rates != 'all' && $request->employeement_rates != '') {
            $schoolQuickFacts->where('employeement_rates', $request->employeement_rates);
        }

        if (isset($request->class_size_undergraduate) && $request->class_size_undergraduate != null && $request->class_size_undergraduate != 'all' && $request->class_size_undergraduate != '') {
            $schoolQuickFacts->where('class_size_undergraduate', $request->class_size_undergraduate);
        }

        if (isset($request->class_size_masters) && $request->class_size_masters != null && $request->class_size_masters != 'all' && $request->class_size_masters != '') {
            $schoolQuickFacts->where('class_size_masters', $request->class_size_masters);
        }

        if (isset($request->service_and_guidance_new_students) && $request->service_and_guidance_new_students != null && $request->service_and_guidance_new_students != 'all' && $request->service_and_guidance_new_students != '') {
            $schoolQuickFacts->where('service_and_guidance_new_students', $request->service_and_guidance_new_students);
        }

        if (isset($request->service_and_guidance_to_new_arrivals_in_canada) && $request->service_and_guidance_to_new_arrivals_in_canada != null && $request->service_and_guidance_to_new_arrivals_in_canada != 'all' && $request->service_and_guidance_to_new_arrivals_in_canada != '') {
            $schoolQuickFacts->where('service_and_guidance_to_new_arrivals_in_canada', $request->service_and_guidance_to_new_arrivals_in_canada);
        }

        if (isset($request->program_type_greduates) && $request->program_type_greduates != null && $request->program_type_greduates != 'all' && $request->program_type_greduates != '') {
            $schoolQuickFacts->where('program_type_greduates', $request->program_type_greduates);
        }

        if (isset($request->program_type_undergreduates) && $request->program_type_undergreduates != null && $request->program_type_undergreduates != 'all' && $request->program_type_undergreduates != '') {
            $schoolQuickFacts->where('program_type_undergreduates', $request->program_type_undergreduates);
        }

        if (isset($request->years_before_elegible_for_pr) && $request->years_before_elegible_for_pr != null && $request->years_before_elegible_for_pr != 'all' && $request->years_before_elegible_for_pr != '') {
            $schoolQuickFacts->where('years_before_elegible_for_pr', $request->years_before_elegible_for_pr);
        }

        if (isset($request->work_off_campus) && $request->work_off_campus != null && $request->work_off_campus != 'all' && $request->work_off_campus != '') {
            $schoolQuickFacts->where('work_off_campus', $request->work_off_campus);
        }

        $school_ids = $schoolQuickFacts->pluck('school_id');
        $defaultLang = getDefaultLanguage(1);
        // $schools = \DB::table('schools')->whereIn('schools.id', $school_ids)
        //     ->join('school_details', function ($join) use ($defaultLang, $request) {
        //         $join->on('schools.id', '=', 'school_details.school_id')->where('school_details.language_code', '=', $defaultLang->abbreviation);

        //         if (!empty($request->search)) {
        //             $join->where('school_details.school_name', 'LIKE', '%' . $request->search . '%');
        //         }
        //     })
        //     ->leftjoin('customers', 'schools.customer_id', '=', 'customers.id')
        //     ->leftjoin('customer_languages', 'schools.customer_id', '=', 'customer_languages.customer_id')
        //     ->leftjoin('registration_packages', 'customers.registration_package_id', '=', 'registration_packages.id')
        //     ->select(['schools.*', 'schools.id as  school_id', 'school_details.*', 'school_details.school_name as name_order', 'customers.registration_package_id', 'registration_packages.package_type'])
        //     ->where('schools.deactive_account', 0)
        //     ->where('schools.deleted_at', null)
        //     ->orderByRaw("ISNULL(package_type),FIELD(package_type, 'featured', 'premium', 'free') ASC")
        //     ->orderBy('name_order');
        // if (isset($request->city) && $request->city != null && $request->city != 'all' && $request->city != '') {
        //     $schools->where('schools.city', $request->city);
        // }

        // if (isset($request->province) && $request->province != null && $request->province != 'all' && $request->province != '') {
        //     $schools->where('schools.province', $request->province);
        // }

        // if (isset($request->degree_id) && $request->degree_id != null && $request->degree_id != 'all' && $request->degree_id != '') {
        //     $schools->where('schools.degree_id', $request->degree_id);
        // }

        // $selectedOptions = $_GET['lang'] ?? null;
        // if (isset($selectedOptions) && !in_array('all', $selectedOptions) && is_array($selectedOptions) && count($selectedOptions) > 0) {
        //     $schools->where(function ($q) use ($selectedOptions) {
        //         foreach ($selectedOptions as $key => $selectedOption) {
        //             if ($key == 0) {
        //                 $q->where('customer_languages.language_code', 'Like', '%' . $selectedOption . '%');
        //             } else {
        //                 $q->orWhere('customer_languages.language_code', 'Like', '%' . $selectedOption . '%');
        //             }
        //         }
        //     });
        // }
        // $schools = $schools->paginate(10);




        $schools = School::whereIn('id', $school_ids);
        $schools = $schools->with(['schoolDetail' => function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        }]);
        $schools = $schools->whereHas('schoolDetail', function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
            if (!empty(request('search'))) {
                $q->where('school_name', 'LIKE', '%' . request('search') . '%');
            }
        });
        $schools = $schools->addSelect(['package_type' => RegistrationPackage::whereColumn('registration_package_id', 'registration_packages.id')->select('package_type')]);
        $schools = $schools->where('schools.deactive_account', 0);
        $schools = $schools->where('schools.deleted_at', null);
        $schools = $schools->addSelect(['name_order' => SchoolDetail::whereColumn('school_id', 'schools.id')->where('school_details.language_code', $defaultLang->abbreviation)->select('school_name')]);
        $schools = $schools->orderByRaw("ISNULL(package_type),FIELD(package_type, 'featured', 'premium', 'free') ASC");
        $schools = $schools->orderBy('name_order');

        if (isset($request->city) && $request->city != null && $request->city != 'all' && $request->city != '') {
            $schools->where('city', $request->city);
        }

        $selectedProvinceOptions = $_GET['province'] ?? null;
        if (isset($selectedProvinceOptions) && !in_array('all', $selectedProvinceOptions) && is_array($selectedProvinceOptions) && count($selectedProvinceOptions) > 0) {

            $schools->where(function ($q) use ($selectedProvinceOptions) {
                foreach ($selectedProvinceOptions as $key => $province) {  // Changed variable to $province
                    if ($key == 0) {
                        $q->where('province', 'LIKE', '%' . $province . '%');
                    } else {
                        $q->orWhere('province', 'LIKE', '%' . $province . '%');
                    }
                }
            });
        }
        // if (isset($request->province) && $request->province != null && $request->province != 'all' && $request->province != '') {
        //     $schools->where('province', $request->province);
        // }

        if (isset($request->degree_id) && $request->degree_id != null && $request->degree_id != 'all' && $request->degree_id != '') {
            $schools->where('degree_id', $request->degree_id);
        }

        $selectedOptions = $_GET['lang'] ?? null;
        if (isset($selectedOptions) && !in_array('all', $selectedOptions) && is_array($selectedOptions) && count($selectedOptions) > 0) {
            $schools->whereHas('customer.customerLanguage', function ($query) use ($selectedOptions) {

                $query->where(function ($q) use ($selectedOptions) {
                    foreach ($selectedOptions as $key => $selectedOption) {
                        if ($key == 0) {
                            $q->where('customer_languages.language_code', 'Like', '%' . $selectedOption . '%');
                        } else {
                            $q->orWhere('customer_languages.language_code', 'Like', '%' . $selectedOption . '%');
                        }
                    }
                });
            });
        }

        $schools = $schools->paginate(10);
        return view('front.school-search', compact('schools'));
    }

    public function viewBusiness($lang, $id, $slug)
    {
        $defaultLang = getDefaultLanguage(1);
        $businesses = Business::with([
            'businessDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        $businesses = $businesses->where('deactive_account', 0)->where(function ($query) use ($id) {
            $query
                ->where('business_catagory_1', $id)
                ->orWhere('business_catagory_2', $id)
                ->orWhere('business_catagory_3', $id);
        });

        $businesses = $businesses->addSelect([
            'name_order' => BusinessDetail::where('language_id', $defaultLang->id)
                ->whereColumn('business_id', 'businesses.id')
                ->limit(1)
                ->select('business_name'),
        ]);
        $businesses = $businesses->addSelect([
            'package_type' => DB::raw("
                CASE
                    WHEN businesses.customer_id IS NULL THEN 'free'  -- If customer_id is NULL, set package_type to 'free'
                    WHEN NOT EXISTS (SELECT 1 FROM customers WHERE customers.id = businesses.customer_id) THEN 'free'  -- If no matching customer, set package_type to 'free'
                    WHEN NOT EXISTS (SELECT 1 FROM registration_packages 
                                      JOIN customers ON customers.registration_package_id = registration_packages.id
                                      WHERE customers.id = businesses.customer_id) THEN 'free'  -- If no matching registration_package_id, set package_type to 'free'
                    ELSE (
                        SELECT registration_packages.package_type
                        FROM registration_packages
                        JOIN customers ON customers.registration_package_id = registration_packages.id
                        WHERE customers.id = businesses.customer_id
                        LIMIT 1
                    )
                END AS package_type
            ")
        ]);
        $businesses = $businesses->orderByRaw("FIELD(package_type, 'featured', 'premium', 'free') ASC");
        $businesses = $businesses
            ->where('deactive_account', 0)
            ->orderBy('name_order')
            ->paginate(12);

        $businessCategory = BusinessCategory::with(['businessCategoryDetail' => function ($q) use ($defaultLang) {
            $q->whereLanguageId($defaultLang->id);
        }])->whereId($id)->first();

        return view('front.businesses', compact('businesses', 'businessCategory'));
    }

    public function viewBusinessDetail($lang, $id)
    {
        $defaultLang = getDefaultLanguage(1);
        $business = Business::with([
            'businessDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'businessCategory1',
            'businessCategory2',
            'businessCategory3',
            'businessCategory1.businessCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'businessCategory2.businessCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'businessCategory3.businessCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])
            ->where('deactive_account', 0)
            ->where('id', $id)
            ->first();

        // $businesses = Business::with([
        //     'businessDetail' => function ($q) use ($defaultLang) {
        //         $q->where('language_id', $defaultLang->id);
        //     },
        // ]);
        // $businesses = $businesses->addSelect([
        //     'name_order' => BusinessDetail::whereColumn('business_id', 'businesses.id')
        //         ->limit(1)
        //         ->select('business_name'),
        // ]);
        // $businesses = $businesses
        //     ->where('deactive_account', 0)
        //     ->orderBy('name_order')
        //     ->limit(4)
        //     ->get();

        // aasdasd
        // $businesses = Business::with([
        //     'businessDetail' => function ($q) use ($defaultLang) {
        //         $q->where('language_id', $defaultLang->id);
        //     },
        // ]);

        // $businesses = $businesses->addSelect([
        //     'name_order' => BusinessDetail::whereColumn('business_id', 'businesses.id')
        //         ->limit(1)
        //         ->select('business_name'),
        // ]);

        // $businesses = $businesses
        //     ->where('deactive_account', 0)
        //     ->whereHas('customer', function ($q) {
        //         $q->where('user_type', 'business')
        //             ->where('package_price', '>', 0);
        //     })
        //     ->orderBy('name_order')
        //     ->limit(4)
        //     ->get();

        $businesses = Business::with([
            'businessDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])
            ->addSelect([
                'name_order' => BusinessDetail::whereColumn('business_id', 'businesses.id')
                    ->limit(1)
                    ->select('business_name'),
                'package_type' => RegistrationPackage::whereColumn('id', 'customers.registration_package_id')
                    ->select('package_type')
            ])
            ->leftJoin('customers', 'customers.id', '=', 'businesses.customer_id') // Join customers table
            ->leftJoin('registration_packages', 'registration_packages.id', '=', 'customers.registration_package_id') // Join registration_packages
            ->where('businesses.deactive_account', 0) // Explicitly specify table name
            ->where('customers.package_price', '>', 0)
            ->where('customers.user_type', 'business')
            ->where('businesses.id', '!=', $business->id)
            ->orderByRaw("CASE 
                        WHEN registration_packages.package_type = 'featured' THEN 1 
                        WHEN registration_packages.package_type = 'premium' THEN 2 
                        ELSE 3 
                      END")
            ->orderBy('name_order')
            ->limit(4)
            ->get();

        $businessTranslations = getStaticTranslation('businesses');
        $businessContactTranslations = getStaticTranslation('contact_business');
        $favorite = Auth::guard('customers')->check()
            ? Favourite::where('record_id', $id)
            ->where('model', 'business')
            ->where('customer_id', Auth::guard('customers')->user()->id)
            ->count()
            : 0;
        // dd($businesses);
        return view('front.business-detail', compact('favorite', 'business', 'businesses', 'businessTranslations', 'businessContactTranslations'));
    }

    public function viewScholarshipDetail($lang, $id)
    {
        $defaultLang = getDefaultLanguage(1);
        $scholarship = SchoolScholarship::with([
            'schoolScholarshipDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
            'school',
            'school.schoolDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        $scholarship = $scholarship->whereId($id)->first();

        $scholarships = SchoolScholarship::with([
            'schoolScholarshipDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ])->whereHas('schoolScholarshipDetail', function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        });
        $scholarships = $scholarships->addSelect([
            'name_order' => SchoolScholarshipDetail::where('language_code', $defaultLang->abbreviation)
                ->whereColumn('school_scholarship_id', 'school_scholarships.id')
                ->limit(1)
                ->select('name'),
        ]);
        $scholarships = $scholarships
            ->orderBy('name_order')
            ->limit(4)
            ->get();
        $scholarshipTranslations = getStaticTranslation('scholarships');
        $favorite = Auth::guard('customers')->check()
            ? Favourite::where('record_id', $id)
            ->where('model', 'scholarship')
            ->where('customer_id', Auth::guard('customers')->user()->id)
            ->count()
            : 0;
        return view('front.scholarship-detail', compact('favorite', 'scholarship', 'scholarships', 'scholarshipTranslations'));
    }

    public function uploadSchoolExcelFile(Request $request)
    {
        // dd($request->all());
        $image = $request->file('excel_file');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        if (!file_exists($destinationPath . '/' . $name)) {
            return response()->json(['error' => 'File upload failed, file does not exist.'], 400);
        }
        $reader = new Xlsx();
        // set the Read data only option
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($destinationPath . '/' . $name);
        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        $firstRowKeys = $data[0];
        $schools = [];
        foreach ($data as $key => $value) {
            if ($key != 0) {
                $localData = [];
                foreach ($firstRowKeys as $i => $firstRowKey) {
                    if (isset($value[$i])) {
                        // $localData[str_replace(' ', '', $firstRowKey)] = str_replace(' ', '', $value[$i]);
                        $localData[$firstRowKey] = $value[$i];
                    }
                }
                $schools[] = $localData;
            }
        }
        // dd($schools);
        $defaultLang = getDefaultLanguage(1);
        foreach ($schools as $school) {
            if (isset($school['name']) && isset($school['school_email'])) {
                if (!School::whereEmail($school['school_email'])->exists()) {
                    if (!SchoolDetail::whereSchoolName($school['name'])->exists()) {
                        $mappedCountry = $this->getMappedCountry($school['country']);
                        $schoolNew = School::create([
                            'email' => $school['school_email'],
                            'website_url' => isset($school['website']) ? $school['website'] : '',
                            'phone' => isset($school['school_phone']) ? $school['school_phone'] : '',
                            // 'time' => '--',
                            // 'time_zone' => '--',
                            // 'province' => '--',
                            'time' => isset($school['time']) ? $school['time'] : '',
                            'time_zone' => isset($school['time_zone']) ? $school['time_zone'] : '',
                            'city' => isset($school['city']) ? $school['city'] : '',
                            'province' => isset($school['province']) ? $school['province'] : '',
                            // 'country' => isset($school['country']) ? $school['country'] : '',
                            'country' => $mappedCountry,
                            'image' => isset($school['featured_image']) ? $school['featured_image'] : '',
                            'facebook' => isset($school['facebook']) ? $school['facebook'] : '',
                            'linkedin' => isset($school['linkedin']) ? $school['linkedin'] : '',
                            'insta' => isset($school['instagram']) ? $school['instagram'] : '',
                            'twitter' => isset($school['twitter']) ? $school['twitter'] : '',
                            'youtube' => isset($school['you_tube']) ? $school['you_tube'] : '',
                            'vk' => isset($school['vk']) ? $school['vk'] : '',
                            'youtube_link' => isset($school['youtube_link']) ? $school['youtube_link'] : '',
                            'main_button_link' => isset($school['main_button_link']) ? $school['main_button_link'] : '',
                            'other_button_link' => isset($school['other_button_link']) ? $school['other_button_link'] : '',
                            'deactive_account' => 0,
                            'quick_facts_status' => isset($school['quick_facts_status']) ? $school['quick_facts_status'] : 1,
                            'overview_status' =>  isset($school['overview_status']) ? $school['overview_status'] : 1,
                            'program_status' =>  isset($school['program_status']) ? $school['program_status'] : 1,
                            'admission_status' =>  isset($school['admission_status']) ? $school['admission_status'] : 1,
                            'financial_status' =>  isset($school['financial_status']) ? $school['financial_status'] : 1,
                            'scholarship_status' =>  isset($school['scholarship_status']) ? $school['scholarship_status'] : 1,
                            'contacts_status' =>  isset($school['contacts_status']) ? $school['contacts_status'] : 1,
                            'degree_id' => isset($school['degree_id']) ? $school['degree_id'] : '',
                            'deactive_account' => isset($school['deactive_account']) ? $school['deactive_account'] : 0,
                        ]);
                        if ($schoolNew) {
                            SchoolDetail::create([
                                'language_code' => $defaultLang->abbreviation,
                                'more_button_title' => isset($school['main_button_title']) ? $school['main_button_title'] : '',
                                'more_button_sub_title' => isset($school['main_button_sub_title']) ? $school['main_button_sub_title'] : '',
                                'other_button_title' => isset($school['other_button_title']) ? $school['other_button_title'] : '',
                                'school_id' => $schoolNew->id,
                                'school_name' => isset($school['name']) ? $school['name'] : '',
                                'description' => isset($school['name']) ? $school['name'] : '',
                            ]);
                            $this->QuickFactImport($school, $schoolNew->id);
                            $this->ContactSettingImport($school, $schoolNew->id);
                            $this->ProgramSettingImport($school, $schoolNew->id);
                            $this->ScholarshipSettingImport($school, $schoolNew->id);
                            $this->OverviewImport($school, $schoolNew->id);
                            $this->AdmissionImport($school, $schoolNew->id);
                            $this->FinancialImport($school, $schoolNew->id);
                        }

                        $imageIndex = 1;
                        while (isset($school["image-{$imageIndex}"])) {
                            if (!empty($school["image-{$imageIndex}"])) {
                                SchoolMoreImage::create([
                                    'school_id' => $schoolNew->id,
                                    'image' => $school["image-{$imageIndex}"]
                                ]);
                            }
                            $imageIndex++;
                        }
                    }
                }
            }
        }
        return redirect()->back();
    }
    public function QuickFactImport($school, $schoolId)
    {
        $defaultLang = getDefaultLanguage(1);

        $schoolTypeId = null;
        if (isset($school['school_type']) && !empty($school['school_type'])) {
            $schoolType = SchoolType::whereHas('schoolTypeDetail', function ($query) use ($school) {
                $query->where('name', 'like', '%' . $school['school_type'] . '%');
            })->first();

            $schoolTypeId = $schoolType ? $schoolType->id : null;
        }
        // $schoolTypeId = $schoolType ? $schoolType->id : null;

        $schoolQuickFacts = SchoolQuickFact::create([
            'school_quick_facts_apply_button_link' => isset($school['quick_facts_apply_now_button_link']) ? $school['quick_facts_apply_now_button_link'] : '',
            'school_quick_facts_apply_button_title' => isset($school['quick_facts_apply_now_button_title']) ? $school['quick_facts_apply_now_button_title'] : '',
            'school_quick_facts_blue_bar_button_title' => isset($school['quick_facts_good_to_go_button_title']) ? $school['quick_facts_good_to_go_button_title'] : '',
            'school_quick_facts_blue_bar_button_link' => isset($school['quick_facts_good_to_go_button_link']) ? $school['quick_facts_good_to_go_button_link'] : '',
            'school_quick_facts_red_bar_button_title' => isset($school['quick_facts_lets_apply_button_title']) ? $school['quick_facts_lets_apply_button_title'] : '',
            'school_quick_facts_red_bar_button_link' => isset($school['quick_facts_lets_apply_button_link']) ? $school['quick_facts_lets_apply_button_link'] : '',
            'title_2_image' => isset($school['quick_facts_title_2_image']) ? $school['quick_facts_title_2_image'] : '',
            'title_2_button_link' => isset($school['quick_facts_title_2_link']) ? $school['quick_facts_title_2_link'] : '',
            // 'school_location' => isset($school['location']) ? $school['location'] : '',
            // 'school_type' => isset($school['school_type']) ? $school['school_type'] : '',
            'school_type' => $schoolTypeId,
            'languages' => isset($school['language']) ? $school['language'] : '',
            'total_undergraduates' => isset($school['undergraduates']) ? $school['undergraduates'] : '',
            'entrance_dates' => isset($school['entrance_dates']) ? $school['entrance_dates'] : '',
            'canidian_tuition_fee' => isset($school['canadian_tuition_fee']) ? $school['canadian_tuition_fee'] : '',
            'international_tuition_fee' => isset($school['international_tuition_fee']) ? $school['international_tuition_fee'] : '',
            'telephone' => isset($school['school_name']) ? $school['school_name'] : '',
            'fax' => isset($school['fax']) ? $school['fax'] : '',
            'school_address' => isset($school['address']) ? $school['address'] : '',
            'start_date' => isset($school['start_date']) ? $school['start_date'] : '',
            'online_or_distance_education' => isset($school['online_distance_education']) ? $school['online_distance_education'] : '',
            'minimum_gpa' => isset($school['minimum_gpa']) ? $school['minimum_gpa'] : '',
            'conditional_admission' => isset($school['conditional_acceptance']) ? $school['conditional_acceptance'] : '',
            'number_of_graduate_programs' => isset($school['number_of_graduate_programs']) ? $school['number_of_graduate_programs'] : '',
            'number_of_undergraduate_programs' => isset($school['number_of_undergraduate_programs']) ? $school['number_of_undergraduate_programs'] : '',
            'number_of_students' => isset($school['number_of_students']) ? $school['number_of_students'] : '',
            'number_of_graduate_students' => isset($school['number_of_graduate_students']) ? $school['number_of_graduate_students'] : '',
            'number_of_undergraduate_students' => isset($school['number_of_undergraduate_students']) ? $school['number_of_undergraduate_students'] : '',
            'study_method' => isset($school['study_method']) ? $school['study_method'] : '',
            'delivery_mode' => isset($school['delivery_mode']) ? $school['delivery_mode'] : '',
            'accomodation' => isset($school['accommodation']) ? $school['accommodation'] : '',
            'work_on_campus' => isset($school['work_on_campus']) ? $school['work_on_campus'] : '',
            'work_during_holidays' => isset($school['work_during_holidays']) ? $school['work_during_holidays'] : '',
            'internship' => isset($school['internship']) ? $school['internship'] : '',
            'co_op_education' => isset($school['co_op_education']) ? $school['co_op_education'] : '',
            'job_placement' => isset($school['job_placement']) ? $school['job_placement'] : '',
            'financial_aid_programs_for_domastic_students' => isset($school['financial_aid_programs_for_domastic_students']) ? $school['financial_aid_programs_for_domastic_students'] : '',
            'financial_aid_programs_for_province_students' => isset($school['financial_aid_programs_for_province_students']) ? $school['financial_aid_programs_for_province_students'] : '',
            'financial_aid_programs_for_international_students' => isset($school['financial_aid_programs_for_international_students']) ? $school['financial_aid_programs_for_international_students'] : '',
            'research_and_dissertaion' => isset($school['research']) ? $school['research'] : '',
            'exchange_program' => isset($school['exchange_programs']) ? $school['exchange_programs'] : '',
            'degree_modifier' => isset($school['degree_modifier']) ? $school['degree_modifier'] : '',
            'daycare_for_students_with_kids' => isset($school['day_care']) ? $school['day_care'] : '',
            'elementary_school_for_students_with_kids' => isset($school['elementary_school']) ? $school['elementary_school'] : '',
            'immigration_office_on_campus' => isset($school['immigration_office']) ? $school['immigration_office'] : '',
            'career_planing' => isset($school['career_planning']) ? $school['career_planning'] : '',
            'pathway_programs' => isset($school['pathway_programs']) ? $school['pathway_programs'] : '',
            'employeement_rates' => isset($school['employment_rates']) ? $school['employment_rates'] : '',
            'class_size_undergraduate' => isset($school['class_size_undergraduate']) ? $school['class_size_undergraduate'] : '',
            'class_size_masters' => isset($school['class_size_master']) ? $school['class_size_master'] : '',
            'service_and_guidance_new_students' => isset($school['service_and_guidance_new_students']) ? $school['service_and_guidance_new_students'] : '',
            'service_and_guidance_to_new_arrivals_in_canada' => isset($school['service_and_guidance_to_new_arrivals_in_canada']) ? $school['service_and_guidance_to_new_arrivals_in_canada'] : '',
            'program_type_greduates' => isset($school['program_type_greduates']) ? $school['program_type_greduates'] : '',
            'program_type_undergreduates' => isset($school['program_type_undergraduates']) ? $school['program_type_undergraduates'] : '',
            'years_before_elegible_for_pr' => isset($school['years_before_elegible_for_pr']) ? $school['years_before_elegible_for_pr'] : '',
            'work_off_campus' => isset($school['work_on_campus']) ? $school['work_on_campus'] : '',
            'school_id' => $schoolId,
            'field_of_study' => $schoolId,
            'marked_facts' => isset($school['marked_facts']) ? $school['marked_facts'] : '',
        ]);
        if ($schoolQuickFacts) {
            SchoolQuickFactDetail::create([
                'school_quick_fact_id' => $schoolQuickFacts->id,
                'title_1' => isset($school['quick_facts_title_1']) ? $school['quick_facts_title_1'] : '',
                'title_1_paragraph' => isset($school['quick_facts_title_1_paragraph']) ? $school['quick_facts_title_1_paragraph'] : '',
                'title_2' => isset($school['quick_facts_title_2']) ? $school['quick_facts_title_2'] : '',
                'title_2_subtitle' => isset($school['quick_facts_title_2_sub_title']) ? $school['quick_facts_title_2_sub_title'] : '',
                'title_2_paragraph' => isset($school['quick_facts_title_2_paragraph']) ? $school['quick_facts_title_2_paragraph'] : '',
                'title_2_button_title' => isset($school['quick_facts_title_2_button']) ? $school['quick_facts_title_2_button'] : '',
                'language_code' => $defaultLang->abbreviation,
            ]);
        }
        $allFeatures = [];

        // Add school_type if exists (top priority)
        if (!empty($schoolTypeId)) {
            $allFeatures[] = [
                'type' => 'school_type',
                'value' => $schoolTypeId,
                'priority' => 0 // highest priority
            ];
        }
        $fieldMappings = [
            // Mapping of Excel column names to ENUM values
            'language' => 'languages',
            'undergraduates' => 'total_undergraduates',
            'entrance_dates' => 'entrance_dates',
            'canadian_tuition_fee' => 'canidian_tuition_fee',
            'international_tuition_fee' => 'international_tuition_fee',
            'school_name' => 'telephone',
            'fax' => 'fax',
            'address' => 'school_address',
            'start_date' => 'start_date',
            'online_distance_education' => 'online_or_distance_education',
            'minimum_gpa' => 'minimum_gpa',
            'conditional_acceptance' => 'conditional_admission',
            'number_of_graduate_programs' => 'number_of_graduate_programs',
            'number_of_undergraduate_programs' => 'number_of_undergraduate_programs',
            'number_of_students' => 'number_of_students',
            'number_of_graduate_students' => 'number_of_graduate_students',
            'number_of_undergraduate_students' => 'number_of_undergraduate_students',
            'study_method' => 'study_method',
            'delivery_mode' => 'delivery_mode',
            'accommodation' => 'accomodation',
            'work_on_campus' => 'work_on_campus',
            'work_during_holidays' => 'work_during_holidays',
            'internship' => 'internship',
            'co_op_education' => 'co_op_education',
            'job_placement' => 'job_placement',
            'financial_aid_programs_for_domastic_students' => 'financial_aid_programs_for_domastic_students',
            'financial_aid_programs_for_province_students' => 'financial_aid_programs_for_province_students',
            'financial_aid_programs_for_international_students' => 'financial_aid_programs_for_international_students',
            'research' => 'research_and_dissertaion',
            'exchange_programs' => 'exchange_program',
            'degree_modifier' => 'degree_modifier',
            'day_care' => 'daycare_for_students_with_kids',
            'elementary_school' => 'elementary_school_for_students_with_kids',
            'immigration_office' => 'immigration_office_on_campus',
            'career_planning' => 'career_planing',
            'pathway_programs' => 'pathway_programs',
            'employment_rates' => 'employeement_rates',
            'class_size_undergraduate' => 'class_size_undergraduate',
            'class_size_master' => 'class_size_masters',
            'service_and_guidance_new_students' => 'service_and_guidance_new_students',
            'service_and_guidance_to_new_arrivals_in_canada' => 'service_and_guidance_to_new_arrivals_in_canada',
            'program_type_greduates' => 'program_type_greduates',
            'program_type_undergraduates' => 'program_type_undergreduates',
            'years_before_elegible_for_pr' => 'years_before_elegible_for_pr',
            'work_on_campus' => 'work_off_campus',
            'marked_facts' => 'marked_facts',
            // Note: school_type is handled separately with $schoolTypeId
        ];

        // $order = 1;

        // // Process regular quick facts
        // foreach ($fieldMappings as $excelField => $enumValue) {
        //     if (isset($school[$excelField]) && !empty($school[$excelField])) {
        //         SchoolQuickFactsFeature::create([
        //             'school_quick_fact_id' => $schoolQuickFacts->id,
        //             'type' => $enumValue,
        //             'value' => $school[$excelField],
        //             'sorting_order' => $order++,
        //             'is_featured' => 1,
        //         ]);
        //     }
        // }

        // // Handle school_type separately since it uses $schoolTypeId
        // if (!empty($schoolTypeId)) {
        //     SchoolQuickFactsFeature::create([
        //         'school_quick_fact_id' => $schoolQuickFacts->id,
        //         'type' => 'school_type',
        //         'value' => $schoolTypeId,
        //         'sorting_order' => $order++,
        //         'is_featured' => 1,
        //     ]);
        // }

        // for ($i = 1; $i <= 10; $i++) {
        //     $typeKey = "quick_fact_{$i}";
        //     $valueKey = "quick_fact_{$i}_value";

        //     if (isset($school[$valueKey]) && !empty($school[$valueKey])) {
        //         SchoolQuickFactsFeature::create([
        //             'school_quick_fact_id' => $schoolQuickFacts->id,
        //             'type' => $typeKey,
        //             'value' => $school[$valueKey],
        //             'sorting_order' => $i, 
        //             'is_featured' => 1, 
        //         ]);
        //     }
        // }
        foreach ($fieldMappings as $excelField => $enumValue) {
            if (isset($school[$excelField]) && !empty(trim($school[$excelField]))) {
                $allFeatures[] = [
                    'type' => $enumValue,
                    'value' => $school[$excelField],
                    'priority' => 1 // medium priority
                ];
            }
        }

        // Add numbered quick facts (lower priority)
        for ($i = 1; $i <= 10; $i++) {
            $valueKey = "quick_fact_{$i}_value";
            if (isset($school[$valueKey]) && !empty(trim($school[$valueKey]))) {
                $allFeatures[] = [
                    'type' => "quick_fact_{$i}",
                    'value' => $school[$valueKey],
                    'priority' => 2 // lowest priority
                ];
            }
        }

        // 2. Sort features by: 
        //    - priority (school_type first, then mapped fields, then numbered facts)
        //    - original order within same priority
        usort($allFeatures, function ($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        // 3. Process features - first 16 get featured status
        $order = 1;
        $featuresToCreate = array_slice($allFeatures, 0, 16);
        $remainingFeatures = array_slice($allFeatures, 16);

        foreach ($featuresToCreate as $feature) {
            SchoolQuickFactsFeature::create([
                'school_quick_fact_id' => $schoolQuickFacts->id,
                'type' => $feature['type'],
                'value' => $feature['value'],
                'sorting_order' => $order++,
                'is_featured' => 1
            ]);
        }

        // Add remaining non-featured fields
        foreach ($remainingFeatures as $feature) {
            SchoolQuickFactsFeature::create([
                'school_quick_fact_id' => $schoolQuickFacts->id,
                'type' => $feature['type'],
                'value' => $feature['value'],
                'sorting_order' => $order++,
                'is_featured' => 0
            ]);
        }
    }
    public function ContactSettingImport($school, $schoolId)
    {
        $defaultLang = getDefaultLanguage(1);
        $schoolContactSetting = SchoolContactSetting::create([
            'school_id' => $schoolId,
            'school_contact_apply_button_title' => isset($school['school_contact_button_title']) ? $school['school_contact_button_title'] : '',
            'school_contact_apply_button_link' => isset($school['school_contact_button_link']) ? $school['school_contact_button_link'] : '',
            'school_contact_blue_bar_button_title' => isset($school['school_contact_good_to_go_button_title']) ? $school['school_contact_good_to_go_button_title'] : '',
            'school_contact_blue_bar_button_link' => isset($school['school_contact_good_to_go_button_link']) ? $school['school_contact_good_to_go_button_link'] : '',
            'school_contact_red_bar_button_title' => isset($school['school_contact_lets_apply_button_title']) ? $school['school_contact_lets_apply_button_title'] : '',
            'school_contact_red_bar_button_link' => isset($school['school_contact_lets_apply_button_link']) ? $school['school_contact_lets_apply_button_link'] : '',
            'top_page_text' => isset($school['contact_page_heading_text']) ? $school['contact_page_heading_text'] : '',
            'top_photo' => isset($school['contact_page_photo']) ? $school['contact_page_photo'] : '',
        ]);
        if ($schoolContactSetting) {
            SchoolContactSettingDetail::create([
                'school_contact_setting_id' => $schoolContactSetting->id,
                'main_paragraph' => isset($school['contacts_page_paragraph']) ? $school['contacts_page_paragraph'] : '',
                'language_code' => $defaultLang->abbreviation,
            ]);
        }
    }
    public function ProgramSettingImport($school, $schoolId)
    {
        $defaultLang = getDefaultLanguage(1);
        $schoolProgramSetting = SchoolProgramSetting::create([
            'school_id' => $schoolId,

            'school_program_apply_button_title' => isset($school['school_program_button_title']) ? $school['school_program_button_title'] : '',
            'school_program_apply_button_link' => isset($school['school_program_button_link']) ? $school['school_program_button_link'] : '',
            'school_program_blue_bar_button_title' => isset($school['school_program_good_to_go_button_title']) ? $school['school_program_good_to_go_button_title'] : '',
            'school_program_blue_bar_button_link' => isset($school['school_program_good_to_go_button_link']) ? $school['school_program_good_to_go_button_link'] : '',
            'school_program_red_bar_button_title' => isset($school['school_program_lets_apply_button_title']) ? $school['school_program_lets_apply_button_title'] : '',
            'school_program_red_bar_button_link' => isset($school['school_program_lets_apply_button_link']) ? $school['school_program_lets_apply_button_link'] : '',
        ]);
        if ($schoolProgramSetting) {
            SchoolProgramSettingDetail::create([
                'school_program_setting_id' => $schoolProgramSetting->id,
                'title_1' => isset($school['programs_title_1']) ? $school['programs_title_1'] : '',
                'title_1_paragraph' => isset($school['programs_page_paragraph']) ? $school['programs_page_paragraph'] : '',
                'language_code' => $defaultLang->abbreviation,
            ]);
        }
    }
    public function ScholarshipSettingImport($school, $schoolId)
    {
        $defaultLang = getDefaultLanguage(1);
        $scholarshipSetting = ScholarshipSetting::create([
            'school_id' => $schoolId,

            'scholarship_settings_apply_button_link' => isset($school['scholarship_settings_button_link']) ? $school['scholarship_settings_button_link'] : '',
            'scholarship_settings_apply_button_title' => isset($school['scholarship_settings_button_title']) ? $school['scholarship_settings_button_title'] : '',
            'scholarship_settings_blue_bar_button_link' => isset($school['scholarship_settings_good_to_go_button_link']) ? $school['scholarship_settings_good_to_go_button_link'] : '',
            'scholarship_settings_blue_bar_button_title' => isset($school['scholarship_settings_good_to_go_button_title']) ? $school['scholarship_settings_good_to_go_button_title'] : '',
            'scholarship_settings_red_bar_button_title' => isset($school['scholarship_settings_lets_apply_button_title']) ? $school['scholarship_settings_lets_apply_button_title'] : '',
            'scholarship_settings_red_bar_button_link' => isset($school['scholarship_settings_lets_apply_button_link']) ? $school['scholarship_settings_lets_apply_button_link'] : '',
            'video_url' => isset($school['scholarship_youtube_video_url']) ? $school['scholarship_youtube_video_url'] : '',
            'video_iframe' => isset($school['scholarship_youtube_video_url']) ? getVideoHtmlAttribute($school['scholarship_youtube_video_url']) : '',
            'top_page_video_url' => isset($school['scholarship_main_video_url']) ? $school['scholarship_main_video_url'] : '',

            // 'title_2_button_link' => isset($school['scholarships_title_2_link']) ? $school['scholarships_title_2_link'] : '',
            // 'title_2_image' => isset($school['scholarships_title_2_image']) ? $school['scholarships_title_2_image'] : '',
            // 'title_4_button_link' => isset($school['contacts_page_paragraph']) ? $school['contacts_page_paragraph'] : '',
            // 'title_4_image' => isset($school['scholarships_title_4_link']) ? $school['scholarships_title_4_link'] : '',
        ]);
        if ($scholarshipSetting) {
            ScholarshipSettingDetail::create([
                'language_code' => $defaultLang->abbreviation,
                'scholarship_setting_id' => $scholarshipSetting->id,
                'scholarship_pre_description' => isset($school['scholarship_pre_description']) ? $school['scholarship_pre_description'] : '',
                'scholarship_post_description' => isset($school['scholarship_post_description']) ? $school['scholarship_post_description'] : '',
                'programs_pre_description' => isset($school['scholarship_programs_pre_description']) ? $school['scholarship_programs_pre_description'] : '',
                'programs_post_description' => isset($school['scholarship_programs_post_description']) ? $school['scholarship_programs_post_description'] : '',
                'faq_post_description' => isset($school['scholarship_faq_post_description']) ? $school['scholarship_faq_post_description'] : '',
                'faq_pre_description' => isset($school['scholarship_faq_pre_description']) ? $school['scholarship_faq_pre_description'] : '',

                // 'title_1' => $defaultLang->scholarships_title_1,
                // 'title_1_paragraph' => isset($school['scholarships_title_1_paragraph']) ? $school['scholarships_title_1_paragraph'] : '',
                // 'text_1_content' => isset($school['scholarships_text_content_1']) ? $school['scholarships_text_content_1'] : '',
                // 'text_2_content' => isset($school['scholarships_text_content_2']) ? $school['scholarships_text_content_2'] : '',
                // 'title_2' => isset($school['scholarships_title_2']) ? $school['scholarships_title_2'] : '',
                // 'title_2_subtitle' => isset($school['scholarships_title_2_sub_title']) ? $school['scholarships_title_2_sub_title'] : '',
                // 'title_2_paragraph' => isset($school['scholarships_title_2_paragraph']) ? $school['scholarships_title_2_paragraph'] : '',
                // 'title_2_button_title' => isset($school['scholarships_title_2_button']) ? $school['scholarships_title_2_button'] : '',
                // 'title_2_image_name' => isset($school['scholarships_title_2_image_name']) ? $school['scholarships_title_2_image_name'] : '',
                // 'title_3' => isset($school['scholarships_title_3']) ? $school['scholarships_title_3'] : '',
                // 'title_3_paragraph' => isset($school['scholarships_title_3_paragraph']) ? $school['scholarships_title_3_paragraph'] : '',
                // 'text_3_content' => isset($school['scholarships_text_content_3']) ? $school['scholarships_text_content_3'] : '',
                // 'title_4' => isset($school['scholarships_title_4']) ? $school['scholarships_title_4'] : '',
                // 'title_4_subtitle' => isset($school['scholarships_title_4_sub_title']) ? $school['scholarships_title_4_sub_title'] : '',
                // 'title_4_paragraph' => isset($school['scholarships_title_4_paragraph']) ? $school['scholarships_title_4_paragraph'] : '',
                // 'title_4_button_title' => isset($school['scholarships_title_4_button']) ? $school['scholarships_title_4_button'] : '',
                // 'title_4_image_name' => isset($school['scholarships_title_4_image_name']) ? $school['scholarships_title_4_image_name'] : '',
            ]);
        }
    }
    public function OverviewImport($school, $schoolId)
    {
        $defaultLang = getDefaultLanguage(1);
        $schoolOverview = SchoolOverview::create([
            'school_id' => $schoolId,

            'school_overviews_apply_button_title' => isset($school['school_overviews_button_title']) ? $school['school_overviews_button_title'] : '',
            'school_overviews_apply_button_link' => isset($school['school_overviews_apply_button_link']) ? $school['school_overviews_apply_button_link'] : '',
            'school_overviews_blue_bar_button_title' => isset($school['school_overviews_good_to_go_button_title']) ? $school['school_overviews_good_to_go_button_title'] : '',
            'school_overviews_blue_bar_button_link' => isset($school['school_overviews_good_to_go_button_link']) ? $school['school_overviews_good_to_go_button_link'] : '',
            'school_overviews_red_bar_button_title' => isset($school['school_overviews_lets_apply_button_title']) ? $school['school_overviews_lets_apply_button_title'] : '',
            'school_overviews_red_bar_button_link' => isset($school['school_overviews_lets_apply_button_link']) ? $school['school_overviews_lets_apply_button_link'] : '',

            'video_url' => isset($school['overview_youtube_video_url']) ? $school['overview_youtube_video_url'] : '',
            'video_iframe' => isset($school['overview_youtube_video_url']) ? getVideoHtmlAttribute($school['overview_youtube_video_url']) : '',



            // 'title_3_image' => isset($school['overview_title_3_image']) ? $school['overview_title_3_image'] : '',
            // 'title_3_date' => isset($school['overview_title_3_date']) ? $school['overview_title_3_date'] : '',
            // 'title_4_image' => isset($school['overview_title_4_image']) ? $school['overview_title_4_image'] : '',
            // 'title_3_button_link' => isset($school['overview_title_3_link']) ? $school['overview_title_3_link'] : '',
            // 'title_6_button_link' => isset($school['overview_title_6_link']) ? $school['overview_title_6_link'] : '',
            // 'title_8_button_link' => isset($school['overview_title_8_link']) ? $school['overview_title_8_link'] : '',
            // 'title_9_image' => isset($school['overview_title_9_image']) ? $school['overview_title_9_image'] : '',
            // 'title_9_button_link' => isset($school['overview_title_9_link']) ? $school['overview_title_9_link'] : '',
        ]);
        if ($schoolOverview) {
            SchoolOverviewDetail::create([
                'language_code' => $defaultLang->abbreviation,
                'school_overview_id' => $schoolOverview->id,
                'blog_pre_description' => isset($school['overview_blog_pre_description']) ? $school['overview_blog_pre_description'] : '',
                'blog_post_description' => isset($school['overview_blog_post_description']) ? $school['overview_blog_post_description'] : '',
                'programs_pre_description' => isset($school['overview_programs_pre_description']) ? $school['overview_programs_pre_description'] : '',
                'programs_post_description' => isset($school['overview_programs_post_description']) ? $school['overview_programs_post_description'] : '',
                // 'title_1' => isset($school['overview_title_1']) ? $school['overview_title_1'] : '',
                // 'title_1_paragraph' => isset($school['overview_title_1_paragraph']) ? $school['overview_title_1_paragraph'] : '',
                // 'title_1_content' => isset($school['overview_text_content_1']) ? $school['overview_text_content_1'] : '',
                // 'title_2' => isset($school['overview_title_2']) ? $school['overview_title_2'] : '',
                // 'title_2_bullet_points' => isset($school['overview_title_2_bullets']) ? $school['overview_title_2_bullets'] : '',
                // 'title_3_subtitle' => isset($school['overview_title_3_sub_title']) ? $school['overview_title_3_sub_title'] : '',
                // 'title_3_paragraph' => isset($school['overview_title_3_paragraph']) ? $school['overview_title_3_paragraph'] : '',
                // 'title_3_button_title' => isset($school['overview_title_3_button']) ? $school['overview_title_3_button'] : '',
                // 'title_3_image_name' => isset($school['overview_title_3_image_name']) ? $school['overview_title_3_image_name'] : '',
                // 'title_4' => isset($school['overview_title_4']) ? $school['overview_title_4'] : '',
                // 'title_4_paragraph' => isset($school['overview_title_4_paragraph']) ? $school['overview_title_4_paragraph'] : '',
                // 'title_5' => isset($school['overview_title_5']) ? $school['overview_title_5'] : '',
                // 'title_5_paragraph' => isset($school['overview_title_5_paragraph']) ? $school['overview_title_5_paragraph'] : '',
                // 'title_6' => isset($school['overview_title_6']) ? $school['overview_title_6'] : '',
                // 'title_6_paragraph' => isset($school['overview_title_6_paragraph']) ? $school['overview_title_6_paragraph'] : '',
                // 'title_6_button_title' => isset($school['overview_title_6_button']) ? $school['overview_title_6_button'] : '',
                // 'title_7' => isset($school['overview_title_7']) ? $school['overview_title_7'] : '',
                // 'title_7_paragraph' => isset($school['overview_title_7_paragraph']) ? $school['overview_title_7_paragraph'] : '',
                // 'title_7_button_title' => isset($school['overview_title_8_button']) ? $school['overview_title_8_button'] : '',
                // 'title_8' => isset($school['overview_title_8']) ? $school['overview_title_8'] : '',
                // 'title_8_paragraph' => isset($school['overview_title_8_paragraph']) ? $school['overview_title_8_paragraph'] : '',
                // 'title_9' => isset($school['overview_title_9']) ? $school['overview_title_9'] : '',
                // 'title_9_subtitle' => isset($school['overview_title_9_sub_title']) ? $school['overview_title_9_sub_title'] : '',
                // 'title_9_paragraph' => isset($school['overview_title_9_paragraph']) ? $school['overview_title_9_paragraph'] : '',
                // 'title_9_button_title' => isset($school['overview_title_9_button']) ? $school['overview_title_9_button'] : '',
                // 'title_9_image_name' => isset($school['overview_title_9_image_name']) ? $school['overview_title_9_image_name'] : '',
                // 'title_10' => isset($school['overview_title_10']) ? $school['overview_title_10'] : '',
                // 'title_10_paragraph' => isset($school['overview_title_10_paragraph']) ? $school['overview_title_10_paragraph'] : '',
                // 'title_11' => isset($school['overview_title_11']) ? $school['overview_title_11'] : '',
                // 'title_11_paragraph' => isset($school['overview_title_11_paragraph']) ? $school['overview_title_11_paragraph'] : '',
                // 'title_12' => isset($school['overview_title_12']) ? $school['overview_title_12'] : '',
                // 'title_12_bullet_points' => isset($school['overview_title_12_bullets']) ? $school['overview_title_12_bullets'] : '',
                // 'title_13' => isset($school['overview_title_13']) ? $school['overview_title_13'] : '',
                // 'title_13_paragraph' => isset($school['overview_title_13_paragraph']) ? $school['overview_title_13_paragraph'] : '',
            ]);
        }
    }
    public function AdmissionImport($school, $schoolId)
    {
        $defaultLang = getDefaultLanguage(1);
        $admissionSetting = AdmissionSetting::create([
            'school_id' => $schoolId,
            'admission_apply_button_link' => isset($school['admission_apply_now_button_link']) ? $school['admission_apply_now_button_link'] : '',
            'admission_apply_button_title' => isset($school['admission_apply_now_button_title']) ? $school['admission_apply_now_button_title'] : '',
            'admission_blue_bar_button_link' => isset($school['admission_good_to_go_button_link']) ? $school['admission_good_to_go_button_link'] : '',
            'admission_blue_bar_button_title' => isset($school['admission_good_to_go_button_title']) ? $school['admission_good_to_go_button_title'] : '',
            'admission_red_bar_button_title' => isset($school['admission_lets_apply_button_title']) ? $school['admission_lets_apply_button_title'] : '',
            'admission_red_bar_button_link' => isset($school['admission_lets_apply_button_link']) ? $school['admission_lets_apply_button_link'] : '',
        ]);
        if ($admissionSetting) {
            AdmissionSettingDetail::create([
                'language_code' => $defaultLang->abbreviation,
                'admission_setting_id' => $admissionSetting->id,
                // 'main_paragraph' => isset($school['admission_paragraph']) ? $school['admission_paragraph'] : '',
                // 'title_1' => isset($school['admission_title_1']) ? $school['admission_title_1'] : '',
                // 'title_1_paragraph' => isset($school['admission_title_1_paragraph']) ? $school['admission_title_1_paragraph'] : '',
                // 'text_1_content' => isset($school['admission_text_content_1']) ? $school['admission_text_content_1'] : '',
                // 'title_2' => isset($school['admission_title_2']) ? $school['admission_title_2'] : '',
                // 'title_2_bullet_points' => isset($school['admission_title_2_bullets']) ? $school['admission_title_2_bullets'] : '',
                // 'title_3' => isset($school['admission_title_3']) ? $school['admission_title_3'] : '',
                // 'title_3_paragraph' => isset($school['admission_title_3_paragraph']) ? $school['admission_title_3_paragraph'] : '',
                // 'title_4' => isset($school['admission_title_4']) ? $school['admission_title_4'] : '',
                // 'title_4_paragraph' => isset($school['admission_title_4_paragraph']) ? $school['admission_title_4_paragraph'] : '',
                // 'title_5' => isset($school['admission_title_5']) ? $school['admission_title_5'] : '',
                // 'title_5_paragraph' => isset($school['admission_title_5_paragraph']) ? $school['admission_title_5_paragraph'] : '',

                'employees_pre_description' => isset($school['admission_employees_pre_description']) ? $school['admission_employees_pre_description'] : '',
                'employees_post_description' => isset($school['admission_employees_post_description']) ? $school['admission_employees_post_description'] : '',
                'team_pre_description' => isset($school['admission_team_pre_description']) ? $school['admission_team_pre_description'] : '',
                'team_post_description' => isset($school['admission_team_post_description']) ? $school['admission_team_post_description'] : '',
                'faq_pre_description' => isset($school['admission_faq_pre_description']) ? $school['admission_faq_pre_description'] : '',
                'faq_post_description' => isset($school['admission_faq_post_description']) ? $school['admission_faq_post_description'] : '',
            ]);
        }
    }

    public function FinancialImport($school, $schoolId)
    {
        $defaultLang = getDefaultLanguage(1);
        $schoolFinancial = SchoolFinancial::create([
            'school_id' => $schoolId,

            'school_financials_apply_button_link' => isset($school['school_financials_button_link']) ? $school['school_financials_button_link'] : '',
            'school_financials_apply_button_title' => isset($school['school_financials_button_title']) ? $school['school_financials_button_title'] : '',
            'school_financials_blue_bar_button_title' => isset($school['school_financials_good_to_go_button_title']) ? $school['school_financials_good_to_go_button_title'] : '',
            'school_financials_blue_bar_button_link' => isset($school['school_financials_good_to_go_button_link']) ? $school['school_financials_good_to_go_button_link'] : '',
            'school_financials_red_bar_button_title' => isset($school['school_financials_lets_apply_button_title']) ? $school['school_financials_lets_apply_button_title'] : '',
            'school_financials_red_bar_button_link' => isset($school['school_financials_lets_apply_button_link']) ? $school['school_financials_lets_apply_button_link'] : '',
            'video_url' => isset($school['financial_youtube_video_url']) ? $school['financial_youtube_video_url'] : '',
            'video_iframe' => isset($school['financial_youtube_video_url']) ? getVideoHtmlAttribute($school['financial_youtube_video_url']) : '',

            // 'tab_1_subtitle_1_bps_1_price' => isset($school['financial_tab_1_sub_title_1_bullet_price']) ? $school['financial_tab_1_sub_title_1_bullet_price'] : '',
            // 'tab_1_subtitle_3_bps_1_price' => isset($school['financial_tab_1_sub_title_3_bullet_1_price']) ? $school['financial_tab_1_sub_title_3_bullet_1_price'] : '',
            // 'tab_1_subtitle_3_bps_2_price' => isset($school['financial_tab_1_sub_title_3_bullet_2_price']) ? $school['financial_tab_1_sub_title_3_bullet_2_price'] : '',
            // 'tab_1_subtitle_3_bps_3_price' => isset($school['financial_tab_1_sub_title_3_bullet_3_price']) ? $school['financial_tab_1_sub_title_3_bullet_3_price'] : '',
            // 'tab_2_subtitle_1_bps_1_price' => isset($school['financial_tab_2_sub_title_1_bullet_price']) ? $school['financial_tab_2_sub_title_1_bullet_price'] : '',
            // 'tab_2_subtitle_3_bps_1_price' => isset($school['financial_tab_2_sub_title_3_bullet_1_price']) ? $school['financial_tab_2_sub_title_3_bullet_1_price'] : '',
            // 'tab_2_subtitle_3_bps_2_price' => isset($school['financial_tab_2_sub_title_3_bullet_2_price']) ? $school['financial_tab_2_sub_title_3_bullet_2_price'] : '',
            // 'tab_2_subtitle_3_bps_3_price' => isset($school['financial_tab_2_sub_title_3_bullet_3_price']) ? $school['financial_tab_2_sub_title_3_bullet_3_price'] : '',
            // 'tab_3_subtitle_1_bps_1_price' => isset($school['financial_tab_3_sub_title_1_bullet_price']) ? $school['financial_tab_3_sub_title_1_bullet_price'] : '',
            // 'tab_3_subtitle_3_bps_1_price' => isset($school['financial_tab_3_sub_title_3_bullet_1_price']) ? $school['financial_tab_3_sub_title_3_bullet_1_price'] : '',
            // 'tab_3_subtitle_3_bps_2_price' => isset($school['financial_tab_3_sub_title_3_bullet_2_price']) ? $school['financial_tab_3_sub_title_3_bullet_2_price'] : '',
            // 'tab_3_subtitle_3_bps_3_price' => isset($school['financial_tab_3_sub_title_3_bullet_3_price']) ? $school['financial_tab_3_sub_title_3_bullet_3_price'] : '',
        ]);
        if ($schoolFinancial) {
            SchoolFinancialDetail::create([
                'language_code' => $defaultLang->abbreviation,
                'school_financial_id' => $schoolFinancial->id,
                'tabs_pre_description' => isset($school['financial_tabs_pre_description']) ? $school['financial_tabs_pre_description'] : '',
                'tabs_post_description' => isset($school['financial_tabs_post_description']) ? $school['financial_tabs_post_description'] : '',
                'tab1_name' => isset($school['financial_tab1_name']) ? $school['financial_tab1_name'] : '',
                'tab1_description' => isset($school['financial_tab1_description']) ? $school['financial_tab1_description'] : '',
                'tab2_name' => isset($school['financial_tab2_name']) ? $school['financial_tab2_name'] : '',
                'tab2_description' => isset($school['financial_tab2_description']) ? $school['financial_tab2_description'] : '',
                'tab3_name' => isset($school['financial_tab3_name']) ? $school['financial_tab3_name'] : '',
                'tab3_description' => isset($school['financial_tab3_description']) ? $school['financial_tab3_description'] : '',
                'scholarship_pre_description' => isset($school['financial_scholarship_pre_description']) ? $school['financial_scholarship_pre_description'] : '',
                'scholarship_post_description' => isset($school['financial_scholarship_post_description']) ? $school['financial_scholarship_post_description'] : '',
                'programs_pre_description' => isset($school['financial_programs_pre_description']) ? $school['financial_programs_pre_description'] : '',
                'programs_post_description' => isset($school['financial_programs_post_description']) ? $school['financial_programs_post_description'] : '',
                'faq_pre_description' => isset($school['financial_faq_pre_description']) ? $school['financial_faq_pre_description'] : '',
                'faq_post_description' => isset($school['financial_faq_post_description']) ? $school['financial_faq_post_description'] : '',


                // 'title_1' => isset($school['financial_title_1']) ? $school['financial_title_1'] : '',
                // 'title_1_paragraph' => isset($school['financial_title_1_paragraph']) ? $school['financial_title_1_paragraph'] : '',
                // 'title_2' => isset($school['financial_title_2']) ? $school['financial_title_2'] : '',
                // 'tab_1_title' => isset($school['financial_title_2_tab_1']) ? $school['financial_title_2_tab_1'] : '',
                // 'tab_1_subtitle_1' => isset($school['financial_tab_1_sub_title_1']) ? $school['financial_tab_1_sub_title_1'] : '',
                // 'tab_1_subtitle_1_bps' => isset($school['financial_tab_1_sub_title_1_bullet']) ? $school['financial_tab_1_sub_title_1_bullet'] : '',
                // 'tab_1_subtitle_2' => isset($school['tabs_pre_description']) ? $school['financial_tab_1_sub_title_2'] : '',
                // 'tab_1_subtitle_2_paragraph' => isset($school['financial_tab_1_sub_title_2_paragraph']) ? $school['financial_tab_1_sub_title_2_paragraph'] : '',
                // 'tab_1_subtitle_3' => isset($school['financial_tab_1_sub_title_3']) ? $school['financial_tab_1_sub_title_3'] : '',
                // 'tab_1_subtitle_3_bps_1' => isset($school['financial_tab_1_sub_title_3_bullet_1']) ? $school['financial_tab_1_sub_title_3_bullet_1'] : '',
                // 'tab_1_subtitle_3_bps_2' => isset($school['financial_tab_1_sub_title_3_bullet_2']) ? $school['financial_tab_1_sub_title_3_bullet_2'] : '',
                // 'tab_1_subtitle_3_bps_3' => isset($school['financial_tab_1_sub_title_3_bullet_3']) ? $school['financial_tab_1_sub_title_3_bullet_3'] : '',
                // 'tab_1_subtitle_3_paragraph' => isset($school['financial_tab_1_sub_title_3_paragraph']) ? $school['financial_tab_1_sub_title_3_paragraph'] : '',
                // 'tab_2_title' => isset($school['financial_title_2_tab_2']) ? $school['financial_title_2_tab_2'] : '',
                // 'tab_2_subtitle_1' => isset($school['financial_tab_2_sub_title_1']) ? $school['financial_tab_2_sub_title_1'] : '',
                // 'tab_2_subtitle_1_bps' => isset($school['financial_tab_2_sub_title_1_bullet']) ? $school['financial_tab_2_sub_title_1_bullet'] : '',
                // 'tab_2_subtitle_2' => isset($school['financial_tab_2_sub_title_2']) ? $school['financial_tab_2_sub_title_2'] : '',
                // 'tab_2_subtitle_2_paragraph' => isset($school['financial_tab_2_sub_title_2_paragraph']) ? $school['financial_tab_2_sub_title_2_paragraph'] : '',
                // 'tab_2_subtitle_3' => isset($school['financial_tab_2_sub_title_3']) ? $school['financial_tab_2_sub_title_3'] : '',
                // 'tab_2_subtitle_3_bps_1' => isset($school['financial_tab_2_sub_title_3_bullet_1']) ? $school['financial_tab_2_sub_title_3_bullet_1'] : '',
                // 'tab_2_subtitle_3_bps_2' => isset($school['financial_tab_2_sub_title_3_bullet_2']) ? $school['financial_tab_2_sub_title_3_bullet_2'] : '',
                // 'tab_2_subtitle_3_bps_3' => isset($school['financial_tab_2_sub_title_3_bullet_3']) ? $school['financial_tab_2_sub_title_3_bullet_3'] : '',
                // 'tab_2_subtitle_3_paragraph' => isset($school['financial_tab_2_sub_title_3_paragraph']) ? $school['financial_tab_2_sub_title_3_paragraph'] : '',
                // 'tab_3_title' => isset($school['financial_title_2_tab_3']) ? $school['financial_title_2_tab_3'] : '',
                // 'tab_3_subtitle_1' => isset($school['financial_tab_3_sub_title_1']) ? $school['financial_tab_3_sub_title_1'] : '',
                // 'tab_3_subtitle_1_bps' => isset($school['financial_tab_3_sub_title_1_bullet']) ? $school['financial_tab_3_sub_title_1_bullet'] : '',
                // 'tab_3_subtitle_2' => isset($school['financial_tab_3_sub_title_2']) ? $school['financial_tab_3_sub_title_2'] : '',
                // 'tab_3_subtitle_2_paragraph' => isset($school['financial_tab_3_sub_title_2_paragraph']) ? $school['financial_tab_3_sub_title_2_paragraph'] : '',
                // 'tab_3_subtitle_3' => isset($school['financial_tab_3_sub_title_3']) ? $school['financial_tab_3_sub_title_3'] : '',
                // 'tab_3_subtitle_3_bps_1' => isset($school['financial_tab_3_sub_title_3_bullet_1']) ? $school['financial_tab_3_sub_title_3_bullet_1'] : '',
                // 'tab_3_subtitle_3_bps_2' => isset($school['financial_tab_3_sub_title_3_bullet_2']) ? $school['financial_tab_3_sub_title_3_bullet_2'] : '',
                // 'tab_3_subtitle_3_bps_3' => isset($school['financial_tab_3_sub_title_3_bullet_3']) ? $school['financial_tab_3_sub_title_3_bullet_3'] : '',
                // 'tab_3_subtitle_3_paragraph' => isset($school['financial_tab_3_sub_title_3_paragraph']) ? $school['financial_tab_3_sub_title_3_paragraph'] : '',
                // 'title_3' => isset($school['financial_title_3']) ? $school['financial_title_3'] : '',
                // 'title_3_paragraph' => isset($school['financial_title_3_paragraph']) ? $school['financial_title_3_paragraph'] : '',
                // 'title_4' => isset($school['financial_title_4']) ? $school['financial_title_4'] : '',
                // 'title_4_paragraph' => isset($school['financial_title_4_paragraph']) ? $school['financial_title_4_paragraph'] : '',
                // 'title_5' => isset($school['financial_title_5']) ? $school['financial_title_5'] : '',
                // 'title_5_paragraph' => isset($school['financial_title_5_paragraph']) ? $school['financial_title_5_paragraph'] : '',
                // 'title_6' => isset($school['financial_title_6']) ? $school['financial_title_6'] : '',
                // 'title_6_paragraph' => isset($school['financial_title_6_paragraph']) ? $school['financial_title_6_paragraph'] : '',
                // 'title_1_content' => isset($school['financial_text_content_1']) ? $school['financial_text_content_1'] : '',
            ]);
        }
    }

    public function businessDirectorySearch(Request $request)
    {
        $businessDirectories = BusinessDirectory::query();
        if (isset($request->keyword) && !empty($request->keyword)) {
            $name = $request->keyword;
            $businessDirectories->whereHas('businessDirectoryDetail', function ($q) use ($name) {
                $q->where('name', 'LIKE', '%' . $name . '%');
            });
        }

        if (isset($request->city) && !empty($request->city)) {
            $businessDirectories->whereCity($request->city);
        }

        if (isset($request->province) && !empty($request->province)) {
            $businessDirectories->whereProvince($request->province);
        }

        if (isset($request->industry) && !empty($request->industry)) {
            $arrayResult = explode(',', $request->industry);

            $businessDirectories->whereIn('Industry', $arrayResult);
        }
        $defaultLang = getDefaultLanguage(1);
        $businessDirectories = $businessDirectories->with([
            'businessDirectoryDetail' => function ($q) use ($defaultLang) {
                $q = $q->where('language_id', $defaultLang->id);
            },
        ]);
        $businessDirectories = $businessDirectories
            ->addSelect([
                'name_order' => BusinessDirectoryDetail::whereColumn('business_directory_id', 'business_directories.id')
                    ->where('language_id', $defaultLang->id)
                    ->limit(1)
                    ->select('name'),
            ])
            ->orderBy('name_order')
            ->paginate(10);
        $businessDirectorySearchTranslations = getStaticTranslation('business_directory_search');
        return view('front.business-directory-search', compact('businessDirectories', 'businessDirectorySearchTranslations'));
    }

    public function DemetraSearchResults(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $gpaSchools = [];
        if (isset($request->min_cgpa) && !empty($request->min_cgpa) && isset($request->max_cgpa) && !empty($request->max_cgpa)) {
            $schoolDemetras1 = SchoolDemetraSetting::whereBetween('min_cgpa', [(float) $request->min_cgpa, (float) $request->max_cgpa])
                ->whereBetween('max_cgpa', [(float) $request->min_cgpa, (float) $request->max_cgpa])
                ->pluck('school_id');

            $gpaSchools = School::with([
                'schoolDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_code', $defaultLang->abbreviation);
                },
            ])
                ->addSelect([
                    'name_order' => SchoolDetail::whereColumn('school_id', 'schools.id')
                        ->limit(1)
                        ->select('school_name'),
                ])
                ->whereIn('id', $schoolDemetras1)
                ->where('deactive_account', 0)
                ->orderBy('name_order')
                ->get();
        }

        $sportSchools = [];
        if (isset($request->sports) && !empty($request->sports)) {
            $scoolDemetras2 = SchoolDemetraSetting::query();
            $sports = explode(',', $request->sports);
            $sports = array_map('intval', $sports);
            $scoolDemetras2->whereHas('sports', function ($query) use ($sports) {
                $query->whereIn('sport_id', $sports);
            });
            $scoolDemetras2 = $scoolDemetras2->pluck('school_id');
            $defaultLang = getDefaultLanguage(1);
            $sportSchools = School::with([
                'schoolDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_code', $defaultLang->abbreviation);
                },
            ])
                ->addSelect([
                    'name_order' => SchoolDetail::whereColumn('school_id', 'schools.id')
                        ->limit(1)
                        ->select('school_name'),
                ])
                ->whereIn('id', $scoolDemetras2)
                ->where('deactive_account', 0)
                ->orderBy('name_order')
                ->get();
        }

        $csSchools = [];
        if (isset($request->community_services) && !empty($request->community_services)) {
            $scoolDemetras3 = SchoolDemetraSetting::query();
            $community_services = explode(',', $request->community_services);
            $community_services = array_map('intval', $community_services);
            $scoolDemetras3->whereHas('communityServices', function ($query) use ($community_services) {
                $query->whereIn('comunity_service_id', $community_services);
            });
            $scoolDemetras3 = $scoolDemetras3->pluck('school_id');
            $defaultLang = getDefaultLanguage(1);
            $csSchools = School::with([
                'schoolDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_code', $defaultLang->abbreviation);
                },
            ])
                ->addSelect([
                    'name_order' => SchoolDetail::whereColumn('school_id', 'schools.id')
                        ->limit(1)
                        ->select('school_name'),
                ])
                ->whereIn('id', $scoolDemetras3)
                ->where('deactive_account', 0)
                ->orderBy('name_order')
                ->get();
        }

        $caSchools = [];
        if (isset($request->conditional_acceptance) && !empty($request->conditional_acceptance)) {
            $scoolDemetras4 = SchoolDemetraSetting::query();
            $scoolDemetras4->where('conditional_acceptance', $request->conditional_acceptance);
            $scoolDemetras4 = $scoolDemetras4->pluck('school_id');
            $caSchools = School::with([
                'schoolDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_code', $defaultLang->abbreviation);
                },
            ])
                ->addSelect([
                    'name_order' => SchoolDetail::whereColumn('school_id', 'schools.id')
                        ->limit(1)
                        ->select('school_name'),
                ])
                ->whereIn('id', $scoolDemetras4)
                ->where('deactive_account', 0)
                ->orderBy('name_order')
                ->get();
        }
        $activityResults = [];
        $activityTypes = Activity::getTypes();

        foreach ($activityTypes as $type => $label) {
            $requestKey = $type . '_ids'; // Matches Vue component format

            if (isset($request->$requestKey) && !empty($request->$requestKey)) {
                $activityIds = explode(',', $request->$requestKey);
                $activityIds = array_map('intval', $activityIds);

                $schoolDemetras = SchoolDemetraSetting::whereHas('activities', function ($query) use ($activityIds, $type) {
                    $query->whereIn('activity_id', $activityIds)
                        ->whereHas('activity', function ($q) use ($type) {
                            $q->where('type', $type);
                        });
                })->pluck('school_id');

                $activityResults[$type] = School::with([
                    'schoolDetail' => function ($q) use ($defaultLang) {
                        $q->where('language_code', $defaultLang->abbreviation);
                    },
                ])
                    ->addSelect([
                        'name_order' => SchoolDetail::whereColumn('school_id', 'schools.id')
                            ->limit(1)
                            ->select('school_name'),
                    ])
                    ->whereIn('id', $schoolDemetras)
                    ->where('deactive_account', 0)
                    ->orderBy('name_order')
                    ->get();
            }
        }
        // return view('front.demetra_search_results', compact('gpaSchools', 'sportSchools', 'csSchools', 'caSchools'));
        return view('front.demetra_search_results', [
            'gpaSchools' => $gpaSchools,
            'sportSchools' => $sportSchools,
            'csSchools' => $csSchools,
            'caSchools' => $caSchools,
            'activityResults' => $activityResults
        ]);
    }

    public function articlesByCategory($lang, $id)
    {
        $defaultLang = getDefaultLanguage(1);
        $articlesByCategories = ArticleCategory::with([
            'ArticleCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleCategoryImage',
        ])
            ->where('parent_id', $id)
            ->addSelect([
                'name_order' => ArticleCategoryDetail::where('language_id', $defaultLang->id)
                    ->whereColumn('article_category_id', 'article_categories.id')
                    ->limit(1)
                    ->select('name'),
            ])
            ->orderBy('name_order')
            ->get();
        return view('front.articles-by-category', compact('articlesByCategories'));
    }

    public function articlesCategories($lang)
    {
        $defaultLang = getDefaultLanguage(1);
        $articlesByCategories = ArticleCategory::where('type', 'article')->whereNull('parent_id')->with([
            'ArticleCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleCategoryImage',
        ])
            ->addSelect([
                'name_order' => ArticleCategoryDetail::where('language_id', $defaultLang->id)
                    ->whereColumn('article_category_id', 'article_categories.id')
                    ->limit(1)
                    ->select('name'),
            ])
            ->orderBy('name_order')
            ->get();
        return view('front.articles-categories', compact('articlesByCategories'));
    }
    public function articlesSubCategories($lang)
    {

        $defaultLang = getDefaultLanguage(1);
        $articlesByCategories = ArticleCategory::where('type', 'article')->with([
            'ArticleCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleCategoryImage',
        ])
            ->addSelect([
                'name_order' => ArticleCategoryDetail::where('language_id', $defaultLang->id)
                    ->whereColumn('article_category_id', 'article_categories.id')
                    ->limit(1)
                    ->select('name'),
            ]);
        if (isset($_GET['category'])) {
            $articlesByCategories->where('parent_id', $_GET['category']);
        }

        $articlesByCategories = $articlesByCategories->orderBy('name_order')
            ->get();
        return view('front.articles-sub-categories', compact('articlesByCategories'));
    }

    public function videosCategories($lang)
    {
        $defaultLang = getDefaultLanguage(1);
        $articlesByCategories = ArticleCategory::where('type', 'video')->whereNull('parent_id')->with([
            'ArticleCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleCategoryImage',
        ])
            ->addSelect([
                'name_order' => ArticleCategoryDetail::where('language_id', $defaultLang->id)
                    ->whereColumn('article_category_id', 'article_categories.id')
                    ->limit(1)
                    ->select('name'),
            ])
            ->orderBy('name_order')
            ->get();
        return view('front.videos-categories', compact('articlesByCategories'));
    }

    public function videosSubCategories($lang)
    {
        $defaultLang = getDefaultLanguage(1);
        $articlesByCategories = ArticleCategory::where('type', 'video')->with([
            'ArticleCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleCategoryImage',
        ])
            ->addSelect([
                'name_order' => ArticleCategoryDetail::where('language_id', $defaultLang->id)
                    ->whereColumn('article_category_id', 'article_categories.id')
                    ->limit(1)
                    ->select('name'),
            ]);

        if (isset($_GET['category'])) {
            $articlesByCategories->where('parent_id', $_GET['category']);
        }
        $articlesByCategories = $articlesByCategories->orderBy('name_order')
            ->get();
        return view('front.videos-sub-categories', compact('articlesByCategories'));
    }

    public function schoolByProgram($lang, $id)
    {
        $defaultLang = getDefaultLanguage(1);
        $programTranslations = getStaticTranslation('program');
        // $schools = \DB::table('schools')
        // ->join('school_details', function ($join) use ($defaultLang) {
        //     $join->on('schools.id', '=', 'school_details.school_id')->where('school_details.language_code', '=', $defaultLang->abbreviation);
        // })
        // ->leftjoin('school_programs', 'school_programs.school_id', '=', 'schools.id')
        // ->leftjoin('customers', 'schools.customer_id', '=', 'customers.id')
        // ->leftjoin('registration_packages', 'customers.registration_package_id', '=', 'registration_packages.id')
        // ->select(['schools.id as  school_id', 'schools.*', 'school_details.*', 'school_details.school_name as name_order', 'customers.registration_package_id', 'registration_packages.package_type'])
        // ->where('schools.deactive_account', 0)
        // ->where('schools.deleted_at', null)
        //     ->where('school_programs.program_id', $id)
        //     ->orderByRaw("ISNULL(package_type),FIELD(package_type, 'featured', 'premium', 'free') ASC")

        //     ->orderBy('name_order');
        // $schools = $schools->paginate(10);

        $schools = School::query();
        $schools = $schools->with(['schoolDetail' => function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        }]);
        $schools = $schools->addSelect(['package_type' => RegistrationPackage::whereColumn('registration_package_id', 'registration_packages.id')->select('package_type')]);
        $schools = $schools->where('schools.deactive_account', 0);
        $schools = $schools->where('schools.deleted_at', null);
        $schools = $schools->whereHas('schoolPrograms', function ($q) use ($id) {
            $q->where('program_id', $id);
        });
        $schools = $schools->addSelect(['name_order' => SchoolDetail::whereColumn('school_id', 'schools.id')->where('school_details.language_code', $defaultLang->abbreviation)->select('school_name')]);
        $schools = $schools->orderByRaw("ISNULL(package_type),FIELD(package_type, 'featured', 'premium', 'free') ASC");
        $schools = $schools->orderBy('name_order');

        $schools = $schools->paginate(10);
        // return 1;
        $program = Program::whereId($id);
        $program = $program->with(['programDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return view('front.school-by-program', compact('schools', 'program', 'programTranslations'));
    }

    // public function searchCareer(Request $request)
    // {
    //     $defaultLang = getDefaultLanguage(1);
    //     $careers = Career::with('careerDetail')
    //         ->whereHas('careerDetail', function ($q) use ($defaultLang, $request) {
    //             $q->where('language_id', $defaultLang->id);

    //             if (isset($request->search) && !empty($request->search)) {
    //                 $q->whereRaw('LOWER(class_name) LIKE ?', ['%' . strtolower($request->search) . '%']);
    //             }
    //         })
    //         ->orderByDesc('hot')
    //         ->paginate(15);
    //     return view('front.search-career-results', compact('careers'));
    // }
    public function searchCareer(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $careers = Career::with('careerDetail')
            ->whereHas('careerDetail', function ($q) use ($defaultLang, $request) {
                $q->where('language_id', $defaultLang->id);

                if (isset($request->search) && !empty($request->search)) {
                    $searchTerm = '%' . strtolower($request->search) . '%';
                    $q->where(function ($query) use ($searchTerm) {
                        $query->whereRaw('LOWER(class_name) LIKE ?', [$searchTerm])
                            ->orWhereRaw('LOWER(class_definition) LIKE ?', [$searchTerm]);
                    });
                }
            })
            ->orderByDesc('hot')
            ->paginate(15);

        return view('front.search-career-results', compact('careers'));
    }

    // public function searchAmbassador(Request $request)
    // {
    //     $defaultLang = getDefaultLanguage(1);
    //     $ambassadors = SchoolAmbassador::with('schoolAmbassadorDetail','school')
    //         ->whereHas('schoolAmbassadorDetail', function ($q) use ($defaultLang, $request) {
    //             $q->where('language_code', $defaultLang->id);

    //             if (isset($request->search) && !empty($request->search)) {
    //                 $q->where('name', 'LIKE', '%' . $request->search . '%')->where('name', '!=', '');
    //                 $q->where('mobile_number', 'LIKE', '%' . $request->search . '%')->where('mobile_number', '!=', '');
    //             }
    //         })->paginate(15);
    //     return view('front.search-ambassador-results', compact('ambassadors'));
    // }

    // public function scholarshipAdancedSearch(Request $request)
    // {
    //     $defaultLang = getDefaultLanguage(1);
    //     $scholarships = SchoolScholarship::with([
    //         'schoolScholarshipDetail' => function ($q) use ($defaultLang) {
    //             $q->where('language_code', $defaultLang->abbreviation);
    //         },
    //         'school',
    //         'school.schoolDetail' => function ($q) use ($defaultLang) {
    //             $q->where('language_code', $defaultLang->abbreviation);
    //         },
    //     ])->whereHas('schoolScholarshipDetail', function ($q) use ($defaultLang, $request) {
    //         $q->where('language_code', $defaultLang->abbreviation);
    //         if (!empty($request->name)) {
    //             $q->where('name', 'LIKE', '%' . $request->name . '%');
    //         }
    //         if (!empty($request->keywords)) {
    //             $q->where('summary', 'LIKE', '%' . $request->keywords . '%');
    //         }
    //     });
    //     if (isset($request->province) && !empty($request->province)) {
    //         $scholarships->where('province', $request->province);
    //     }
    //     if (isset($request->awards) && !empty($request->awards)) {
    //         $scholarships->where('award', $request->awards);
    //     }
    //     if (isset($request->action) && !empty($request->action)) {
    //         $scholarships->where('action', $request->action);
    //     }

    //     if (isset($request->availability) && !empty($request->availability)) {
    //         $scholarships->where('availability', $request->availability);
    //     }

    //     if (isset($request->study_level) && !empty($request->study_level)) {
    //         $scholarships->where('study_level', $request->study_level);
    //     }
    //     if (isset($request->duration) && !empty($request->duration)) {
    //         $scholarships->where('duration', $request->duration);
    //     }
    //     if (isset($request->school) && !empty($request->school)) {
    //         $scholarships->where('school_id', $request->school);
    //     }
    //     if (isset($request->amount) && !empty($request->amount)) {
    //         $scholarships->where('amount', $request->amount);
    //     }
    //     if (isset($request->date_posted) && !empty($request->date_posted)) {
    //         $scholarships->where('date_posted', $request->date_posted);
    //     }
    //     if (isset($request->expiry_date) && !empty($request->expiry_date)) {
    //         $scholarships->where('expiry_date', $request->expiry_date);
    //     }
    //     if (isset($request->application_deadline) && !empty($request->application_deadline)) {
    //         $scholarships->where('deadline_date', $request->application_deadline);
    //     }
    //     $scholarships = $scholarships->addSelect([
    //         'name_order' => SchoolScholarshipDetail::where('language_code', $defaultLang->abbreviation)
    //             ->whereColumn('school_scholarship_id', 'school_scholarships.id')
    //             ->limit(1)
    //             ->select('name'),
    //     ]);
    //     if (isset($request->json_response) && $request->json_response == '1') {
    //         $scholarships = $scholarships->orderBy('name_order')->get();
    //         return $this->successResponse($scholarships, 'Data Get Successfully!');
    //     } else {
    //         $scholarships = $scholarships->orderBy('name_order')->paginate(12);
    //         return view('front.search-scholarships', compact('scholarships'));
    //     }
    // }
    public function scholarshipAdancedSearch(Request $request)
    {
        $defaultLang = getDefaultLanguage(1);

        $scholarships = SchoolScholarship::with([
            'schoolScholarshipDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
            'school',
            'school.schoolDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ])->whereHas('schoolScholarshipDetail', function ($q) use ($defaultLang, $request) {
            $q->where('language_code', $defaultLang->abbreviation);
            if (!empty($request->name)) {
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            }
            if (!empty($request->keywords)) {
                $q->where('summary', 'LIKE', '%' . $request->keywords . '%');
            }
        });

        // Apply filters (without filtering by school_id)
        if (!empty($request->province)) {
            $scholarships->where('province', $request->province);
        }
        if (!empty($request->awards)) {
            $scholarships->where('award', $request->awards);
        }
        if (!empty($request->action)) {
            $scholarships->where('action', $request->action);
        }
        if (!empty($request->availability)) {
            $scholarships->where('availability', $request->availability);
        }
        if (!empty($request->study_level)) {
            $scholarships->where('study_level', $request->study_level);
        }
        if (!empty($request->duration)) {
            $scholarships->where('duration', $request->duration);
        }

        // Order so that the specified school's scholarships come first
        if (!empty($request->school)) {
            $scholarships->orderByRaw("CASE WHEN school_id = ? THEN 0 ELSE 1 END", [$request->school]);
        }

        if ($request->json_response == '1') {
            $scholarships = $scholarships->orderBy('id', 'DESC')->get();
            return $this->successResponse($scholarships, 'Data Get Successfully!');
        } else {
            $scholarships = $scholarships->orderBy('id', 'DESC')->paginate(12);
            return view('front.search-scholarships', compact('scholarships'));
        }
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        return $this->loginSocialUse($user, $request);
    }

    public function redirectToLinkedIn()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function handleLinkedInCallback(Request $request)
    {
        $user = Socialite::driver('linkedin')->user();
        return $this->loginSocialUse($user, $request);
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {
        $user = Socialite::driver('facebook')->user();
        return $this->loginSocialUse($user, $request);
    }

    public function loginSocialUse($user, $request)
    {
        $defaultLang = getDefaultLanguage(1);
        $page = Page::with([
            'pageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])
            ->where('template', 'login_template')
            ->first();
        $redirectUrl = isset($page->pageDetail[0]->slug) ? $page->pageDetail[0]->slug : '/login';
        $isExist = Customer::where('email', $user->email)
            ->withTrashed()
            ->exists();
        if ($isExist) {
            $customer = Customer::where('email', $user->email)
                ->where('deactive_account', 0)
                ->first();
            $deletedCustomer = Customer::where('email', $user->email)
                ->onlyTrashed()
                ->first();
            if ($deletedCustomer) {
                return redirect($redirectUrl)->with('message', 'admin has blocked this email. Use another email for login/register');
            }
            if ($customer) {
                Auth::guard('customers')->attempt([
                    'email' => $customer->email,
                    'password' => '123',
                ]);
                $request->session()->regenerate();

                return redirect()->intended();
            } else {
                return redirect($redirectUrl)->with('message', 'Your Account is deactivated');
            }
        } else {
            $customer = Customer::create([
                'first_name' => $user->name,
                'last_name' => $user->name,
                'email' => $user->email,
                'password' => Hash::make('123'),
                'provider' => 'google',
                'provider_id' => $user->id,
            ]);
            CustomerLanguage::create([
                'customer_id' => $customer->id,
                'language_code' => $defaultLang->abbreviation,
            ]);
            $emailData = ['id' => $customer->id, 'first_name' => $user->name, 'last_name' => $user->name, 'email' => $user->email, 'password' => '123', 'type' => 'register_customer'];
            dispatch(new RegistrationEmailJob($emailData));
            return redirect($redirectUrl)->with('message', 'Your Account has been created successfully an you can login once admin approve your account');
        }
    }

    public function zohoToken()
    {
        // Zoho OAuth 2.0 endpoints
        $authorizationUrl = 'https://accounts.zoho.com/oauth/v2/auth';
        // Your application's client ID and client secret
        $clientID = env('ZOHO_CLIENT_ID');
        // Your application's callback URL
        $redirectUri = 'http://canedu.test/zoho/integration';
        $scopes = 'ZohoMeeting.manageOrg.READ ZohoMeeting.webinar.UPDATE ZohoMeeting.webinar.READ ZohoMeeting.webinar.CREATE ZohoMeeting.webinar.DELETE';
        // Redirect the user to Zoho's authorization URL
        $authUrl = "$authorizationUrl?prompt=consent&access_type=offline&client_id=$clientID&redirect_uri=$redirectUri&response_type=code&scope=$scopes";
        return view('front.zoho_authentication', compact('authUrl'));
    }

    public function ZohoIntegration(Request $request)
    {
        $tokenUrl = 'https://accounts.zoho.com/oauth/v2/token';
        $clientId = Auth::guard('school_ambassadors')->user()->zoho_client_id;
        $clientSecret = Auth::guard('school_ambassadors')->user()->zoho_client_secret;
        $redirectUri = env('APP_URL') . '/zoho/integration';

        $code = $request->code;
        $postData = [
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ];
        $client = new Client();
        $response = $client->post($tokenUrl, [
            'form_params' => $postData,
        ]);
        \Log::info('status code ' . $response->getStatusCode());
        if ($response->getStatusCode() == 200 || $response->getStatusCode() == '200') {
            $responseData = json_decode($response->getBody(), true);
            \Log::info($responseData);
            if (isset($responseData['access_token'])) {
                \Log::info('tokens ' . $responseData['access_token'] . ' ' . $responseData['refresh_token']);
                $accessToken = $responseData['access_token'];
                $refresh_token = $responseData['refresh_token'];
                SchoolAmbassador::where('id', Auth::guard('school_ambassadors')->user()->id)->update([
                    'zoho_refresh_token' => $refresh_token,
                ]);
            }
        }
        return view('front.zoho_authentication');
    }

    public function zohoAllWebinars()
    {
        $zohoService = new ZohoService();
        // return $zohoService->sycnhSingleWebinar();
        return $zohoService->sycnhAllWebinars();
    }

    public function getMappedCountry($countryName)
    {
        $countries = [
            "Afghanistan" => "AF",
            "Aland Islands" => "AX",
            "Albania" => "AL",
            "Algeria" => "DZ",
            "American Samoa" => "AS",
            "Andorra" => "AD",
            "Angola" => "AO",
            "Anguilla" => "AI",
            "Antarctica" => "AQ",
            "Antigua and Barbuda" => "AG",
            "Argentina" => "AR",
            "Armenia" => "AM",
            "Aruba" => "AW",
            "Australia" => "AU",
            "Austria" => "AT",
            "Azerbaijan" => "AZ",
            "Bahamas" => "BS",
            "Bahrain" => "BH",
            "Bangladesh" => "BD",
            "Barbados" => "BB",
            "Belarus" => "BY",
            "Belgium" => "BE",
            "Belize" => "BZ",
            "Benin" => "BJ",
            "Bermuda" => "BM",
            "Bhutan" => "BT",
            "Bolivia" => "BO",
            "Bonaire, Sint Eustatius and Saba" => "BQ",
            "Bosnia and Herzegovina" => "BA",
            "Botswana" => "BW",
            "Bouvet Island" => "BV",
            "Brazil" => "BR",
            "British Indian Ocean Territory" => "IO",
            "Brunei Darussalam" => "BN",
            "Bulgaria" => "BG",
            "Burkina Faso" => "BF",
            "Burundi" => "BI",
            "Cambodia" => "KH",
            "Cameroon" => "CM",
            "Canada" => "CA",
            "Cape Verde" => "CV",
            "Cayman Islands" => "KY",
            "Central African Republic" => "CF",
            "Chad" => "TD",
            "Chile" => "CL",
            "China" => "CN",
            "Christmas Island" => "CX",
            "Cocos (Keeling) Islands" => "CC",
            "Colombia" => "CO",
            "Comoros" => "KM",
            "Congo" => "CG",
            "Congo, Democratic Republic of the Congo" => "CD",
            "Cook Islands" => "CK",
            "Costa Rica" => "CR",
            "Cote D'Ivoire" => "CI",
            "Croatia" => "HR",
            "Cuba" => "CU",
            "Curacao" => "CW",
            "Cyprus" => "CY",
            "Czech Republic" => "CZ",
            "Denmark" => "DK",
            "Djibouti" => "DJ",
            "Dominica" => "DM",
            "Dominican Republic" => "DO",
            "Ecuador" => "EC",
            "Egypt" => "EG",
            "El Salvador" => "SV",
            "Equatorial Guinea" => "GQ",
            "Eritrea" => "ER",
            "Estonia" => "EE",
            "Ethiopia" => "ET",
            "Falkland Islands (Malvinas)" => "FK",
            "Faroe Islands" => "FO",
            "Fiji" => "FJ",
            "Finland" => "FI",
            "France" => "FR",
            "French Guiana" => "GF",
            "French Polynesia" => "PF",
            "French Southern Territories" => "TF",
            "Gabon" => "GA",
            "Gambia" => "GM",
            "Georgia" => "GE",
            "Germany" => "DE",
            "Ghana" => "GH",
            "Gibraltar" => "GI",
            "Greece" => "GR",
            "Greenland" => "GL",
            "Grenada" => "GD",
            "Guadeloupe" => "GP",
            "Guam" => "GU",
            "Guatemala" => "GT",
            "Guernsey" => "GG",
            "Guinea" => "GN",
            "Guinea-Bissau" => "GW",
            "Guyana" => "GY",
            "Haiti" => "HT",
            "Heard Island and McDonald Islands" => "HM",
            "Holy See (Vatican City State)" => "VA",
            "Honduras" => "HN",
            "Hong Kong" => "HK",
            "Hungary" => "HU",
            "Iceland" => "IS",
            "India" => "IN",
            "Indonesia" => "ID",
            "Iran, Islamic Republic of" => "IR",
            "Iraq" => "IQ",
            "Ireland" => "IE",
            "Isle of Man" => "IM",
            "Israel" => "IL",
            "Italy" => "IT",
            "Jamaica" => "JM",
            "Japan" => "JP",
            "Jersey" => "JE",
            "Jordan" => "JO",
            "Kazakhstan" => "KZ",
            "Kenya" => "KE",
            "Kiribati" => "KI",
            "Korea, Democratic People's Republic of" => "KP",
            "Korea, Republic of" => "KR",
            "Kosovo" => "XK",
            "Kuwait" => "KW",
            "Kyrgyzstan" => "KG",
            "Lao People's Democratic Republic" => "LA",
            "Latvia" => "LV",
            "Lebanon" => "LB",
            "Lesotho" => "LS",
            "Liberia" => "LR",
            "Libyan Arab Jamahiriya" => "LY",
            "Liechtenstein" => "LI",
            "Lithuania" => "LT",
            "Luxembourg" => "LU",
            "Macao" => "MO",
            "Macedonia, the Former Yugoslav Republic of" => "MK",
            "Madagascar" => "MG",
            "Malawi" => "MW",
            "Malaysia" => "MY",
            "Maldives" => "MV",
            "Mali" => "ML",
            "Malta" => "MT",
            "Marshall Islands" => "MH",
            "Martinique" => "MQ",
            "Mauritania" => "MR",
            "Mauritius" => "MU",
            "Mayotte" => "YT",
            "Mexico" => "MX",
            "Micronesia, Federated States of" => "FM",
            "Moldova, Republic of" => "MD",
            "Monaco" => "MC",
            "Mongolia" => "MN",
            "Montenegro" => "ME",
            "Montserrat" => "MS",
            "Morocco" => "MA",
            "Mozambique" => "MZ",
            "Myanmar" => "MM",
            "Namibia" => "NA",
            "Nauru" => "NR",
            "Nepal" => "NP",
            "Netherlands" => "NL",
            "Netherlands Antilles" => "AN",
            "New Caledonia" => "NC",
            "New Zealand" => "NZ",
            "Nicaragua" => "NI",
            "Niger" => "NE",
            "Nigeria" => "NG",
            "Niue" => "NU",
            "Norfolk Island" => "NF",
            "Northern Mariana Islands" => "MP",
            "Norway" => "NO",
            "Oman" => "OM",
            "Pakistan" => "PK",
            "Palau" => "PW",
            "Palestinian Territory, Occupied" => "PS",
            "Panama" => "PA",
            "Papua New Guinea" => "PG",
            "Paraguay" => "PY",
            "Peru" => "PE",
            "Philippines" => "PH",
            "Pitcairn" => "PN",
            "Poland" => "PL",
            "Portugal" => "PT",
            "Puerto Rico" => "PR",
            "Qatar" => "QA",
            "Romania" => "RO",
            "Russian Federation" => "RU",
            "Rwanda" => "RW",
            "Reunion" => "RE",
            "Saint Barthelemy" => "BL",
            "Saint Helena, Ascension and Tristan da Cunha" => "SH",
            "Saint Kitts and Nevis" => "KN",
            "Saint Lucia" => "LC",
            "Saint Martin (French part)" => "MF",
            "Saint Pierre and Miquelon" => "PM",
            "Saint Vincent and the Grenadines" => "VC",
            "Samoa" => "WS",
            "San Marino" => "SM",
            "Sao Tome and Principe" => "ST",
            "Saudi Arabia" => "SA",
            "Senegal" => "SN",
            "Serbia" => "RS",
            "Seychelles" => "SC",
            "Sierra Leone" => "SL",
            "Singapore" => "SG",
            "Sint Maarten (Dutch part)" => "SX",
            "Slovakia" => "SK",
            "Slovenia" => "SI",
            "Solomon Islands" => "SB",
            "Somalia" => "SO",
            "South Africa" => "ZA",
            "South Georgia and the South Sandwich Islands" => "GS",
            "South Sudan" => "SS",
            "Spain" => "ES",
            "Sri Lanka" => "LK",
            "Sudan" => "SD",
            "Suriname" => "SR",
            "Svalbard and Jan Mayen" => "SJ",
            "Swaziland" => "SZ",
            "Sweden" => "SE",
            "Switzerland" => "CH",
            "Syrian Arab Republic" => "SY",
            "Taiwan" => "TW",
            "Tajikistan" => "TJ",
            "Tanzania, United Republic of" => "TZ",
            "Thailand" => "TH",
            "Timor-Leste" => "TL",
            "Togo" => "TG",
            "Tokelau" => "TK",
            "Tonga" => "TO",
            "Trinidad and Tobago" => "TT",
            "Tunisia" => "TN",
            "Turkey" => "TR",
            "Turkmenistan" => "TM",
            "Tuvalu" => "TV",
            "Uganda" => "UG",
            "Ukraine" => "UA",
            "United Arab Emirates" => "AE",
            "United Kingdom" => "GB",
            "United States" => "US",
            "Uruguay" => "UY",
            "Uzbekistan" => "UZ",
            "Vanuatu" => "VU",
            "Venezuela" => "VE",
            "Viet Nam" => "VN",
            "Western Sahara" => "EH",
            "Yemen" => "YE",
            "Zambia" => "ZM",
            "Zimbabwe" => "ZW"
        ];


        return $countries[$countryName] ?? null;
    }
    public function updateSchoolsFromExcel()
    {
        $filePath = storage_path('app/public/schools.xlsx');

        if (!file_exists($filePath)) {
            return 'File not found!';
        }

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // First row is headers
        $headers = array_map('strtolower', $rows[0]);

        // Loop from second row
        for ($i = 1; $i < count($rows); $i++) {
            $row = array_combine($headers, $rows[$i]);
            $school = School::whereIn('degree_id', ['3', '2'])->where('email', $row['email'])->whereHas('schoolDetail', function ($query) use ($row) {
                $query->where('school_name', $row['school name']);
            })->first();

            if ($school) {
                $school->image = $row['image url 1'];
                $school->backup_images = json_encode([
                    $row['image url 2'],
                    $row['image url 3'],
                    $row['image url 4'],
                    $row['image url 5'],
                ]);
                $school->save();
            }
        }

        return 'School records updated from Excel!';
    }
    public function ImportCSV(Request $request)
    {
        // Get all columns of School and SchoolDetail tables
        $schoolColumns = Schema::getColumnListing((new \App\Models\School)->getTable());
        $schoolDetailColumns = Schema::getColumnListing((new \App\Models\SchoolDetail)->getTable());

        $csvHeader = array_merge(
            array_map(fn($col) => "school_{$col}", $schoolColumns),
            array_map(fn($col) => "school_detail_{$col}", $schoolDetailColumns)
        );

        $schools = School::whereNotIn('degree_id', ['3', '2'])
            ->whereHas('schoolDetail')
            ->with(['schoolDetail'])
            ->get();

        $csvData = [];

        foreach ($schools as $school) {
            $row = [];

            // Add School columns
            foreach ($schoolColumns as $col) {
                $row[] = $school->{$col};
            }

            // Add SchoolDetail columns (first detail only)
            $schoolDetail = $school->schoolDetail->first();
            foreach ($schoolDetailColumns as $col) {
                $row[] = $schoolDetail->{$col} ?? 'N/A';
            }

            $csvData[] = $row;
        }

        $filename = 'school_full_list_' . Str::random(5) . '.csv';
        $handle = fopen(storage_path('app/' . $filename), 'w+');
        fputcsv($handle, $csvHeader);

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return response()->download(storage_path('app/' . $filename))->deleteFileAfterSend(true);
    }
}
