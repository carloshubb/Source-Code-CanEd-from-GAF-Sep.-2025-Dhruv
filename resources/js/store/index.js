import { createStore } from "vuex";
import menu from "./admin/menu.js";
import languages from "./admin/languages.js";
import business_categories from "./admin/business_categories.js";
import menus from "./admin/menus.js";
import registration_packages from "./admin/registration_packages.js";
import errors from "./admin/errors.js";
import reg_page_setting from "./admin/reg_page_setting.js";
import auth from "./admin/auth.js";
import degrees from "./admin/degrees.js";
import stories from "./admin/stories.js";

import articles from "./admin/articles.js";
import article_categories from "./admin/article_categories.js";
import pages from "./admin/pages.js";
import login_page_setting from "./admin/login_page_setting.js";
import home_page_setting from "./admin/home_page_setting.js";
import school_request_setting from "./admin/school_request_setting.js";
import is_login_modal_setting from "./admin/is_login_modal_setting.js";
import register_business from "./admin/register_business.js";
import banners from "./admin/banners.js";
import careers from "./admin/careers.js";
import programs from "./admin/programs.js";
import career_setting from "./admin/career_setting.js";
import program_setting from "./admin/program_setting.js";
import contact_page_setting from "./admin/contact_page_setting.js";
import footer_setting from "./admin/footer_setting.js";
import cookie_setting from "./admin/cookie_setting.js";

import master_application_setting from "./admin/master_application_setting.js";
import article_page_setting from "./admin/article_page_setting.js";
import events from "./admin/events.js";
import sponsors from "./admin/sponsors.js";
import teams from "./admin/teams.js";
import quotes from "./admin/quotes.js";
import countries from "./admin/countries.js";
import videos from "./admin/videos.js";
import business_directories from "./admin/business_directories.js";
import networks from "./admin/networks.js";
import master_applications from "./admin/master_applications.js";
import schools from "./admin/schools.js";
import customers from "./admin/customers.js";
import contacts from "./admin/contacts.js";

import businesses from "./admin/business.js";
import school_types from "./admin/school_types.js";
import school_scholarships from "./admin/school_scholarships.js";
import suggession_page_setting from "./admin/suggession_page_setting.js";
import bus_directory_setting from "./admin/bus_directory_setting.js";
import sports from "./admin/sports.js";
import curricular_activities from "./admin/curricular_activities.js";
import activities from "./admin/activities.js";
import comunity_services from "./admin/comunity_services.js";
import learning_languages from "./admin/learning_languages.js";
import social_services from "./admin/social_services.js";
import leadership_skills from "./admin/leadership_skills.js";
import demetra_page_setting from "./admin/demetra_page_setting.js";
import proxima_request_setting from "./admin/proxima_request_setting.js";
import proxima_requests from "./admin/proxima_requests.js";
import sitemap_setting from "./admin/sitemap_setting.js";
import virtual_tours from "./admin/virtual_tours.js";
import open_days from "./admin/open_days.js";
import ambassadors from "./admin/ambassadors.js";
import static_translation from "./admin/static_translation.js";
import admission_setting from "./admin/admission_setting.js";
import faqs from "./admin/faqs.js";
import blogs from "./admin/blog.js";
import school_teams from "./admin/school_teams.js";
import school_contacts from "./admin/school_contacts.js";
import school_contact_settings from "./admin/school_contact_settings.js";
import school_ambassador_settings from "./admin/school_ambassador_settings.js";
import school_overviews from "./admin/school_overviews.js";
import school_financials from "./admin/school_financials.js";
import school_quickfacts from "./admin/school_quickfacts.js";
import school_programs from "./admin/school_programs.js";
import school_program_settings from "./admin/school_program_settings.js";
import scholarship_settings from "./admin/scholarship_settings.js";
import messaging_apps from "./admin/messaging_apps.js";
import tests from "./admin/tests.js";

export default new createStore({
    strict: true,
    modules: {
        menu,
        languages,
        business_categories,
        registration_packages,
        auth,
        errors,
        reg_page_setting,
        degrees,
        stories,
        articles,
        article_categories,
        banners,
        pages,
        login_page_setting,
        menus,
        home_page_setting,
        school_request_setting,
        is_login_modal_setting,
        register_business,
        careers,
        programs,
        career_setting,
        program_setting,
        contact_page_setting,
        footer_setting,
        master_application_setting,
        article_page_setting,
        events,
        sponsors,
        teams,
        quotes,
        countries,
        videos,
        business_directories,
        networks,
        master_applications,
        schools,
        businesses,
        school_types,
        customers,
        businesses,
        school_scholarships,
        suggession_page_setting,
        bus_directory_setting,
        sports,
        curricular_activities,
        activities,
        comunity_services,
        learning_languages,
        social_services,
        leadership_skills,
        demetra_page_setting,
        proxima_request_setting,
        proxima_requests,
        sitemap_setting,
        virtual_tours,
        open_days,
        ambassadors,
        contacts,
        cookie_setting,
        static_translation,
        admission_setting,
        faqs,
        blogs,
        school_teams,
        school_contacts,
        school_contact_settings,
        school_ambassador_settings,
        school_overviews,
        school_financials,
        school_quickfacts,
        school_programs,
        school_program_settings,
        scholarship_settings,
        messaging_apps,
        tests,
    },
});
