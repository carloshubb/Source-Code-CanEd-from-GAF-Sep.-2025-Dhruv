<template>
  <div class="bg-white mx-auto">
    <div class="flex justify-end">
      <p class="text-red-500">
        {{ indicate_required_field }}
      </p>
    </div>
    <header class="mt-3">
      <div class="max-w-full mx-auto">
        <div class="flex items-center justify-between">
          <p class="block text-base lg:text-lg can-edu-h1">
            Languages
          </p>
        </div>
        <div class="flex items-center justify-between">
          <div class="can-edu-p mt-2">
            <div class="">
              <div class="">
                <p>{{ static_translations?.language_selection_text }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <form @submit.prevent="recaptcha()">
      <div
        class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <ul class="flex gap-2 flex-wrap my-4">
          <li class="mr-2" v-for="language in languages" :key="language.id">
            <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
              'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
              (activeTab == null && language.is_default) ||
                activeTab == language.id
                ? 'text-white bg-primary active'
                : '',
              errors.has(`title.title_${language.id}`)
                ? 'bg-red-600 text-white hover:text-white'
                : '',
            ]">{{ language.name }}</a>
          </li>
        </ul>
      </div>

      <div class="w-full md:gap-6 mb-2 grid grid-cols-1 md:grid-col-2" v-for="language in languages" :key="language.id"
        :class="(activeTab == null && language.is_default) || activeTab == language.id
            ? 'block'
            : 'hidden'
          ">
        <div class="relative w-full mt-2">
          <label for="title" class="block text-base lg:text-lg">
            {{ static_translations?.business_name_label || "" }}
          </label>
          <input type="text" name="title" id="title"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            :placeholder="static_translations?.business_name_placeholder || ''"
            @input="handleInput($event.target.value, language.id, 'title')"
            :value="form?.['title']?.[`title_${language.id}`] || ''" />
          <error :fieldName="'title.title_' + language.id" :validationErros="errors" />
        </div>
        <div class="relative w-full mt-2">
          <label for="subsidiary" class="block text-base lg:text-lg">{{
            static_translations?.subsidiary_label || ""
          }}</label>
          <input type="text" name="subsidiary" id="subsidiary"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            :placeholder="static_translations?.subsidiary_placeholder || ''"
            @input="handleInput($event.target.value, language.id, 'subsidiary')"
            :value="form?.['subsidiary']?.[`subsidiary_${language.id}`] || ''" />
          <error :fieldName="'subsidiary.subsidiary_' + language.id" :validationErros="errors" />
        </div>
        <div class="relative w-full mt-2" v-if="isDataLoaded">
          <label for="short_description" class="block text-base lg:text-lg">{{
            static_translations?.short_description_label || "" }}</label>
          <editor @selectionChange="
            handleSelectionChange(language, 'short_description')
            " :ref="`short_description_${language.id}`" :id="`short_description_${language.id}`" :placeholder="static_translations?.short_description_placeholder || ''
              " :initial-value="form?.[`short_description`]?.[
              `short_description_${language?.id}`
              ] || ''
              " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
          <error :fieldName="'short_description.short_description_' + language.id" :validationErros="errors" />
        </div>
        <div class="relative w-full mt-2" v-if="isDataLoaded">
          <label :for="'editor_' + language.id" class="block text-base lg:text-lg">
            {{ static_translations?.description_label || "" }}
          </label>
          <editor @selectionChange="handleSelectionChange(language, 'description')" :ref="`description_${language.id}`"
            :id="`description_${language.id}`" :initial-value="form?.[`description`]?.[`description_${language?.id}`] || ''
              " :placeholder="static_translations?.description_placeholder || ''" :init="editorConfig"
            :tinymce-script-src="tinymceScriptSrc" />

          <error :fieldName="'description.description_' + language.id" :validationErros="errors" />
        </div>
        <div class="relative w-full mt-2">
          <label for="keywords" class="block text-base lg:text-lg">
            {{static_translations?.Keywords_label || ""}}</label>
          <input type="text" name="keywords" id="keywords"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            :placeholder="static_translations?.Keywords_placeholder || ''"
            @input="handleInput($event.target.value, language.id, 'keywords')"
            :value="form?.['keywords']?.[`keywords_${language.id}`] || ''" />
          <error :fieldName="'keywords.keywords_' + language.id" :validationErros="errors" />
        </div>
        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 my-5">
          <div class="col-span-2">
            <h1 class="can-edu-h1">Services you offer to students</h1>
            <p>
              Please state the services that you offer to the students, and the
              web page of each service if available
            </p>
          </div>
          <div class="relative w-full mt-2 col-span-2 md:col-span-1">
            <label for="service1_name" class="block text-base lg:text-lg">
              {{ static_translations?.service_1_name_label || "" }}
            </label>
            <input type="text" name="service1_name" id="service1_name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.service_1_name_placeholder || ''
                " @input="
                handleInput($event.target.value, language.id, 'service1_name')
                " :value="form?.['service1_name']?.[`service1_name_${language.id}`] || ''
                " />
            <error :fieldName="'service1_name.service1_name_' + language.id" :validationErros="errors" />
          </div>
          <div class="relative w-full mt-2 col-span-2 md:col-span-1">
            <label for="service1_url" class="block text-base lg:text-lg">
              {{ static_translations?.service_1_url_label || "" }}
            </label>
            <input type="text" name="service1_url" id="service1_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.service_1_url_placeholder || ''
                " @input="
                handleInput($event.target.value, language.id, 'service1_url')
                " :value="form?.['service1_url']?.[`service1_url_${language.id}`] || ''
                " />
            <error :fieldName="'service1_url.service1_url_' + language.id" :validationErros="errors" />
          </div>
          <div class="relative w-full mt-2 col-span-2 md:col-span-1">
            <label for="service2_name" class="block text-base lg:text-lg">
              {{ static_translations?.service_2_name_label || "" }}
            </label>
            <input type="text" name="service2_name" id="service2_name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.service_2_name_placeholder || ''
                " @input="
                handleInput($event.target.value, language.id, 'service2_name')
                " :value="form?.['service2_name']?.[`service2_name_${language.id}`] || ''
                " />
            <error :fieldName="'service2_name.service2_name_' + language.id" :validationErros="errors" />
          </div>
          <div class="relative w-full mt-2 col-span-2 md:col-span-1">
            <label for="service2_url" class="block text-base lg:text-lg">
              {{ static_translations?.service_2_url_label || "" }}
            </label>
            <input type="text" name="service2_url" id="service2_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.service_2_url_placeholder || ''
                " @input="
                handleInput($event.target.value, language.id, 'service2_url')
                " :value="form?.['service2_url']?.[`service2_url_${language.id}`] || ''
                " />
            <error :fieldName="'service2_url.service2_url_' + language.id" :validationErros="errors" />
          </div>
          <div class="relative w-full mt-2 col-span-2 md:col-span-1">
            <label for="service3_name" class="block text-base lg:text-lg">
              {{ static_translations?.service_3_name_label || "" }}
            </label>
            <input type="text" name="service3_name" id="service3_name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.service_3_name_placeholder || ''
                " @input="
                handleInput($event.target.value, language.id, 'service3_name')
                " :value="form['service3_name']?.[`service3_name_${language.id}`] || ''
                " />
            <error :fieldName="'service3_name.service3_name_' + language.id" :validationErros="errors" />
          </div>
          <div class="relative w-full mt-2 col-span-2 md:col-span-1">
            <label for="service3_url" class="block text-base lg:text-lg">
              {{ static_translations?.service_3_url_label || "" }}
            </label>
            <input type="text" name="service3_url" id="service3_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.service_3_url_placeholder || ''
                " @input="
                handleInput($event.target.value, language.id, 'service3_url')
                " :value="form?.['service3_url']?.[`service3_url_${language.id}`] || ''
                " />
            <error :fieldName="'service3_url.service3_url_' + language.id" :validationErros="errors" />
          </div>
          <div class="relative w-full mt-2 col-span-2 md:col-span-1">
            <label for="service4_name" class="block text-base lg:text-lg">
              {{ static_translations?.service_4_name_label || "" }}
            </label>
            <input type="text" name="service4_name" id="service4_name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.service_4_name_placeholder || ''
                " @input="
                handleInput($event.target.value, language.id, 'service4_name')
                " :value="form?.['service4_name']?.[`service4_name_${language.id}`] || ''
                " />
            <error :fieldName="'service4_name.service4_name_' + language.id" :validationErros="errors" />
          </div>
          <div class="relative w-full mt-2 col-span-2 md:col-span-1">
            <label for="service4_url" class="block text-base lg:text-lg">
              {{ static_translations?.service_4_url_label || "" }}
            </label>
            <input type="text" name="service4_url" id="service4_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.service_4_url_placeholder || ''
                " @input="
                handleInput($event.target.value, language.id, 'service4_url')
                " :value="form?.['service4_url']?.[`service4_url_${language.id}`] || ''
                " />
            <error :fieldName="'service4_url.service4_url_' + language.id" :validationErros="errors" />
          </div>
          <div class="relative w-full mt-2 col-span-2 md:col-span-1">
            <label for="service5_name" class="block text-base lg:text-lg">
              {{ static_translations?.service_5_name_label || "" }}
            </label>
            <input type="text" name="service5_name" id="service5_name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.service_5_name_placeholder || ''
                " @input="
                handleInput($event.target.value, language.id, 'service5_name')
                " :value="form?.['service5_name']?.[`service5_name_${language.id}`] || ''
                " />
            <error :fieldName="'service5_name.service5_name_' + language.id" :validationErros="errors" />
          </div>
          <div class="relative w-full mt-2 col-span-2 md:col-span-1">
            <label for="service5_url" class="block text-base lg:text-lg">
              {{ static_translations?.service_5_url_label || "" }}
            </label>
            <input type="text" name="service5_url" id="service5_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.service_5_url_placeholder || ''
                " @input="
                handleInput($event.target.value, language.id, 'service5_url')
                " :value="form?.['service5_url']?.[`service5_url_${language.id}`] || ''
                " />
            <error :fieldName="'service5_url.service5_url_' + language.id" :validationErros="errors" />
          </div>
          <div class="col-span-2">
            <h1 class="can-edu-h1">Contact Information</h1>
          </div>
          <div class="relative w-full mt-2 col-span-2">
            <label for="contact_person_name" class="block text-base lg:text-lg">
              {{ static_translations?.contact_person_name_label || "" }}
            </label>
            <input type="text" name="contact_person_name" id="contact_person_name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              :placeholder="static_translations?.contact_person_name_placeholder || ''
                " @input="
                handleInput(
                  $event.target.value,
                  language.id,
                  'contact_person_name'
                )
                " :value="form?.['contact_person_name']?.[
                `contact_person_name_${language.id}`
                ] || ''
                " />
            <error :fieldName="'contact_person_name.contact_person_name_' + language.id
              " :validationErros="errors" />
          </div>
        </div>
      </div>

      <div class="grid md:grid-cols-2 gap-4 md:gap-6">
        <div class="relative z-0 w-full group">
          <label for="contact_person_phone" class="block text-base lg:text-lg">
            {{ static_translations?.contact_person_phone_label || "" }}
          </label>
          <input type="text" name="contact_person_phone" id="contact_person_phone"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            :placeholder="static_translations?.contact_person_phone_placeholder || ''
              " v-model="form.contact_person_phone" @keypress="restrictToNumbers($event, 15)" />
          <error :fieldName="'contact_person_phone'" :validationErros="errors" />
        </div>
        <div class="relative z-0 w-full group">
          <label for="contact_person_image" class="block text-base lg:text-lg">
            {{ static_translations?.contact_person_image_label || "" }}
          </label>
          
          <!-- Image preview (only shows if image exists) -->
          <img
            v-if="form.contact_person_image"
            :src="form.contact_person_image"
            style="height: 100px; width: 100px"
            class="mt-2"
          />
          
          <!-- File input -->
          <input
            type="file"
            name="contact_person_image"
            id="contact_person_image"
            class="mt-2 border w-full px-4 py-1.5 rounded border-gray-300 border-l-[5px] border-l-primary"
            @change="handleImage"
          />
          <error :fieldName="'contact_person_image'" :validationErros="errors" />
        </div>
        <div class="relative z-0 w-full group">
          <label for="contact_person_email" class="block text-base lg:text-lg">
            {{ static_translations?.contact_person_email_label || "" }}
          </label>
          <input type="text" name="contact_person_email" id="contact_person_email"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            :placeholder="static_translations?.contact_person_email_placeholder || ''
              " v-model="form.contact_person_email" />
          <error :fieldName="'contact_person_email'" :validationErros="errors" />
        </div>
        <div class="relative z-0 w-full group">
          <label for="country" class="block text-base lg:text-lg">
            {{ static_translations?.location_label || "" }}
          </label>
          <input type="text" name="country" id="country"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            :placeholder="static_translations?.location_placeholder || ''" v-model="form.country" />
          <error :fieldName="'country'" :validationErros="errors" />
        </div>
        <div class="relative z-0 w-full group">
          <label for="url" class="block text-base lg:text-lg">
            {{ static_translations?.website_label || "" }}
          </label>
          <input type="text" name="url" id="url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            :placeholder="static_translations?.website_placeholder || ''" v-model="form.url" />
          <error :fieldName="'url'" :validationErros="errors" />
        </div>

        <div class="relative z-0 w-full group">
          <label for="image" class="block text-base lg:text-lg mb-2">
            {{ static_translations?.logo_label || "" }}
          </label>
          <FilePond name="image" class-name="my-pond" accepted-file-types="image/*" @init="handleFilePondInit"
            @processfile="handleFilePondFlagIconProcess" @removefile="handleFilePondFlagIconRemoveFile" />
          <error :fieldName="'image'" :validationErros="errors" />
        </div>
      </div>

      <div class="recaptcha">
        <Error v-if="submitted" fieldName="captcha" :validationErros="errors" full_width="1" />
      </div>
      <div class="my-8 flex items-center gap-2 justify-center">
        <button class="can-edu-btn-fill whitespace-nowrap" type="submit">
          {{
            static_translations?.submit_button_text
              ? static_translations?.submit_button_text
              : ""
          }}
        </button>
      </div>
    </form>
  </div>
  <transition name="slide">
    <div id="defaultModal" tabindex="-1"
      class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
      v-if="showPopUpModal">
      <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
        ref="elementToDetectClick">
        <div class="relative">
          <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
            <button type="button"
              class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
              data-modal-hide="defaultModal">
              <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
              </svg>
            </button>
          </div>
          <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
            <p class="text-center can-edu-p mt-2">
              {{ success_message }}
            </p>
            <div class="flex justify-center">
            <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
              @click="togglePopUpModal">
              Close
            </button>
          </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
