require("./bootstrap");

import { createApp } from "vue";
import store from "./store/web/index.js";

import LanguageModal from "./web/modals/LanguageModal.vue";
import SchoolCategorySection from "./web/HomePageSections/SchoolCategorySection";
import SchoolCategorySectionMobile from "./web/HomePageSections/SchoolCategorySectionMobile";
import ProximaStudySection from "./web/HomePageSections/ProximaStudySection";
import FeeturedSchoolSection from "./web/HomePageSections/FeeturedSchoolSection";
import FeeturedBusinessSection from "./web/HomePageSections/FeeturedBusinessSection";
import FinancialHelp from "./web/HomePageSections/FinancialHelp";
import BannerOneSection from "./web/HomePageSections/BannerOneSection";
import BannerTwoSection from "./web/HomePageSections/BannerTwoSection";
import BannerThreeSection from "./web/HomePageSections/BannerThreeSection";
import WorkWhileStudy from "./web/HomePageSections/WorkWhileStudy";
import ProximaStudySectionTwo from "./web/HomePageSections/ProximaStudySectionTwo";
import RecentArticleSection from "./web/HomePageSections/RecentArticleSection";
import LoginPage from "./web/Auth/Login";
import RegisterPage from "./web/Auth/Register";
import SchoolRequestPage from "./web/SchoolRequest.vue";
import RegisterBusinessPage from "./web/RegisterBusiness.vue";
import ContactPage from "./web/ContactPage.vue";
import MasterApplication from "./web/MasterApplication.vue";
import AccountInfo from "./web/account/AccountInfo.vue";
import SchoolSetting from "./web/account/SchoolSetting.vue";
import Faq from "./web/account/Faq.vue";
import VirtualTourCreate from "./web/account/Virtualtour/Create.vue";
import VirtualTourEdit from "./web/account/Virtualtour/Edit.vue";
import VirtualTourDelete from "./web/account/Virtualtour/Delete.vue";

import ArticleCreate from "./web/account/Article/Create.vue";
import ArticleEdit from "./web/account/Article/Edit.vue";
import ArticleDelete from "./web/account/Article/Delete.vue";

import EventCreate from "./web/account/Event/Create.vue";
import EventEdit from "./web/account/Event/Edit.vue";
import EventDelete from "./web/account/Event/Delete.vue";

import VideoCreate from "./web/account/Video/Create.vue";
import VideoEdit from "./web/account/Video/Edit.vue";

import BusinessCreate from "./web/account/business/Create.vue";
import BusinessEdit from "./web/account/business/Edit.vue";
import BusinessDelete from "./web/account/business/Delete.vue";


import OpenDayCreate from "./web/account/Openday/Create.vue";
import OpenDayEdit from "./web/account/Openday/Edit.vue";
import OpenDayDelete from "./web/account/Openday/Delete.vue";

import WebinarCreate from "./web/account/Webinar/Create.vue";
import WebinarEdit from "./web/account/Webinar/Edit.vue";
import WebinarDelete from "./web/account/Webinar/Delete.vue";
import WebinarSetting from "./web/account/Webinar/Setting.vue";
import SynchWebinars from "./web/account/Webinar/SynchWebinars.vue";




import SchoolProgram from "./web/account/SchoolProgram.vue";
import SchoolContact from "./web/account/SchoolContact.vue";
import SchoolAmbassadorSetting from "./web/account/SchoolAmbassadorSetting.vue";
import SchoolScholarship from "./web/account/SchoolScholarship.vue";
import SchoolEmployee from "./web/account/SchoolEmployee.vue";
import AdmissionSetting from "./web/account/AdmissionSetting.vue";
import SchoolInformation from "./web/account/SchoolInformation.vue";
import SchoolQuickFact from "./web/account/SchoolQuickFact.vue";
import SchoolOverview from "./web/account/SchoolOverview.vue";
import SchoolFinancial from "./web/account/SchoolFinancial.vue";
import UpdatePassword from "./web/account/UpdatePassword.vue";
import AddNetwork from "./web/AddNetwork.vue";
import CloseAccount from "./web/account/CloseAccount.vue";
import SchoolAmbassador from "./web/account/SchoolAmbassador.vue";
import SchoolAmbassadorCreate from "./web/account/SchoolAmbassadorCreate.vue";

