import { createStore } from "vuex";
import signup from "./signup.js";

import business_categories from "./../admin/business_categories.js";
import faqs from "./faqs.js";
import blogs from "./blog.js";
import school_teams from "./school_teams.js";
import virtual_tours from "./virtual_tours.js";
import open_days from "./open_days.js";
import school_programs from "./school_programs.js";
import programs from "./programs.js";
import degrees from "./degrees.js";
import school_contacts from "./school_contacts.js";
import school_scholarships from "./school_scholarships.js";
import school_employees from "./school_employees.js";
import admission_setting from "./admission_setting.js";
import school_informations from "./school_informations.js";
import school_quickfacts from "./school_quickfacts.js";
import school_overviews from "./school_overviews.js";
import school_financials from "./school_financials.js";
import school_contact_settings from "./school_contact_settings.js";
import school_ambassador_settings from "./school_ambassador_settings.js";
import school_program_settings from "./school_program_settings.js";
import scholarship_settings from "./scholarship_settings.js";
import school_ambassadors from "./school_ambassadors.js";
import sports from "./sports.js";
import curricular_activities from "./curricular_activities.js";
import activities from "./activities.js";
import comunity_services from "./comunity_services.js";
import learning_languages from "./learning_languages.js";
import social_services from "./social_services.js";
import leadership_skills from "./leadership_skills.js";
import overview_programs from "./overview_programs.js";
import schools from "./schools.js";
import webinars from "./webinars.js";
import school_types from "./school_types.js";
import languages from "./languages.js";
import business from "./business.js";
import articles from "./articles.js";
import events from "./events.js";
import videos from "./videos.js";
import article_categories from "./article_categories.js";

import messaging_apps from "./messaging_apps.js";
import tests from "./tests.js";
// import curricular_activities from './../admin/curricular_activities';

export default new createStore({
    strict: true,
    modules: {
        signup,
        languages,
        business,
        business_categories,
        faqs,
        blogs,
        school_teams,
        virtual_tours,
        open_days,
        school_programs,
        programs,
        degrees,
        school_contacts,
        school_scholarships,
        school_employees,
        admission_setting,
        school_informations,
        school_quickfacts,
        school_overviews,
        school_financials,
        school_contact_settings,
        school_ambassador_settings,
        school_program_settings,
        scholarship_settings,
        school_ambassadors,
        sports,
        curricular_activities,
        activities,
        comunity_services,
        learning_languages,
        social_services,
        leadership_skills,
        overview_programs,
        schools,
        webinars,
        school_types,
        articles,
        events,
        videos,
        article_categories,
        messaging_apps,
        tests,
    },
});
