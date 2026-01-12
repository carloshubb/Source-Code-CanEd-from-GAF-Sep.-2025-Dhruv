<template>
  <AppLayout>
    <div class="relative shadow-md rounded-lg bg-white py-4">
      <header class="">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h1 class="can-edu-h1">{{ isFormEdit ? 'Edit' : 'Create' }} business</h1>
            <router-link :to="{ name: 'admin.business.index' }" class="can-edu-btn-fill">
              Back
            </router-link>
          </div>
        </div>
      </header>
      <header class="mt-3">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
              Select language(s) of the business
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
                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                (activeTab == null && language.is_default) ||
                  activeTab == language.id
                  ? 'text-white bg-primary active'
                  : '',
                validationErros.has(
                  `business_name.business_name_${language.id}`
                ) ||
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
            <label for="business_name" class="block text-base lg:text-lg">Business Name <span
              class="text-primary">*</span></label>
            <input type="text" name="business_name" id="business_name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder=" " @input="
                handleMultipleInput(
                  'business_name',
                  $event.target.value,
                  language
                )
                " :value="form['business_name'] &&
                  form['business_name'][`business_name_${language.id}`]
                  ? form['business_name'][`business_name_${language.id}`]
                  : ''
                  " />
            <p class="mt-2 text-base text-primary" v-if="
              validationErros.has(
                `business_name.business_name_${language.id}`
              )
            " v-text="validationErros.get(
              `business_name.business_name_${language.id}`
            )
              "></p>
          </div>
          <div class="relative z-0 w-full group md:col-span-2" v-if="isDataLoaded">
            <!-- <div
              class="mt-5 ckeditorText"
              :id="`description_${language.id}`"
              ></div> -->
            <label for="title" class="block text-base lg:text-lg">Short Description <span
              class="text-primary">*</span></label>
            <editor
              placeholder="Describe the nature of your business in no more than 30 words. You can write your business slogan, company mission, or highlight your competitive advantage. This information will appear next to your company name on the search results page and will help you to attract visitors to your profile page. Make sure to describe your business in an engaging, informative way so that when the user reads it, they will be more inclined to check out your business profile."
              @selectionChange="
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

          <div class="relative z-0 w-full group md:col-span-2" v-if="isDataLoaded">
            <!-- <div
              class="mt-5 ckeditorText"
              :id="`description_${language.id}`"
              ></div> -->
            <label for="title" class="block text-base lg:text-lg">Detailed Description <span
              class="text-primary">*</span></label>
            <editor
              placeholder="This is the text that will appear on your actual business profile page. Once the importer has selected YOUR company and clicked on your name in the search results page, they will be taken to your business profile page. Use this space to outline what your business does and why potential customers should choose YOU. Your description should be no more than 300 words and include details about your products and services. This is your opportunity to reach potential clients, introduce them to your products, and attract further business"
              @selectionChange="
                handleSelectionChange(
                  language,
                  'detail_description'
                )
                " :ref="`detail_description_${language.id}`" :id="`detail_description_${language.id}`" :initial-value="form[`detail_description`][`detail_description_${language?.id}`]
                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
            <p class="mt-2 text-base text-primary" v-if="
              validationErros.has(`detail_description.detail_description_${language.id}`)
            " v-text="validationErros.get(`detail_description.detail_description_${language.id}`)
              "></p>
          </div>


          <div class="relative z-0 w-full group">
            <label for="keywords" class="block text-base lg:text-lg">Keywords</label>
            <textarea rows="4" name="keywords"
              placeholder="Enter up to 5 separate keywords or keyphrases, separated by commas. These are extremely useful when a potential client is searching for a particular product or service. So be specific and target your business product as well as you can If you are unsure of what to include, here is an example: you have a family-run business that produces homemade candles. Your suggested keywords or key phrases may look something like this: candles, homemade, family-run business, traditional, made to order As you can see, the example includes 5 keywords / keyphrases that highlight the main features of the product"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'keywords')" :value="form['keywords'] ? form['keywords'] : ''" ></textarea>
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`keywords`)"
              v-text="validationErros.get(`keywords`)"></p>
          </div>

          <div class="relative z-0 w-full group">
            <label for="contact_name" class="block text-base lg:text-lg">Contact person name and title</label>
            <textarea rows="4" name="contact_name"
              placeholder="Please include your full name and the title you would like to be addressed by, separated by a dash or hyphen. For example, John Smith – Sales Manager"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'contact_name')"
              :value="form['contact_name'] ? form['contact_name'] : ''" ></textarea>
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`contact_name`)"
              v-text="validationErros.get(`contact_name`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="email" class="block text-base lg:text-lg">Email</label>
            <input name="email"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'email')" :value="form['email'] ? form['email'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`email`)"
              v-text="validationErros.get(`email`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="phone" class="block text-base lg:text-lg">Phone <span
              class="text-primary">*</span></label>
            <input type="text" name="phone"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder="With area code" @input="handleInput($event.target.value, 'phone')"
              :value="form['phone'] ? form['phone'] : ''" @keypress="restrictToNumbers($event, 15)" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`phone`)"
              v-text="validationErros.get(`phone`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="address" class="block text-base lg:text-lg">Address</label>
            <input name="address"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'address')" :value="form['address'] ? form['address'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`address`)"
              v-text="validationErros.get(`address`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="website_url" class="block text-base lg:text-lg">Website URL</label>
            <input name="website_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'website_url')"
              :value="form['website_url'] ? form['website_url'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`website_url`)"
              v-text="validationErros.get(`website_url`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="degree" class="block text-base lg:text-lg">Business category 1</label>
            <select name="business_catagory_1"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'business_catagory_1')">
              <option value="">Select</option>
              <option v-for="(business_category, key) in business_categories"
                :selected="form['business_catagory_1'] == business_category.id" :value="business_category.id"
                :key="key">
                {{
                  business_category?.business_category_detail.length > 0
                    ? business_category?.business_category_detail[0].name
                    : ""
                }}
              </option>
            </select>
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`business_catagory_1`)"
              v-text="validationErros.get(`business_catagory_1`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="business_catagory_2" class="block text-base lg:text-lg">Business category 2</label>
            <select name="business_catagory_2"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'business_catagory_2')">
              <option value="">Select</option>
              <option v-for="(business_category, key) in business_categories"
                :selected="form['business_catagory_2'] == business_category.id" :value="business_category.id"
                :key="key">
                {{
                  business_category?.business_category_detail.length > 0
                    ? business_category?.business_category_detail[0].name
                    : ""
                }}
              </option>
            </select>
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`business_catagory_2`)"
              v-text="validationErros.get(`business_catagory_2`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="business_catagory_3" class="block text-base lg:text-lg">Business category 3</label>
            <select name="business_catagory_3"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'business_catagory_3')">
              <option value="">Select</option>
              <option v-for="(business_category, key) in business_categories"
                :selected="form['business_catagory_3'] == business_category.id" :value="business_category.id"
                :key="key">
                {{
                  business_category?.business_category_detail.length > 0
                    ? business_category?.business_category_detail[0].name
                    : ""
                }}
              </option>
            </select>
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`business_catagory_3`)"
              v-text="validationErros.get(`business_catagory_3`)"></p>
          </div>

          <div class="relative z-0 w-full group">
            <label for="media_section_title" class="block text-base lg:text-lg">Title of the media section (max. 10
              words) <span
              class="text-primary">*</span></label>
            <textarea rows="2"
              placeholder="Your business profile will include a section of images and video(s). What do you want the title of that section to be?"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="
                handleMultipleInput(
                  'media_section_title',
                  $event.target.value,
                  language,
                )
                " :value="form['media_section_title'] &&
                form['media_section_title'][`media_section_title_${language.id}`]
                ? form['media_section_title'][`media_section_title_${language.id}`]
                : ''
                "></textarea>
            <p class="mt-2 text-base text-primary" v-if="
              validationErros.has(`media_section_title.media_section_title_${language.id}`)
            " v-text="validationErros.get(`media_section_title.media_section_title_${language.id}`)
              "></p>

          </div>



          <div class="relative z-0 w-full group">
            <label for="media_section_description" class="block text-base lg:text-lg">Description of the media section
              (Max.50 words) <span
              class="text-primary">*</span></label>
            <textarea rows="4"
              placeholder="Write a brief introduction to what the potential client is going to be looking at; are you showing images of your products? Of your facilities? … etc"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="
                handleMultipleInput(
                  'media_section_description',
                  $event.target.value,
                  language,
                )
                " :value="form['media_section_description'] &&
                form['media_section_description'][`media_section_description_${language.id}`]
                ? form['media_section_description'][`media_section_description_${language.id}`]
                : ''
                " ></textarea>
            <p class="mt-2 text-base text-primary" v-if="
              validationErros.has(`media_section_description.media_section_description_${language.id}`)
            " v-text="validationErros.get(`media_section_description.media_section_description_${language.id}`)
              "></p>

          </div>


          <div class="w-full mt-4">
            <label class="block text-base lg:text-lg">Logo <span class="text-primary">*</span></label>
            <p class="text-base">
                Logo(Files must be less than 5MB. Allowed file types: JPG. JPEG, PNG.)
            </p>
            <input type="file"
                class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @change="handleLogo($event,'logo')" />
                <p class="mt-2 text-base text-primary" v-if="validationErros.has(`logo`)"
                v-text="validationErros.get(`logo`)"></p>
            <div v-if="form['logo']" class="mt-2 relative">
                <img :src="form.logo" style="height: 100px; width: 100px" />
                <button @click="removeImageLogo"
                    class="absolute top-0 right-0 bg-primary text-white rounded-full px-2 py-1 text-xs">
                    X
                </button>
            </div>
        </div>


          <div class="relative z-0 w-full group">
            <label for="welcome_video" class="block text-base lg:text-lg">Welcome video <span
              class="text-primary">*</span></label>
            <input name="welcome_video"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'welcome_video')"
              :value="form['welcome_video'] ? form['welcome_video'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`welcome_video`)"
              v-text="validationErros.get(`welcome_video`)"></p>
          </div>

          <div class="relative z-0 w-full group">
            <label for="facebook_url" class="block text-base lg:text-lg">Facebook URL</label>
            <input name="facebook_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'facebook_url')"
              :value="form['facebook_url'] ? form['facebook_url'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`facebook_url`)"
              v-text="validationErros.get(`facebook_url`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="twitter_url" class="block text-base lg:text-lg">Twitter URL</label>
            <input name="twitter_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'twitter_url')"
              :value="form['twitter_url'] ? form['twitter_url'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`twitter_url`)"
              v-text="validationErros.get(`twitter_url`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="youtube_url" class="block text-base lg:text-lg">Youtube URL</label>
            <input name="youtube_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'youtube_url')"
              :value="form['youtube_url'] ? form['youtube_url'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`youtube_url`)"
              v-text="validationErros.get(`youtube_url`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="linked_url" class="block text-base lg:text-lg">Linked URL</label>
            <input name="linked_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'linked_url')"
              :value="form['linked_url'] ? form['linked_url'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`linked_url`)"
              v-text="validationErros.get(`linked_url`)"></p>
          </div>
         

          <div class="relative z-0 w-full group">
            <label for="other_social_url" class="block text-base lg:text-lg">Social URLs (Other)</label>
            <input name="other_social_url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'other_social_url')"
              :value="form['other_social_url'] ? form['other_social_url'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`other_social_url`)"
              v-text="validationErros.get(`other_social_url`)"></p>
          </div>

          
          <div class="relative z-0 w-full group">
            <label for="degree" class="block text-base lg:text-lg">Image (Files must be less than 5MB. Allowed file
              types: PNG, GIF, JPG, JPEG)</label>
            <input :key="`image`" type="file" :name="`image`" :id="`image`"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder=" " @change="handleImageArray($event)" multiple />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`image`)"
              v-text="validationErros.get(`image`)"></p>
          </div>

        </div>

        <div class="grid my-5 md:grid-cols-2 md:gap-6">
          <div class="md:col-span-4">
            <div class="flex flex-wrap gap-2">
              <div class="relative h-32 w-32 bg-gray-50 border" v-for="(image, key) in form?.image" :key="key">
                <img :src="image" class="w-full h-full object-contain" />
                <span @click="removeImage(key)"
                  class="absolute top-0 right-0 flex justify-center items-center cursor-pointer bg-white border border-primary rounded-full text-primary w-5 h-5">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </span>
              </div>
            </div>
          </div>
        </div>



        <ListErrors :validationErrors="validationErros" />

        <button type="submit" class="can-edu-btn-fill mb-2">Submit</button>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      isFormEdit: (state) => state.businesses.isFormEdit,
      form: (state) => state.businesses.form,
      validationErros: (state) => state.businesses.validationErros,
      languages: (state) => state.languages.languages,
      business_categories: (state) =>
        state.business_categories.business_categories,
    }),
  },
  components: {
    editor: Editor,
    ListErrors
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
    };
  },
  methods: {
    handleLogo(event, key) {
    const fileInput = event.target;
    if (!fileInput.files.length) return;

    let file = new FormData();
    file.append("file", fileInput.files[0]);

    axios.post("/api/admin/media/image_again_upload", file)
        .then((res) => {
            this.$store.commit("businesses/setState", {
                key: key,
                value: res?.data,
            });

            if (this.validationErros.has(key)) {
                this.validationErros.clear(key);
            }
        })
        .catch((error) => {
            console.error("Image upload failed:", error);
        });
},

        removeImageLogo() {
            this.$store.commit("businesses/setState", {
                key: "logo",
                value: null, 
            });
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
    handleInput(value, key) {
      this.$store.commit("businesses/setState", { key, value });
      if (value.trim()) {
        this.validationErros.clear(key);
      }
    },
    handleSelectionChange(language, key) {
      const content = tinymce.get(`${key}_${language.id}`).getContent();
      this.$store.commit(`businesses/updateState`, {
        value: content,
        id: language.id,
        key: key,
      });
      if (content.trim()) {
        this.validationErros.clear(`${key}.${key}_${language.id}`);
      }
    },
    handleMultipleInput(key, value, language) {
      this.$store.commit("businesses/updateState", {
        value: value,
        id: language.id,
        key,
      });
      if (value.trim()) {
        this.validationErros.clear(`${key}.${key}_${language.id}`);
      }
    },
    addUpdateForm() {
      this.$store
        .dispatch("businesses/addUpdateForm")
        .then(() => this.$router.push({ name: "admin.business.index" }
        )).catch((error) => {
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
    fetchBusiness() {
      if (this.$route.params.id) {
        let id = this.$route.params.id;

        this.$store.commit("businesses/setIsFormEdit", 1);
        this.$store
          .dispatch("businesses/fetchBusiness", {
            id: id,
            url: `${process.env.MIX_ADMIN_API_URL}businesses/${id}?withBusinessDetail=1`,
          })
          .then((res) => {
            console.log('busniess res', res);
            let keys = [
              "facebook_url",
              "welcome_video",
              "twitter_url",
              "youtube_url",
              "logo",
              "linked_url",
              "other_social_url",
              "keywords",
              "contact_name",
              "email",
              "phone",
              "address",
              "website_url",
              "business_catagory_1",
              "business_catagory_2",
              "business_catagory_3",
            ];
            this.$store.commit("businesses/setState", {
              key: "id",
              value: id,
            });
            for (var i = 0; i < keys.length; i++) {
              this.$store.commit("businesses/setState", {
                key: keys[i],
                value: res.data.data[keys[i]],
              });
            }
            let data =
              res.data.data && res.data.data.business_detail
                ? res.data.data.business_detail
                : [];

            let obj = {};
            data.map((res) => {
              obj["business_name_" + res.language_id] = res.business_name;
            });
            this.$store.commit("businesses/setState", {
              key: "business_name",
              value: obj,
            });

            data.map((res) => {
              obj["description_" + res.language_id] = res.description;
            });
            this.$store.commit("businesses/setState", {
              key: "description",
              value: obj,
            });

            data.map((res) => {
              obj["detail_description_" + res.language_id] = res.detail_description;
            });
            this.$store.commit("businesses/setState", {
              key: "detail_description",
              value: obj,
            });

            data.map((res) => {
              obj["media_section_title_" + res.language_id] = res.media_section_title;
            });
            this.$store.commit("businesses/setState", {
              key: "media_section_title",
              value: obj,
            });

            data.map((res) => {
              obj["media_section_description_" + res.language_id] = res.media_section_description;
            });
            this.$store.commit("businesses/setState", {
              key: "media_section_description",
              value: obj,
            });
            if (res.data.data.images) {
              for (
                var i = 0;
                i < res.data.data.images?.length;
                i++
              ) {
                this.$store.commit(
                  "businesses/setImages",
                  res.data.data.images[i]
                );
              }
            }
            this.isDataLoaded = 1;
          });
      }
    },
    handleImage(e, key) {
      var files = e.target.files;
      var formData = new FormData();

      for (let i = 0; i < files.length; i++) {
        formData.append("files[]", files[i]);
      }
      axios
        .post("/api/admin/media/upload-multiple-files", formData)
        .then((res) => {
          const imageNames = res?.data.join(",");
          this.$store.commit("businesses/setState", {
            key,
            value: imageNames,
          });
        });
    },
    getImagesArray(images) {
      if (images) {
        const imageArray = images.split(',');

        if (imageArray.length > 0) {
          return imageArray;
        } else {
          return null;
        }
      }
      return null;
    },
    removeImage(index) {
      this.$store.commit("businesses/removeImage", index);
    },
    handleImageArray(e) {
      for (var i = 0; i < e.target.files.length; i++) {
        var file = new FormData();
        file.append("file", e.target.files[i]);
        axios.post("/api/web/image_again_upload", file).then((res) => {
          this.$store.commit("businesses/setImages", res?.data);
        });
      }
    },
  },
  created() {
    this.$store.commit("businesses/resetForm");
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        let data = res.data.data;
        let obj = {};
        data.map((res) => {
          obj["business_name_" + res.id] = "";
        });
        this.$store.commit("businesses/setState", {
          key: "business_name",
          value: obj,
        });
        data.map((res) => {
          obj["description_" + res.id] = "";
        });
        this.$store.commit("businesses/setState", {
          key: "description",
          value: obj,
        });

        data.map((res) => {
          obj["detail_description_" + res.id] = "";
        });
        this.$store.commit("businesses/setState", {
          key: "detail_description",
          value: obj,
        });

        data.map((res) => {
          obj["media_section_title_" + res.id] = "";
        });
        this.$store.commit("businesses/setState", {
          key: "media_section_title",
          value: obj,
        });

        data.map((res) => {
          obj["media_section_description_" + res.id] = "";
        });
        this.$store.commit("businesses/setState", {
          key: "media_section_description",
          value: obj,
        });
        if (this.$route.params.id) {
          this.fetchBusiness();
        }
        else {
          this.isDataLoaded = 1;
        }
      });
    this.$store.commit("business_categories/setLimit", 10000);
    this.$store.commit("business_categories/setSortBy", "business_category_name");
    this.$store.commit("business_categories/setSortType", "asc");
    this.$store.dispatch("business_categories/fetchBusinessCategories");
  },
};
</script>