import Editor from "@tinymce/tinymce-vue";
// ES6 Modules or TypeScript
import Swal from "sweetalert2";
import axios from "axios";
import ErrorHandling from "../ErrorHandling";
import { mapState } from "vuex";
import vueRecaptcha from "vue3-recaptcha2";
import { load } from "recaptcha-v3";
import Error from "./Error.vue";

// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

export default {
  props: [
    "logged_in_customer",
    "school_id",
    "lang",
    "sponsor_page_translation",
    "indicate_required_field",
    "success_message",
  ],
  components: {
    FilePond,
    vueRecaptcha,
    Error,
    editor: Editor,
  },
  computed: {
    ...mapState({
      languages: (state) => state.languages.languages,
    }),
    sitekey() {
      return process.env.MIX_RECAPTCHA_SITE_KEY;
    },
  },
  data() {
    return {
      submitted: false,
      showPopUpModal: false,
      isDataLoaded: false,
      errors: new ErrorHandling(),
      error_message: "",
      activeTab: null,
      showRecaptcha: true,
      toggelSubmitButton: false,
      static_translations: [],
      form: {
        id: null,
        title: {},
        keywords: {},
        subsidiary: {},
        contact_person_name: {},
        // contact_person_name: "",
        short_description: {},
        description: {},
        service1_name: {},
        service1_url: {},
        service2_name: {},
        service2_url: {},
        service3_name: {},
        service3_url: {},
        service4_name: {},
        service4_url: {},
        service5_name: {},
        service5_url: {},
        contact_person_phone: "",
        contact_person_image: "",
        contact_person_email: "",
        country: "",
        image: "",
        url: "",
        is_web: true,
      },
      editorConfig: {
        height: 250,
        menubar: false,
        plugins:
          "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code",
        toolbar:
          "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
      },
      tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
    };
  },
  methods: {
    handleImage(e) {
        var file = new FormData();
        file.append("file", e.target.files[0]);

        axios.post("/api/web/image_again_upload", file).then((res) => {
            this.form.contact_person_image = res?.data;
            localStorage.setItem("rb_contact_person_image", res?.data);
        });
    },
    togglePopUpModal() {
      this.showPopUpModal = !this.showPopUpModal;
      if (!this.showPopUpModal) {
        window.location.reload();

      }
    },
    handleClickOutsidePopup(event) {
      // // Check if the click target is not within the element
      if (
        this.$refs.elementToDetectClick &&
        event.target.contains(this.$refs.elementToDetectClick)
      ) {
        // Clicked outside the element, you can perform actions here
        if (this.showPopUpModal == true) {
          this.showPopUpModal = false;
          window.location.reload();


        }
      }
    },
    restrictToNumbers(event, allowedLength) {
      const keyCode = event.which ? event.which : event.keyCode;
      const inputChar = String.fromCharCode(keyCode);
      const isValidSpecialChar = /^[\+\-\(\)]$/.test(inputChar);
      const isDigit = /^\d$/.test(inputChar);
      let currentValue = event.target.value + inputChar;
      const digitCount = currentValue.replace(/[^\d]/g, "").length;
      if (!isValidSpecialChar && (!isDigit || digitCount > allowedLength)) {
        event.preventDefault();
      }
    },
    handleSelectionChange(language, key) {
      let val = tinymce.get(`${key}_${language.id}`).getContent();
      this.form[key][key + "_" + language.id] = val;
    },
    changeLanguageTab(language) {
      this.activeTab = language.id;
    },
    handleInput(val, i, key) {
      this.form[key][key + "_" + i] = val;
    },
    async recaptcha() {
      this.submitted = true;
      // this.loading = 1;
      load(process.env.MIX_reCAPTCHA_site_key_new).then((recaptcha) => {
        recaptcha.showBadge()
        recaptcha.execute("submit").then((token) => {
          axios
            .post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, {
              token: token,
            })
            .then((res) => {
              setTimeout(() => {
                recaptcha.hideBadge()
              }, 3000);
              if (res.data.status == "Success") {
                this.addUpdateForm();
              } else if (res.data.status == "Error") {
                // this.loading = 0;
                this.errors.record({
                  captcha: [res.data.message],
                });
              }
            });
        });
      });
    },


    // working one with :value v-model and tinmyce rich text eduitor
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
          tinymceEditor.focus();
          tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });
          return;
        } else {
          console.log(`TinyMCE editor instance not found for ${editorId}`);
        }
      }

      if (inputElement) {
        console.log("Found input element:", inputElement);
        inputElement.scrollIntoView({ behavior: "smooth", block: "center" });
        inputElement.focus();
      } else {
        console.log(`No input field found for ${fieldName}`);
      }
    },
    addUpdateForm() {
      let url = "/api/web/sponsors";
      let method = "post";
      if (this.form?.id) {
        url = `/api/web/sponsors/${$this.form.id}`;
        method = "put";
      }
      axios[method](url, this.form)
        .then((res) => {
          if (res?.data?.status == "Success") {
            this.showPopUpModal = true;
            // helper.swalSuccessMessage(res.data.message);
          }
          if (res.data.status == "Error") {
            helper.swalErrorMessage(res.data.message);
          }
        })
        .catch((error) => {
          this.error_message = "";
          this.errors = new ErrorHandling();
          if (error.response.status == 422) {
            if (error.response.data.status == "Error") {
              helper.swalErrorMessage(error.response.data.message);
            } else {
              this.errors.record(error.response.data.errors);
              this.focusOnFirstErrorInput(error.response.data.errors);
            }
          }
        })
        .finally(() => (this.$parent.loading = false));
    },
    recaptchaVerified(response) {
      this.toggelSubmitButton = true;
    },
    recaptchaExpired() {
      this.toggelSubmitButton = false;
      this.$refs.vueRecaptcha.reset();
    },
    recaptchaFailed() {
      this.toggelSubmitButton = false;
    },
    handleFilePondInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_WEB_API_URL,
          process: (
            fieldName,
            file,
            metadata,
            load,
            error,
            progress,
            abort,
            transfer,
            options
          ) => {
            const formData = new FormData();
            formData.append("media", file, file.name);
            formData.append("is_temp_media", 1);
            formData.append("type", "image");

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_WEB_API_URL}media/process`);
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.upload.onprogress = (e) => {
              progress(e.lengthComputable, e.loaded, e.total);
            };
            request.onload = function () {
              if (request.status >= 200 && request.status < 300) {
                load(request.responseText);
              } else {
                error("oh no");
              }
            };

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          revert: (uniqueFileId, load, error) => {
            const formData = new FormData();
            formData.append("media", uniqueFileId);

            const request = new XMLHttpRequest();
            request.open("POST", `${process.env.MIX_WEB_API_URL}media/revert`);
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          headers: {
            "X-CSRF-TOKEN": document.head.querySelector(
              'meta[name="csrf-token"]'
            ).content,
          },
        },
      });
    },
    handleFilePondFlagIconProcess(error, file) {
      this.form.image = file.serverId || null;
      this.form.id = this.$route.params.id || null;
    },
    handleFilePondFlagIconRemoveFile(error, file) {
      this.form.image = null;
    },
    convertImgUrlToBase64(url, type) {
      var image = new Image();

      image.onload = function () {
        var canvas = document.createElement("canvas");
        canvas.width = image.width;
        canvas.height = image.height;

        canvas.getContext("2d").drawImage(this, 0, 0);

        canvas.toBlob(
          function (source) {
            var newImg = document.createElement("img"),
              url = URL.createObjectURL(source);

            newImg.onload = function () {
              URL.revokeObjectURL(url);
            };

            newImg.src = url;
          },
          type,
          1
        );
        let dataUrl = canvas.toDataURL(type);
        let files = [
          {
            source: dataUrl,
            options: {
              type: "local",
            },
          },
        ];
        setOptions({
          files: files,
        });
      };
      image.src = url;
    },
  },
  // watch: {
  //   contact_person_phone(newValue, oldValue) {
  //           this.errors.has("contact_person_phone") ? this.errors.clear("contact_person_phone") : "";
  //           if (newValue && newValue != "") {
  //               localStorage.setItem("become_sponsor_contact_person_phone", newValue);
  //           }
  //       },
  //     },
  watch: {
    "form.contact_person_phone"(newValue, oldValue) {
      if (this.errors.has("contact_person_phone")) {
        this.errors.clear("contact_person_phone");
      }
      if (newValue && newValue !== "") {
        localStorage.setItem("become_sponsor_contact_person_phone", newValue);
      }
    },
    "form.contact_person_image"(newValue, oldValue) {
      if (this.errors.has("contact_person_image")) {
        this.errors.clear("contact_person_image");
      }
      if (newValue && newValue !== "") {
        localStorage.setItem("become_sponsor_contact_person_image", newValue);
      }
    },
    "form.country"(newValue, oldValue) {
      if (this.errors.has("country")) {
        this.errors.clear("country");
      }
      if (newValue && newValue !== "") {
        localStorage.setItem("become_sponsor_country", newValue);
      }
    },
    "form.image"(newValue, oldValue) {
      if (this.errors.has("image")) {
        this.errors.clear("image");
      }
      if (newValue && newValue !== "") {
        localStorage.setItem("become_sponsor_image", newValue);
      }
    },
    "form.url"(newValue, oldValue) {
      if (this.errors.has("url")) {
        this.errors.clear("url");
      }
      if (newValue && newValue !== "") {
        localStorage.setItem("become_sponsor_url", newValue);
      }
    },
    "form.title": {
      handler(newValue) {
        Object.keys(newValue).forEach((key) => {
          if (this.errors.has(`title.${key}`)) {
            this.errors.clear(`title.${key}`);
          }
          if (newValue[key] && newValue[key] !== "") {
            localStorage.setItem(`become_sponsor_title_${key}`, newValue[key]);
          }
        });
      },
      deep: true, // Ensures Vue detects changes inside objects
    },
    "form.short_description": {
      handler(newValue) {
        Object.keys(newValue).forEach((key) => {
          if (this.errors.has(`short_description.${key}`)) {
            this.errors.clear(`short_description.${key}`);
          }
          if (newValue[key] && newValue[key] !== "") {
            localStorage.setItem(`become_sponsor_short_description_${key}`, newValue[key]);
          }
        });
      },
      deep: true, // Ensures Vue detects changes inside objects
    },
    "form.description": {
      handler(newValue) {
        Object.keys(newValue).forEach((key) => {
          if (this.errors.has(`description.${key}`)) {
            this.errors.clear(`description.${key}`);
          }
          if (newValue[key] && newValue[key] !== "") {
            localStorage.setItem(`become_sponsor_description_${key}`, newValue[key]);
          }
        });
      },
      deep: true, // Ensures Vue detects changes inside objects
    },
  },
  beforeUnmount() {
    document.removeEventListener("click", this.handleClickOutsidePopup);
  },
  mounted() {
    document.addEventListener("click", this.handleClickOutsidePopup);
  },
  created() {
    // if (this.logged_in_customer == "") {
    //   window.location.href =
    //     "/" +
    //     JSON.parse(this.lang)?.["abbreviation"] +
    //     "/login?url=" +
    //     window.location.href;
    // }
    setOptions({
      files: [],
    });
    this.isDataLoaded = true;
    this.$store.dispatch("languages/fetchLanguages", {
      url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
    });
    this.activeTab = JSON.parse(this.lang)?.["id"];
    console.log('this.static_translationsthis.static_translationsthis.static_translationsthis.static_translationsthis.static_translations',this.static_translations);
    this.static_translations = JSON.parse(this.sponsor_page_translation);
    console.log('this.static_translationsthis.static_translationsthis.static_translations',this.static_translations.Keywords_placeholder);
  },
};
</script>
<style scoped>
/* Slide Animation */
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>