import Ambassadors from "./web/Ambassadors.vue";
import AmbassadorTab from "./web/AmbassadorTab.vue";
import AmbassadorChat from "./web/AmbassadorChat.vue";
import StudentChat from "./web/StudentChat.vue";
import AmbassadorStudentChat from "./web/AmbassadorStudentChat.vue";
import AddQuote from "./web/AddQuote.vue";
import AddVideo from "./web/AddVideo.vue";
import AddEvent from "./web/AddEvent.vue";
import AddEventForm from "./web/AddEventForm.vue";
import RegisterTypeModal from "./web/RegisterTypeModal.vue";
import AddCareer from "./web/AddCareer.vue";
import AddCareerForm from "./web/AddCareerForm.vue";
import AddStory from "./web/AddStory.vue";
import AddStoryForm from "./web/AddStoryForm.vue";
import AddSponsorButton from "./web/AddSponsorButton.vue";
import AddSponsorForm from "./web/AddSponsorForm.vue";

import ScholarshipAdvancedSearch from "./web/ScholarshipAdvancedSearch.vue";
import ScholarshipAdvancedSearchOnSchoolPage from "./web/ScholarshipAdvancedSearchOnSchoolPage.vue";

import SuggessionForm from "./web/SuggessionForm.vue";
import AddProgram from "./web/AddProgram.vue";
import AddArticle from "./web/AddArticle.vue";
import AddVirtualTour from "./web/AddVirtualTour.vue";
import DemetraSetting from "./web/account/DemetraSetting.vue";
import StudentProfile from "./web/account/StudentProfile.vue";
import SearchStudentProfile from "./web/account/SearchStudentProfile.vue";
import ProximatchModal from "./web/ProximatchModal.vue";
import OpenDayContactOrgnizer from "./web/OpenDayContactOrgnizer.vue";
import OverviewPrograms from "./web/account/OverviewPrograms.vue";
import Blog from "./web/account/Blog.vue";
import SchoolTeams from "./web/account/SchoolTeam.vue";
import EventContactOrgnizer from "./web/EventContactOrgnizer.vue";
import CreateProfilePayment from "./web/ProfilePayment.vue";
import updatePlan from "./web/UpdatePlan.vue";
import FavIcon from "./web/FavIcon.vue";
import RemoveFavIcon from "./web/RemoveFavIcon.vue";
import ContactBusiness from "./web/ContactBusiness.vue";
import ContactSchool from "./web/ContactSchool.vue";
import EventImage from "./web/EventImage.vue";
import EventContactImage from "./web/EventContactImage.vue";
import BusinessDirectory from "./web/BusinessDirectory.vue";
import DemetraSearch from "./web/DemetraSearch.vue";
import ProximaChat from "./web/ProximaChat.vue";
import ProximaPayment from "./web/ProximaPayment.vue";


import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import Select2 from 'vue3-select2-component';
import vSelect from 'vue-select'



