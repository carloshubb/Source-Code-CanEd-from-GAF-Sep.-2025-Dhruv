<template>
  <AppLayout>
    <div class="relative shadow-md rounded-lg bg-white py-4">
      <header class="">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h1 class="can-edu-h1">{{ isFormEdit ? 'Edit' : 'Create' }} page</h1>
            <router-link :to="{ name: 'admin.pages.index' }" class="can-edu-btn-fill">
              Back
            </router-link>
          </div>
        </div>
      </header>
      <header class="mt-3">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <p class="block text-base lg:text-lg text-primary font-FuturaMdCnBT">
              Select language(s) of the page
            </p>
          </div>
        </div>
      </header>
      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
        <div
          class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
          <ul class="flex gap-2 flex-wrap my-4">
            <li class="mr-2 mb-2" v-for="language in languages" :key="language.id">
              <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                'inline-block py-2 px-4 text-primary border border-primary font-FuturaMdCnBT text-base font-medium rounded hover:text-white hover:bg-primary active:text-white active:bg-primary',
                (activeTab == null && language.is_default) ||
                  activeTab == language.id
                  ? 'text-white bg-primary active'
                  : '',
                validationErros.has(`name.name_${language.id}`) ||
                  validationErros.has(`description.description_${language.id}`)
                  ? 'bg-red-600 text-white hover:text-white'
                  : '',
              ]">{{ language.name }}</a>
            </li>
          </ul>
        </div>

        <div class="grid my-5 md:grid-cols-2 md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
          activeTab == language.id
          ? 'block'
          : 'hidden'
          ">
          <div class="relative z-0 w-full group md:col-span-2">
            <label for="name" class="block text-base lg:text-lg">Name<span class="text-primary">*</span></label>
            <input type="text" name="name" id="name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder=" " @input="handleNameInput($event.target.value, language)" :value="form['name'] && form['name'][`name_${language.id}`]
                ? form['name'][`name_${language.id}`]
                : ''
                " />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name.name_${language.id}`)"
              v-text="validationErros.get(`name.name_${language.id}`)"></p>
          </div>
          <div class="relative z-0 w-full group md:col-span-2"
            v-if="isDataLoaded && selectedTemplate !== 'home_template'">
            <label for="name" class="block text-base lg:text-lg">Description<span class="text-primary">*</span></label>
            <!-- <div class="mt-5" :id="'editor_' + language.id"></div> -->
            <editor @selectionChange="
              handleSelectionChange(
                language,
                'description'
              )
              " :ref="`description_${language.id}`" :id="`description_${language.id}`" :initial-value="form[`description`][`description_${language?.id}`]
                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />

            <p class="mt-2 text-base text-primary" v-if="
              validationErros.has(`description.description_${language.id}`)
            " v-text="validationErros.get(`description.description_${language.id}`)
              "></p>
          </div>
          <div class="relative z-0 w-full group">
            <div class="flex justify-between items-center">
              <label for="name" class="text-base font-medium text-gray-700">Template</label>

              <div class="">
                <input :key="`set_as_home`" type="checkbox" :name="`set_as_home`" :id="`set_as_home`"
                  @input="handleIsHome($event)" :checked="form['set_as_home']" />
                <label for="set_as_home" class="text-base font-medium text-gray-700">
                  Set as home ?
                </label>
              </div>
            </div>
            <Select2 :class="dropdownClass" v-model="selectedTemplate" :options="templates"
              @select="handleTemplateInput" :settings="{ width: '100%' }" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`set_as_home`)"
              v-text="validationErros.get(`set_as_home`)"></p>

            <p class="mt-2 text-base text-primary" v-if="validationErros.has('template')"
              v-text="validationErros.get('template')"></p>
            <br />
          </div>
          <div class="relative z-0 w-full group" v-if="selectedTemplate !== 'home_template'">
            <label :for="`image`" class="block text-base lg:text-lg">Image</label>
            <input :key="`image`" type="file" :name="`image`" :id="`image`"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder=" " @input="handleImage($event, 'image')" ref="fileupload" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`image`)"
              v-text="validationErros.get(`image`)"></p>
            <div v-if="form['image']">
              <img :src="form['image'] ? form['image'] : ''" style="height: 100px; width: 100px" />
              <button @click="removeImage" class="mt-2 can-edu-btn-fill">
                Remove image
              </button>
            </div>
          </div>
        </div>

        <button v-if="
          excludedTemplates.indexOf(form.template) > -1 || form.template == ''
        " type="submit" class="can-edu-btn-fill mb-2">
          Submit
        </button>
      </form>
      <div class="bg-white">
        <template v-if="form.template == 'login_template'">
          <login-page-setting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>

        <template v-if="form.template == 'register_template'">
          <reg-page-setting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>

        <div v-if="form.template == 'home_template'">
          <home-page-setting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </div>
        <div v-if="form.template == 'school_request_template'">
          <school-request-setting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </div>

        <div v-if="form.template == 'register_business_template'">
          <register-business @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </div>
        <template v-if="form.template == 'contact_page_template'">
          <contact-page-setting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>
        <template v-if="form.template == 'master_application_template'">
          <master-application-setting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>
        <template v-if="form.template == 'career_setting'">
          <career-setting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>

        <template v-if="form.template == 'program_setting'">
          <program-setting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>

        <template v-if="form.template == 'article_page_setting'">
          <article-page-setting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>
        <template v-if="form.template == 'suggessions'">
          <suggesstion-page-setting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>
        <template v-if="form.template == 'business_directory'">
          <BusDirectorySetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>
        <template v-if="form.template == 'demetra'">
          <DemetraPageSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>

        <template v-if="form.template == 'proximatch'">
          <ProximaRequestSetting @addUpdateFormParent="addUpdateForm" :selectedLanguage="activeTab" />
        </template>

        <!-- <template v-if="form.template == 'sitemap'">
                <sitemap-setting
                    @addUpdateFormParent="addUpdateForm"
                    :selectedLanguage="activeTab"
                />
            </template> -->
      </div>
    </div>
  </AppLayout>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import BusDirectorySetting from "./BusDirectorySetting.vue";
