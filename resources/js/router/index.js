import { createRouter, createWebHistory } from "vue-router";

import Dashboard from "../admin/Dashboard/Dashboard.vue";
import Languages from "../admin/Languages/Languages.vue";
import CreateLanguages from "../admin/Languages/Create.vue";
import BusinessCategories from "../admin/BusinessCategories/BusinessCategories.vue";
import CreateBusinessCategories from "../admin/BusinessCategories/Create.vue";
import RegistrationPackages from "../admin/RegistrationPackages/RegistrationPackages.vue";
import CreateRegistrationPackages from "../admin/RegistrationPackages/Create.vue";
import Errors from "../admin/Errors/Create.vue";
import RegPageSetting from "../admin/Pages/RegPageSetting.vue";
import LoginPageSetting from "../admin/Pages/LoginPageSetting.vue";
import HomePageSetting from "../admin/Pages/HomePageSetting.vue";
import CreatePages from "../admin/Pages/Create.vue";
import Pages from "../admin/Pages/Pages.vue";
import Profile from "../admin/Profile/Profile.vue";
import Setting from "../admin/Settings/Setting.vue";
import Degrees from "../admin/Degrees/Degrees.vue";
import CreateDegrees from "../admin/Degrees/Create.vue";
import MessagingApps from "../admin/MessagingApps/MessagingApps.vue";
import CreateMessagingApps from "../admin/MessagingApps/Create.vue";
import Tests from "../admin/Tests/Tests.vue";
import CreateTests from "../admin/Tests/Create.vue";
import Stories from "../admin/Stories/Stories.vue";
import CreateStories from "../admin/Stories/Create.vue";
import SuggestedArticles from "../admin/SuggestedArticles/SuggestedArticles.vue";
import Articles from "../admin/Articles/Articles.vue";
import CreateArticles from "../admin/Articles/Create.vue";
import ArticleCategories from "../admin/ArticleCategories/ArticleCategories.vue";
import CreateArticleCategories from "../admin/ArticleCategories/Create.vue";
import Menus from "../admin/Menus/Menus.vue";
import CreateMenus from "../admin/Menus/Create.vue";
import CreateMenuBuilder from "../admin/Menus/MenuBuilder.vue";

import Banners from "../admin/Banners/Banners.vue";
import CreateBanners from "../admin/Banners/Create.vue";

import Career from "../admin/Career/Careers.vue";
import CreateCareer from "../admin/Career/Create.vue";
import Program from "../admin/Programs/Programs.vue";
import CreateProgram from "../admin/Programs/Create.vue";
import IsLoginModalSetting from "../admin/Pages/IsLoginModalSetting";
import FooterSettings from "../admin/Pages/FooterSetting";
import CookieSettings from "../admin/Pages/CookieSetting";

import Events from "../admin/Events/Events.vue";
import CreateEvents from "../admin/Events/Create.vue";
import Sponsors from "../admin/Sponsors/Sponsors.vue";
import CreateSponsors from "../admin/Sponsors/Create.vue";
import Teams from "../admin/Teams/Teams.vue";
import CreateTeams from "../admin/Teams/Create.vue";
import Quotes from "../admin/Quotes/Quotes.vue";
import CreateQuotes from "../admin/Quotes/Create.vue";
import Countries from "../admin/Countries/Countries.vue";
import CreateCountries from "../admin/Countries/Create.vue";
import Videos from "../admin/Videos/Videos.vue";
import CreateVideos from "../admin/Videos/Create.vue";

import BusinessDirectories from "../admin/BusinessDirectories/BusinessDirectories.vue";
import CreateBusinessDirectories from "../admin/BusinessDirectories/Create.vue";

import Networks from "../admin/Networks/Networks.vue";
import CreateNetworks from "../admin/Networks/Create.vue";

import MasterApplications from "../admin/MasterApplications/MasterApplications.vue";
import CreateMasterApplications from "../admin/MasterApplications/Create.vue";
import Customers from "../admin/Customers/Customers.vue";
import Contacts from "../admin/Contacts/Contacts.vue";

