<template>
  <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full overflow-hidden">
    <div class="mt-4 flex justify-between items-center gap-2 p-2">
      <h2 class="px-4 can-school-h2 text-primary">Create event</h2>
    </div>
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
               
              validationErros.has(`title.title_${language.id}`) ||
                validationErros.has(
                  `short_description.short_description_${language.id}`
                ) ||
                validationErros.has(`description.description_${language.id}`)
                ? 'bg-red-600 text-white hover:text-white'
                : '',
            ]">{{ language.name }}</a>
          </li>
        </ul>
      </div>

      <div class="grid my-5 grid-cols-1 md:grid-cols-2 gap-4 md:gap-6" v-for="language in languages" :key="language.id"
        :class="(activeTab == null && language.is_default) ||
          activeTab == language.id
          ? 'block'
          : 'hidden'
          ">
        <div class="relative z-0 w-full group md:col-span-2">
          <label for="title" class="block text-base lg:text-lg">Event name</label>
          <input type="text" name="title" id="title"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="
              handleMultipleInput('title', $event.target.value, language)
              " :value="form['title'] && form['title'][`title_${language.id}`]
                    ? form['title'][`title_${language.id}`]
                    : ''
                    " />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`title.title_${language.id}`)"
            v-text="validationErros.get(`title.title_${language.id}`)"></p>
        </div>
        <div class="relative z-0 w-full group md:col-span-2">
          <label for="short_description" class="block text-base lg:text-lg">Event short description</label>
          <textarea type="text" name="short_description" id="short_description"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder="Describe the Event in no more than 30 words. This information will appear next to the Event’s name on the search results page and will help you attract visitors "
            rows="3" @input="
              handleMultipleInput(
                'short_description',
                $event.target.value,
                language
              )
              " :value="form['short_description'] &&
                    form['short_description'][`short_description_${language.id}`]
                    ? form['short_description'][
                    `short_description_${language.id}`
                    ]
                    : ''
                    "></textarea>
          <p class="mt-2 text-base text-primary" v-if="
            validationErros.has(
              `short_description.short_description_${language.id}`
            )
          " v-text="validationErros.get(
                `short_description.short_description_${language.id}`
              )
                "></p>
        </div>
        <div class="relative z-0 w-full group md:col-span-2">
          <!-- <div
                          class="mt-5 ckeditorText"
                          :id="`description_${language.id}`"
                      ></div> -->
          <label for="description" class="block text-base lg:text-lg">Event detailed description</label>
          <!-- <editor @selectionChange="handleSelectionChange(language, 'description')"
                :ref="`description_${language.id}`" :id="`description_${language.id}`" :initial-value="form[`description`][`description_${language?.id}`]
                  "
                placeholder="This is the text that will appear on your actual Event’s page. Your description should be no more than 300 words. This is your opportunity to reach students, introduce them to your school products or services, and attract more of them"
                :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" /> -->
          <editor @selectionChange="handleSelectionChange(language, 'description')" :ref="`description_${language.id}`"
            :id="`description_${language.id}`" :placeholder="static_translations?.description_placeholder || ''"
            :initial-value="description?.[`description_${language.id}`] || ''" :init="editorConfig"
            :tinymce-script-src="tinymceScriptSrc" />
          <p class="mt-2 text-base text-primary" v-if="
            validationErros.has(`description.description_${language.id}`)
          " v-text="validationErros.get(`description.description_${language.id}`)
                "></p>
        </div>
        <div class="relative z-0 w-full group md:col-span-2">
          <label for="product_search" class="block text-base lg:text-lg">Keywords</label>
          <textarea rows="2" name="product_search" id="product_search"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder="Enter up to 5 separate keywords or key-phrases, separated by commas. These are extremely useful when a prospect is searching for a particular school, product or service. So be specific and target your prospects as well as you can"
            @input="handleInput($event.target.value, 'product_search')"
            :value="form['product_search'] ? form['product_search'] : ''"></textarea>
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`product_search`)"
            v-text="validationErros.get(`product_search`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="start_date" class="block text-base lg:text-lg">Start date</label>
          <input type="date" name="start_date" id="start_date"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="handleInput($event.target.value, 'start_date')" v-model="startDate" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`start_date`)"
            v-text="validationErros.get(`start_date`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="end_date" class="block text-base lg:text-lg">End date</label>
          <input type="date" name="end_date" id="end_date"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="handleInput($event.target.value, 'end_date')" v-model="endDate" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`end_date`)"
            v-text="validationErros.get(`end_date`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="veneue" class="block text-base lg:text-lg">Address of the event</label>
          <textarea rows="2" name="veneue" id="veneue"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            @input="handleInput($event.target.value, 'veneue')" :value="form['veneue'] ?? ''"></textarea>
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`veneue`)"
            v-text="validationErros.get(`veneue`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="event_website" class="block text-base lg:text-lg">Event’s website(URL)</label>
          <input type="text" name="event_website" id="event_website"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="handleInput($event.target.value, 'event_website')"
            :value="form['event_website'] ? form['event_website'] : ''" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`event_website`)"
            v-text="validationErros.get(`event_website`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="exibiters_url" class="block text-base lg:text-lg">Event in the media (URL)</label>
          <textarea rows="2" name="exibiters_url" id="exibiters_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder="Add the URL of a news or a business platform that talks about the Event, or about your participation in it"
            @input="handleInput($event.target.value, 'exibiters_url')"
            :value="form['exibiters_url'] ? form['exibiters_url'] : ''"></textarea>
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`exibiters_url`)"
            v-text="validationErros.get(`exibiters_url`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="visitor_url" class="block text-base lg:text-lg">Visitors URL</label>
          <textarea rows="2" name="visitor_url" id="visitor_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder="If the Event requires, or allows, the visitors to register in advance, or needs them to know something, add the URL of that web page here"
            @input="handleInput($event.target.value, 'visitor_url')"
            :value="form['visitor_url'] ? form['visitor_url'] : ''"></textarea>
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`visitor_url`)"
            v-text="validationErros.get(`visitor_url`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="press_url" class="block text-base lg:text-lg">For the press (URL)</label>
          <textarea rows="2" name="press_url" id="press_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder="If the Event, or you, have a page dedicated for the press, add its URL here"
            @input="handleInput($event.target.value, 'press_url')"
            :value="form['press_url'] ? form['press_url'] : ''"></textarea>
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`press_url`)"
            v-text="validationErros.get(`press_url`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="video_url" class="block text-base lg:text-lg">Event’s welcome video(URL)</label>
          <textarea rows="2" name="video_url" id="video_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder="Add the URL of a video about the Event, or about your participation in it. Valid URL formats must start with https://www.youtube.com/"
            @input="handleInput($event.target.value, 'video_url')"
            :value="form['video_url'] ? form['video_url'] : ''"></textarea>
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`video_url`)"
            v-text="validationErros.get(`video_url`)"></p>
        </div>
      </div>
      <div class="grid my-5 grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        <div class="md:col-span-2">
          <h2 class="can-school-h2 text-primary">Event in social media</h2>
        </div>
        <div class="relative z-0 w-full group">
          <label for="facebook_url" class="block text-base lg:text-lg">Facebook</label>
          <input type="text" name="facebook_url" id="facebook_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="handleInput($event.target.value, 'facebook_url')"
            :value="form['facebook_url'] ? form['facebook_url'] : ''" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`facebook_url`)"
            v-text="validationErros.get(`facebook_url`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="instagram_url" class="block text-base lg:text-lg">Instagram</label>
          <input type="text" name="instagram_url" id="instagram_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="handleInput($event.target.value, 'instagram_url')"
            :value="form['instagram_url'] ? form['instagram_url'] : ''" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`instagram_url`)"
            v-text="validationErros.get(`instagram_url`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="linkedin_url" class="block text-base lg:text-lg">LinkedIn</label>
          <input type="text" name="linkedin_url" id="linkedin_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="handleInput($event.target.value, 'linkedin_url')"
            :value="form['linkedin_url'] ? form['linkedin_url'] : ''" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`linkedin_url`)"
            v-text="validationErros.get(`linkedin_url`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="youtube_url" class="block text-base lg:text-lg">YouTube</label>
          <input type="text" name="youtube_url" id="youtube_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="handleInput($event.target.value, 'youtube_url')"
            :value="form['youtube_url'] ? form['youtube_url'] : ''" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`youtube_url`)"
            v-text="validationErros.get(`youtube_url`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="pintrest_url" class="block text-base lg:text-lg">Pinterest</label>
          <input type="text" name="pintrest_url" id="pintrest_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="handleInput($event.target.value, 'pintrest_url')"
            :value="form['pintrest_url'] ? form['pintrest_url'] : ''" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`pintrest_url`)"
            v-text="validationErros.get(`pintrest_url`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="snapchat_url" class="block text-base lg:text-lg">Snapchat</label>
          <input type="text" name="snapchat_url" id="snapchat_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="handleInput($event.target.value, 'snapchat_url')"
            :value="form['snapchat_url'] ? form['snapchat_url'] : ''" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`snapchat_url`)"
            v-text="validationErros.get(`snapchat_url`)"></p>
        </div>
        <div class="relative z-0 w-full group">
          <label for="twitter_url" class="block text-base lg:text-lg">Twitter</label>
          <input type="text" name="twitter_url" id="twitter_url"
            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
            placeholder=" " @input="handleInput($event.target.value, 'twitter_url')"
            :value="form['twitter_url'] ? form['twitter_url'] : ''" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has(`twitter_url`)"
            v-text="validationErros.get(`twitter_url`)"></p>
        </div>
      </div>
      <div class="grid md:grid-cols-4 ite md:gap-6">
        <div class="relative z-0 w-full mb-6 group md:col-span-2">
          <label for="featured_image" class="block text-base lg:text-lg mb-2">Main photo</label>
          <FilePond name="featured_image" class-name="my-pond" accepted-file-types="image/*" @init="handleFilePondInit"
            @processfile="handleFilePondFlagIconProcess" @removefile="handleFilePondFlagIconRemoveFile" />
          <p class="mt-2 text-base text-primary" v-if="validationErros.has('featured_image')"
            v-text="validationErros.get('featured_image')"></p>
        </div>

        <div class="relative z-0 w-full mb-6 group md:col-span-2">
          <label class="block text-base lg:text-lg">Add more photos</label>
          <input type="file" multiple
            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @change="handleImageArray($event)" />
          <div class="z-10 -top-2 left-1/4 absolute">
            <p class="tooltiptext line-clamp-2 w-72 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
              v-if="validationErros.has('images')" v-text="validationErros.get('images')"></p>
          </div>
        </div>
        <div class="md:col-span-4">
          <div class="flex flex-wrap gap-2">
            <div class="relative h-32 w-32 bg-gray-50 border" v-for="(image, key) in form?.images" :key="key">
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
      <!-- <div class="grid md:grid-cols-2 md:gap-6">
                  <div
                      class="relative z-0 w-full mb-6 group flex items-center space-x-2"
                  >
                      <input
                          type="checkbox"
                          name="status"
                          id="status"
                          class="accent-pink-300"
                          @input="handleInput($event.target.checked, 'status')"
                          :checked="form['status'] ? form['status'] : ''"
                      />
                      <label for="status" class="text-base text-gray-500"
                          >Status</label
                      >
                      <p
                          class="mt-2 text-base text-primary"
                          v-if="validationErros.has(`status`)"
                          v-text="validationErros.get(`status`)"
                      ></p>
                  </div>
              </div> -->

      <div class="mt-4" v-for="(contact, key) in form?.contacts" :key="key">
        <div class="flex justify-between items-center">
          <h1 class="can-edu-h1">Contact information</h1>
          <!-- <a href="#">
                          <div class="search_card_heading">
                          </div>
                      </a> -->
          <button v-if="key != 0"
            class="section delete cursor-pointer border border-primary rounded-full w-5 sm:w-7 h-5 sm:h-7 flex items-center justify-center"
            type="button" @click="removeFromContacts(key)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-4 sm:w-6 h-4 sm:h-6 text-primary">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="grid my-5 md:grid-cols-2 md:gap-6">
          <div class="relative z-0 w-full group">
            <label for="contact_name" class="block text-base lg:text-lg">Contact person’s name and title</label>
            <input type="text" name="contact_name" id="contact_name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder=" " @input="setContacts(key, 'contact_name', $event.target.value)" :value="form['contacts'][key]['contact_name']
                ? form['contacts'][key]['contact_name']
                : ''
                " />
            <!-- <p class="mt-2 text-base text-primary" v-if="validationErros.has(`contact_name`)"
                  v-text="validationErros.get(`contact_name`)"></p> -->
            <p class="mt-2 text-base text-primary" v-if="getValidationError('contact_name', key)"
              v-text="getValidationError('contact_name', key)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="contact_email" class="block text-base lg:text-lg">Contact person’s email</label>
            <input type="text" name="contact_email" id="contact_email"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder=" " @input="setContacts(key, 'contact_email', $event.target.value)" :value="form['contacts'][key]['contact_email']
                ? form['contacts'][key]['contact_email']
                : ''
                " />
            <!-- <p class="mt-2 text-base text-primary" v-if="validationErros.has(`contact_email`)"
                  v-text="validationErros.get(`contact_email`)"></p> -->
            <p class="mt-2 text-base text-primary" v-if="getValidationError('contact_email', key)"
              v-text="getValidationError('contact_email', key)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="contact_phone" class="block text-base lg:text-lg">Contact person’s phone</label>
            <input type="text" name="contact_phone" id="contact_phone"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder="With area code" @input="setContacts(key, 'contact_phone', $event.target.value)" :value="form['contacts'][key]['contact_phone']
                ? form['contacts'][key]['contact_phone']
                : ''
                " @keypress="restrictToNumbers($event, 15)" />
            <!-- <p class="mt-2 text-base text-primary" v-if="validationErros.has(`contact_phone`)"
                  v-text="validationErros.get(`contact_phone`)"></p> -->
            <p class="mt-2 text-base text-primary" v-if="getValidationError('contact_phone', key)"
              v-text="getValidationError('contact_phone', key)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label :for="`contact-image-[${index}]`" class="block text-base lg:text-lg">Contact person’s photo</label>
            <input type="file" name="contact-image" :id="`contact-image-[${key}]`"
              class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-[3px] rounded border-gray-300"
              @change="uploadImage($event, key)" />
            <img v-if="contact.contact_photo" :src="contact.contact_photo" style="height: 100px; width: 100px" />
            <!-- <p class="mt-2 text-base text-primary" v-if="validationErros.has(`contact_photo`)"
                  v-text="validationErros.get(`contact_photo`)"></p> -->
            <p class="mt-2 text-base text-primary" v-if="getValidationError('contact_photo', key)"
              v-text="getValidationError('contact_photo', key)"></p>
          </div>

        </div>
      </div>
      <button type="button" @click="addMoreContacts" class="can-edu-btn-fill mb-2">
        Add another contact
      </button>

      <br />
      <button type="submit" class="can-edu-btn-fill mb-2">Create event</button>
    </form>
  </div>
  <transition name="slide">
    <div id="defaultModal" tabindex="-1" aria-hidden="true"
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
            <p class="text-center can-edu-p mt-2">
              {{
                popupMsg
              }} </p>
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
  <transition name="slide">
        <div id="defaultLockModal" tabindex="-1"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showLockPopUpModal">
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="toggleLockPopUpModal">
                        <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                      <p class="text-center can-edu-p">
                        You've reached your package limit. Upgrade your package to continue creating more
                </p>
                        <div class="flex justify-center">
                        <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                            @click="toggleLockPopUpModal">
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
//   import Error from "./Error.vue";
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
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      // isFormEdit: (state) => state.events.isFormEdit,
      form: (state) => state.events.form,
      validationErros: (state) => state.events.validationErros,
      languages: (state) => state.languages.languages,
    }),
  },
  mounted() {
    console.log('Logged in customer prop:', this.logged_in_customer);
    console.log('Customer ID:', this.lang);
  },
  props: ["events_access","school_id", "slug", "logged_in_customer", "logged_in_user_type_create", "is_package_amount_paid_create", "lang"],
  // props: {
  //     logged_in_customer: {
  //         type: Object,
  //         required: true
  //     },
  //     school_id: {
  //         type: String,
  //         required: true
  //     },
  //     logged_in_user_type_create: {
  //         type: String,
  //         required: true
  //     },
  //     is_package_amount_paid_create: {
  //         type: String,
  //         required: true
  //     }
  // },
  data() {
    return {
      showLockPopUpModal: false,
      lang:'',
      showPopUpModal: false,
      popupMsg: '',
      startDate: "",
      endDate: "",
      validationErrors: new Map(),
      activeTab: null,
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
  watch: {
    startDate(newValue) {
      if (newValue) {
        let parts = newValue.split("-");
        if (parts[0].length > 4) {
          parts[0] = parts[0].slice(0, 4);
          if (this.startDate !== parts.join("-")) {
            this.startDate = parts.join("-");
          }
        }
      }
    },
    endDate(newValue) {
      if (newValue) {
        let parts = newValue.split("-");
        if (parts[0].length > 4) {
          parts[0] = parts[0].slice(0, 4);
          if (this.endDate !== parts.join("-")) {
            this.endDate = parts.join("-");
          }
        }
      }
    },
  },
  methods: {
    toggleLockPopUpModal() {
            this.showLockPopUpModal = !this.showLockPopUpModal;
            if (!this.showLockPopUpModal) {
                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/open-house";
            }
        },
    togglePopUpModal() {
      this.showPopUpModal = !this.showPopUpModal;
      if (!this.showPopUpModal) {
        // window.location.href = "/" + this.lang + "/our-profile/our-events";

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
          // window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/events";

        }
      }
    },
    restrictToNumbers(event, allowedLength = 15) {
    const keyCode = event.which ? event.which : event.keyCode;
    const inputChar = String.fromCharCode(keyCode);


    // Prevent spaces
    if (/\s/.test(inputChar)) {
        event.preventDefault();
        return;
    }

   
},
    getValidationError(baseField, key) {
      const baseError = this.validationErros.get(baseField);
      const nestedError = this.validationErros.get(`${baseField}.${key}`);

      return baseError || nestedError;
    },
    uploadImage(e, index) {
      var file = new FormData();
      file.append("file", e.target.files[0]);
      axios.post("/api/web/media/image_again_upload", file, {headers: {
        'X-Requested-With': 'XMLHttpRequest',
    }}).then((res) => {
        if (res?.data?.status == "Error") {
            if (!errorOccurred) {
              helper.swalErrorMessage(res?.data?.message);
            }
            errorOccurred = true;
            return;
          }
        this.setContacts(index, 'contact_photo', res?.data);
      }).catch((error) => {
        helper.swalErrorMessage(
          "An error occurred while uploading the image"
        );
        errorOccurred = true;
      });
    },
    setContacts(index, key, value) {
      this.$store.commit("events/setContacts", {
        index,
        key,
        value,
      });
      if (this.validationErros.has(`${key}.${index}`)) {
        this.validationErros.clear(`${key}.${index}`);
      } else if (this.validationErros.has(key)) {
        this.validationErros.clear(key);
      }
      let contact_name = this.form?.contacts.map(
        (contact) => contact.contact_name
      );
      let contact_email = this.form?.contacts.map(
        (contact) => contact.contact_email
      );
      let contact_phone = this.form?.contacts.map(
        (contact) => contact.contact_phone
      );
      let contact_photo = this.form?.contacts.map(
        (contact) => contact.contact_photo
      );
      let contact_title = this.form?.contacts.map(
        (contact) => contact.contact_title
      );
      this.$store.commit("events/setState", {
        key: "contact_name",
        value: contact_name,
      });

      this.$store.commit("events/setState", {
        key: "contact_email",
        value: contact_email,
      });

      this.$store.commit("events/setState", {
        key: "contact_phone",
        value: contact_phone,
      });

      this.$store.commit("events/setState", {
        key: "contact_photo",
        value: contact_photo,
      });

      this.$store.commit("events/setState", {
        key: "contact_title",
        value: contact_title,
      });
    },
    removeFromContacts(index) {
      this.$store.commit("events/removeFromContacts", index);
    },
    addMoreContacts() {
      this.$store.commit("events/addToContacts");
    },
    removeImage(index) {
      this.$store.commit("events/removeImage", index);
    },
    handleImageArray(e) {
      const selectedFiles = Array.from(e.target.files);
      const totalFiles = this.form.images.length + selectedFiles.length;

      let _this = this;
      let errorOccurred = false;

      for (var i = 0; i < e.target.files.length; i++) {
        if (errorOccurred) break;
        var file = new FormData();
        file.append("file", e.target.files[i]);
        file.append("total_files", totalFiles);
        file.append("source", "event");
        axios
          .post("/api/web/image_again_upload", file, {headers: {
            'X-Requested-With': 'XMLHttpRequest',
           }})
          .then((res) => {
            if (res?.data?.status == "Error") {
              if (!errorOccurred) {
                helper.swalErrorMessage(res.data.message);
              }
              errorOccurred = true;
              return;
            }
            _this.$store.commit("events/setImages", res?.data);
          })
          .catch((error) => {
            helper.swalErrorMessage(
              "An error occurred while uploading the image"
            );
            errorOccurred = true;
          });
      }
    },
    // handleInput(value, key) {
    //      if (key === "start_date") {
    //   if (value) {
    //     let parts = value.split("-");
    //     if (parts[0].length > 4) {
    //       parts[0] = parts[0].slice(0, 4); 
    //       value = parts.join("-");
    //     }
    //   }
    // }
    //   this.$store.commit("events/setState", { key, value });
    // },
    handleInput(value, key) {
      this.$store.commit("events/setState", { key, value });
      if (this.validationErros.has(key) && value !== "") {
        this.validationErros.clear(key);
      }
    },
    handleSelectionChange(language, key) {
      const editorContent = tinymce.get(`${key}_${language.id}`)?.getContent() || "";
      this.$store.commit(`events/updateState`, {
        value: editorContent,
        id: language.id,
        key: key,
      });
      const errorKey = `description.description_${language.id}`;
      if (this.validationErros.has(errorKey) && editorContent.trim() !== "") {
        this.validationErros.clear(errorKey);
      }
    },
    handleMultipleInput(key, value, language) {
      this.$store.commit("events/updateState", {
        value: value.trim(),
        id: language.id,
        key,
      });
      const errorKey = `${key}.${key}_${language.id}`;
      if (this.validationErros.has(errorKey) && value.trim() !== "") {
        this.validationErros.clear(errorKey);
      }
    },
    addUpdateForm() {
      // this.$store
      //   .dispatch("events/addUpdateForm")
      //   .then(() => this.$router.push({ name: "admin.events.index" }));
      this.$store.dispatch("events/addUpdateForm").then((res) => {
        this.showPopUpModal = true;
        this.popupMsg = res.data.message;
      }).catch((error) => {
        console.log('errorerrorerrorerrorerrorerror',error)
        if (error.response && error.response.data.errors) {
          this.focusOnFirstErrorInput(error.response.data.errors);
        }
        
        if (error.response && !error.response.status == 422) {
          this.popupMsg =  error.response.data.message;
          this.showPopUpModal = true;
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
    changeLanguageTab(language) {
      this.lang= language.abbreviation
      this.activeTab = language.id;
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
            formData.append("type", "featured_image");

            const request = new XMLHttpRequest();
            request.open(
              "POST",
              `${process.env.MIX_WEB_API_URL}media/process`
            );
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
            request.open(
              "POST",
              `${process.env.MIX_WEB_API_URL}media/revert`
            );
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
      this.$store.commit("events/setForm", {
        featured_image: file.serverId,
        id: this.$route?.params?.id || "",
      });
      if (this.validationErros.has("featured_image")) {
        this.validationErros.clear("featured_image");
      }
    },
    handleFilePondFlagIconRemoveFile(error, file) {
      this.$store.commit("events/setForm", {
        featured_image: null,
      });
      if (this.validationErros.has("featured_image")) {
        this.validationErros.clear("featured_image");
      }
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
        setOptions({ files: files });
      };
      image.src = url;
    },
  },
  created() {
    setOptions({ files: [] });
    console.log(this.logged_in_customer, 'this.logged_in_customer');
    console.log('Updated State value:', this.value);
    console.log('Updated State:', this.$store.state.events.form);
    console.log(this.$store.state.events.form.customer_id, 'customer_id after commit');
    this.$store.commit("events/resetForm");


    this.$store.commit("events/setForm", {
      key: "customer_id",
      value: this.logged_in_customer.id,
    });
    this.$store.commit("events/setForm", {
      key: "school_id",
      value: this.school_id,
    });
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        let data = res.data.data;
        let obj = {};
        data.map((res) => {
          obj["title_" + res.id] = "";
        });
        this.$store.commit("events/setState", {
          key: "title",
          value: obj,
        });
        data.map((res) => {
          obj["short_description_" + res.id] = "";
        });
        this.$store.commit("events/setState", {
          key: "short_description",
          value: obj,
        });

        data.map((res) => {
          obj["description_" + res.id] = "";
        });
        this.$store.commit("events/setState", {
          key: "description",
          value: obj,
        });
        //   if (this.$route.params.id) {
        //     this.fetchEvents();
        //   } else {
        //     this.isDataLoaded = 1;
        //   }
      });
      this.showLockPopUpModal=!JSON.parse(this.events_access);
  },
  components: {
    FilePond,
    //   ListErrors,
    editor: Editor,
  },
  beforeUnmount() {
    document.removeEventListener("click", this.handleClickOutsidePopup);

  },
  mounted() {
    document.addEventListener("click", this.handleClickOutsidePopup);
  }
};
</script>

<style scoped>
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

  .slide-enter-active, .slide-leave-active {
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
  }
  .slide-enter-from, .slide-leave-to {
    transform: translateY(-20px);
    opacity: 0;
  }

</style>