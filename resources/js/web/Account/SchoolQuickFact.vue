<template>
  <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full">
    <div class="modal-content py-6 text-left px-6">
      <div class="flex justify-between items-center pb-3">
        <h2 class="can-school-h2 text-primary">School quick facts</h2>
      </div>
      <div class="">
        <div class="text-sm font-medium text-center text-gray-500 dark:text-gray-400 dark:border-gray-700">
          <h3 class="text-left">Language</h3>
          <p class="text-left text-base font-normal text-gray-700">Select the languages under which you want your school
            profile to appear</p>
          <ul class="flex gap-2 flex-wrap my-4">
            <li class="mr-2" v-for="language in languages" :key="language.code">
              <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                activeTab != null && activeTab == language.language_code
                  ? 'text-white bg-primary active'
                  : '',
                errors.has(`title_1.title_1_${language.code}`)
                  ? 'bg-red-600 text-white hover:text-white'
                  : '',
              ]">{{ getLanguageName(language.language_code) }}</a>
            </li>
          </ul>
        </div>
        <div v-for="language in languages" :key="language.language_code"
          :class="activeTab == language.language_code ? 'block' : 'hidden'">
          <div class="w-full mt-2 relative">
            <label class="block text-base lg:text-lg">Page main title</label>
            <input type="text" placeholder="" name="title_1"
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_1', language)" :value="form['title_1'] &&
                  form['title_1'][`title_1_${language.language_code}`]
                  ? form['title_1'][`title_1_${language.language_code}`]
                  : ''
                " />
            <error :fieldName="`title_1.title_1_${language.language_code}`" :validationErros="errors" />
          </div>
          <div class="w-full mt-2 relative" v-if="isDataLoaded">
            <label class="block text-base lg:text-lg mb-2">Page main text</label>
            <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`title_1_paragraph_${language.language_code}`"
                    ></div> -->
            <editor @selectionChange="
              handleSelectionChange(language, 'title_1_paragraph')
              " :ref="`title_1_paragraph_${language.language_code}`"
              :id="`title_1_paragraph_${language.language_code}`" :initial-value="form[`title_1_paragraph`][
                `title_1_paragraph_${language?.language_code}`
                ]
                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
            <!-- <textarea
                        type="text"
                        placeholder="Title 1 paragraph"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="
                            handleInput($event, 'title_1_paragraph', language)
                        "
                        >{{
                            form["title_1_paragraph"] &&
                            form["title_1_paragraph"][
                                `title_1_paragraph_${language.language_code}`
                            ]
                                ? form["title_1_paragraph"][
                                      `title_1_paragraph_${language.language_code}`
                                  ]
                                : ""
                        }}</textarea
                    > -->
            <error :fieldName="`title_1_paragraph.title_1_paragraph_${language.language_code}`"
              :validationErros="errors" />
          </div>
          <div class="w-full mt-2 relative">
            <label class="block text-base lg:text-lg">Title 2</label>
            <input type="text" placeholder="" name="title_2"
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_2', language)" :value="form['title_2'] &&
                  form['title_2'][`title_2_${language.language_code}`]
                  ? form['title_2'][`title_2_${language.language_code}`]
                  : ''
                " />
            <error :fieldName="`title_2.title_2_${language.language_code}`" :validationErros="errors" />
          </div>
        </div>
        <div class="relative mt-2">
          <label class="block text-base lg:text-lg mt-1">Image</label>
          <p class="text-base mb-1">
            (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
          </p>
          <input type="file" name="title_2_image"
            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @change="handleImage($event)" />
          <error :fieldName="`title_2_image`" :validationErros="errors" />
          <div v-if="form['title_2_image']" class="w-40 h-40 rounded bg-gray-50 border mt-4">
            <img :src="form?.title_2_image ? form.title_2_image : ''" class="w-full h-full object-contain" />
          </div>
        </div>
        <div v-for="language in languages" :key="language.language_code"
          :class="activeTab == language.language_code ? 'block' : 'hidden'">
          <div class="w-full mt-2 relative">
            <label class="block text-base lg:text-lg">Title 2 Subtitle</label>
            <input type="text" placeholder="" name="title_2_subtitle"
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_2_subtitle', language)" :value="form['title_2_subtitle'] &&
                  form['title_2_subtitle'][
                  `title_2_subtitle_${language.language_code}`
                  ]
                  ? form['title_2_subtitle'][
                  `title_2_subtitle_${language.language_code}`
                  ]
                  : ''
                " />
            <error :fieldName="`title_2_subtitle.title_2_subtitle_${language.language_code}`"
              :validationErros="errors" />
          </div>

          <div class="w-full mt-2 relative" v-if="isDataLoaded">
            <label class="block text-base lg:text-lg">Title 2 Paragraph</label>
            <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`title_2_paragraph_${language.language_code}`"
                    ></div> -->
            <editor @selectionChange="
              handleSelectionChange(language, 'title_2_paragraph')
              " :ref="`title_2_paragraph_${language.language_code}`"
              :id="`title_2_paragraph_${language.language_code}`" :initial-value="form[`title_2_paragraph`][
                `title_2_paragraph_${language?.language_code}`
                ]
                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
            <error :fieldName="`title_2_paragraph.title_2_paragraph_${language.language_code}`"
              :validationErros="errors" />
          </div>

          <div class="w-full mt-2 relative">
            <label class="block text-base lg:text-lg">Title 2 button title</label>
            <input type="text" placeholder="" name="title_2_button_title"
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_2_button_title', language)" :value="form['title_2_button_title'] &&
                  form['title_2_button_title'][
                  `title_2_button_title_${language.language_code}`
                  ]
                  ? form['title_2_button_title'][
                  `title_2_button_title_${language.language_code}`
                  ]
                  : ''
                " />
            <error :fieldName="`title_2_button_title.title_2_button_title_${language.language_code}`"
              :validationErros="errors" />
          </div>
          <div class="w-full mt-2 relative">
            <label for="" class="block text-base lg:text-lg">Title 2 button link</label>
            <input type="text" placeholder="" name="title_2_button_link"
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_2_button_link', '')" :value="form['title_2_button_link'] ? form['title_2_button_link'] : ''
                " />
            <error :fieldName="`title_2_button_link`" :validationErros="errors" />
          </div>
          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >School quick facts button title</label
            >
            <input
              type="text"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_quick_facts_apply_button_title', '')"
              :value="
                form['school_quick_facts_apply_button_title'] ? form['school_quick_facts_apply_button_title'] : ''
              "
            />
            <error
              :fieldName="`school_quick_facts_apply_button_title`"
              :validationErros="errors"
            />
          </div>
          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >School quick facts button link</label
            >
            <input
              type="text"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_quick_facts_apply_button_link', '')"
              :value="
                form['school_quick_facts_apply_button_link'] ? form['school_quick_facts_apply_button_link'] : ''
              "
            />
            <error
              :fieldName="`school_quick_facts_apply_button_link`"
              :validationErros="errors"
            />
          </div>

          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >Good to go button title</label
            >
            <input
              type="text"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_quick_facts_blue_bar_button_title', '')"
              :value="
                form['school_quick_facts_blue_bar_button_title'] ? form['school_quick_facts_blue_bar_button_title'] : ''
              "
            />
            <error
              :fieldName="`school_quick_facts_blue_bar_button_title`"
              :validationErros="errors"
            />
          </div>
          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >Good to go button link</label
            >
            <input
              type="text"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_quick_facts_blue_bar_button_link', '')"
              :value="
                form['school_quick_facts_blue_bar_button_link'] ? form['school_quick_facts_blue_bar_button_link'] : ''
              "
            />
            <error
              :fieldName="`school_quick_facts_blue_bar_button_link`"
              :validationErros="errors"
            />
          </div>

          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >Let's apply button title</label
            >
            <input
              type="text"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_quick_facts_red_bar_button_title', '')"
              :value="
                form['school_quick_facts_red_bar_button_title'] ? form['school_quick_facts_red_bar_button_title'] : ''
              "
            />
            <error
              :fieldName="`school_quick_facts_red_bar_button_title`"
              :validationErros="errors"
            />
          </div>
          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >Let's apply button link</label
            >
            <input
              type="text"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_quick_facts_red_bar_button_link', '')"
              :value="
                form['school_quick_facts_red_bar_button_link'] ? form['school_quick_facts_red_bar_button_link'] : ''
              "
            />
            <error
              :fieldName="`school_quick_facts_red_bar_button_link`"
              :validationErros="errors"
            />
          </div>

        </div>
        <div class="mb-4 mt-10">
          <p>Select up to 12 “Featured” Quick Facts; they will appear on your school profile. You can change them in the
            future</p>
        </div>
        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4" v-for="(quickFact, index) in quickFacts"
          :key="index">
          <div class="w-full mt-2 relative">
            <div class="flex items-center justify-between">
              <label for="" class="block text-base lg:text-lg">{{ transformString(labels[quickFact]) }}</label>
              <div class="flex items-center gap-2">
                <input :id="quickFact" type="checkbox" placeholder=""
                :disabled="isMaxSelected && !form?.[`${quickFact}_featured`]"
                @input="
                  handleFeaturedInput(
                    $event.target.checked,
                    `${quickFact}_featured`
                  )
                  " :checked="form?.[`${quickFact}_featured`] &&
                      form?.[`${quickFact}_featured`] === true
                      ? true
                      : false
                    " />
                <label :for="quickFact">Featured</label>
              </div>
            </div>
            <template v-if="quickFact == 'start_date'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'fall'" value="fall">
                  Fall
                </option>
                <option :selected="form[quickFact] == 'winter'" value="winter">
                  Winter
                </option>
                <option :selected="form[quickFact] == 'summar'" value="summar">
                  Summar
                </option>
              </select>
            </template>
            <!-- <template v-else-if="quickFact == 'field_of_study'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option v-for="(program, i) in programs" :key="i" :selected="form[quickFact] == program?.id"
                  :value="program?.id">
                  {{
                    program?.program_detail?.length > 0
                      ? program?.program_detail[0]?.name
                      : ""
                  }}
                </option>
              </select>
            </template> -->
            <template v-else-if="quickFact == 'program_type_undergreduates'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'co_op'" value="co_op">
                  Co-op
                </option>
                <option :selected="form[quickFact] == 'honours'" value="honours">
                  Honours
                </option>
                <option :selected="form[quickFact] == 'interdisciplinary'" value="interdisciplinary">
                  Interdisciplinary
                </option>
                <option :selected="form[quickFact] == 'major'" value="major">
                  Major
                </option>
                <option :selected="form[quickFact] == 'minor'" value="minor">
                  Minor
                </option>
                <option :selected="form[quickFact] == 'spcialization'" value="spcialization">
                  Spacialization
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'program_type_greduates'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'thesis'" value="thesis">
                  Thesis
                </option>
                <option :selected="form[quickFact] == 'non_thesis'" value="non_thesis">
                  Non-thesis
                </option>
                <option :selected="form[quickFact] == 'co_op'" value="co_op">
                  Co-op
                </option>
                <option :selected="form[quickFact] == 'internship'" value="internship">
                  Internship
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'years_before_elegible_for_pr'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == '1'" value="1">1</option>
                <option :selected="form[quickFact] == '2'" value="2">2</option>
                <option :selected="form[quickFact] == '3'" value="3">3</option>
                <option :selected="form[quickFact] == '4'" value="4">4</option>
                <option :selected="form[quickFact] == '5'" value="5">5</option>
              </select>
            </template>
            <template v-else-if="quickFact == 'work_off_campus'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
              </select>
            </template>
            <template v-else-if="
              quickFact == 'service_and_guidance_to_new_arrivals_in_canada'
            ">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'service_and_guidance_new_students'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'class_size_masters'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == '10'" value="10">
                  10
                </option>
                <option :selected="form[quickFact] == '20'" value="20">
                  20
                </option>
                <option :selected="form[quickFact] == '30'" value="30">
                  30
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'class_size_undergraduate'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == '10'" value="10">
                  10
                </option>
                <option :selected="form[quickFact] == '20'" value="20">
                  20
                </option>
                <option :selected="form[quickFact] == '30'" value="30">
                  30
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'employeement_rates'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == '90'" value="90">
                  Above 90%
                </option>
                <option :selected="form[quickFact] == '80'" value="80">
                  Above 80%
                </option>
                <option :selected="form[quickFact] == '70'" value="70">
                  Above 70%
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'pathway_programs'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'graduates'" value="graduates">
                  Graduate
                </option>
                <option :selected="form[quickFact] == 'undergraduates'" value="undergraduates">
                  UnderGraduates
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'career_planing'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'immigration_office_on_campus'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="
              quickFact == 'elementary_school_for_students_with_kids'
            ">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'school_owned'" value="school_owned">
                  School-owned
                </option>
                <option :selected="form[quickFact] == 'school_managed'" value="school_managed">
                  School-managed
                </option>
                <option :selected="form[quickFact] == 'private_neighbor'" value="private_nearby">
                  Private, nearby
                </option>
                <option :selected="form[quickFact] == 'public_neighbor'" value="public_nearby">
                  Public, nearby
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'daycare_for_students_with_kids'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option
                    :selected="form[quickFact] == 'all'"
                    value="all"
                  >
                    All
                  </option>
                  <option
                    :selected="form[quickFact] == 'school_owned'"
                    value="school_owned"
                  >
                    School-owned
                  </option>
                  <option
                    :selected="form[quickFact] == 'school_managed'"
                    value="school_managed"
                  >
                    School-managed
                  </option>
                  <option
                    :selected="form[quickFact] == 'private_nearby'"
                    value="private_nearby"
                  >
                    Private, nearby
                  </option>
                  <option
                    :selected="form[quickFact] == 'public_nearby'"
                    value="public_nearby"
                  >
                    Public, nearby
                  </option>
              </select>
            </template>
            <!-- <template v-else-if="quickFact == 'degree_modifier'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'apprenticeship'" value="apprenticeship">
                  Apprenticeship
                </option>
                <option :selected="form[quickFact] == 'co_op'" value="co_op">
                  Co-op
                </option>
                <option :selected="form[quickFact] == 'distance'" value="distance">
                  Distance
                </option>
                <option :selected="form[quickFact] == 'honor'" value="honor">
                  Honor
                </option>
                <option :selected="form[quickFact] == 'online'" value="online">
                  Online
                </option>
                <option :selected="form[quickFact] == 'university_transfer'" value="university_transfer">
                  University Transfer
                </option>
              </select>
            </template> -->
            <template v-else-if="quickFact == 'exchange_program'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'research_and_dissertaion'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="
              quickFact == 'financial_aid_programs_for_international_students'
            ">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'grants'" value="grants">
                  Bursaries / grants
                </option>
                <option :selected="form[quickFact] == 'scholarships'" value="scholarships">
                  Scholarships
                </option>
                <option :selected="form[quickFact] == 'student_loans_co_signer'" value="student_loans_co_signer">
                  Student loans co-signer
                </option>
                <option :selected="form[quickFact] == 'student_loans_without_co_signer'
                  " value="student_loans_without_co_signer">
                  Student loans without co-signer
                </option>
                <option :selected="form[quickFact] == 'none'
                  " value="none">
                  None
                </option>
              </select>
            </template>
            <template v-else-if="
              quickFact == 'financial_aid_programs_for_province_students'
            ">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'grants'" value="grants">
                  Bursaries / grants
                </option>
                <option :selected="form[quickFact] == 'scholarships'" value="scholarships">
                  Scholarships
                </option>
                <option :selected="form[quickFact] == 'student_loans'" value="student_loans">
                  Student loans
                </option>
              </select>
            </template>
            <template v-else-if="
              quickFact == 'financial_aid_programs_for_province_students'
            ">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'grants'" value="grants">
                  Bursaries / grants
                </option>
                <option :selected="form[quickFact] == 'scholarships'" value="scholarships">
                  Scholarships
                </option>
                <option :selected="form[quickFact] == 'student_loans'" value="student_loans">
                  Student loans
                </option>
              </select>
            </template>
            <template v-else-if="
              quickFact == 'financial_aid_programs_for_domastic_students'
            ">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'grants'" value="grants">
                  Bursaries / grants
                </option>
                <option :selected="form[quickFact] == 'scholarships'" value="scholarships">
                  Scholarships
                </option>
                <option :selected="form[quickFact] == 'student_loans'" value="student_loans">
                  Student loans
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'job_placement'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'co_op_education'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'internship'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no    '" value="no   ">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'work_during_holidays'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'summar'" value="summar">
                  Summer
                </option>
                <option :selected="form[quickFact] == 'winter'" value="winter">
                  Winter
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'work_on_campus'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'accomodation'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'school_owned'" value="school_owned">
                  School-Owned
                </option>
                <option :selected="form[quickFact] == 'school_managed'" value="school_managed">
                  School-Managed
                </option>
                <option :selected="form[quickFact] == 'nearby'" value="nearby">
                  Private, nearby
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'delivery_mode'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'all'" value="all">
                  All
                </option>
                <option :selected="form[quickFact] == 'day'" value="day">
                  Day
                </option>
                <option :selected="form[quickFact] == 'evening'" value="evening">
                  Evening
                </option>
                <option :selected="form[quickFact] == 'day_and_evening'" value="day_and_evening">
                  Day and Evening
                </option>
                <option :selected="form[quickFact] == 'weekends'" value="weekends">
                  Weekends
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'study_method'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'study_method', '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form['study_method'] == 'all'" value="all">
                  All
                </option>
                <option :selected="form['study_method'] == 'fall_time'" value="full_time">
                  Full Time
                </option>
                <option :selected="form['study_method'] == 'part_time'" value="part_time">
                  Part Time
                </option>
                <!-- <option :selected="form['study_method'] == 'continue'" value="continue">
                  Continuing education
                </option> -->
              </select>
            </template>
            <template v-else-if="quickFact == 'conditional_admission'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'conditional_admission'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'minimum_gpa'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == '50'" value="50">
                  Equivalent to 50%
                </option>
                <option :selected="form[quickFact] == '60'" value="60">
                  Equivalent to 60%
                </option>
                <option :selected="form[quickFact] == '70'" value="70">
                  Equivalent to 70%
                </option>
                <option :selected="form[quickFact] == '80'" value="80">
                  Equivalent to 80%
                </option>
                <option :selected="form[quickFact] == '90'" value="90">
                  Equivalent to 90%
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'online_or_distance_education'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option :selected="form[quickFact] == 'yes'" value="yes">
                  Yes
                </option>
                <option :selected="form[quickFact] == 'no'" value="no">
                  No
                </option>
              </select>
            </template>
            <template v-else-if="quickFact == 'school_type'">
              <select
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')">
                <option value="" selected="" disabled="" hidden=""></option>
                <option v-for="(school_type, i) in school_types" :key="i" :selected="form[quickFact] == school_type?.id"
                  :value="school_type?.id">
                  {{
                    school_type?.school_type_detail?.length > 0
                      ? school_type?.school_type_detail[0]?.name
                      : ""
                  }}
                </option>
              </select>
            </template>
            <template v-else>
              <input type="text" :placeholder="transformString(palceholders[quickFact])"
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, quickFact, '')" :value="form[quickFact] ? form[quickFact] : ''" />
            </template>
            <error :fieldName="quickFact" :validationErros="errors" />
          </div>

          <div class="w-full mt-2 relative">
            <label for="" class="block text-base lg:text-lg">Quick facts order</label>

            <input type="number" 
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleOrderInput($event, `${quickFact}_order`, '')" :value="form[`${quickFact}_order`] ? form[`${quickFact}_order`] : ''
                " />
            <error :fieldName="`${quickFact}_order`" :validationErros="errors" />
          </div>
        </div>

        <div class="flex justify-center items-center gap-3 mt-4">
          <div>
            <button class="can-edu-btn-fill" @click="addUpdate">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <transition name="slide">
    <div id="defaultModal" tabindex="-1" aria-hidden="true"
      class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
      v-if="showPopUpModal">
      <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
        ref="elementToDetectClick">
        <div class="relative">
          <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
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
            <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
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
import axios from "axios";
import { mapState } from "vuex";
import Error from "../Error.vue";
export default {
  components: { Error, editor: Editor },
  props: ["logged_in_customer", "school_id", "languages_with_names"],
  computed: {
    ...mapState({
      form: (state) => state.school_quickfacts.form,
      school_quickfacts: (state) => state.school_quickfacts.school_quickfacts,
      is_featured_array: (state) => state.school_quickfacts.is_featured_array,
      errors: (state) => state.school_quickfacts.errors,
      isLoading: (state) => state.school_quickfacts.isLoading,
      languages: (state) => state.school_quickfacts.languages,
      school_types: (state) => state.school_types.school_types,
      programs: (state) => state.programs.programs,
    }),
    selectedQuickFacts() {
    return Object.values(this.$store.state.school_quickfacts.form || {}).filter(
      value => value === true
    ).length;
  },
  isMaxSelected() {
    return this.selectedQuickFacts >= 16;
  },
    parsedLanguages() {
      if (typeof this.languages_with_names === 'string') {
        try {
          return JSON.parse(this.languages_with_names);
        } catch (error) {
          console.error('Error parsing JSON:', error);
          return []; // Return an empty array as a fallback
        }
      }
      return this.languages_with_names; // Return as is if already an array or object
    }
  },
  data() {
    return {
      showPopUpModal: false,
      popupMsg: '',
      activeTab: "en",
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
      quickFacts: [
        "accomodation",
        "career_planing",
        "class_size_masters",
        "class_size_undergraduate",
        "co_op_education",
        "conditional_admission",
        "daycare_for_students_with_kids",
        "delivery_mode",
        "elementary_school_for_students_with_kids",
        "employeement_rates",
        "start_date",
        "exchange_program",
        "fax",
        "financial_aid_programs_for_domastic_students",
        "financial_aid_programs_for_international_students",
        "financial_aid_programs_for_province_students",
        "number_of_graduate_programs",
        "immigration_office_on_campus",
        "internship",
        "job_placement",
        "school_address",
        "minimum_gpa",
        "number_of_students",
        "number_of_undergraduate_students",
        "online_or_distance_education",
        "pathway_programs",
        "telephone",
        "program_type_undergreduates",
        "program_type_greduates",
        "research_and_dissertaion",
        "school_type",
        "study_method",
        "languages",
        "canidian_tuition_fee",
        "international_tuition_fee",
        "number_of_undergraduate_programs",
        "total_undergraduates",
        "entrance_dates",
        "service_and_guidance_to_new_arrivals_in_canada",
        "service_and_guidance_new_students",
        "work_during_holidays",
        "work_off_campus",
        "work_on_campus",
        "years_before_elegible_for_pr",
        "quick_fact_1",
        "quick_fact_2",
        "quick_fact_3",
        "quick_fact_4",
        "quick_fact_5",
        "quick_fact_6",
        "quick_fact_7",
        "quick_fact_8",
        "quick_fact_9",
        "quick_fact_10"

      ],
      labels: {
        "accomodation": "accommodation",
        "career_planing": "career_planning",
        "class_size_masters": "class_size,_graduate",
        "class_size_undergraduate": "class_size,_undergraduate",
        "co_op_education": "co_-_op_education",
        "conditional_admission": "conditional_admission",
        "daycare_for_students_with_kids": "daycare_for_students_with_kids",
        "delivery_mode": "delivery_mode",
        "elementary_school_for_students_with_kids": "elementary_school_for_students_with_kids",
        "employeement_rates": "Employment_rates_after_graduation",
        "start_date": "entrance_date",
        "exchange_program": "exchange_programs",
        "fax": "fax",
        "financial_aid_programs_for_domastic_students": "Financial_aid_programs_for_Canadian_students",
        "financial_aid_programs_for_international_students": "financial_aid_programs_for_international_students",
        "financial_aid_programs_for_province_students": "financial_aid_programs_for_provincial_students",
        "number_of_graduate_programs": "graduate_programs",
        "immigration_office_on_campus": "immigration_office_on-campus",
        "internship": "internship",
        "job_placement": "job_placement",
        "school_address": "location",
        "minimum_gpa": "minimum_GPA",
        "number_of_students": "number_of_students",
        "number_of_undergraduate_students": "number_of_undergraduate_students",
        "online_or_distance_education": "online_or_distance_education",
        "pathway_programs": "pathway_programs",
        "telephone": "phone",
        "program_type_undergreduates": "program_type,_undergraduate",
        "program_type_greduates": "program_types,_graduate",
        "research_and_dissertaion": "research_and_dissertation",
        "school_type": "school_type",
        "study_method": "study_method",
        "languages": "teaching_languages",
        "canidian_tuition_fee": "tuition_-_Canadian",
        "international_tuition_fee": "tuition_-_International",
        "number_of_undergraduate_programs": "undergraduate_programs",
        "total_undergraduates": "undergraduate_students",
        "entrance_dates": "entrance_dates",
        "service_and_guidance_to_new_arrivals_in_canada": "Welcome_&_guidance_to_new_arrivals_in_Canada",
        "service_and_guidance_new_students": "Welcome_&_guidance_to_new_students",
        "work_during_holidays": "work_during_holidays",
        "work_off_campus": "work_off-campus",
        "work_on_campus": "work_on-campus",
        "years_before_elegible_for_pr": "years_to_be_eligible_for_PR",
        "quick_fact_1": "Quick_fact_-_1",
        "quick_fact_2": "Quick_fact_-_2",
        "quick_fact_3": "Quick_fact_-_3",
        "quick_fact_4": "Quick_fact_-_4",
        "quick_fact_5": "Quick_fact_-_5",
        "quick_fact_6": "Quick_fact_-_6",
        "quick_fact_7": "Quick_fact_-_7",
        "quick_fact_8": "Quick_fact_-_8",
        "quick_fact_9": "Quick_fact_-_9",
        "quick_fact_10": "Quick_fact_-_10",
      },
      palceholders: {
        "school_type" : "",
        "languages" : "",
        "total_undergraduates" : "",
        "entrance_dates" : "entrance_dates",
        "canidian_tuition_fee" : "tuition_fee_for_the_canadian;_out-of-province_students",
        "international_tuition_fee" : "",
        "telephone" : "",
        "fax" : "",
        "school_address" : "",
        "start_date" : "",
        "online_or_distance_education" : "",
        "minimum_gpa" : "",
        "conditional_admission" : "",
        "number_of_graduate_programs" : "",
        "number_of_undergraduate_programs" : "",
        "number_of_students" : "",
        "number_of_undergraduate_students" : "Number_of_graduate_students",
        "study_method" : "",
        "delivery_mode" : "",
        "accomodation" : "",
        "work_on_campus" : "",
        "work_during_holidays" : "",
        "internship" : "",
        "co_op_education" : "",
        "job_placement" : "",
        "financial_aid_programs_for_domastic_students" : "",
        "financial_aid_programs_for_province_students" : "",
        "financial_aid_programs_for_international_students" : "",
        "research_and_dissertaion" : "",
        "exchange_program" : "",
        "daycare_for_students_with_kids" : "",
        "elementary_school_for_students_with_kids" : "",
        "immigration_office_on_campus" : "",
        "career_planing" : "",
        "pathway_programs" : "",
        "employeement_rates" : "",
        "class_size_undergraduate" : "",
        "class_size_masters" : "",
        "service_and_guidance_new_students" : "",
        "service_and_guidance_to_new_arrivals_in_canada" : "",
        "work_off_campus" : "",
        "years_before_elegible_for_pr" : "",
        "program_type_greduates" : "",
        "program_type_undergreduates" : "",
        "school_address":"City, Province. Separated by a comma",
        "quick_fact_1": "Add your own Quick Facts",
        "quick_fact_2": "Add your own Quick Facts",
        "quick_fact_3": "Add your own Quick Facts",
        "quick_fact_4": "Add your own Quick Facts",
        "quick_fact_5": "Add your own Quick Facts",
        "quick_fact_6": "Add your own Quick Facts",
        "quick_fact_7": "Add your own Quick Facts",
        "quick_fact_8": "Add your own Quick Facts",
        "quick_fact_9": "Add your own Quick Facts",
        "quick_fact_10": "Add your own Quick Facts",
      },
      
    };
  },
  methods: {
    togglePopUpModal() {
      this.showPopUpModal = !this.showPopUpModal;
      if (!this.showPopUpModal) {
        // window.location.reload();
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
          // window.location.reload();

        }
      }
    },
    getLanguageName(language_code) {
      const languages = this.parsedLanguages; // Use the computed property
      if (Array.isArray(languages)) {
        const language = languages.find(
          (lang) => lang.language_code === language_code
        );
        return language ? language.language_name : language_code;
      }
      return language_code; // Fallback if parsedLanguages is not an array
    },
    transformString(inputString) {
      // Replace underscores with spaces
      let stringWithSpaces = inputString.replace(/_/g, " ");

      // Capitalize the first letter of each word
      let transformedString =
        stringWithSpaces.charAt(0).toUpperCase() +
        stringWithSpaces.slice(1);

      return transformedString;
    },
    handleIsFeatured(val, key) {
      this.$store.commit("school_quickfacts/setIsFeatured", {
        checked: val,
        key,
      });
    },
    closeModal() {
      this.$store.commit("school_quickfacts/setShowModal", 0);
    },
    handleOrderInput(e, key, language) {
      // debugger;
      let data = e.target.value;

      data = data.replace(/[^0-9]/g, '');



      if ( data < 1) {
        data = "";
      } else if (data > 16) {
        data = ""; 
      }

      this.$store.commit("school_quickfacts/setForData", {
        key,
        language: language ? language : "",
        value: data,
      });
    },
    handleInput(e, key, language) {
      const value = e.target.value;
      this.$store.commit("school_quickfacts/setForData", {
        key,
        language: language ? language : "",
        value: value,
      });
      if (value.trim() !== "") {
        const fieldKey = language
          ? `${key}.${key}_${language.language_code}`
          : key;
        this.errors.clear(fieldKey);
      }
    },
    // handleFeaturedInput(value, key) {
    //   this.$store.commit("school_quickfacts/setForData", {
    //     key,
    //     value: value,
    //   });
    // },
    handleFeaturedInput(value, key) {
  if (!value && this.selectedQuickFacts <= 16) {
    this.$store.commit("school_quickfacts/setForData", { key, value });
  } else if (value && this.selectedQuickFacts < 16) {
    this.$store.commit("school_quickfacts/setForData", { key, value });
  }
},
    handleSelectionChange(language, key) {
      this.$store.commit(`school_quickfacts/updateFormData`, {
        value: tinymce.get(`${key}_${language.language_code}`).getContent(),
        id: language.language_code,
        key: key,
      });
    },
    changeLanguageTab(language) {
      this.activeTab = language.language_code;
    },
    addUpdate() {
      this.$store.dispatch("school_quickfacts/addUpdateForm").then((res) => {
        if (res.data.status == "Success") {
          this.$store.commit("school_quickfacts/setLimit", 10);
          this.$store.commit("school_quickfacts/setSortBy", "id");
          this.$store.commit("school_quickfacts/setSortType", "desc");
          this.$store.dispatch("school_quickfacts/fetchSchoolQuickFact");
          this.showPopUpModal = true;
          this.popupMsg = res.data.message;
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

    fetchSchoolQuickFact() {
      this.$store
        .dispatch("school_quickfacts/fetchSchoolQuickFact", {
          url: `${process.env.MIX_WEB_API_URL}school-quick-facts?withSchoolQuickFactDetail=1`,
        })
        .then((res) => {
          let school_keys = ["title_2_image", "title_2_button_link","school_quick_facts_apply_button_title","school_quick_facts_apply_button_link", "school_quick_facts_blue_bar_button_title",
            "school_quick_facts_blue_bar_button_link",
            "school_quick_facts_red_bar_button_link",
            "school_quick_facts_red_bar_button_title",];
          let data = res.data.data ? res.data.data : [];
          for (var i = 0; i < school_keys?.length; i++) {
            this.$store.commit("school_quickfacts/setForData", {
              key: school_keys[i],
              value: data[school_keys[i]] ? data[school_keys[i]] : "",
            });
          }
          if (
            data?.marked_facts != "" &&
            data?.marked_facts != null &&
            data?.marked_facts != undefined
          ) {
            this.$store.commit(
              "school_quickfacts/setIsFeaturedArray",
              data?.marked_facts
            );
          }

          data =
            res.data.data && res.data.data.school_quick_fact_detail
              ? res.data.data.school_quick_fact_detail
              : [];
          let obj = {};
          data.map((res) => {
            obj["title_1_" + res.language_code] = res.title_1;
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_1",
            value: obj,
          });

          // obj = {};
          // data.map((res) => {
          //     obj["title_1_paragraph_" + res.language_code] =
          //         res.title_1_paragraph;
          // });
          // this.$store.commit("school_quickfacts/setForData", {
          //     key: "title_1_paragraph",
          //     value: obj,
          // });

          obj = {};
          data.map((res) => {
            obj["title_2_" + res.language_code] = res.title_2;
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_2",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["title_2_subtitle_" + res.language_code] = res.title_2_subtitle;
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_2_subtitle",
            value: obj,
          });
          obj = {};
          data.map((res) => {
            obj["title_1_paragraph_" + res.language_code] =
              res.title_1_paragraph;
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_1_paragraph",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["title_2_paragraph_" + res.language_code] =
              res.title_2_paragraph;
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_2_paragraph",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["title_2_button_title_" + res.language_code] =
              res.title_2_button_title;
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_2_button_title",
            value: obj,
          });
          let quick_features =
            res?.data?.data?.school_quick_fact_feature || [];
          quick_features.map((quick_feature) => {
            this.handleFeaturedInput(
              quick_feature?.is_featured == "1" ? true : false,
              `${quick_feature.type}_featured`
            );

            this.$store.commit("school_quickfacts/setForData", {
              key: quick_feature.type,
              value: quick_feature.value,
            });

            this.$store.commit("school_quickfacts/setForData", {
              key: `${quick_feature.type}_order`,
              value: quick_feature.sorting_order,
            });
          });
          this.isDataLoaded = 1;
        });
    },
    handleImage(e) {
      // console.log(e.target.files[0], key, language, mutationName);
      var file = new FormData();
      file.append("file", e.target.files[0]);
      axios.post("/api/web/image_again_upload", file).then((res) => {
        this.$store.commit("school_quickfacts/setForData", {
          key: "title_2_image",
          value: res?.data,
          language: "",
        });
      });
    },
  },
  beforeUnmount() {
    document.removeEventListener("click", this.handleClickOutsidePopup);

  },
  mounted() {
    document.addEventListener("click", this.handleClickOutsidePopup);

    this.$store.commit("school_quickfacts/setForData", {
      key: "customer_id",
      value: this.logged_in_customer,
    });
    this.$store.commit("school_quickfacts/setForData", {
      key: "school_id",
      value: this.school_id,
    });
    axios
      .get("/api/web/customer-languages?customer_id=" + this.logged_in_customer)
      .then((res) => {
        if (res.data.status == "Success") {
          this.$store.commit("school_quickfacts/setLanguages", res.data.data);

          let data = res.data.data;
          let obj = {};
          data.map((res) => {
            obj["title_1_" + res.language_code] = "";
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_1",
            value: obj,
          });

          // obj = {};
          // data.map((res) => {
          //     obj["title_1_paragraph_" + res.language_code] = "";
          // });
          // this.$store.commit("school_quickfacts/setForData", {
          //     key: "title_1_paragraph",
          //     value: obj,
          // });

          obj = {};
          data.map((res) => {
            obj["title_2_" + res.language_code] = "";
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_2",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["title_2_subtitle_" + res.language_code] = "";
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_2_subtitle",
            value: obj,
          });
          obj = {};
          data.map((res) => {
            obj["title_1_paragraph_" + res.language_code] = "";
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_1_paragraph",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["title_2_paragraph_" + res.language_code] = "";
          });

          this.$store.commit("school_quickfacts/setForData", {
            key: "title_2_paragraph",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["title_2_button_title_" + res.language_code] = "";
          });
          this.$store.commit("school_quickfacts/setForData", {
            key: "title_2_button_title",
            value: obj,
          });

          this.fetchSchoolQuickFact();
          this.$store.commit("school_types/setLimit", 2000);
          this.$store.commit("school_types/setSortBy", "id");
          this.$store.commit("school_types/setSortType", "desc");
          this.$store.dispatch("school_types/fetchSchoolTypes");
          this.$store.commit("programs/setLimit", 2000);
          this.$store.commit("programs/setSortBy", "id");
          this.$store.commit("programs/setSortType", "desc");
          this.$store.dispatch("programs/fetchPrograms");
        }
      });
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