import Schools from "../admin/Schools/Schools.vue";
import CreateSchools from "../admin/Schools/Create.vue";
import SchoolAdmission from "../admin/Schools/Admission.vue";
import SchoolContact from "../admin/Schools/Contact.vue";
import SchoolAmbassadorSetting from "../admin/Schools/SchoolAmbassadorSetting.vue";
import SchoolOverview from "../admin/Schools/Overview.vue";
import SchoolFinancial from "../admin/Schools/Financial.vue";
import SchoolQuickfacts from "../admin/Schools/QuickFacts.vue";
import SchoolProgram from "../admin/Schools/Program.vue";
import SchoolScholarship from "../admin/Schools/Scholarship.vue";
import SchoolAmbassador from "../admin/Schools/Ambassador.vue";

import SchoolAdmissionFaq from "../admin/Schools/AdmissionFaq.vue";
import SchoolFinancialFaq from "../admin/Schools/FinancialFaq.vue";
import SchoolOverviewFaq from "../admin/Schools/OverviewFaq.vue";
import SchoolScholarshipFaq from "../admin/Schools/ScholarshipFaq.vue";
import SchoolBlog from "../admin/Schools/Blog.vue";
import SchoolTeam from "../admin/Schools/SchoolTeam.vue";
import SchoolProgramsFaq from "../admin/Schools/ProgramsFaq.vue";
import SchoolQuickFactsFaq from "../admin/Schools/QuickFactsFaq.vue";

import BulkImport from "../admin/Schools/BulkImport.vue";
import BulkImportScholarships from "../admin/Schools/BulkImportScholarships.vue";

import BulkImportBusinessDirectory from "../admin/BusinessDirectories/BulkImportBusinessDirectory.vue";
import BulkImportPrograms from "../admin/programs/BulkImportPrograms.vue";
import BulkImportSchoolPrograms from "../admin/programs/BulkImportSchoolPrograms.vue";
import SchoolTypes from "../admin/SchoolTypes/SchoolTypes.vue";
import CreateSchoolTypes from "../admin/SchoolTypes/Create.vue";
import BulkImportSchoolTypes from "../admin/SchoolTypes/BulkImportSchoolTypes.vue";
import BulkImportBusinessCategories from "../admin/BusinessCategories/BulkImportBusinessCategories.vue";
import Business from "../admin/Business/Business.vue";
import BusinessCreate from "../admin/Business/Create.vue";
import BulkImportBusinesses from "../admin/Business/BulkImportBusinesses.vue";
import SchoolScholarships from "../admin/SchoolScholarship/SchoolScholarships.vue";
import SchoolScholarshipsCreate from "../admin/SchoolScholarship/Create.vue";
import Sports from "../admin/Sports/Sports.vue";
import CreateSports from "../admin/Sports/Create.vue";
import CurricularActivities from "../admin/CurricularActivities/CurricularActivities.vue";
import CreateCurricularActivities from "../admin/CurricularActivities/Create.vue";
import Activities from "../admin/Activities/Activities.vue";
import CreateActivities from "../admin/Activities/Create.vue";
import ComunityServices from "../admin/ComunityServices/ComunityServices.vue";
import CreateComunityServices from "../admin/ComunityServices/Create.vue";
import LearningLanguages from "../admin/LearningLanguages/LearningLanguages.vue";
import CreateLearningLanguages from "../admin/LearningLanguages/Create.vue";
import SocialServices from "../admin/SocialServices/SocialServices.vue";
import CreateSocialServices from "../admin/SocialServices/Create.vue";

import LeadershipSkills from "../admin/LeadershipSkills/LeadershipSkills.vue";
import CreateLeadershipSkills from "../admin/LeadershipSkills/Create.vue";
import ProximaRequests from "../admin/ProximaRequests/ProximaRequests.vue";
import CreateProximaRequests from "../admin/ProximaRequests/Create.vue";
import ChatProximaRequests from "../admin/ProximaRequests/Chat.vue";