createApp({})
.use(VueSweetalert2)
.use(Select2)
.component("vSelect", vSelect)
.component("LanguageModal", LanguageModal)
.component("SchoolCategorySection", SchoolCategorySection)
.component("SchoolCategorySectionMobile", SchoolCategorySectionMobile)
.component("ProximaStudySection", ProximaStudySection)
.component("FeeturedSchoolSection", FeeturedSchoolSection)
.component("FeeturedBusinessSection", FeeturedBusinessSection)
.component("FinancialHelp", FinancialHelp)
.component("BannerOneSection", BannerOneSection)
.component("BannerTwoSection", BannerTwoSection)
.component("WorkWhileStudy", WorkWhileStudy)
.component("ProximaStudySectionTwo", ProximaStudySectionTwo)
.component("RecentArticleSection", RecentArticleSection)
.component("BannerThreeSection", BannerThreeSection)
.component("LoginPage", LoginPage)
.component("RegisterPage", RegisterPage)
.component("SchoolRequestPage", SchoolRequestPage)
.component("RegisterBusinessPage", RegisterBusinessPage)
.component("ContactPage", ContactPage)
.component("MasterApplication", MasterApplication)
.component("AccountInfo", AccountInfo)
.component("SchoolSetting", SchoolSetting)
.component("FaqComponent", Faq)
.component("VirtualTourCreate", VirtualTourCreate)
.component("VirtualTourEdit", VirtualTourEdit)
.component("VirtualTourDelete", VirtualTourDelete)
.component("BusinessCreate", BusinessCreate)
.component("BusinessEdit", BusinessEdit)
.component("BusinessDelete", BusinessDelete)
.component("ArticleCreate", ArticleCreate)
.component("ArticleEdit", ArticleEdit)
.component("ArticleDelete", ArticleDelete)
.component("EventCreate", EventCreate)
.component("EventEdit", EventEdit)
.component("EventDelete", EventDelete)
.component("VideoCreate", VideoCreate)
.component("VideoEdit", VideoEdit)
.component("OpenDayCreate", OpenDayCreate)
.component("OpenDayEdit", OpenDayEdit)
.component("OpenDayDelete", OpenDayDelete)
.component("WebinarCreate", WebinarCreate)
.component("WebinarEdit", WebinarEdit)
.component("WebinarDelete", WebinarDelete)
.component("WebinarSetting", WebinarSetting)
.component("SynchWebinars", SynchWebinars)
.component("SchoolProgram", SchoolProgram)
.component("SchoolContact", SchoolContact)
.component("SchoolAmbassadorSetting", SchoolAmbassadorSetting)
.component("SchoolScholarship", SchoolScholarship)
.component("SchoolEmployee", SchoolEmployee)
.component("AdmissionSetting", AdmissionSetting)
.component("SchoolInformation", SchoolInformation)
.component("SchoolQuickFact", SchoolQuickFact)
.component("SchoolOverview", SchoolOverview)
.component("SchoolFinancial", SchoolFinancial)
.component("AddNetwork", AddNetwork)
.component("CloseAccount", CloseAccount)
.component("SchoolAmbassadorComponent", SchoolAmbassador)
.component("SchoolAmbassadorCreateComponent", SchoolAmbassadorCreate)
.component("AmbassadorsComponent", Ambassadors)
.component("AmbassadorTab", AmbassadorTab)
.component("AmbassadorChat", AmbassadorChat)
.component("StudentChat", StudentChat)
.component("AmbassadorStudentChat", AmbassadorStudentChat)
.component("AddQuote", AddQuote)
.component("AddVideo", AddVideo)
.component("AddEvent", AddEvent)
.component("AddEventForm", AddEventForm)
.component("RegisterTypeModal", RegisterTypeModal)
.component("AddCareer", AddCareer)
.component("AddCareerForm", AddCareerForm)
.component("AddStory", AddStory)
.component("AddStoryForm", AddStoryForm)
.component("AddSponsorButton", AddSponsorButton)
.component("AddSponsorForm", AddSponsorForm)
.component("SuggessionForm", SuggessionForm)
.component("AddProgram", AddProgram)
.component("StudentProfile", StudentProfile)
.component("SearchStudentProfile", SearchStudentProfile)
.component("AddVirtualTour", AddVirtualTour)
.component("AddArticle", AddArticle)
.component("DemetraSetting", DemetraSetting)
.component("ProximatchModal", ProximatchModal)
.component("OpenDayContactOrgnizer", OpenDayContactOrgnizer)
.component("OverviewPrograms", OverviewPrograms)
.component("Blog", Blog)
.component("SchoolTeams", SchoolTeams)
.component("EventContactOrgnizer", EventContactOrgnizer)
.component("CreateProfilePayment", CreateProfilePayment)
.component("updatePlan", updatePlan)
.component("FavIcon", FavIcon)
.component("RemoveFavIcon", RemoveFavIcon)
.component("UpdatePassword", UpdatePassword)
.component("ScholarshipAdvancedSearch", ScholarshipAdvancedSearch)
.component("ScholarshipAdvancedSearchOnSchoolPage", ScholarshipAdvancedSearchOnSchoolPage)
.component("ContactBusiness", ContactBusiness)
.component("ContactSchool", ContactSchool)
.component("EventImage", EventImage)
.component("EventContactImage", EventContactImage)
.component("BusinessDirectory", BusinessDirectory)
.component("DemetraSearch", DemetraSearch)
.component("ProximaChat", ProximaChat)
.component("ProximaPayment", ProximaPayment)
.use(store)
.mount("#canedu-app");
