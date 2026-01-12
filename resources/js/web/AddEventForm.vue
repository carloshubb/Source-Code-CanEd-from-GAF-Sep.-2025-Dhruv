<template>
  <div class="bg-white mx-auto">
    <template v-if="!is_logged_id">
      <form @submit.prevent="recaptcha()">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <template v-for="(language, key) in languages" :key="language.id">
            <div :class="(activeTab == null && language.is_default) ||
              activeTab == language.id
              ? 'block'
              : 'hidden'
              " class="relative md:col-span-2">
              <label class="block text-base lg:text-lg">{{
                static_translations?.title_label
                  ? static_translations?.title_label
                  : ""
              }}
                <span class="text-primary">*</span>
              </label>
              <input :key="key" :value="title['title_' + language.id]"
                @input="handleInput($event.target.value, language.id, 'title')"
                class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                :class="position == 'rtl'
                  ? 'border-r-[5px] rounded-r border-r-primary'
                  : 'border-l-[5px] rounded-l border-l-primary'
                  " />
              <error :fieldName="'title.title_' + language.id" :validationErros="errors" />
            </div>
            <div :class="(activeTab == null && language.is_default) ||
              activeTab == language.id
              ? 'block'
              : 'hidden'
              " class="relative md:col-span-2">
              <label class="block text-base lg:text-lg">{{
                static_translations?.short_description_label
                  ? static_translations?.short_description_label
                  : ""
              }}
                <span class="text-primary">*</span>
              </label>
              <textarea rows="2" :key="key" @input="
                handleInput(
                  $event.target.value,
                  language.id,
                  'short_description'
                )
                "
                placeholder="Describe the Event in no more than 30 words. This information will appear next to the Event’s name on the search results page and will help you attract visitors"
                class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                :class="position == 'rtl'
                  ? 'border-r-[5px] rounded-r border-r-primary'
                  : 'border-l-[5px] rounded-l border-l-primary'
                  " :value="short_description['short_description_' + language.id]"></textarea>
              <error :fieldName="'short_description.short_description_' + language.id" :validationErros="errors" />
            </div>
            <div :class="(activeTab == null && language.is_default) ||
              activeTab == language.id
              ? 'block'
              : 'hidden'
              " class="relative md:col-span-2">
              <label class="block text-base lg:text-lg">
                {{
                  static_translations?.description_label
                    ? static_translations?.description_label
                    : ""
                }}
                <span class="text-primary">*</span>
              </label>
              <textarea rows="3" :key="key" @input="
                handleInput($event.target.value, language.id, 'description')
                "
                placeholder="This is the text that will appear on your actual Event’s page. Your description should be no more than 300 words. This is your opportunity to reach students, introduce them to your school products or services, and attract more of them"
                class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                :class="position == 'rtl'
                  ? 'border-r-[5px] rounded-r border-r-primary'
                  : 'border-l-[5px] rounded-l border-l-primary'
                  " :value="description['description_' + language.id]"></textarea>
              <error :fieldName="'description.description_' + language.id" :validationErros="errors" />
            </div>
          </template>

          <div class="relative md:col-span-2">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.veneue_label
                ? static_translations?.veneue_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <textarea type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="veneue"></textarea>
            <error :fieldName="'veneue'" :validationErros="errors" />
          </div>
          <div class="relative md:col-span-2">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.product_search_label
                ? static_translations?.product_search_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <textarea type="text"
              placeholder="Enter up to 5 separate keywords or key-phrases, separated by commas. These are extremely useful when a prospect is searching for a particular school, product or service. So be specific and target your prospects as well as you can"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="product_search"></textarea>
            <error :fieldName="'product_search'" :validationErros="errors" />
          </div>
          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.start_date_label
                ? static_translations?.start_date_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="date"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="start_date" />
            <error :fieldName="'start_date'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.end_date_label
                ? static_translations?.end_date_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="date"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="end_date" />
            <error :fieldName="'end_date'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.event_website_label
                ? static_translations?.event_website_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="event_website" />
            <error :fieldName="'event_website'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.exibitor_url_label
                ? static_translations?.exibitor_url_label
                : ""
            }}
            </label>
            <textarea rows="2"
              placeholder="Add a news or a business platform that talks about the Event, or about your participation in it"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="exibiters_url"></textarea>
            <error :fieldName="'exibiters_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.visitor_url_label
                ? static_translations?.visitor_url_label
                : ""
            }}
            </label>
            <input type="text" placeholder="If the Event requires, or allows the visitors to register in advance"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="visitor_url" />
            <error :fieldName="'visitor_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.press_url_label
                ? static_translations?.press_url_label
                : ""
            }}
            </label>
            <input type="text" placeholder="If the Event, or if you, have a page dedicated for the press"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="press_url" />
            <error :fieldName="'press_url'" :validationErros="errors" />
          </div>

          <div class="relative col-span-2">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.video_url_label
                ? static_translations?.video_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text" placeholder="Add a video about the Event, or about your participation in it"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="video_url" />
            <error :fieldName="'video_url'" :validationErros="errors" />
          </div>
        </div>
        <div class="grid my-5 grid-cols-1 md:grid-cols-2 md:gap-4">
          <div class="md:col-span-2 mb-4">
            <div class="search_card_heading">Event in social media</div>
          </div>
          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.facebook_url_label
                ? static_translations?.facebook_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="facebook_url" />
            <error :fieldName="'facebook_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.insta_url_label
                ? static_translations?.insta_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="instagram_url" />
            <error :fieldName="'instagram_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.linkedin_url_label
                ? static_translations?.linkedin_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="linkedin_url" />
            <error :fieldName="'linkedin_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.youtube_url_label
                ? static_translations?.youtube_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="youtube_url" />
            <error :fieldName="'youtube_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.pintrest_url_label
                ? static_translations?.pintrest_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="pintrest_url" />
            <error :fieldName="'pintrest_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.snapchat_url_label
                ? static_translations?.snapchat_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="snapchat_url" />
            <error :fieldName="'snapchat_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.twitter_url_label
                ? static_translations?.twitter_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="twitter_url" />
            <error :fieldName="'twitter_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.image_upload_label
                ? static_translations?.image_upload_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="file" accept="image/*"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1 rounded border-gray-300" :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " @change="handleImage" />
            <div v-if="imagePreview" class="mt-2">
              <img :src="imagePreview" alt="Preview" class="w-32 h-32 object-cover rounded-md border border-gray-300" />
            </div>
            <error :fieldName="'featured_image'" :validationErros="errors" />
          </div>
          <div class="relative z-0 w-full mb-6 group md:col-span-2">
            <label class="block text-base lg:text-lg">{{
              static_translations?.more_images_upload_label
                ? static_translations?.more_images_upload_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="file" multiple accept="image/*"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1 rounded border-gray-300" :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " @change="handleImageArray($event)" />
            <error :fieldName="'images'" :validationErros="errors" />
          </div>
          <div class="md:col-span-2">
            <div class="flex flex-wrap gap-2">
              <div class="relative h-24 lg:h-32 w-24 lg:w-32 bg-gray-50 border" v-for="(image, key) in images"
                :key="key">
                <img :src="image" class="w-full h-full object-cover" />
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

        <div class="mt-4 border rounded p-4 w-full" id="main_section">
          <div class="grid grid-cols-12 gap-3 md:gap-4">
            <div class="col-span-12">
              <div class="mt-4" v-for="(contact, key) in contacts" :key="key">
                <div class="flex justify-between items-center">
                  <a href="#">
                    <div class="search_card_heading">
                      {{
                        static_translations?.add_more_section_text
                          ? static_translations?.add_more_section_text
                          : ""
                      }}
                    </div>
                  </a>
                  <button v-if="key != 0"
                    class="section delete cursor-pointer border border-primary rounded-full w-5 sm:w-7 h-5 sm:h-7 flex items-center justify-center"
                    type="button" @click="removeContactSection(key)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-4 sm:w-6 h-4 sm:h-6 text-primary">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
                <div class="mt-2">
                  <div class="mt-4">
                    <label for="" class="block text-base lg:text-lg">{{
                      static_translations?.contact_name_label
                        ? static_translations?.contact_name_label
                        : ""
                    }}
                      <span class="text-primary">*</span>
                    </label>
                    <input type="text"
                      class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                      :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                        " @input="
                          setContacts(key, 'contact_name', $event.target.value)
                          " :value="contact.contact_name" />
                    <error :fieldName="'contact_name.' + key" :validationErros="errors" />
                  </div>

                  <div class="mt-4">
                    <label for="" class="block text-base lg:text-lg">{{
                      static_translations?.contact_email_label
                        ? static_translations?.contact_email_label
                        : ""
                    }}
                      <span class="text-primary">*</span>
                    </label>
                    <input type="text"
                      class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                      :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                        " @input="
                          setContacts(key, 'contact_email', $event.target.value)
                          " :value="contact.contact_email" />
                    <error :fieldName="'contact_email.' + key" :validationErros="errors" />
                  </div>

                  <div class="mt-4">
                    <label for="" class="block text-base lg:text-lg">{{
                      static_translations?.contact_phone_label
                        ? static_translations?.contact_phone_label
                        : ""
                    }}
                      <span class="text-primary">*</span>
                    </label>
                    <input type="text"
                      class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                      :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                        " @input="
                          setContacts(key, 'contact_phone', $event.target.value)
                          " :value="contact.contact_phone" />
                    <error :fieldName="'contact_phone.' + key" :validationErros="errors" />
                  </div>
                </div>
                <div class="relative z-0 w-full group">
                  <label for="" class="block text-base lg:text-lg">{{
                    static_translations?.contact_photo_label
                      ? static_translations?.contact_photo_label
                      : ""
                  }}
                    <span class="text-primary">*</span>
                  </label>
                  <input type="file" name="contact-image" :id="`contact-image-[${key}]`"
                    class="border w-full focus:ring-primary focus:outline-none px-4 py-1 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                    @input="uploadImage($event, key)" />
                  <img v-if="contact.contact_photo" :src="contact.contact_photo" style="height: 100px; width: 100px" />
                  <error :fieldName="'contact_photo.' + key" :validationErros="errors" />
                </div>
              </div>
              <button @click="addContact" type="button" class="can-edu-btn-fill whitespace-nowrap mt-4">
                {{
                  static_translations?.add_more_contacts_button_text
                    ? static_translations?.add_more_contacts_button_text
                    : ""
                }}
              </button>
            </div>
          </div>
        </div>
        <div class="recaptcha">
            <Error
            v-if="submitted"
                fieldName="captcha"
                :validationErros="errors"
                full_width="1"
            />
        </div>
        <div class="my-8 flex items-center gap-2 justify-center">
          <!-- <button
                      class="can-edu-btn-fill whitespace-nowrap"
                      @click="toggleModal"
                  >
                      {{
                          static_translations?.close_button_text
                              ? static_translations?.close_button_text
                              : ""
                      }}
                  </button> -->
          <button class="can-edu-btn-fill whitespace-nowrap" type="submit">
            {{
              static_translations?.submit_button_text
                ? static_translations?.submit_button_text
                : ""
            }}
          </button>
        </div>
      </form>
      <transition name="slide">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
          class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 md:h-full"
          v-if="showModal">
          <div class="relative w-full h-full max-w-lg md:h-auto flex items-center justify-center"
            ref="elementToDetectClick">
            <!-- Modal content -->
            <div class="">
              <!-- modal cross button -->
              <div class="absolute top-4 right-4 cursor-pointer" @click="toggleModal">
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                    <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
              </div>
              <div class="bg-white py-8 px-10 rounded-2xl shadow-2xl border-4 border-primary/30 text-center pt-10">
                <p class="text-center can-edu-p">
                  This service is available exclusively to our Sponsors, Featured and Premium schools and businesses
                </p>
                <div class="flex justify-center">
                <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
                  @click="toggleModal">
                  Close
                </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </template>
    <template v-else-if="JSON.parse(this.events_access)">
      <div class="flex justify-end">
        <p class="text-red-500">
          {{ indicate_required_field }}
        </p>
      </div>
      <form @submit.prevent="recaptcha()">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <template v-for="(language, key) in languages" :key="language.id">
            <div :class="(activeTab == null && language.is_default) ||
              activeTab == language.id
              ? 'block'
              : 'hidden'
              " class="relative md:col-span-2">
              <label class="block text-base lg:text-lg">{{
                static_translations?.title_label
                  ? static_translations?.title_label
                  : ""
              }}
                <span class="text-primary">*</span>
              </label>
              <input :key="key" :value="title['title_' + language.id]"
              name="title"
                @input="handleInput($event.target.value, language.id, 'title')"
                class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                :class="position == 'rtl'
                  ? 'border-r-[5px] rounded-r border-r-primary'
                  : 'border-l-[5px] rounded-l border-l-primary'
                  " />
              <error :fieldName="'title.title_' + language.id" :validationErros="errors" />
            </div>
            <div :class="(activeTab == null && language.is_default) ||
              activeTab == language.id
              ? 'block'
              : 'hidden'
              " class="relative md:col-span-2">
              <label class="block text-base lg:text-lg">{{
                static_translations?.short_description_label
                  ? static_translations?.short_description_label
                  : ""
              }}
                <span class="text-primary">*</span>
              </label>
              <textarea rows="2" :key="key" @input="
                handleInput(
                  $event.target.value,
                  language.id,
                  'short_description'
                )
                "
                name="short_description"
                placeholder="Describe the Event in no more than 30 words. This information will appear next to the Event’s name on the search results page and will help you attract visitors"
                class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                :class="position == 'rtl'
                  ? 'border-r-[5px] rounded-r border-r-primary'
                  : 'border-l-[5px] rounded-l border-l-primary'
                  " :value="short_description['short_description_' + language.id]"></textarea>
              <error :fieldName="'short_description.short_description_' + language.id" :validationErros="errors" />
            </div>
            <div :class="(activeTab == null && language.is_default) ||
              activeTab == language.id
              ? 'block'
              : 'hidden'
              " class="relative md:col-span-2">
              <label class="block text-base lg:text-lg">
                {{
                  static_translations?.description_label
                    ? static_translations?.description_label
                    : ""
                }}
                <span class="text-primary">*</span>
              </label>
              <textarea rows="3" :key="key" name="description"  @input="
                handleInput($event.target.value, language.id, 'description')
                "
                placeholder="This description will appear on your Event’s page. This is your opportunity to reach visitors, introduce them to your products or services, and attract more of them. (300 words max.)"
                class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                :class="position == 'rtl'
                  ? 'border-r-[5px] rounded-r border-r-primary'
                  : 'border-l-[5px] rounded-l border-l-primary'
                  " :value="description['description_' + language.id]"></textarea>
              <error :fieldName="'description.description_' + language.id" :validationErros="errors" />
            </div>
          </template>

          <div class="relative md:col-span-2">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.location_label
                ? static_translations?.location_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <textarea type="text"
            name="location"
            placeholder="10 words max."
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="location"></textarea>
            <error :fieldName="'location'" :validationErros="errors" />
          </div>
          <div class="relative md:col-span-2">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.veneue_label
                ? static_translations?.veneue_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <textarea type="text"
            name="veneue"
            placeholder="10 words max."
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="veneue"></textarea>
            <error :fieldName="'veneue'" :validationErros="errors" />
          </div>
          <div class="relative md:col-span-2">
            <label for="" class="block text-base lg:text-lg">{{
                static_translations?.product_search_label
                  ? static_translations?.product_search_label
                  : ""
              }}
            </label>
            <textarea name="product_search" type="text"
              placeholder="Enter up to 5 keywords or key-phrases, separated by commas. These are extremely useful when a prospect is searching for a particular event, business, product or service. So be specific and target your audience as well as you can"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="product_search"></textarea>
            <error :fieldName="'product_search'" :validationErros="errors" />
          </div>
          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.start_date_label
                ? static_translations?.start_date_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="date"
            name="start_date"
            @click="openDatePicker($event)"
            @keydown.prevent
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="start_date" @input="validateYear" />
            <error :fieldName="'start_date'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.end_date_label
                ? static_translations?.end_date_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="date"
            @click="openDatePicker($event)"
            @keydown.prevent
            name="end_date"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="end_date" @input="validateYear" />
            <error :fieldName="'end_date'" :validationErros="errors" />
          </div>

        

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.event_website_label
                ? static_translations?.event_website_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
            name="event_website"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="event_website" />
            <error :fieldName="'event_website'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.exibitor_url_label
                ? static_translations?.exibitor_url_label
                : ""
            }}
            </label>
            <textarea name="exibiters_url" rows="2"
              placeholder="Add the URL of a news media, social media, or a business platform that talks about the Event, or about your participation in it"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="exibiters_url"></textarea>
            <error :fieldName="'exibiters_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.visitor_url_label
                ? static_translations?.visitor_url_label
                : ""
            }}
            </label>
            <textarea rows="2" name="visitor_url" placeholder="If the Event requires, or allows, the visitors to register in advance, or needs them to know something, add the URL of that web page here"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="visitor_url" ></textarea>
            <error :fieldName="'visitor_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.press_url_label
                ? static_translations?.press_url_label
                : ""
            }}
            </label>
            <textarea rows="2" name="press_url" placeholder="If the Event, or you, have a page dedicated for the press, add its URL here"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="press_url" ></textarea>
            <error :fieldName="'press_url'" :validationErros="errors" />
          </div>
        </div>
        <div class="grid my-5 grid-cols-1 md:grid-cols-2 md:gap-4">
          <div class="md:col-span-2">
            <div class="search_card_heading">Event in social media</div>
          </div>
          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.facebook_url_label
                ? static_translations?.facebook_url_label
                : ""
            }}
              <!-- <span class="text-primary">*</span> -->
            </label>
            <input type="text" name="facebook_url"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="facebook_url" />
            <error :fieldName="'facebook_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.insta_url_label
                ? static_translations?.insta_url_label
                : ""
            }}
              <!-- <span class="text-primary">*</span> -->
            </label>
            <input type="text" name="instagram_url"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="instagram_url" />
            <error :fieldName="'instagram_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.linkedin_url_label
                ? static_translations?.linkedin_url_label
                : ""
            }}
              <!-- <span class="text-primary">*</span> -->
            </label>
            <input type="text" name="linkedin_url"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="linkedin_url" />
            <error :fieldName="'linkedin_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.youtube_url_label
                ? static_translations?.youtube_url_label
                : ""
            }}
              <!-- <span class="text-primary">*</span> -->
            </label>
            <input type="text" name="youtube_url"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="youtube_url" />
            <error :fieldName="'youtube_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.pintrest_url_label
                ? static_translations?.pintrest_url_label
                : ""
            }}
              <!-- <span class="text-primary">*</span> -->
            </label>
            <input type="text" name="pintrest_url"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="pintrest_url" />
            <error :fieldName="'pintrest_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.snapchat_url_label
                ? static_translations?.snapchat_url_label
                : ""
            }}
              <!-- <span class="text-primary">*</span> -->
            </label>
            <input type="text" name="snapchat_url"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="snapchat_url" />
            <error :fieldName="'snapchat_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.twitter_url_label
                ? static_translations?.twitter_url_label
                : ""
            }}
              <!-- <span class="text-primary">*</span> -->
            </label>
            <input type="text" name="twitter_url"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="twitter_url" />
            <error :fieldName="'twitter_url'" :validationErros="errors" />
          </div>

        </div>
        
        <div class="grid my-5 grid-cols-1 md:grid-cols-2 md:gap-4 mb-8">
          <div class="md:col-span-2">
            <div class="search_card_heading">Media</div>
          </div>
        
          <div class="relative col-span-2">
            <label for="" class="block text-base lg:text-lg">{{
                static_translations?.video_url_label
                  ? static_translations?.video_url_label
                  : ""
              }}
            </label>
            <input type="text" name="video_url"
            :placeholder="static_translations?.video_url_placholder
              ? static_translations?.video_url_placholder
              : 'Add the URL of a YouTube video about the Event, or about your participation in it'
            "
 
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="video_url" />
            <error :fieldName="'video_url'" :validationErros="errors" />
          </div>
          <!-- Featured Image Upload -->
          <div class="relative">
            <label for="" class="block text-base lg:text-lg">
              {{ static_translations?.image_upload_label || "" }}
              <span class="text-primary">*</span>
            </label>
            <label for="" class="block text-base lg:text-lg">
              5MB max. Allowed formats: JPG, JPEG, PNG
            </label>
            <input
              type="file" name="featured_image" accept="image/*"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1 rounded border-gray-300"
              :class="position == 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary'"
              @change="handleImage"
            />
            <div v-if="imagePreview" class="mt-2">
              <img :src="imagePreview" alt="Preview" class="w-32 h-32 object-cover rounded-md border border-gray-300" />
            </div>
            <error :fieldName="'featured_image'" :validationErros="errors" />
          </div>
        
          <!-- Multiple Images Upload -->
          <div class="relative">
            <label class="block text-base lg:text-lg">
              {{ static_translations?.more_images_upload_label || "" }}
              <!-- <span class="text-primary">*</span> -->
            </label>
            <label for="" class="block text-base lg:text-lg">
              5MB max. Allowed formats: JPG, JPEG, PNG
            </label>
            <input
              type="file"
              multiple
              accept="image/*"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1 rounded border-gray-300"
              :class="position == 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary'"
              @change="handleImageArray($event)"
            />
            <error :fieldName="'images'" :validationErros="errors" />
        
            <!-- Move Image Previews Here -->
            <div class="flex flex-wrap gap-2 mt-2">
              <div class="relative h-24 lg:h-32 w-24 lg:w-32 bg-gray-50 border" v-for="(image, key) in images" :key="key">
                <img :src="image" class="w-full h-full object-cover" />
                <span
                  @click="removeImage(key)"
                  class="absolute top-0 right-0 flex justify-center items-center cursor-pointer bg-white border border-primary rounded-full text-primary w-5 h-5"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </span>
              </div>
            </div>
          </div>
        </div>
        


        <div class="mt-4 border rounded p-4 w-full" id="main_section">
          <div class="grid grid-cols-12 gap-3 md:gap-4">
            <div class="col-span-12">
              <div class="mt-4" v-for="(contact, key) in contacts" :key="key">
                <div class="flex justify-between items-center">
                  <a href="#">
                    <div class="search_card_heading">
                      {{
                        static_translations?.add_more_section_text
                          ? static_translations?.add_more_section_text
                          : ""
                      }}
                    </div>
                  </a>
                  <button v-if="key != 0"
                    class="section delete cursor-pointer border border-primary rounded-full w-5 sm:w-7 h-5 sm:h-7 flex items-center justify-center"
                    type="button" @click="removeContactSection(key)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-4 sm:w-6 h-4 sm:h-6 text-primary">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
                <div class="mt-2">
                  <div class="mt-4">
                    <label for="" class="block text-base lg:text-lg">{{
                      static_translations?.contact_name_label
                        ? static_translations?.contact_name_label
                        : ""
                    }}
                      <span class="text-primary">*</span>
                    </label>
                    <textarea type="text" name="contact_name"
                    placeholder="Please include your full name and the title you would like to be addressed by, separated by a dash or hyphen. For example, John Smith – Sales Manager"
                      class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                      :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                        " @input="
                          setContacts(key, 'contact_name', $event.target.value)
                          " :value="contact.contact_name" ></textarea>
                    <error :fieldName="'contact_name.' + key" :validationErros="errors" />
                  </div>

                  <div class="mt-4">
                    <label for="" class="block text-base lg:text-lg">{{
                        static_translations?.contact_email_label
                          ? static_translations?.contact_email_label
                          : ""
                      }}
                      <span class="text-primary">*</span>
                    </label>
                    <input type="text" name="contact_email" placeholder="Enter your email, even if it is the same you used to register"
                      class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                      :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                        " @input="
                          setContacts(key, 'contact_email', $event.target.value)
                          " :value="contact.contact_email" />
                    <error :fieldName="'contact_email.' + key" :validationErros="errors" />
                  </div>

                  <div class="mt-4">
                    <label for="" class="block text-base lg:text-lg">{{
                        static_translations?.contact_phone_label
                          ? static_translations?.contact_phone_label
                          : ""
                      }}
                      <span class="text-primary">*</span>
                    </label>
                    <input type="text" name="contact_phone" placeholder="With area code. Numbers only"
                      class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                      :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                        " @input="
                          setContacts(key, 'contact_phone', $event.target.value)
                          " :value="contact.contact_phone" 
                          @keypress="restrictToNumbers($event, 15)"/>
                    <error :fieldName="'contact_phone.' + key" :validationErros="errors" />
                  </div>
                </div>
                <div class="relative z-0 w-full group">
                  <label for="" class="block text-base lg:text-lg">{{
                      static_translations?.contact_photo_label
                        ? static_translations?.contact_photo_label
                        : "Contact person’s photo - 5MB max. Allowed formats: JPG, JPEG, PNG"
                    }}
                    <!-- <span class="text-primary">*</span> -->
                  </label>
                  <input type="file" name="contact_photo"  :id="`contact-image-[${key}]`"
                    class="border w-full focus:ring-primary focus:outline-none px-4 py-1 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                    @input="uploadImage($event, key)" />
                  <img v-if="contact.contact_photo" :src="contact.contact_photo" style="height: 100px; width: 100px" />
                  <error :fieldName="'contact_photo.' + key" :validationErros="errors" />
                </div>
              </div>
              <button @click="addContact" type="button" class="can-edu-btn-fill whitespace-nowrap mt-4">
                {{
                  static_translations?.add_more_contacts_button_text
                    ? static_translations?.add_more_contacts_button_text
                    : ""
                }}
              </button>
            </div>
          </div>
        </div>
        <div class="recaptcha">
            <Error
            v-if="submitted"
                fieldName="captcha"
                :validationErros="errors"
                full_width="1"
            />
        </div>
        <div class="my-8 flex items-center gap-2 justify-center">
          <!-- <button
                    class="can-edu-btn-fill whitespace-nowrap"
                    @click="toggleModal"
                >
                    {{
                        static_translations?.close_button_text
                            ? static_translations?.close_button_text
                            : ""
                    }}
                </button> -->
          <button class="can-edu-btn-fill whitespace-nowrap" type="submit">
            {{
              static_translations?.submit_button_text
                ? static_translations?.submit_button_text
                : ""
            }}
          </button>
        </div>
      </form>
    </template>
    
    <template v-else>
      <form @submit.prevent="recaptcha()">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <template v-for="(language, key) in languages" :key="language.id">
            <div :class="(activeTab == null && language.is_default) ||
              activeTab == language.id
              ? 'block'
              : 'hidden'
              " class="relative md:col-span-2">
              <label class="block text-base lg:text-lg">{{
                static_translations?.title_label
                  ? static_translations?.title_label
                  : ""
              }}
                <span class="text-primary">*</span>
              </label>
              <input :key="key" :value="title['title_' + language.id]"
                @input="handleInput($event.target.value, language.id, 'title')"
                class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                :class="position == 'rtl'
                  ? 'border-r-[5px] rounded-r border-r-primary'
                  : 'border-l-[5px] rounded-l border-l-primary'
                  " />
              <error :fieldName="'title.title_' + language.id" :validationErros="errors" />
            </div>
            <div :class="(activeTab == null && language.is_default) ||
              activeTab == language.id
              ? 'block'
              : 'hidden'
              " class="relative md:col-span-2">
              <label class="block text-base lg:text-lg">{{
                static_translations?.short_description_label
                  ? static_translations?.short_description_label
                  : ""
              }}
                <span class="text-primary">*</span>
              </label>
              <textarea rows="2" :key="key" @input="
                handleInput(
                  $event.target.value,
                  language.id,
                  'short_description'
                )
                "
                placeholder="Describe the Event in no more than 30 words. This information will appear next to the Event’s name on the search results page and will help you attract visitors"
                class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                :class="position == 'rtl'
                  ? 'border-r-[5px] rounded-r border-r-primary'
                  : 'border-l-[5px] rounded-l border-l-primary'
                  " :value="short_description['short_description_' + language.id]"></textarea>
              <error :fieldName="'short_description.short_description_' + language.id" :validationErros="errors" />
            </div>
            <div :class="(activeTab == null && language.is_default) ||
              activeTab == language.id
              ? 'block'
              : 'hidden'
              " class="relative md:col-span-2">
              <label class="block text-base lg:text-lg">
                {{
                  static_translations?.description_label
                    ? static_translations?.description_label
                    : ""
                }}
                <span class="text-primary">*</span>
              </label>
              <textarea rows="3" :key="key" @input="
                handleInput($event.target.value, language.id, 'description')
                "
                placeholder="This is the text that will appear on your actual Event’s page. Your description should be no more than 300 words. This is your opportunity to reach students, introduce them to your school products or services, and attract more of them"
                class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                :class="position == 'rtl'
                  ? 'border-r-[5px] rounded-r border-r-primary'
                  : 'border-l-[5px] rounded-l border-l-primary'
                  " :value="description['description_' + language.id]"></textarea>
              <error :fieldName="'description.description_' + language.id" :validationErros="errors" />
            </div>
          </template>

          <div class="relative md:col-span-2">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.veneue_label
                ? static_translations?.veneue_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <textarea type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="veneue"></textarea>
            <error :fieldName="'veneue'" :validationErros="errors" />
          </div>
          <div class="relative md:col-span-2">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.product_search_label
                ? static_translations?.product_search_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <textarea type="text"
              placeholder="Enter up to 5 separate keywords or key-phrases, separated by commas. These are extremely useful when a prospect is searching for a particular school, product or service. So be specific and target your prospects as well as you can"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="product_search"></textarea>
            <error :fieldName="'product_search'" :validationErros="errors" />
          </div>
          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.start_date_label
                ? static_translations?.start_date_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="date"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="start_date" />
            <error :fieldName="'start_date'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.end_date_label
                ? static_translations?.end_date_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="date"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="end_date" />
            <error :fieldName="'end_date'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.event_website_label
                ? static_translations?.event_website_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="event_website" />
            <error :fieldName="'event_website'" :validationErros="errors" />
          </div>
         

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.exibitor_url_label
                ? static_translations?.exibitor_url_label
                : ""
            }}
            </label>
            <textarea rows="2"
              placeholder="Add a news or a business platform that talks about the Event, or about your participation in it"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="exibiters_url"></textarea>
            <error :fieldName="'exibiters_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.visitor_url_label
                ? static_translations?.visitor_url_label
                : ""
            }}
            </label>
            <input type="text" placeholder="If the Event requires, or allows the visitors to register in advance"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="visitor_url" />
            <error :fieldName="'visitor_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.press_url_label
                ? static_translations?.press_url_label
                : ""
            }}
            </label>
            <input type="text" placeholder="If the Event, or if you, have a page dedicated for the press"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="press_url" />
            <error :fieldName="'press_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.video_url_label
                ? static_translations?.video_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text" placeholder="Add a video about the Event, or about your participation in it"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="video_url" />
            <error :fieldName="'video_url'" :validationErros="errors" />
          </div>
        </div>
        <div class="grid my-5 grid-cols-1 md:grid-cols-2 md:gap-4">
          <div class="md:col-span-2 mb-4">
            <div class="search_card_heading">Event in social media</div>
          </div>
          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.facebook_url_label
                ? static_translations?.facebook_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="facebook_url" />
            <error :fieldName="'facebook_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.insta_url_label
                ? static_translations?.insta_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="instagram_url" />
            <error :fieldName="'instagram_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.linkedin_url_label
                ? static_translations?.linkedin_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="linkedin_url" />
            <error :fieldName="'linkedin_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.youtube_url_label
                ? static_translations?.youtube_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="youtube_url" />
            <error :fieldName="'youtube_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.pintrest_url_label
                ? static_translations?.pintrest_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="pintrest_url" />
            <error :fieldName="'pintrest_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.snapchat_url_label
                ? static_translations?.snapchat_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="snapchat_url" />
            <error :fieldName="'snapchat_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.twitter_url_label
                ? static_translations?.twitter_url_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="text"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " v-model="twitter_url" />
            <error :fieldName="'twitter_url'" :validationErros="errors" />
          </div>

          <div class="relative">
            <label for="" class="block text-base lg:text-lg">{{
              static_translations?.image_upload_label
                ? static_translations?.image_upload_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="file" accept="image/*"
              class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1 rounded border-gray-300" :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " @change="handleImage" />
            <div v-if="imagePreview" class="mt-2">
              <img :src="imagePreview" alt="Preview" class="w-32 h-32 object-cover rounded-md border border-gray-300" />
            </div>
            <error :fieldName="'featured_image'" :validationErros="errors" />
          </div>
          <div class="relative z-0 w-full mb-6 group md:col-span-2">
            <label class="block text-base lg:text-lg">{{
              static_translations?.more_images_upload_label
                ? static_translations?.more_images_upload_label
                : ""
            }}
              <span class="text-primary">*</span>
            </label>
            <input type="file" multiple accept="image/*"
              class="border w-full focus:ring-primary focus:outline-none px-4 py-1 rounded border-gray-300" :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " @change="handleImageArray($event)" />
            <error :fieldName="'images'" :validationErros="errors" />
          </div>
          <div class="md:col-span-2">
            <div class="flex flex-wrap gap-2">
              <div class="relative h-24 lg:h-32 w-24 lg:w-32 bg-gray-50 border" v-for="(image, key) in images"
                :key="key">
                <img :src="image" class="w-full h-full object-cover" />
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

        <div class="mt-4 border rounded p-4 w-full" id="main_section">
          <div class="grid grid-cols-12 gap-3 md:gap-4">
            <div class="col-span-12">
              <div class="mt-4" v-for="(contact, key) in contacts" :key="key">
                <div class="flex justify-between items-center">
                  <a href="#">
                    <div class="search_card_heading">
                      {{
                        static_translations?.add_more_section_text
                          ? static_translations?.add_more_section_text
                          : ""
                      }}
                    </div>
                  </a>
                  <button v-if="key != 0"
                    class="section delete cursor-pointer border border-primary rounded-full w-5 sm:w-7 h-5 sm:h-7 flex items-center justify-center"
                    type="button" @click="removeContactSection(key)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-4 sm:w-6 h-4 sm:h-6 text-primary">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
                <div class="mt-2">
                  <div class="mt-4">
                    <label for="" class="block text-base lg:text-lg">{{
                      static_translations?.contact_name_label
                        ? static_translations?.contact_name_label
                        : ""
                    }}
                      <span class="text-primary">*</span>
                    </label>
                    <input type="text"
                      class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                      :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                        " @input="
                          setContacts(key, 'contact_name', $event.target.value)
                          " :value="contact.contact_name" />
                    <error :fieldName="'contact_name.' + key" :validationErros="errors" />
                  </div>

                  <div class="mt-4">
                    <label for="" class="block text-base lg:text-lg">{{
                      static_translations?.contact_email_label
                        ? static_translations?.contact_email_label
                        : ""
                    }}
                      <span class="text-primary">*</span>
                    </label>
                    <input type="text"
                      class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                      :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                        " @input="
                          setContacts(key, 'contact_email', $event.target.value)
                          " :value="contact.contact_email" />
                    <error :fieldName="'contact_email.' + key" :validationErros="errors" />
                  </div>

                  <div class="mt-4">
                    <label for="" class="block text-base lg:text-lg">{{
                      static_translations?.contact_phone_label
                        ? static_translations?.contact_phone_label
                        : ""
                    }}
                      <span class="text-primary">*</span>
                    </label>
                    <input type="text"
                      class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                      :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                        " @input="
                          setContacts(key, 'contact_phone', $event.target.value)
                          " :value="contact.contact_phone" />
                    <error :fieldName="'contact_phone.' + key" :validationErros="errors" />
                  </div>
                </div>
                <div class="relative z-0 w-full group">
                  <label for="" class="block text-base lg:text-lg">{{
                    static_translations?.contact_photo_label
                      ? static_translations?.contact_photo_label
                      : ""
                  }}
                    <span class="text-primary">*</span>
                  </label>
                  <input type="file" name="contact-image" :id="`contact-image-[${key}]`"
                    class="border w-full focus:ring-primary focus:outline-none px-4 py-1 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                    @input="uploadImage($event, key)" />
                  <img v-if="contact.contact_photo" :src="contact.contact_photo" style="height: 100px; width: 100px" />
                  <error :fieldName="'contact_photo.' + key" :validationErros="errors" />
                </div>
              </div>
              <button @click="addContact" type="button" class="can-edu-btn-fill whitespace-nowrap mt-4">
                {{
                  static_translations?.add_more_contacts_button_text
                    ? static_translations?.add_more_contacts_button_text
                    : ""
                }}
              </button>
            </div>
          </div>
        </div>
        <div class="recaptcha">
            <Error
            v-if="submitted"
                fieldName="captcha"
                :validationErros="errors"
                full_width="1"
            />
        </div>
        <div class="my-8 flex items-center gap-2 justify-center">
          <!-- <button
                      class="can-edu-btn-fill whitespace-nowrap"
                      @click="toggleModal"
                  >
                      {{
                          static_translations?.close_button_text
                              ? static_translations?.close_button_text
                              : ""
                      }}
                  </button> -->
          <button class="can-edu-btn-fill whitespace-nowrap" type="submit">
            {{
              static_translations?.submit_button_text
                ? static_translations?.submit_button_text
                : ""
            }}
          </button>
        </div>
      </form>
      <transition name="slide-fade">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
          class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
          v-if="showModal">
          <div class="relative w-full h-full max-w-lg md:h-auto flex items-center justify-center"
            ref="elementToDetectClick">
            <!-- Modal content -->
            <div class="">
              <!-- modal cross button -->
              <div class="absolute top-3 right-3 cursor-pointer" @click="toggleModal">
                <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                    <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
              </div>
              <div class="bg-white py-8 px-10 rounded shadow-lg text-center pt-10">
                <p class="text-center can-edu-p">
                  This service is available exclusively to our Sponsors, Featured and Premium schools and businesses
                </p>
                <div class="flex justify-center">
                <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
                  @click="toggleModal">
                  Close
                </button>
              </div>
            </div>
            </div>
          </div>
        </div>
      </transition>
    </template>
  </div>
  <transition name="slide">
        <div id="defaultModal" tabindex="-1" 
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showPopUpModal">
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
                      <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                          <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                          </svg>
                      </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p" >
                          {{success_message}}                    </p>
                          <div class="flex justify-center">
                        <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4" @click="togglePopUpModal">
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
// ES6 Modules or TypeScript
import Swal from "sweetalert2";
import axios from "axios";
import ErrorHandling from "../ErrorHandling";
import { mapState } from "vuex";
import vueRecaptcha from "vue3-recaptcha2";
import { load } from "recaptcha-v3";
import Error from "./Error.vue";

export default {
  props: [
    "events_access",
    "is_logged_id",
    "logged_in_customer",
    "school_id",
    "lang",
    "lang_id",
    "event_modal_translation",
    "position",
    "indicate_required_field",
    "success_message"
  ],
  components: {
    vueRecaptcha,
    Error,
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
      showPopUpModal: false,
      imagePreview: null, // For displaying the preview image
      featured_image: null,
      showModal: false,
      start_date: "",
      end_date: "",
      event_website: "",
      location: "",
      exibiters_url: "",
      visitor_url: "",
      press_url: "",
      video_url: "",
      submitted: false,
      // contact_name: [],
      // contact_email: [],
      // contact_phone: [],
      // contact_photo: [],
      facebook_url: "",
      instagram_url: "",
      linkedin_url: "",
      youtube_url: "",
      pintrest_url: "",
      snapchat_url: "",
      twitter_url: "",
      featured_image: "",
      status: 0,
      title: {},
      short_description: {},
      description: {},
      city: "",
      country: "",
      street_name: "",
      veneue: "",
      product_search: "",
      state_province: "",
      images: [],
      errors: new ErrorHandling(),
      error_message: "",
      activeTab: null,
      showRecaptcha: true,
      toggelSubmitButton: false,
      emailValidationErro: "",
      static_translations: [],
      contacts: [
        {
          contact_name: "",
          contact_email: "",
          contact_phone: "",
          contact_photo: "",
        },
      ],
    };
  },
  methods: {
    openDatePicker(event) {
        event.target.showPicker(); 
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
    // restrictToNumbers(event, allowedLength) {
    //   const keyCode = event.which ? event.which : event.keyCode;
    //   const inputChar = String.fromCharCode(keyCode);
    //   const valid = /^\d$|^[\+\-\(\)]$/.test(inputChar); 
    //   const maxLengthReached = event.target.value.length >= allowedLength;
    //   if (!valid || maxLengthReached) {
    //     event.preventDefault();
    //   }
    //   return true;
    // },
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
    validateYear() {
      let date = this.start_date;
      if (date) {
        let parts = date.split('-');
        if (parts[0].length > 4) {
          parts[0] = parts[0].slice(0, 4);
          this.start_date = parts.join('-');
        }
      }
      let endDate = this.end_date;
  if (endDate) {
    let parts = endDate.split('-');
    if (parts[0].length > 4) {
      parts[0] = parts[0].slice(0, 4);
      this.end_date = parts.join('-');
    }
  }
    },
    handleClickOutside(event) {
      if (
        this.$refs.elementToDetectClick &&
        !this.$refs.elementToDetectClick.contains(event.target)
      ) {
        if (this.showModal) {
          this.showModal = false;
          window.location.href = "/" + this.lang + "/our-events"; 
        }
      }
    },
    uploadImage(e, index) {
      var file = new FormData();
      file.append("file", e.target.files[0]);
      axios.post("/api/web/image_again_upload", file).then((res) => {
        console.log('event res', res);
        this.setContacts(index, 'contact_photo', res?.data);
      });
    },
    setContacts(index, key, value) {
      this.contacts[index][key] = value;
      localStorage.setItem("event_contacts", JSON.stringify(this.contacts));
      console.log(localStorage.getItem("event_contacts"));
    },
    removeContactSection(index) {
      this.contacts.splice(index, 1);
      localStorage.setItem("event_contacts", JSON.stringify(this.contacts));
      console.log(localStorage.getItem("event_contacts"));
    },
    addContact() {
      this.contacts.push({
        contact_name: "",
        contact_email: "",
        contact_phone: "",
        contact_photo: "",
      });
      localStorage.setItem("event_contacts", JSON.stringify(this.contacts));

      console.log(localStorage.getItem("event_contacts"));
    },
    removeImage(index) {
      this.images.splice(index, 1);
    },
    handleImageArray(e) {
      const selectedFiles = Array.from(e.target.files);
      const totalFiles = this.images.length + selectedFiles.length;
      let errorOccurred = false;

      for (var i = 0; i < e.target.files.length; i++) {
        if (errorOccurred) break;
        var file = new FormData();
        file.append("file", e.target.files[i]);
        file.append("total_files", totalFiles);
        file.append("source", "event");
        axios
          .post("/api/web/image_again_upload", file)
          .then((res) => {
            if (res?.data?.status == "Error") {
              if (!errorOccurred) {
                helper.swalErrorMessage(res.data.message);
              }
              errorOccurred = true;
              return;
            }
            this.images.push(res?.data);
          })
          .catch((error) => {
            helper.swalErrorMessage(
              "An error occurred while uploading the image"
            );
            errorOccurred = true;
          });
      }
      localStorage.setItem("event_images", JSON.stringify(this.images));
    },
    // toggleModal() {
    //   this.showModal = !this.showModal;
    //   if (!this.is_logged_id) {
    //     window.location.href =
    //       "/" + this.lang + "/login?url=" + window.location.href;
    //   }
    // },
    toggleModal() {
      this.showModal = !this.showModal;
      if (!this.showModal) {
        // window.location.href = "/" + this.lang + "/our-events";
        window.location.href = "/" + this.lang + "/events";
      }
    },
    changeLanguageTab(language) {
      this.activeTab = language.id;
    },
    // handleImage(e) {
    //   // console.log(e.target.files[0], key, language, mutationName);
    //   var file = new FormData();
    //   file.append("media", e.target.files[0]);
    //   file.append("is_temp_media", true);
    //   file.append("type", "event_image");
    //   axios.post("/api/web/media/process", file).then((res) => {
    //     this.featured_image = JSON.stringify(res?.data);
    //     localStorage.setItem("event_featured_image", res?.data);
    //   });
    // },
    handleImage(e) {
      const file = e.target.files[0];
      if (file) {
        // Generate the preview URL
        this.imagePreview = URL.createObjectURL(file);

        // Prepare the FormData for submission
        const formData = new FormData();
        formData.append("media", file);
        formData.append("is_temp_media", true);
        formData.append("type", "event_image");

        // Post to the API
        axios.post("/api/web/media/process", formData).then((res) => {
          this.featured_image = JSON.stringify(res?.data);
          localStorage.setItem("event_featured_image", res?.data);
        });
      }
    },
    // handleInput(val, i, key) {
    //   this[key][key + "_" + i] = val;
    //   localStorage.setItem("event_" + key, val);
    //   localStorage.setItem("event_" + key + "_index", i);
    // },
    handleInput(val, languageId, key) {
      const fieldName = `${key}.${key}_${languageId}`;
      this[key][`${key}_${languageId}`] = val;

      if (this.errors.has(fieldName)) {
        this.errors.clear(fieldName);
      }

      localStorage.setItem(`event_${key}_${languageId}`, val);
      localStorage.setItem(`event_${key}_index`, languageId);
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
                    this.saveNetwork();
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
    focusOnFirstErrorInput(errors) {
    console.log('Errors object:', errors);
    const firstErrorField = Object.keys(errors)[0];
    console.log('First error field name:', firstErrorField);

    if (!firstErrorField) {
      console.log('No error field found');
      return;
    }

    const fieldName = firstErrorField.split('.')[0];
    console.log('Stripped error field name:', fieldName);
    const containerDiv = document.querySelector(`[name="${fieldName}"]`);
    console.log('Found input element:', containerDiv);

    if (containerDiv) {
      containerDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
      containerDiv.focus();
    } else {
      console.log(`No input field found for ${fieldName}`);
    }
  },
  saveNetwork() {
    let contact_name = this.contacts.map((contact) => contact.contact_name);
    let contact_email = this.contacts.map((contact) => contact.contact_email);
    let contact_phone = this.contacts.map((contact) => contact.contact_phone);
    let contact_photo = this.contacts.map((contact) => contact.contact_photo);

    const data = {
      start_date: this.start_date,
      end_date: this.end_date,
      event_website: this.event_website,
      location: this.location,
      exibiters_url: this.exibiters_url,
      visitor_url: this.visitor_url,
      press_url: this.press_url,
      video_url: this.video_url,
      contact_name: contact_name,
      contact_email: contact_email,
      contact_phone: contact_phone,
      contact_photo: contact_photo,
      facebook_url: this.facebook_url,
      instagram_url: this.instagram_url,
      linkedin_url: this.linkedin_url,
      youtube_url: this.youtube_url,
      pintrest_url: this.pintrest_url,
      snapchat_url: this.snapchat_url,
      twitter_url: this.twitter_url,
      featured_image: this.featured_image,
      status: 0,
      title: this.title,
      short_description: this.short_description,
      description: this.description,
      city: this.city,
      country: this.country,
      street_name: this.street_name,
      veneue: this.veneue,
      product_search: this.product_search,
      state_province: this.state_province,
      customer_id: JSON.parse(this.logged_in_customer)?.['id'],
      images: this.images,
      is_web: true,
    };

    let justLanguageId = [];
    this.languages.filter((res) => {
      justLanguageId.push(res.id);
    });
    data["language_id"] = justLanguageId;

    axios
      .post("/api/web/events", data)
      .then((res) => {
        if (res?.data?.status == "Success") {
          this.showPopUpModal = true;

          let eventfields = [
            "start_date",
            "end_date",
            "event_website",
            "location",
            "exibiters_url",
            "visitor_url",
            "press_url",
            "video_url",
            "facebook_url",
            "instagram_url",
            "linkedin_url",
            "youtube_url",
            "pintrest_url",
            "snapchat_url",
            "twitter_url",
            "featured_image",
            "city",
            "country",
            "street_name",
            "veneue",
            "product_search",
            "state_province",
            "contacts",
          ];
          eventfields?.map((f) => {
            localStorage.removeItem("event_" + f);
          });

          let multiKeys = ["title", "description", "short_description"];
          multiKeys.map((field) => {
            localStorage.removeItem("event_" + field);
            localStorage.removeItem("event_" + field + "_index");
          });
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
            this.focusOnFirstErrorInput(error.response.data.errors); // Scroll to first error
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
  },
  // created() {
  //   if (!this.is_logged_id) {
  //     window.location.href =
  //       "/" + this.lang + "/login?url=" + window.location.href;
  //   }
  //   this.$store
  //     .dispatch("languages/fetchLanguages", {
  //       url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
  //     })
  //     .then((res) => {
  //       let data = res.data.data;
  //       data.map((res, i) => {
  //         this.title["title_" + res?.id] = "";
  //         this.description["description_" + res?.id] = "";
  //         this.short_description["short_description_" + res?.id] = "";
  //         let multiKeys = ["title", "description", "short_description"];
  //         multiKeys.map((field) => {
  //           const savedField = localStorage.getItem("event_" + field);
  //           const savedFieldIndex = localStorage.getItem(
  //             "event_" + field + "_index"
  //           );
  //           if (savedField && savedFieldIndex) {
  //             this[field][field + "_" + parseInt(savedFieldIndex)] = savedField;
  //           }
  //         });

  //         const savedSD = localStorage.getItem("rs_description");
  //         const savedSDIndex = localStorage.getItem("rs_description_index");
  //         if (savedSD && savedSDIndex) {
  //           this.description[parseInt(savedSDIndex)] = savedSD;
  //         }
  //       });
  //     });
  //   this.activeTab = this.lang_id;
  //   this.static_translations = JSON.parse(this.event_modal_translation);
  // },
  created() {
    // if (!this.is_logged_id) {
    //   window.location.href =
    //     "/" + this.lang + "/login?url=" + window.location.href;
    // }

    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        let data = res.data.data;

        data.forEach((res) => {
          this.title["title_" + res?.id] = "";
          this.description["description_" + res?.id] = "";
          this.short_description["short_description_" + res?.id] = "";
        });

        localStorage.removeItem("event_title");
        localStorage.removeItem("event_title_index");
        localStorage.removeItem("event_description");
        localStorage.removeItem("event_description_index");
        localStorage.removeItem("event_short_description");
        localStorage.removeItem("event_short_description_index");
      });
    this.activeTab = this.lang_id;
    this.static_translations = JSON.parse(this.event_modal_translation);
    
  },
  
  beforeUnmount() {
    document.removeEventListener("click", this.handleClickOutside);
    document.removeEventListener("click", this.handleClickOutsidePopup);
    
  },
  mounted() {
    this.showModal= !JSON.parse(this.events_access);
    // document.addEventListener("click", this.handleClickOutsidePopup);
    // document.addEventListener("click", this.handleClickOutside);
    // this.toggleModal();
    let eventfields = [
      "start_date",
      "end_date",
      "event_website",
      "location",
      "exibiters_url",
      "visitor_url",
      "press_url",
      "video_url",
      "facebook_url",
      "instagram_url",
      "linkedin_url",
      "youtube_url",
      "pintrest_url",
      "snapchat_url",
      "twitter_url",
      "featured_image",
      "city",
      "country",
      "street_name",
      "veneue",
      "state_province",
      "product_search",
    ];
    eventfields?.map((f) => {
      // const savedField = localStorage.getItem("event_" + f);
      // if (savedField) {
      //   this[f] = savedField;
      // }
      this[f] = "";
    });
    // const savedImages = localStorage.getItem("event_images");
    // if (savedImages) {
    //   this.images = JSON.parse(savedImages);
    // }

    // const savedField = localStorage.getItem("event_contacts");
    // if (savedField) {
    //   this.contacts = JSON.parse(savedField);
    // }
    this.event_contacts = [];
    this.event_images = [];

    let contact_name = this.contacts.map((contact) => contact.contact_name);
    let contact_email = this.contacts.map((contact) => contact.contact_email);
    let contact_phone = this.contacts.map((contact) => contact.contact_phone);
    let contact_photo = this.contacts.map((contact) => contact.contact_photo);

    this.contact_name = contact_name;
    this.contact_email = contact_email;
    this.contact_phone = contact_phone;
    this.contact_photo = contact_photo;
  },
  watch: {
    title: {
      deep: true,
      handler(newValue) {
        Object.keys(newValue).forEach((key) => {
          if (this.errors.has(key)) {
            this.errors.clear(key);
          }
        });
      },
    },
    'contacts': {
      handler(newValue) {
        newValue.forEach((contact, index) => {
          if (contact.contact_name && contact.contact_name !== "") {
            this.errors.has(`contact_name.${index}`) ? this.errors.clear(`contact_name.${index}`) : "";
            localStorage.setItem(`master_contact_name_${index}`, contact.contact_name);
          }

          if (contact.contact_email && contact.contact_email !== "") {
            this.errors.has(`contact_email.${index}`) ? this.errors.clear(`contact_email.${index}`) : "";
            localStorage.setItem(`master_contact_email_${index}`, contact.contact_email);
          }

          if (contact.contact_phone && contact.contact_phone !== "") {
            this.errors.has(`contact_phone.${index}`) ? this.errors.clear(`contact_phone.${index}`) : "";
            localStorage.setItem(`master_contact_phone_${index}`, contact.contact_phone);
          }

          if (contact.contact_photo && contact.contact_photo !== "") {
            this.errors.has(`contact_photo.${index}`) ? this.errors.clear(`contact_photo.${index}`) : "";
            localStorage.setItem(`master_contact_photo_${index}`, contact.contact_photo);
          }
        });
      },
      deep: true,
    },

    'contacts.contact_name': {
      handler(newValue, oldValue) {
        if (newValue !== "") {
          const index = this.contacts.findIndex(contact => contact.contact_name === newValue);
          this.errors.has(`contact_name.${index}`) ? this.errors.clear(`contact_name.${index}`) : "";
        }
      },
      deep: true
    },

    'contacts.contact_email': {
      handler(newValue, oldValue) {
        if (newValue !== "") {
          const index = this.contacts.findIndex(contact => contact.contact_email === newValue);
          this.errors.has(`contact_email.${index}`) ? this.errors.clear(`contact_email.${index}`) : "";
        }
      },
      deep: true
    },

    'contacts.contact_phone': {
      handler(newValue, oldValue) {
        if (newValue !== "") {
          const index = this.contacts.findIndex(contact => contact.contact_phone === newValue);
          this.errors.has(`contact_phone.${index}`) ? this.errors.clear(`contact_phone.${index}`) : "";
        }
      },
      deep: true
    },

    'contacts.contact_photo': {
      handler(newValue, oldValue) {

        if (newValue !== "") {
          const index = this.contacts.findIndex(contact => contact.contact_photo === newValue);
          this.errors.has(`contact_photo.${index}`) ? this.errors.clear(`contact_photo.${index}`) : "";
        }
      },
      deep: true
    },
    start_date(newValue, oldValue) {
      this.errors.has("start_date") ? this.errors.clear("start_date") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_start_date", newValue);
      }
    },
    end_date(newValue, oldValue) {
      this.errors.has("end_date") ? this.errors.clear("end_date") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_end_date", newValue);
      }
    },
    event_website(newValue, oldValue) {
      this.errors.has("event_website") ? this.errors.clear("event_website") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_event_website", newValue);
      }
    },
    location(newValue, oldValue) {
      this.errors.has("location") ? this.errors.clear("location") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_location", newValue);
      }
    },
    exibiters_url(newValue, oldValue) {
      this.errors.has("exibiters_url") ? this.errors.clear("exibiters_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_exibiters_url", newValue);
      }
    },
    visitor_url(newValue, oldValue) {
      this.errors.has("visitor_url") ? this.errors.clear("visitor_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_visitor_url", newValue);
      }
    },
    press_url(newValue, oldValue) {
      this.errors.has("press_url") ? this.errors.clear("press_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_press_url", newValue);
      }
    },
    video_url(newValue, oldValue) {
      this.errors.has("video_url") ? this.errors.clear("video_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_video_url", newValue);
      }
    },
    facebook_url(newValue, oldValue) {
      this.errors.has("facebook_url") ? this.errors.clear("facebook_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_facebook_url", newValue);
      }
    },
    instagram_url(newValue, oldValue) {
      this.errors.has("instagram_url") ? this.errors.clear("instagram_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_instagram_url", newValue);
      }
    },
    linkedin_url(newValue, oldValue) {
      this.errors.has("linkedin_url") ? this.errors.clear("linkedin_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_linkedin_url", newValue);
      }
    },
    youtube_url(newValue, oldValue) {
      this.errors.has("youtube_url") ? this.errors.clear("youtube_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_youtube_url", newValue);
      }
    },
    pintrest_url(newValue, oldValue) {
      this.errors.has("pintrest_url") ? this.errors.clear("pintrest_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_pintrest_url", newValue);
      }
    },
    snapchat_url(newValue, oldValue) {
      this.errors.has("snapchat_url") ? this.errors.clear("snapchat_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_snapchat_url", newValue);
      }
    },
    twitter_url(newValue, oldValue) {
      this.errors.has("twitter_url") ? this.errors.clear("twitter_url") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_twitter_url", newValue);
      }
    },
    featured_image(newValue, oldValue) {
      this.errors.has("featured_image") ? this.errors.clear("featured_image") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_featured_image", newValue);
      }
    },
    status(newValue, oldValue) {
      this.errors.has("status") ? this.errors.clear("status") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_status", newValue);
      }
    },
    city(newValue, oldValue) {
      this.errors.has("city") ? this.errors.clear("city") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_city", newValue);
      }
    },
    country(newValue, oldValue) {
      this.errors.has("country") ? this.errors.clear("country") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_country", newValue);
      }
    },
    street_name(newValue, oldValue) {
      this.errors.has("street_name") ? this.errors.clear("street_name") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_street_name", newValue);
      }
    },
    veneue(newValue, oldValue) {
      this.errors.has("veneue") ? this.errors.clear("veneue") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_veneue", newValue);
      }
    },
    product_search(newValue, oldValue) {
      this.errors.has("product_search") ? this.errors.clear("product_search") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_product_search", newValue);
      }
    },
    state_province(newValue, oldValue) {
      this.errors.has("state_province") ? this.errors.clear("state_province") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("event_state_province", newValue);
      }
    },
  },
};
</script>
<style scoped>
/* Slide Animation */
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}
.slide-enter-from, .slide-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>