import VirtualTours from "../admin/VirtualTours/VirtualTours.vue";
import CreateVirtualTours from "../admin/VirtualTours/Create.vue";
import OpenDays from "../admin/OpenDays/OpenDays.vue";
import CreateOpenDays from "../admin/OpenDays/Create.vue";
import Ambassadors from "../admin/Ambassadors/Ambassadors.vue";
import CreateAmbassadors from "../admin/Ambassadors/Create.vue";
import CreateStaticTranslation from "../admin/StaticTranslation/Create.vue";
const routes = [
    {
        path: "/admin/dashboard",
        name: "admin.dashboard",
        component: Dashboard,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/languages",
        name: "admin.languages.index",
        component: Languages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Languages",
                    routeName: "admin.languages.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/languages/create",
        name: "admin.languages.create",
        component: CreateLanguages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Languages",
                    routeName: "admin.languages.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.languages.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/languages/:id/edit",
        name: "admin.languages.edit",
        component: CreateLanguages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Languages",
                    routeName: "admin.languages.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.languages.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    ,
    {
        path: "/admin/virtual_tours",
        name: "admin.virtual_tours.index",
        component: VirtualTours,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Virtual tours",
                    routeName: "admin.virtual_tours.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/virtual_tours/create",
        name: "admin.virtual_tours.create",
        component: CreateVirtualTours,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Virtual tours",
                    routeName: "admin.virtual_tours.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.virtual_tours.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/virtual_tours/:id/edit",
        name: "admin.virtual_tours.edit",
        component: CreateVirtualTours,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Virtual tours",
                    routeName: "admin.virtual_tours.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.virtual_tours.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    ,
    {
        path: "/admin/open_days",
        name: "admin.open_days.index",
        component: OpenDays,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Open days",
                    routeName: "admin.open_days.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/open_days/create",
        name: "admin.open_days.create",
        component: CreateOpenDays,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Open days",
                    routeName: "admin.open_days.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.open_days.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/open_days/:id/edit",
        name: "admin.open_days.edit",
        component: CreateOpenDays,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Open days",
                    routeName: "admin.open_days.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.open_days.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    ,
    {
        path: "/admin/ambassadors",
        name: "admin.ambassadors.index",
        component: Ambassadors,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Open days",
                    routeName: "admin.ambassadors.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/ambassadors/create",
        name: "admin.ambassadors.create",
        component: CreateAmbassadors,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Open days",
                    routeName: "admin.ambassadors.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.ambassadors.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/ambassadors/:id/edit",
        name: "admin.ambassadors.edit",
        component: CreateAmbassadors,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Open days",
                    routeName: "admin.ambassadors.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.ambassadors.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/proxima_requests",
        name: "admin.proxima_requests.index",
        component: ProximaRequests,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Proxima requests",
                    routeName: "admin.proxima_requests.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/proxima_requests/create",
        name: "admin.proxima_requests.create",
        component: CreateProximaRequests,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Proxima requests",
                    routeName: "admin.proxima_requests.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.proxima_requests.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/proxima_requests/:id/chat",
        name: "admin.proxima_requests.chat",
        component: ChatProximaRequests,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Proxima requests",
                    routeName: "admin.proxima_requests.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.proxima_requests.chat",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/proxima_requests/:id/edit",
        name: "admin.proxima_requests.edit",
        component: CreateProximaRequests,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Proxima requests",
                    routeName: "admin.proxima_requests.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.proxima_requests.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/banners",
        name: "admin.banners.index",
        component: Banners,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Banners",
                    routeName: "admin.banners.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/banners/create",
        name: "admin.banners.create",
        component: CreateBanners,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Banners",
                    routeName: "admin.banners.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.banners.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/banners/:id/edit",
        name: "admin.banners.edit",
        component: CreateBanners,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Banners",
                    routeName: "admin.banners.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.banners.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business-categories",
        name: "admin.business_categories.index",
        component: BusinessCategories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business categories",
                    routeName: "admin.business_categories.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business-categories/create",
        name: "admin.business_categories.create",
        component: CreateBusinessCategories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business categories",
                    routeName: "admin.business_categories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.business_categories.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business-categories/:id/edit",
        name: "admin.business_categories.edit",
        component: CreateBusinessCategories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business categories",
                    routeName: "admin.business_categories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.business_categories.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/business-categories/bulk-import",
        name: "admin.business-categories.bulk.import",
        component: BulkImportBusinessCategories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business categories",
                    routeName: "admin.business_categories.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business-directories/bulk-import",
        name: "admin.business-directories.bulk.import",
        component: BulkImportBusinessDirectory,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business directories",
                    routeName: "admin.business-directories.bulk.import",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    //menus
    {
        path: "/admin/menus",
        name: "admin.menus.index",
        component: Menus,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Menus",
                    routeName: "admin.menus.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/menus/create",
        name: "admin.menus.create",
        component: CreateMenus,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Menus",
                    routeName: "admin.menus.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.menus.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/menus/:id/edit",
        name: "admin.menus.edit",
        component: CreateMenus,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Menus",
                    routeName: "admin.menus.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.menus.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/menus/:id/builder",
        name: "admin.menu-builder.edit",
        component: CreateMenuBuilder,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Menus",
                    routeName: "admin.menus.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.menu-builder.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/degrees",
        name: "admin.degrees.index",
        component: Degrees,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Degrees",
                    routeName: "admin.degrees.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/degrees/create",
        name: "admin.degrees.create",
        component: CreateDegrees,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Degrees",
                    routeName: "admin.degrees.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.degrees.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/degrees/:id/edit",
        name: "admin.degrees.edit",
        component: CreateDegrees,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Degrees",
                    routeName: "admin.degrees.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.degrees.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/messaging_apps",
        name: "admin.messaging_apps.index",
        component: MessagingApps,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Messaging apps",
                    routeName: "admin.messaging_apps.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/messaging_apps/create",
        name: "admin.messaging_apps.create",
        component: CreateMessagingApps,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Messaging apps",
                    routeName: "admin.messaging_apps.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.messaging_apps.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/messaging_apps/:id/edit",
        name: "admin.messaging_apps.edit",
        component: CreateMessagingApps,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Messaging apps",
                    routeName: "admin.messaging_apps.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.messaging_apps.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/tests",
        name: "admin.tests.index",
        component: Tests,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Tests",
                    routeName: "admin.tests.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/tests/create",
        name: "admin.tests.create",
        component: CreateTests,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Tests",
                    routeName: "admin.tests.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.tests.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/tests/:id/edit",
        name: "admin.tests.edit",
        component: CreateTests,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Tests",
                    routeName: "admin.tests.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.tests.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/stories",
        name: "admin.stories.index",
        component: Stories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Stories",
                    routeName: "admin.stories.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/stories/create",
        name: "admin.stories.create",
        component: CreateStories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Stories",
                    routeName: "admin.stories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.stories.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/stories/:id/edit",
        name: "admin.stories.edit",
        component: CreateStories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Stories",
                    routeName: "admin.stories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.stories.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/article_categories-listing",
        name: "admin.article_categories.index",
        component: ArticleCategories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Article categories",
                    routeName: "admin.article_categories.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/article_categories/create",
        name: "admin.article_categories.create",
        component: CreateArticleCategories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Article categories",
                    routeName: "admin.article_categories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.article_categories.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/article_categories/:id/edit",
        name: "admin.article_categories.edit",
        component: CreateArticleCategories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Article categories",
                    routeName: "admin.article_categories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.article_categories.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/suggested-articles",
        name: "admin.suggested-articles.index",
        component: SuggestedArticles,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Suggested Articles",
                    routeName: "admin.suggested-articles.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/articles-listing",
        name: "admin.articles.index",
        component: Articles,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Articles",
                    routeName: "admin.articles.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/articles/create",
        name: "admin.articles.create",
        component: CreateArticles,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Articles",
                    routeName: "admin.articles.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.articles.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/articles/:id/edit",
        name: "admin.articles.edit",
        component: CreateArticles,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Articles",
                    routeName: "admin.articles.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.articles.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/careers-listing",
        name: "admin.careers.index",
        component: Career,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Carrers",
                    routeName: "admin.careers.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/careers/create",
        name: "admin.careers.create",
        component: CreateCareer,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Carrers",
                    routeName: "admin.careers.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.careers.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/careers/:id/edit",
        name: "admin.careers.edit",
        component: CreateCareer,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Article categories",
                    routeName: "admin.careers.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.careers.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/programs-listing",
        name: "admin.programs.index",
        component: Program,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Article categories",
                    routeName: "admin.programs.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/programs/create",
        name: "admin.programs.create",
        component: CreateProgram,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Article categories",
                    routeName: "admin.programs.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.programs.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/programs/:id/edit",
        name: "admin.programs.edit",
        component: CreateProgram,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Article categories",
                    routeName: "admin.programs.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.programs.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/programs/bulk-import",
        name: "admin.programs.bulk.import",
        component: BulkImportPrograms,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Programs",
                    routeName: "admin.programs.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/school-programs/bulk-import",
        name: "admin.school-programs.bulk.import",
        component: BulkImportSchoolPrograms,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Programs",
                    routeName: "admin.programs.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/school_types",
        name: "admin.school_types.index",
        component: SchoolTypes,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "School types",
                    routeName: "admin.school_types.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/school_types/create",
        name: "admin.school_types.create",
        component: CreateSchoolTypes,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "School types",
                    routeName: "admin.school_types.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.school_types.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/school_types/:id/edit",
        name: "admin.school_types.edit",
        component: CreateSchoolTypes,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "School types",
                    routeName: "admin.school_types.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.school_types.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/school-types/bulk-import",
        name: "admin.school.types.bulk.import",
        component: BulkImportSchoolTypes,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "School types",
                    routeName: "admin.school_types.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/registration-packages",
        name: "admin.registration_packages.index",
        component: RegistrationPackages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Registration packages",
                    routeName: "admin.registration_packages.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/registration-packages/create",
        name: "admin.registration_packages.create",
        component: CreateRegistrationPackages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Registration packages",
                    routeName: "admin.registration_packages.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.registration_packages.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/registration-packages/:id/edit",
        name: "admin.registration_packages.edit",
        component: CreateRegistrationPackages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Registration packages",
                    routeName: "admin.registration_packages.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.registration_packages.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/profile",
        name: "admin.profile.edit",
        component: Profile,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Profile",
                    routeName: "admin.profile.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/settings",
        name: "admin.setting.edit",
        component: Setting,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Settings",
                    routeName: "admin.setting.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/errors",
        name: "admin.errors.edit",
        component: Errors,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Errors",
                    routeName: "admin.errors.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/pages/registration",
        name: "admin.registration.edit",
        component: RegPageSetting,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Registration page",
                    routeName: "admin.registration.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/pages/home",
        name: "admin.home.edit",
        component: HomePageSetting,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Home page",
                    routeName: "admin.home.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/pages/login",
        name: "admin.login.edit",
        component: LoginPageSetting,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Login page",
                    routeName: "admin.login.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/pages/web-general-setting",
        name: "admin.web-general-setting.edit",
        component: IsLoginModalSetting,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Login page",
                    routeName: "admin.login.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/pages/footer-setting",
        name: "admin.footer.settings",
        component: FooterSettings,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Footer setting page",
                    routeName: "admin.footer.settings",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/pages/cookies-policy",
        name: "admin.cookie.settings",
        component: CookieSettings,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Cookie setting page",
                    routeName: "admin.cookie.settings",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/pages",
        name: "admin.pages.index",
        component: Pages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Pages",
                    routeName: "admin.pages.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/pages/create",
        name: "admin.pages.create",
        component: CreatePages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Pages",
                    routeName: "admin.pages.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.pages.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/pages/:id/edit",
        name: "admin.pages.edit",
        component: CreatePages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Pages",
                    routeName: "admin.pages.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.pages.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/events",
        name: "admin.events.index",
        component: Events,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Events",
                    routeName: "admin.events.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/events/create",
        name: "admin.events.create",
        component: CreateEvents,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Events",
                    routeName: "admin.events.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.events.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/events/:id/edit",
        name: "admin.events.edit",
        component: CreateEvents,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Events",
                    routeName: "admin.events.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.events.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/leadership_skills",
        name: "admin.leadership_skills.index",
        component: LeadershipSkills,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Leadership skills",
                    routeName: "admin.leadership_skills.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/leadership_skills/create",
        name: "admin.leadership_skills.create",
        component: CreateLeadershipSkills,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Leadership skills",
                    routeName: "admin.leadership_skills.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.leadership_skills.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/leadership_skills/:id/edit",
        name: "admin.leadership_skills.edit",
        component: CreateLeadershipSkills,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Leadership skills",
                    routeName: "admin.leadership_skills.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.leadership_skills.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/comunity_services",
        name: "admin.comunity_services.index",
        component: ComunityServices,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "community services",
                    routeName: "admin.comunity_services.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/comunity_services/create",
        name: "admin.comunity_services.create",
        component: CreateComunityServices,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "community services",
                    routeName: "admin.comunity_services.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.comunity_services.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/comunity_services/:id/edit",
        name: "admin.comunity_services.edit",
        component: CreateComunityServices,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "community services",
                    routeName: "admin.comunity_services.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.comunity_services.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/social_services",
        name: "admin.social_services.index",
        component: SocialServices,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Social services",
                    routeName: "admin.social_services.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/social_services/create",
        name: "admin.social_services.create",
        component: CreateSocialServices,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Social services",
                    routeName: "admin.social_services.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.social_services.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/social_services/:id/edit",
        name: "admin.social_services.edit",
        component: CreateSocialServices,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Social services",
                    routeName: "admin.social_services.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.social_services.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/learning_languages",
        name: "admin.learning_languages.index",
        component: LearningLanguages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Learning languages",
                    routeName: "admin.learning_languages.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/learning_languages/create",
        name: "admin.learning_languages.create",
        component: CreateLearningLanguages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Learning languages",
                    routeName: "admin.learning_languages.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.learning_languages.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/learning_languages/:id/edit",
        name: "admin.learning_languages.edit",
        component: CreateLearningLanguages,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Learning languages",
                    routeName: "admin.learning_languages.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.learning_languages.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/sports",
        name: "admin.sports.index",
        component: Sports,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Sports",
                    routeName: "admin.sports.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/sports/create",
        name: "admin.sports.create",
        component: CreateSports,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Sports",
                    routeName: "admin.sports.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.sports.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/sports/:id/edit",
        name: "admin.sports.edit",
        component: CreateSports,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Sports",
                    routeName: "admin.sports.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.sports.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    // curriclar
    {
        path: "/admin/curricular_activities",
        name: "admin.curricular_activities.index",
        component: CurricularActivities,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "CurricularActivities",
                    routeName: "admin.curricular_activities.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/curricular_activities/create",
        name: "admin.curricular_activities.create",
        component: CreateCurricularActivities,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "CreateCurricularActivities",
                    routeName: "admin.curricular_activities.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.curricular_activities.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/curricular_activities/:id/edit",
        name: "admin.curricular_activities.edit",
        component: CreateCurricularActivities,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "CreateCurricularActivities",
                    routeName: "admin.curricular_activities.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.curricular_activities.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    // activities
    {
        path: "/admin/activities",
        name: "admin.activities.index",
        component: Activities,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Activities",
                    routeName: "admin.activities.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/activities/create",
        name: "admin.activities.create",
        component: CreateActivities,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "CreateActivities",
                    routeName: "admin.activities.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.activities.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/activities/:id/edit",
        name: "admin.activities.edit",
        component: CreateActivities,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "CreateActivities",
                    routeName: "admin.activities.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.activities.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/sponsors",
        name: "admin.sponsors.index",
        component: Sponsors,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Sponsors",
                    routeName: "admin.sponsors.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/sponsors/create",
        name: "admin.sponsors.create",
        component: CreateSponsors,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Sponsors",
                    routeName: "admin.sponsors.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.sponsors.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/sponsors/:id/edit",
        name: "admin.sponsors.edit",
        component: CreateSponsors,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Sponsors",
                    routeName: "admin.sponsors.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.sponsors.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/teams",
        name: "admin.teams.index",
        component: Teams,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Teams",
                    routeName: "admin.teams.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/teams/create",
        name: "admin.teams.create",
        component: CreateTeams,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Teams",
                    routeName: "admin.teams.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.teams.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/teams/:id/edit",
        name: "admin.teams.edit",
        component: CreateTeams,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Teams",
                    routeName: "admin.teams.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.teams.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/business_directories",
        name: "admin.business_directories.index",
        component: BusinessDirectories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business directories",
                    routeName: "admin.business_directories.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business_directories/create",
        name: "admin.business_directories.create",
        component: CreateBusinessDirectories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business directories",
                    routeName: "admin.business_directories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.business_directories.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business_directories/:id/edit",
        name: "admin.business_directories.edit",
        component: CreateBusinessDirectories,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business directories",
                    routeName: "admin.business_directories.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.business_directories.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/quotes",
        name: "admin.quotes.index",
        component: Quotes,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Quotes",
                    routeName: "admin.quotes.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/quotes/create",
        name: "admin.quotes.create",
        component: CreateQuotes,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Quotes",
                    routeName: "admin.quotes.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.quotes.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/quotes/:id/edit",
        name: "admin.quotes.edit",
        component: CreateQuotes,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Quotes",
                    routeName: "admin.quotes.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.quotes.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/countries",
        name: "admin.countries.index",
        component: Countries,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Countries",
                    routeName: "admin.countries.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/countries/create",
        name: "admin.countries.create",
        component: CreateCountries,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Countries",
                    routeName: "admin.countries.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.countries.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/countries/:id/edit",
        name: "admin.countries.edit",
        component: CreateCountries,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Countries",
                    routeName: "admin.countries.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.countries.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/videos",
        name: "admin.videos.index",
        component: Videos,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Videos",
                    routeName: "admin.videos.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/videos/create",
        name: "admin.videos.create",
        component: CreateVideos,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Videos",
                    routeName: "admin.videos.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.videos.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/videos/:id/edit",
        name: "admin.videos.edit",
        component: CreateVideos,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Videos",
                    routeName: "admin.videos.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.videos.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/networks",
        name: "admin.networks.index",
        component: Networks,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Networks",
                    routeName: "admin.networks.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/networks/create",
        name: "admin.networks.create",
        component: CreateNetworks,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Networks",
                    routeName: "admin.networks.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.networks.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/networks/:id/edit",
        name: "admin.networks.edit",
        component: CreateNetworks,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Networks",
                    routeName: "admin.networks.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.networks.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/master-applications",
        name: "admin.master-applications.index",
        component: MasterApplications,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Master applications",
                    routeName: "admin.master-applications.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/master-applications/create",
        name: "admin.master-applications.create",
        component: CreateMasterApplications,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Master applications",
                    routeName: "admin.master-applications.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.master-applications.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/master-applications/:id/view",
        name: "admin.master-applications.view",
        component: CreateMasterApplications,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Master applications",
                    routeName: "admin.master-applications.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "View",
                    routeName: "admin.master-applications.view",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/customers",
        name: "admin.customers.index",
        component: Customers,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Customers",
                    routeName: "admin.customers.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/contacts",
        name: "admin.contacts.index",
        component: Contacts,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Contacts",
                    routeName: "admin.contacts.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/schools/bulk-import",
        name: "admin.schools.bulk.import",
        component: BulkImport,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/scholarship/bulk-import",
        name: "admin.scholarship.bulk.import",
        component: BulkImportScholarships,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools",
        name: "admin.schools.index",
        component: Schools,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/create",
        name: "admin.schools.create",
        component: CreateSchools,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.schools.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/edit",
        name: "admin.schools.edit",
        component: CreateSchools,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/contact",
        name: "admin.schools.contact",
        component: SchoolContact,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.contact",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/ambassador",
        name: "admin.schools.ambassador.setting",
        component: SchoolAmbassadorSetting,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.ambassador.setting",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/overview",
        name: "admin.schools.overview",
        component: SchoolOverview,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.overview",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/quick_facts",
        name: "admin.schools.quick_facts",
        component: SchoolQuickfacts,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.quick_facts",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/program",
        name: "admin.schools.program",
        component: SchoolProgram,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.program",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/scholarship",
        name: "admin.schools.scholarship",
        component: SchoolScholarship,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.scholarship",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/ambassador",
        name: "admin.schools.ambassador",
        component: SchoolAmbassador,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.ambassador",
                    isCurrentRoute: 1,
                },
            ],
        },
    },

    {
        path: "/admin/schools/:id/financial",
        name: "admin.schools.financial",
        component: SchoolFinancial,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.financial",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/admission",
        name: "admin.schools.admission",
        component: SchoolAdmission,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.admission",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/admission/faq",
        name: "admin.schools.admission.faq",
        component: SchoolAdmissionFaq,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.admission.faq",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/financial/faq",
        name: "admin.schools.financial.faq",
        component: SchoolFinancialFaq,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.financial.faq",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/overview/faq",
        name: "admin.schools.overview.faq",
        component: SchoolOverviewFaq,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.overview.faq",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/programs/faq",
        name: "admin.schools.programs.faq",
        component: SchoolProgramsFaq,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.programs.faq",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/quick_facts/faq",
        name: "admin.schools.quick_facts.faq",
        component: SchoolQuickFactsFaq,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.quick_facts.faq",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/scholarship/faq",
        name: "admin.schools.scholarship.faq",
        component: SchoolScholarshipFaq,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.scholarship.faq",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/blog",
        name: "admin.schools.blog",
        component: SchoolBlog,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.blog",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/schools/:id/school-team",
        name: "admin.schools.school-team",
        component: SchoolTeam,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Schools",
                    routeName: "admin.schools.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.schools.school-team",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business",
        name: "admin.business.index",
        component: Business,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business",
                    routeName: "admin.business.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business/create",
        name: "admin.business.create",
        component: BusinessCreate,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "business",
                    routeName: "admin.business.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.business.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business/:id/edit",
        name: "admin.business.edit",
        component: BusinessCreate,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "business",
                    routeName: "admin.business.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.business.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/business-bulk-import",
        name: "admin.business.bulk.import",
        component: BulkImportBusinesses,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Business",
                    routeName: "admin.business.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/school_scholarships",
        name: "admin.school_scholarships.index",
        component: SchoolScholarships,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "School scholarships",
                    routeName: "admin.school_scholarships.index",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/school_scholarships/create",
        name: "admin.school_scholarships.create",
        component: SchoolScholarshipsCreate,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "School scholarships",
                    routeName: "admin.school_scholarships.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Create",
                    routeName: "admin.school_scholarships.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/school_scholarships/:id/edit",
        name: "admin.school_scholarships.edit",
        component: SchoolScholarshipsCreate,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "School scholarships",
                    routeName: "admin.school_scholarships.index",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit",
                    routeName: "admin.school_scholarships.edit",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
    {
        path: "/admin/static-translation/:type",
        name: "admin.static-translation.create",
        component: CreateStaticTranslation,
        meta: {
            breadcrumbs: [
                {
                    name: "Dashboard",
                    routeName: "admin.dashboard",
                    isCurrentRoute: 0,
                },
                {
                    name: "Edit static translation",
                    routeName: "admin.static-translation.create",
                    isCurrentRoute: 1,
                },
            ],
        },
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