import Select2 from "vue3-select2-component";
import { mapState } from "vuex";
import HomePageSetting from "./HomePageSetting.vue";
import LoginPageSetting from "./LoginPageSetting.vue";
import RegPageSetting from "./RegPageSetting.vue";
import SchoolRequestSetting from "./SchoolRequestSetting.vue";
import RegisterBusiness from "./RegisterBusiness.vue";
import ContactPageSetting from "./ContactPageSetting.vue";
import MasterApplicationSetting from "./MasterApplicationSetting.vue";
import CareerSetting from "./CareerSetting.vue";
import ProgramSetting from "./ProgramSetting.vue";
import ArticlePageSetting from "./ArticlePageSetting.vue";
import SuggesstionPageSetting from "./SuggesstionPageSetting.vue";
import DemetraPageSetting from "./DemetraPageSetting.vue";
import ProximaRequestSetting from "./ProximaRequestSetting.vue";
import SitemapSetting from "./SitemapSetting.vue";
export default {
  computed: {
    ...mapState({
      isFormEdit: (state) => state.pages.isFormEdit,
      form: (state) => state.pages.form,
      validationErros: (state) => state.pages.validationErros,
      languages: (state) => state.languages.languages,
    }),
  },
  data() {
    return {
      activeTab: null,
      isDataLoaded: false,
      editorConfig: {
        height: 250,
        menubar: false,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen',
      },
      tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
      selectedTemplate: "",
      templates: [
        {
          id: "login_template",
          text: "Login",
        },
        {
          id: "story",
          text: "Student Story",
        },
        { id: "register_template", text: "Register" },
        { id: "home_template", text: "Home" },
        { id: "school_request_template", text: "School Request" },
        {
          id: "register_business_template",
          text: "Register Business Template",
        },
        { id: "contact_page_template", text: "Contact Page Template" },
        {
          id: "master_application_template",
          text: "Master Application Template",
        },
        { id: "career_setting", text: "Career Setting" },
        { id: "program_setting", text: "Program Setting" },
        { id: "article_page_setting", text: "Article page setting" },
        { id: "businesses", text: "Businesses" },
        { id: "schools", text: "schools" },
        { id: "scholar_ship", text: "Scholarship" },
        { id: "quotes", text: "Quotes" },
        { id: "our_sponsor", text: "Our sponsor" },
        { id: "meet_our_team", text: "Meet our team" },
        { id: "networks", text: "Networks" },
        { id: "videos", text: "Videos" },
        { id: "virtual_tour", text: "Virtual tour" },
        { id: "open_houses", text: "Open house" },
        { id: "events", text: "Events" },
        // { id: "sitemap", text: "Sitemap" },
        { id: "business_directory", text: "Business Directory" },
        { id: "jobs", text: "Jobs" },
        { id: "suggessions", text: "Suggessions" },
        { id: "demetra", text: "Demetra" },
        { id: "proximatch", text: "Proximatch" },
        { id: "ambassadors", text: "Ambassadors" },
        { id: "webinars", text: "Webinars" },
      ],
      excludedTemplates: [
        "videos",
        "businesses",
        "schools",
        "scholar_ship",
        "quotes",
        "our_sponsor",
        "meet_our_team",
        "networks",
        "virtual_tour",
        "open_houses",
        "events",
        "jobs",
        "ambassadors",
        "webinars",
        "story",
      ],
      dropdownClass:
        "block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent appearance-none dark:text-white focus:outline-none focus:ring-0 peer",
    };
  },
  methods: {
    handleIsHome(e) {
      this.$store.commit("pages/setIsHome", e.target.checked);
    },
    handleSelectionChange(language, key) {
      const content = tinymce.get(`${key}_${language.id}`).getContent();
      this.$store.commit(`pages/updateDescription`, {
        description: content,
        id: language.id,
      });
      const errorKey = `description.description_${language.id}`;
      if (content.trim()) {
        this.validationErros.clear(errorKey);
      }
    },
    removeImage() {
      this.$refs.fileupload.value = null;
      this.$store.commit("pages/setImage", "");
    },
    handleImage(e, key) {
      var file = new FormData();
      file.append("file", e.target.files[0]);
      axios.post("/api/admin/media/image_again_upload", file).then((res) => {
        this.$store.commit("pages/setImage", res?.data);
      });
    },
    handleTemplateInput(data) {
      this.$store.commit("pages/setTemplate", data?.id);
    },
    handleNameInput(value, language) {
      this.$store.commit("pages/updateName", {
        name: value,
        id: language.id,
      });
      const errorKey = `name.name_${language.id}`;
      if (value.trim()) {
        this.validationErros.clear(errorKey);
      }
    },
    addUpdateForm() {
      this.$store.dispatch("pages/addUpdateForm").then((res) => {
        if (res.data.status == "Success") {
          this.$router.push({
            name: "admin.pages.index",
          });
        }
      }).catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.focusOnFirstErrorInput(error.response.data.errors);
                    }
                });
    },

     focusOnFirstErrorInput(errors) {
      console.log("Errors object:", errors);
      const firstErrorField = Object.keys(errors)[0];
      console.log("First error field name:", firstErrorField);

      if (!firstErrorField) {
        console.log("No error field found");
        return;
      }

      const fieldNameParts = firstErrorField.split(".");
      const fieldName = fieldNameParts[0];
      console.log("Stripped error field name:", fieldName);

      let inputElement = document.querySelector(
        `[name="${fieldName}"], [v-model="${fieldName}"], [data-v-model="${fieldName}"], [data-value="${fieldName}"]`
      );

      if (!inputElement) {
        console.log(`No standard input field found for ${fieldName}, checking for rich text editor...`);

        const editorId = fieldNameParts[1] || fieldName;
        const tinymceEditor = window.tinymce?.get(editorId);

        if (tinymceEditor) {
          console.log(`Focusing on TinyMCE editor: ${editorId}`);
          tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });

          setTimeout(() => {
            tinymceEditor.focus();
          }, 300); 

          return;
        } else {
          console.log(`TinyMCE editor instance not found for ${editorId}`);
        }
      }

      if (inputElement) {
        console.log("Found input element:", inputElement);
        inputElement.scrollIntoView({ behavior: "smooth", block: "center" });

        setTimeout(() => {
          inputElement.focus();
        }, 300);

      } else {
        console.log(`No input field found for ${fieldName}`);
      }
    },
    changeLanguageTab(language) {
      this.activeTab = language.id;
    },
    fetchPages() {
      if (this.$route.params.id) {
        let id = this.$route.params.id;
        this.$store.commit("pages/setIsFormEdit", 1);
        this.$store
          .dispatch("pages/fetchPages", {
            id: id,
            source: "page_edit",
            url: `${process.env.MIX_ADMIN_API_URL}pages/${id}?withPageDetail=1`,
          })
          .then((res) => {
            this.page_category = res.data.data.page_category_id;
            this.selectedTemplate = res.data.data.template;
            this.$store.commit("pages/setForm", {
              id,
            });
            if (res.data.data.template != null) {
              this.$store.commit("pages/setTemplate", res.data.data.template);
            }

            this.$store.commit("pages/setImage", res.data.data.image);
            this.$store.commit("pages/setIsHome", res.data.data.set_as_home);
            let data =
              res.data.data && res.data.data.page_detail
                ? res.data.data.page_detail
                : [];

            let obj = {};
            data.map((res) => {
              obj["name_" + res.language_id] = res.name;
            });
            this.$store.commit("pages/setName", obj);
            let d = {};
            data.map((res, key) => {
              d["description_" + res.language_id] = res.description;
            });
            this.$store.commit("pages/setDescription", d);
            this.isDataLoaded = 1;
          });
      }
    },
  },
  created() {
    this.$store.commit("pages/resetForm");
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        let data = res.data.data;
        let obj = {};
        let d = {};
        data.map((res, i) => {
          if (res.is_default) {
            this.activeTab = res.id;
          }
          obj["name_" + res.id] = "";
          d["description_" + res.id] = "";
        });
        this.$store.commit("pages/setName", obj);
        this.$store.commit("pages/setDescription", d);

        if (this.$route.params.id) {
          this.fetchPages();
        }
        else {
          this.isDataLoaded = 1;
        }
      });
  },
  components: {
    Select2,
    LoginPageSetting,
    RegPageSetting,
    HomePageSetting,
    SchoolRequestSetting,
    RegisterBusiness,
    ContactPageSetting,
    MasterApplicationSetting,
    CareerSetting,
    ProgramSetting,
    ArticlePageSetting,
    SuggesstionPageSetting,
    BusDirectorySetting,
    DemetraPageSetting,
    ProximaRequestSetting,
    SitemapSetting,
    editor: Editor,
  },
};
</script>

<style scope, SchoolRequestSettingd>
/**
 * FilePond Custom Styles
 */
.filepond--drop-label {
  color: #4c4e53;
}

.filepond--label-action {
  text-decoration-color: #babdc0;
}

.filepond--panel-root {
  border-radius: 2em;
  background-color: #edf0f4;
  height: 1em;
}

.filepond--item-panel {
  background-color: #595e68;
}

.filepond--drip-blob {
  background-color: #7f8a9a;
}
</style>
