<template>
  <AppLayout>
    <div class="relative shadow-md rounded-lg bg-white py-4">
      <header class="">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h1 class="can-edu-h1">
              {{ isFormEdit ? "Edit" : "Create a new" }} sponsor
            </h1>
            <router-link :to="{ name: 'admin.sponsors.index' }" class="can-edu-btn-fill">
              Back
            </router-link>
          </div>
        </div>
      </header>
      <header class="mt-3">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <p class="block text-base lg:text-lg font-FuturaMdCnBT text-primary">
              Select language(s) of the sponsor
            </p>
          </div>
        </div>
      </header>
      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
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
                validationErros.has(`title.title_${language.id}`)
                  ? 'bg-red-600 text-white hover:text-white'
                  : '',
              ]">{{ language.name }}</a>
            </li>
          </ul>
        </div>

        <div class="w-full md:gap-6 mb-2 grid grid-cols-1 md:grid-col-2" v-for="language in languages"
          :key="language.id" :class="(activeTab == null && language.is_default) ||
            activeTab == language.id
            ? 'block'
            : 'hidden'
            ">
          <div class="relative w-full mt-2">
            <label for="title" class="block text-base lg:text-lg">Sponsor’s name<span class="text-primary">*</span></label>
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
          <div class="relative w-full mt-2">
            <label for="subsidiary" class="block text-base lg:text-lg">Subsidiary</label>
            <input type="text" name="subsidiary" id="subsidiary"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder="If you are sponsoring us through a subsidiary or an entity other than your main business, please enter its name here"
              @input="
                handleMultipleInput('subsidiary', $event.target.value, language)
                " :value="form['subsidiary'] &&
                  form['subsidiary'][`subsidiary_${language.id}`]
                  ? form['subsidiary'][`subsidiary_${language.id}`]
                  : ''
                  " />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`subsidiary.subsidiary_${language.id}`)"
              v-text="validationErros.get(`subsidiary.subsidiary_${language.id}`)
                "></p>
          </div>
          <div class="relative w-full mt-2" v-if="isDataLoaded">
            <label for="short_description" class="text-base text-gray-700 font-semibold">Short Description<span class="text-primary">*</span></label>
            <editor @selectionChange="
              handleSelectionChange(language, 'short_description')
              " :ref="`short_description_${language.id}`" :id="`short_description_${language.id}`" :initial-value="form?.[`short_description`]?.[
                `short_description_${language?.id}`
              ] || ''
                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" 
                placeholder="In 30 words maximum, please tell us about you, why you are sponsoring us, or anything else you want"
                />
            <p class="mt-2 text-base text-primary" v-if="
              validationErros.has(
                `short_description.short_description_${language.id}`
              )
            " v-text="validationErros.get(
              `short_description.short_description_${language.id}`
            )
              "></p>
          </div>
          <div class="relative w-full mt-2" v-if="isDataLoaded">
            <label :for="'editor_' + language.id" class="text-base text-gray-700 font-semibold">Detailed description<span class="text-primary">*</span></label>
            <editor @selectionChange="handleSelectionChange(language, 'description')"
              :ref="`description_${language.id}`" :id="`description_${language.id}`" :initial-value="form?.[`description`]?.[`description_${language?.id}`] || ''
                "
              placeholder="Enter a text of no more than 300    words. Tell us, the audience, the schools, and the students, whatever you want us to know about you, your business, your initiative, your program, and anything else"
              :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />

            <p class="mt-2 text-base text-primary" v-if="
              validationErros.has(`description.description_${language.id}`)
            " v-text="validationErros.get(`description.description_${language.id}`)
              "></p>
          </div>
          <div class="relative w-full mt-2">
            <label for="keywords" class="block text-base lg:text-lg">Keywords</label>
            <input type="text" name="keywords" id="keywords"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder="Enter up to 5 keywords or keyphrases, separated by commas"
              @input="
                handleMultipleInput('keywords', $event.target.value, language)
                " :value="form['keywords'] &&
                  form['keywords'][`keywords_${language.id}`]
                  ? form['keywords'][`keywords_${language.id}`]
                  : ''
                  " />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`keywords.keywords_${language.id}`)"
              v-text="validationErros.get(`keywords.keywords_${language.id}`)
                "></p>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-5">
            <div class="col-span-2">
              <h1 class="can-edu-h1">Services offered by the Sponsor</h1>
              <p>
                Please state the services that you offer to the students, and
                the web page of each service if available
              </p>
            </div>
            <div class="relative w-full mt-2 col-span-2 md:col-span-1">
              <label for="service1_name" class="block text-base lg:text-lg">Service offered - 1</label>
              <input type="text" name="service1_name" id="service1_name"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'service1_name',
                    $event.target.value,
                    language
                  )
                  " :value="form['service1_name'] &&
                    form['service1_name'][`service1_name_${language.id}`]
                    ? form['service1_name'][`service1_name_${language.id}`]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `service1_name.service1_name_${language.id}`
                )
              " v-text="validationErros.get(
                `service1_name.service1_name_${language.id}`
              )
                "></p>
            </div>
            <div class="relative w-full mt-2 col-span-2 md:col-span-1">
              <label for="service1_url" class="block text-base lg:text-lg">Landing page (Web page) of this
                service</label>
              <input type="text" name="service1_url" id="service1_url"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'service1_url',
                    $event.target.value,
                    language
                  )
                  " :value="form['service1_url'] &&
                    form['service1_url'][`service1_url_${language.id}`]
                    ? form['service1_url'][`service1_url_${language.id}`]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `service1_url.service1_url_${language.id}`
                )
              " v-text="validationErros.get(
                `service1_url.service1_url_${language.id}`
              )
                "></p>
            </div>
            <div class="relative w-full mt-2 col-span-2 md:col-span-1">
              <label for="service2_name" class="block text-base lg:text-lg">Service offered - 2</label>
              <input type="text" name="service2_name" id="service2_name"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'service2_name',
                    $event.target.value,
                    language
                  )
                  " :value="form['service2_name'] &&
                    form['service2_name'][`service2_name_${language.id}`]
                    ? form['service2_name'][`service2_name_${language.id}`]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `service2_name.service2_name_${language.id}`
                )
              " v-text="validationErros.get(
                `service2_name.service2_name_${language.id}`
              )
                "></p>
            </div>
            <div class="relative w-full mt-2 col-span-2 md:col-span-1">
              <label for="service2_url" class="block text-base lg:text-lg">Landing page (Web page) of this
                service</label>
              <input type="text" name="service2_url" id="service2_url"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'service2_url',
                    $event.target.value,
                    language
                  )
                  " :value="form['service2_url'] &&
                    form['service2_url'][`service2_url_${language.id}`]
                    ? form['service2_url'][`service2_url_${language.id}`]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `service2_url.service2_url_${language.id}`
                )
              " v-text="validationErros.get(
                `service2_url.service2_url_${language.id}`
              )
                "></p>
            </div>
            <div class="relative w-full mt-2 col-span-2 md:col-span-1">
              <label for="service3_name" class="block text-base lg:text-lg">Service offered - 3</label>
              <input type="text" name="service3_name" id="service3_name"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'service3_name',
                    $event.target.value,
                    language
                  )
                  " :value="form['service3_name'] &&
                    form['service3_name'][`service3_name_${language.id}`]
                    ? form['service3_name'][`service3_name_${language.id}`]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `service3_name.service3_name_${language.id}`
                )
              " v-text="validationErros.get(
                `service3_name.service3_name_${language.id}`
              )
                "></p>
            </div>
            <div class="relative w-full mt-2 col-span-2 md:col-span-1">
              <label for="service3_url" class="block text-base lg:text-lg">Landing page (Web page) of this
                service</label>
              <input type="text" name="service3_url" id="service3_url"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'service3_url',
                    $event.target.value,
                    language
                  )
                  " :value="form['service3_url'] &&
                    form['service3_url'][`service3_url_${language.id}`]
                    ? form['service3_url'][`service3_url_${language.id}`]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `service3_url.service3_url_${language.id}`
                )
              " v-text="validationErros.get(
                `service3_url.service3_url_${language.id}`
              )
                "></p>
            </div>
            <div class="relative w-full mt-2 col-span-2 md:col-span-1">
              <label for="service4_name" class="block text-base lg:text-lg">Service offered - 4</label>
              <input type="text" name="service4_name" id="service4_name"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'service4_name',
                    $event.target.value,
                    language
                  )
                  " :value="form['service4_name'] &&
                    form['service4_name'][`service4_name_${language.id}`]
                    ? form['service4_name'][`service4_name_${language.id}`]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `service4_name.service4_name_${language.id}`
                )
              " v-text="validationErros.get(
                `service4_name.service4_name_${language.id}`
              )
                "></p>
            </div>
            <div class="relative w-full mt-2 col-span-2 md:col-span-1">
              <label for="service4_url" class="block text-base lg:text-lg">Landing page (Web page) of this
                service</label>
              <input type="text" name="service4_url" id="service4_url"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'service4_url',
                    $event.target.value,
                    language
                  )
                  " :value="form['service4_url'] &&
                    form['service4_url'][`service4_url_${language.id}`]
                    ? form['service4_url'][`service4_url_${language.id}`]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `service4_url.service4_url_${language.id}`
                )
              " v-text="validationErros.get(
                `service4_url.service4_url_${language.id}`
              )
                "></p>
            </div>
            <div class="relative w-full mt-2 col-span-2 md:col-span-1">
              <label for="service5_name" class="block text-base lg:text-lg">Service offered - 5</label>
              <input type="text" name="service5_name" id="service5_name"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'service5_name',
                    $event.target.value,
                    language
                  )
                  " :value="form['service5_name'] &&
                    form['service5_name'][`service5_name_${language.id}`]
                    ? form['service5_name'][`service5_name_${language.id}`]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `service5_name.service5_name_${language.id}`
                )
              " v-text="validationErros.get(
                `service5_name.service5_name_${language.id}`
              )
                "></p>
            </div>
            <div class="relative w-full mt-2 col-span-2 md:col-span-1">
              <label for="service5_url" class="block text-base lg:text-lg">Landing page (Web page) of this
                service</label>
              <input type="text" name="service5_url" id="service5_url"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'service5_url',
                    $event.target.value,
                    language
                  )
                  " :value="form['service5_url'] &&
                    form['service5_url'][`service5_url_${language.id}`]
                    ? form['service5_url'][`service5_url_${language.id}`]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `service5_url.service5_url_${language.id}`
                )
              " v-text="validationErros.get(
                `service5_url.service5_url_${language.id}`
              )
                "></p>
            </div>
            <div class="col-span-2">
              <h1 class="can-edu-h1">Contact Information</h1>
            </div>
            <div class="relative w-full mt-2 col-span-2">
              <label for="contact_person_name" class="block text-base lg:text-lg">Contact person’s name and
                title</label>
              <input type="text" name="contact_person_name" id="contact_person_name"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="
                  handleMultipleInput(
                    'contact_person_name',
                    $event.target.value,
                    language
                  )
                  " :value="form['contact_person_name'] &&
                    form['contact_person_name'][
                    `contact_person_name_${language.id}`
                    ]
                    ? form['contact_person_name'][
                    `contact_person_name_${language.id}`
                    ]
                    : ''
                    " />
              <p class="mt-2 text-base text-primary" v-if="
                validationErros.has(
                  `contact_person_name.contact_person_name_${language.id}`
                )
              " v-text="validationErros.get(
                `contact_person_name.contact_person_name_${language.id}`
              )
                "></p>
            </div>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4 md:gap-6">
          <div class="relative z-0 w-full group">
            <label for="contact_person_phone" class="block text-base lg:text-lg">Your phone number<span class="text-primary">*</span></label>
            <input type="text" name="contact_person_phone" id="contact_person_phone"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder="With area code" @input="handleInput($event.target.value, 'contact_person_phone')" :value="form['contact_person_phone'] ? form['contact_person_phone'] : ''
                " @keypress="restrictToNumbers($event, 15)" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`contact_person_phone`)"
              v-text="validationErros.get(`contact_person_phone`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="contact_person_email" class="block text-base lg:text-lg">Your email<span class="text-primary">*</span></label>
            <input type="text" name="contact_person_email" id="contact_person_email"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder="Contact person’s email" @input="handleInput($event.target.value, 'contact_person_email')"
              :value="form['contact_person_email'] ? form['contact_person_email'] : ''
                " />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`contact_person_email`)"
              v-text="validationErros.get(`contact_person_email`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="contact_person_image" class="block text-base lg:text-lg">Contact person image</label>
            <input :key="`contact_person_image`" type="file" :name="`contact_person_image`" :id="`contact_person_image`"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" " @input="handleImage($event, 'contact_person_image')" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`contact_person_image`)"
                v-text="validationErros.get(`contact_person_image`)"></p>

            <img v-if="form['contact_person_image']" :src="form['contact_person_image'] ? form['contact_person_image'] : ''"
                style="height: 100px; width: 100px" />
        </div>
          <div class="relative z-0 w-full group">
            <label for="country" class="block text-base lg:text-lg">Location<span class="text-primary">*</span></label>
            <input type="text" name="country" id="country"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder="city , country" @input="handleInput($event.target.value, 'country')"
              :value="form['country'] ? form['country'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`country`)"
              v-text="validationErros.get(`country`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="url" class="block text-base lg:text-lg">Your website<span class="text-primary">*</span></label>
            <input type="text" name="url" id="url"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder="Enter your main website, or the page you want people to visit about you"
              @input="handleInput($event.target.value, 'url')" :value="form['url'] ? form['url'] : ''" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`url`)"
              v-text="validationErros.get(`url`)"></p>
          </div>

          <div class="relative z-0 w-full group">
            <label for="status" class="block text-base lg:text-lg">Status<span class="text-primary">*</span></label>
            <select
            name="status"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              @input="handleInput($event.target.value, 'status')">
              <option value="">Select</option>
              <option :selected="form['status'] == 'yes'" value="yes">
                Active
              </option>
              <option :selected="form['status'] == 'no'" value="no">
                Inactive
              </option>
            </select>
            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`status`)"
              v-text="validationErros.get(`status`)"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="image" class="block text-base lg:text-lg mb-2">Image, Logo (Allowed file types: png, gif, jpg,
              jpeg)<span class="text-primary">*</span></label>
            <FilePond name="image" class-name="my-pond" accepted-file-types="image/*" @init="handleFilePondInit"
              @processfile="handleFilePondFlagIconProcess" @removefile="handleFilePondFlagIconRemoveFile" />
            <p class="mt-2 text-base text-primary" v-if="validationErros.has('image')"
              v-text="validationErros.get('image')"></p>
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
import ListErrors from "../components/ListErrors.vue";
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      isFormEdit: (state) => state.sponsors.isFormEdit,
      form: (state) => state.sponsors.form,
      validationErros: (state) => state.sponsors.validationErros,
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
        plugins:
          "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code",
        toolbar:
          "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
      },
      tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
    };
  },
  methods: {
    handleImage(e, key) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.$store.commit("sponsors/setState", {
                        key,
                        value: res?.data,
                    });
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
      this.$store.commit("sponsors/setState", {
        key,
        value,
      });
      if (value.trim()) {
        this.validationErros.clear(key);
    }
    },
    handleSelectionChange(language, key) {
      const content = tinymce.get(`${key}_${language.id}`).getContent();
      this.$store.commit(`sponsors/updateState`, {
        value: content,
        id: language.id,
        key: key,
      });
      if (content.trim()) {
        this.validationErros.clear(`${key}.${key}_${language.id}`);
      }
    },
    handleMultipleInput(key, value, language) {
      this.$store.commit("sponsors/updateState", {
        value: value,
        id: language.id,
        key,
      });
      if (value) {
        this.validationErros.clear(`${key}.${key}_${language.id}`);
      }
    },
    addUpdateForm() {
      this.$store.dispatch("sponsors/addUpdateForm").then(() =>
        this.$router.push({
          name: "admin.sponsors.index",
        })
      ).catch((error) => {
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
    fetchSponsors() {
      if (this.$route.params.id) {
        let id = this.$route.params.id;

        this.$store.commit("sponsors/setIsFormEdit", 1);
        this.$store
          .dispatch("sponsors/fetchSponsors", {
            id: id,
            url: `${process.env.MIX_ADMIN_API_URL}sponsors/${id}?withSponsorDetail=1`,
          })
          .then((res) => {
            let keys = [
              "country",
              "image",
              "status",
              "url",
              "contact_person_phone",
              "contact_person_image",
              "contact_person_email",
            ];
            this.$store.commit("sponsors/setState", {
              key: "id",
              value: id,
            });
            for (var i = 0; i < keys.length; i++) {
              this.$store.commit("sponsors/setState", {
                key: keys[i],
                value: res.data.data[keys[i]],
              });
            }

            if (res.data.data.image) {
              this.convertImgUrlToBase64(
                res.data.data.image.full_path,
                `image/${res.data.data.image.extension}`
              );
            }
            let data =
              res.data.data && res.data.data.sponsor_detail
                ? res.data.data.sponsor_detail
                : [];
            let obj = {};
            data.map((res) => {
              obj["title_" + res.language_id] = res.title;
            });
            this.$store.commit("sponsors/setState", {
              key: "title",
              value: obj,
            });

            data.map((res) => {
              obj["subsidiary_" + res.language_id] = res.subsidiary;
            });
            this.$store.commit("sponsors/setState", {
              key: "subsidiary",
              value: obj,
            });
            data.map((res) => {
              obj["keywords_" + res.language_id] = res.keywords;
            });
            this.$store.commit("sponsors/setState", {
              key: "keywords",
              value: obj,
            });
            data.map((res) => {
              obj["contact_person_name_" + res.language_id] =
                res.contact_person_name;
            });
            this.$store.commit("sponsors/setState", {
              key: "contact_person_name",
              value: obj,
            });
            data.map((res) => {
              obj["short_description_" + res.language_id] =
                res.short_description;
            });
            this.$store.commit("sponsors/setState", {
              key: "short_description",
              value: obj,
            });
            data.map((res) => {
              obj["description_" + res.language_id] = res.description;
            });
            this.$store.commit("sponsors/setState", {
              key: "description",
              value: obj,
            });
            data.map((res) => {
              obj["service1_name_" + res.language_id] = res.service1_name;
            });
            this.$store.commit("sponsors/setState", {
              key: "service1_name",
              value: obj,
            });
            data.map((res) => {
              obj["service1_url_" + res.language_id] = res.service1_url;
            });
            this.$store.commit("sponsors/setState", {
              key: "service1_url",
              value: obj,
            });
            data.map((res) => {
              obj["service2_name_" + res.language_id] = res.service2_name;
            });
            this.$store.commit("sponsors/setState", {
              key: "service2_name",
              value: obj,
            });
            data.map((res) => {
              obj["service2_url_" + res.language_id] = res.service2_url;
            });
            this.$store.commit("sponsors/setState", {
              key: "service2_url",
              value: obj,
            });
            data.map((res) => {
              obj["service3_name_" + res.language_id] = res.service3_name;
            });
            this.$store.commit("sponsors/setState", {
              key: "service3_name",
              value: obj,
            });
            data.map((res) => {
              obj["service3_url_" + res.language_id] = res.service3_url;
            });
            this.$store.commit("sponsors/setState", {
              key: "service3_url",
              value: obj,
            });
            data.map((res) => {
              obj["service4_name_" + res.language_id] = res.service4_name;
            });
            this.$store.commit("sponsors/setState", {
              key: "service4_name",
              value: obj,
            });
            data.map((res) => {
              obj["service4_url_" + res.language_id] = res.service4_url;
            });
            this.$store.commit("sponsors/setState", {
              key: "service4_url",
              value: obj,
            });
            data.map((res) => {
              obj["service5_name_" + res.language_id] = res.service5_name;
            });
            this.$store.commit("sponsors/setState", {
              key: "service5_name",
              value: obj,
            });
            data.map((res) => {
              obj["service5_url_" + res.language_id] = res.service5_url;
            });
            this.$store.commit("sponsors/setState", {
              key: "service5_url",
              value: obj,
            });
            this.isDataLoaded = 1;
          });
      } else {
        this.isDataLoaded = 1;
      }
    },
    handleFilePondInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_ADMIN_API_URL,
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
            request.open(
              "POST",
              `${process.env.MIX_ADMIN_API_URL}media/process`
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
              `${process.env.MIX_ADMIN_API_URL}media/revert`
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
      this.$store.commit("sponsors/setForm", {
        image: file.serverId,
        id: this.$route.params.id ? this.$route.params.id : "",
      });
      if (this.validationErros.has("image")) {
        this.validationErros.clear("image");
      }
    },
    handleFilePondFlagIconRemoveFile(error, file) {
      this.$store.commit("sponsors/setForm", {
        image: null,
      });
      if (this.validationErros.has("image")) {
        this.validationErros.clear("image");
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
        setOptions({
          files: files,
        });
      };
      image.src = url;
    },
  },
  created() {
    setOptions({
      files: [],
    });
    this.$store.commit("sponsors/resetForm");
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        let data = res.data.data;
        let obj = {};
        data.map((res) => {
          obj["title_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "title",
          value: obj,
        });
        data.map((res) => {
          obj["subsidiary_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "subsidiary",
          value: obj,
        });
        data.map((res) => {
          obj["keywords_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "keywords",
          value: obj,
        });
        data.map((res) => {
          obj["contact_person_name_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "contact_person_name",
          value: obj,
        });
        data.map((res) => {
          obj["short_description_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "short_description",
          value: obj,
        });
        data.map((res) => {
          obj["description_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "description",
          value: obj,
        });
        data.map((res) => {
          obj["service1_name_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "service1_name",
          value: obj,
        });
        data.map((res) => {
          obj["service1_url_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "service1_url",
          value: obj,
        });
        data.map((res) => {
          obj["service2_name_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "service2_name",
          value: obj,
        });
        data.map((res) => {
          obj["service2_url_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "service2_url",
          value: obj,
        });
        data.map((res) => {
          obj["service3_name_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "service3_name",
          value: obj,
        });
        data.map((res) => {
          obj["service3_url_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "service3_url",
          value: obj,
        });
        data.map((res) => {
          obj["service4_name_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "service4_name",
          value: obj,
        });
        data.map((res) => {
          obj["service4_url_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "service4_url",
          value: obj,
        });
        data.map((res) => {
          obj["service5_name_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "service5_name",
          value: obj,
        });
        data.map((res) => {
          obj["service5_url_" + res.id] = "";
        });
        this.$store.commit("sponsors/setState", {
          key: "service5_url",
          value: obj,
        });
        this.fetchSponsors();
      });
  },
  components: {
    editor: Editor,
    FilePond,
    ListErrors,
  },
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
</style>
