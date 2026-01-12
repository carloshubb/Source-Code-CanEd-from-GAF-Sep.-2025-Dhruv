<template>
  <AppLayout>
    <header class="py-4 bg-white">
      <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <h1 class="can-edu-h1">School overview</h1>
          <router-link
            :to="{ name: 'admin.schools.index' }"
            class="can-edu-btn-fill"
          >
            Back
          </router-link>
        </div>
      </div>
      <div v-if="$route?.params?.id">
        <other-options type="overview" :id="$route?.params?.id" />
      </div>
    </header>
    <div class="p-5 bg-white dark:bg-gray-800">
      <!-- <OverviewPrograms :school_overview_id="form['id']" v-if="form['id']" /> -->
      <div class="modal-content py-6 text-left px-6">
        <div class="modal-body">
          <div
            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
          >
            <ul class="flex flex-wrap my-4">
              <li
                class="mr-2"
                v-for="language in languages"
                :key="language.code"
              >
                <a
                  @click.prevent="changeLanguageTab(language)"
                  href="#"
                  :class="[
                    'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                    activeTab != null && activeTab == language.abbreviation
                      ? 'text-white bg-primary active'
                      : '',
                    errors.has(`title_1.title_1_${language.code}`)
                      ? 'bg-red-600 text-white hover:text-white'
                      : '',
                  ]"
                  >{{ language.abbreviation }}</a
                >
              </li>
            </ul>
          </div>
          <div
            v-for="language in languages"
            :key="language.abbreviation"
            :class="activeTab == language.abbreviation ? 'block' : 'hidden'"
          >
            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 1</label
              >
              <input
                type="text"
                placeholder="Name"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_1', language)"
                :value="
                  form['title_1'] &&
                  form['title_1'][`title_1_${language.abbreviation}`]
                    ? form['title_1'][`title_1_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_1.title_1_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 1 Paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_1_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_1_paragraph')
                "
                :ref="`title_1_paragraph_${language.abbreviation}`"
                :id="`title_1_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_1_paragraph`][
                    `title_1_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_1_paragraph.title_1_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 1 Content</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_1_content_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_1_content')
                "
                :ref="`title_1_content_${language.abbreviation}`"
                :id="`title_1_content_${language.abbreviation}`"
                :initial-value="
                  form[`title_1_content`][
                    `title_1_content_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_1_content_.title_1_content_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 2</label
              >
              <input
                type="text"
                placeholder="Title 2"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_2', language)"
                :value="
                  form['title_2'] &&
                  form['title_2'][`title_2_${language.abbreviation}`]
                    ? form['title_2'][`title_2_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_2.title_2_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 2 Bulletspoints</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_2_bullet_points_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_2_bullet_points')
                "
                :ref="`title_2_bullet_points_${language.abbreviation}`"
                :id="`title_2_bullet_points_${language.abbreviation}`"
                :initial-value="
                  form[`title_2_bullet_points`][
                    `title_2_bullet_points_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_2_bullet_points.title_2_bullet_points_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 3 subtitle</label
              >
              <input
                type="text"
                placeholder="Title 3 subtitle"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_3_subtitle', language)"
                :value="
                  form['title_3_subtitle'] &&
                  form['title_3_subtitle'][
                    `title_3_subtitle_${language.abbreviation}`
                  ]
                    ? form['title_3_subtitle'][
                        `title_3_subtitle_${language.abbreviation}`
                      ]
                    : ''
                "
              />
              <error
                :fieldName="`title_3_subtitle.title_3_subtitle_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 3 paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_3_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_3_paragraph')
                "
                :ref="`title_3_paragraph_${language.abbreviation}`"
                :id="`title_3_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_3_paragraph`][
                    `title_3_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_3_paragraph.title_3_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 3 button title</label
              >
              <input
                type="text"
                placeholder="Title 3 button title"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_3_button_title', language)"
                :value="
                  form['title_3_button_title'] &&
                  form['title_3_button_title'][
                    `title_3_button_title_${language.abbreviation}`
                  ]
                    ? form['title_3_button_title'][
                        `title_3_button_title_${language.abbreviation}`
                      ]
                    : ''
                "
              />
              <error
                :fieldName="`title_3_button_title.title_3_button_title_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
          </div>

          <div class="relative">
            <p>
              Image * (Files must be less than 5MB, allowed file types: png,
              gif, jpg, jpeg)
            </p>
            <input
              type="file"
              class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @change="handleImage($event, 'title_3_image')"
            />
            <error :fieldName="`title_3_image`" :validationErros="errors" />
            <img :src="form?.title_3_image ? form.title_3_image : ''" />
          </div>
          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >Title 3 date</label
            >
            <input
              type="date"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_3_date', '')"
              :value="form['title_3_date'] ? form['title_3_date'] : ''"
            />
            <error :fieldName="`title_3_date`" :validationErros="errors" />
          </div>
          <div
            v-for="language in languages"
            :key="language.abbreviation"
            :class="activeTab == language.abbreviation ? 'block' : 'hidden'"
          >
            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 3 image name</label
              >
              <input
                type="text"
                placeholder="Title 2 subtitle"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_3_image_name', language)"
                :value="
                  form['title_3_image_name'] &&
                  form['title_3_image_name'][
                    `title_3_image_name_${language.abbreviation}`
                  ]
                    ? form['title_3_image_name'][
                        `title_3_image_name_${language.abbreviation}`
                      ]
                    : ''
                "
              />
              <error
                :fieldName="`title_3_image_name.title_3_image_name_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
          </div>

          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >Title 3 button link</label
            >
            <input
              type="text"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_3_button_link', '')"
              :value="
                form['title_3_button_link'] ? form['title_3_button_link'] : ''
              "
            />
            <error
              :fieldName="`title_3_button_link`"
              :validationErros="errors"
            />
          </div>
          <div
            v-for="language in languages"
            :key="language.abbreviation"
            :class="activeTab == language.abbreviation ? 'block' : 'hidden'"
          >
            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 4</label
              >
              <input
                type="text"
                placeholder="Title 4"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_4', language)"
                :value="
                  form['title_4'] &&
                  form['title_4'][`title_4_${language.abbreviation}`]
                    ? form['title_4'][`title_4_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_4.title_4_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 4 paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_4_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_4_paragraph')
                "
                :ref="`title_4_paragraph_${language.abbreviation}`"
                :id="`title_4_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_4_paragraph`][
                    `title_4_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_4_paragraph.title_4_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
          </div>
          <div class="relative">
            <p>
              Image * (Files must be less than 5MB, allowed file types: png,
              gif, jpg, jpeg)
            </p>
            <input
              type="file"
              class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @change="handleImage($event, 'title_4_image')"
            />
            <error :fieldName="`title_4_image`" :validationErros="errors" />
            <img :src="form?.title_4_image ? form.title_4_image : ''" />
          </div>
          <div
            v-for="language in languages"
            :key="language.abbreviation"
            :class="activeTab == language.abbreviation ? 'block' : 'hidden'"
          >
            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 5</label
              >
              <input
                type="text"
                placeholder="Title 5"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_5', language)"
                :value="
                  form['title_5'] &&
                  form['title_5'][`title_5_${language.abbreviation}`]
                    ? form['title_5'][`title_5_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_5.title_5_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 5 paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_5_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_5_paragraph')
                "
                :ref="`title_5_paragraph_${language.abbreviation}`"
                :id="`title_5_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_5_paragraph`][
                    `title_5_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_5_paragraph.title_5_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 6</label
              >
              <input
                type="text"
                placeholder="Title 6"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_6', language)"
                :value="
                  form['title_6'] &&
                  form['title_6'][`title_6_${language.abbreviation}`]
                    ? form['title_6'][`title_6_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_6.title_6_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 6 paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_6_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_6_paragraph')
                "
                :ref="`title_6_paragraph_${language.abbreviation}`"
                :id="`title_6_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_6_paragraph`][
                    `title_6_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_6_paragraph.title_6_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 6 button title</label
              >
              <input
                type="text"
                placeholder="Title 6"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_6_button_title', language)"
                :value="
                  form['title_6_button_title'] &&
                  form['title_6_button_title'][
                    `title_6_button_title_${language.abbreviation}`
                  ]
                    ? form['title_6_button_title'][
                        `title_6_button_title_${language.abbreviation}`
                      ]
                    : ''
                "
              />
              <error
                :fieldName="`title_6_button_title.title_6_button_title_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
          </div>

          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >Title 6 button link</label
            >
            <input
              type="text"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_6_button_link', '')"
              :value="
                form['title_6_button_link'] ? form['title_6_button_link'] : ''
              "
            />
            <error
              :fieldName="`title_6_button_link`"
              :validationErros="errors"
            />
          </div>
          <div
            v-for="language in languages"
            :key="language.abbreviation"
            :class="activeTab == language.abbreviation ? 'block' : 'hidden'"
          >
            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 7</label
              >
              <input
                type="text"
                placeholder="Title 7"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_7', language)"
                :value="
                  form['title_7'] &&
                  form['title_7'][`title_7_${language.abbreviation}`]
                    ? form['title_7'][`title_7_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_7.title_7_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 7 paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_7_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_7_paragraph')
                "
                :ref="`title_7_paragraph_${language.abbreviation}`"
                :id="`title_7_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_7_paragraph`][
                    `title_7_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_7_paragraph.title_7_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 8</label
              >
              <input
                type="text"
                placeholder="Title 8"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_8', language)"
                :value="
                  form['title_8'] &&
                  form['title_8'][`title_8_${language.abbreviation}`]
                    ? form['title_8'][`title_8_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_8.title_8_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 8 paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_8_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_8_paragraph')
                "
                :ref="`title_8_paragraph_${language.abbreviation}`"
                :id="`title_8_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_8_paragraph`][
                    `title_8_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_8_paragraph.title_8_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 8 button name</label
              >
              <input
                type="text"
                placeholder="Title 7"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_7_button_title', language)"
                :value="
                  form['title_7_button_title'] &&
                  form['title_7_button_title'][
                    `title_7_button_title_${language.abbreviation}`
                  ]
                    ? form['title_7_button_title'][
                        `title_7_button_title_${language.abbreviation}`
                      ]
                    : ''
                "
              />
              <error
                :fieldName="`title_7_button_title.title_7_button_title_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
          </div>
          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >Title 8 button link</label
            >
            <input
              type="text"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_8_button_link', '')"
              :value="
                form['title_8_button_link'] ? form['title_8_button_link'] : ''
              "
            />
            <error
              :fieldName="`title_8_button_link`"
              :validationErros="errors"
            />
          </div>
          <div
            v-for="language in languages"
            :key="language.abbreviation"
            :class="activeTab == language.abbreviation ? 'block' : 'hidden'"
          >
            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 9</label
              >
              <input
                type="text"
                placeholder="Title 9"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_9', language)"
                :value="
                  form['title_9'] &&
                  form['title_9'][`title_9_${language.abbreviation}`]
                    ? form['title_9'][`title_9_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_9.title_9_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 9 subtitle</label
              >
              <input
                type="text"
                placeholder="Title 9"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_9_subtitle', language)"
                :value="
                  form['title_9_subtitle'] &&
                  form['title_9_subtitle'][
                    `title_9_subtitle_${language.abbreviation}`
                  ]
                    ? form['title_9_subtitle'][
                        `title_9_subtitle_${language.abbreviation}`
                      ]
                    : ''
                "
              />
              <error
                :fieldName="`title_9_subtitle.title_9_subtitle_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 9 paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_9_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_9_paragraph')
                "
                :ref="`title_9_paragraph_${language.abbreviation}`"
                :id="`title_9_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_9_paragraph`][
                    `title_9_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_9_paragraph.title_9_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 9 button title</label
              >
              <input
                type="text"
                placeholder="Title 9 button title"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_9_button_title', language)"
                :value="
                  form['title_9_button_title'] &&
                  form['title_9_button_title'][
                    `title_9_button_title_${language.abbreviation}`
                  ]
                    ? form['title_9_button_title'][
                        `title_9_button_title_${language.abbreviation}`
                      ]
                    : ''
                "
              />
              <error
                :fieldName="`title_9_button_title.title_9_button_title_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
          </div>

          <div class="w-full mt-2 relative">
            <label
              for=""
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >Title 9 button link</label
            >
            <input
              type="text"
              placeholder=""
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_9_button_link', '')"
              :value="
                form['title_9_button_link'] ? form['title_9_button_link'] : ''
              "
            />
            <error
              :fieldName="`title_9_button_link`"
              :validationErros="errors"
            />
          </div>

          <div class="relative">
            <p>
              Image * (Files must be less than 5MB, allowed file types: png,
              gif, jpg, jpeg)
            </p>
            <input
              type="file"
              class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @change="handleImage($event, 'title_9_image')"
            />
            <error :fieldName="`title_9_image`" :validationErros="errors" />
            <img :src="form?.title_9_image ? form.title_9_image : ''" />
          </div>
          <div
            v-for="language in languages"
            :key="language.abbreviation"
            :class="activeTab == language.abbreviation ? 'block' : 'hidden'"
          >
            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 9 image name</label
              >
              <input
                type="text"
                placeholder="Title 9 image name"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_9_image_name', language)"
                :value="
                  form['title_9_image_name'] &&
                  form['title_9_image_name'][
                    `title_9_image_name_${language.abbreviation}`
                  ]
                    ? form['title_9_image_name'][
                        `title_9_image_name_${language.abbreviation}`
                      ]
                    : ''
                "
              />
              <error
                :fieldName="`title_9_image_name.title_9_image_name_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 10</label
              >
              <input
                type="text"
                placeholder="Title 10"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_10', language)"
                :value="
                  form['title_10'] &&
                  form['title_10'][`title_10_${language.abbreviation}`]
                    ? form['title_10'][`title_10_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_10.title_10_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 10 paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_10_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_10_paragraph')
                "
                :ref="`title_10_paragraph_${language.abbreviation}`"
                :id="`title_10_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_10_paragraph`][
                    `title_10_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_10_paragraph.title_10_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 11</label
              >

              <input
                type="text"
                placeholder="Title 11"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_11', language)"
                :value="
                  form['title_11'] &&
                  form['title_11'][`title_11_${language.abbreviation}`]
                    ? form['title_11'][`title_11_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_11.title_11_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 11 paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_11_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_11_paragraph')
                "
                :ref="`title_11_paragraph_${language.abbreviation}`"
                :id="`title_11_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_11_paragraph`][
                    `title_11_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_11_paragraph.title_11_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 12</label
              >
              <input
                type="text"
                placeholder="Title 12"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_12', language)"
                :value="
                  form['title_12'] &&
                  form['title_12'][`title_12_${language.abbreviation}`]
                    ? form['title_12'][`title_12_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_12.title_12_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 12 bullet points</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_12_bullet_points_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_12_bullet_points')
                "
                :ref="`title_12_bullet_points_${language.abbreviation}`"
                :id="`title_12_bullet_points_${language.abbreviation}`"
                :initial-value="
                  form[`title_12_bullet_points`][
                    `title_12_bullet_points_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_12_bullet_points.title_12_bullet_points_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 13</label
              >
              <input
                type="text"
                placeholder="Title 13"
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'title_13', language)"
                :value="
                  form['title_13'] &&
                  form['title_13'][`title_13_${language.abbreviation}`]
                    ? form['title_13'][`title_13_${language.abbreviation}`]
                    : ''
                "
              />
              <error
                :fieldName="`title_13.title_13_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Title 13 paragraph</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`title_13_paragraph_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'title_13_paragraph')
                "
                :ref="`title_13_paragraph_${language.abbreviation}`"
                :id="`title_13_paragraph_${language.abbreviation}`"
                :initial-value="
                  form[`title_13_paragraph`][
                    `title_13_paragraph_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`title_13_paragraph.title_13_paragraph_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
          </div>

          <div class="flex justify-center items-center gap-3 mt-4">
            <div>
              <button class="can-edu-btn-fill" @click="addUpdate">
                Submit
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
<script>
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import { mapState } from "vuex";
// import OverviewPrograms from "./OverviewPrograms.vue";
import Error from "./Error.vue";
import OtherOptions from "./OtherOptions.vue";
export default {
  components: {
    Error,
    OtherOptions,
    editor: Editor,
  },
  props: ["logged_in_customer", "school_id"],
  computed: {
    ...mapState({
      form: (state) => state.school_overviews.form,
      school_overviews: (state) => state.school_overviews.school_overviews,
      is_featured_array: (state) => state.school_overviews.is_featured_array,
      errors: (state) => state.school_overviews.errors,
      isLoading: (state) => state.school_overviews.isLoading,
      languages: (state) => state.languages.languages,
    }),
  },
  data() {
    return {
      activeTab: "en",
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
    handleIsFeatured(val, key) {
      this.$store.commit("school_overviews/setIsFeatured", {
        checked: val,
        key,
      });
    },
    closeModal() {
      this.$store.commit("school_overviews/setShowModal", 0);
    },
    handleInput(e, key, language) {
      this.$store.commit("school_overviews/setForData", {
        key,
        language: language ? language : "",
        value: e.target.value,
      });
    },
    handleSelectionChange(language, key) {
      this.$store.commit(`school_overviews/updateFormData`, {
        value: tinymce.get(`${key}_${language.abbreviation}`).getContent(),
        id: language.abbreviation,
        key: key,
      });
    },
    changeLanguageTab(language) {
      this.activeTab = language.abbreviation;
    },
    addUpdate() {
      this.$store.dispatch("school_overviews/addUpdateForm").then((res) => {
        if (res.data.status == "Success") {
          this.$store.commit("school_overviews/setLimit", 10);
          this.$store.commit("school_overviews/setSortBy", "id");
          this.$store.commit("school_overviews/setSortType", "desc");
          this.$store.dispatch("school_overviews/fetchSchoolOverviews", {
            url: `${process.env.MIX_WEB_API_URL}school-overviews?withSchoolOverviewDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
          });
        }
      });
    },
    fetchSchoolOverviews() {
      this.$store
        .dispatch("school_overviews/fetchSchoolOverviews", {
          url: `${process.env.MIX_WEB_API_URL}school-overviews?withSchoolOverviewDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
        })
        .then((res) => {
          let school_keys = [
            "id",
            "customer_id",
            "title_3_image",
            "title_3_date",
            "title_4_image",
            "title_3_button_link",
            "title_6_button_link",
            "title_8_button_link",
            "title_9_image",
            "title_9_button_link",
          ];
          let data = res.data.data ? res.data.data : [];
          for (var i = 0; i < school_keys?.length; i++) {
            this.$store.commit("school_overviews/setForData", {
              key: school_keys[i],
              value: data[school_keys[i]] ? data[school_keys[i]] : "",
            });
          }

          data =
            res.data.data && res.data.data.school_overview_detail
              ? res.data.data.school_overview_detail
              : [];
          var moreFields = [
            "title_1",
            "title_2",
            "title_3_subtitle",
            "title_3_button_title",
            "title_3_image_name",
            "title_4",
            "title_5",
            "title_6",
            "title_6_button_title",
            "title_7",
            "title_7_button_title",
            "title_8",
            "title_9",
            "title_9_subtitle",
            "title_9_button_title",
            "title_9_image_name",
            "title_10",
            "title_11",
            "title_12",
            "title_13",
          ];
          for (var i = 0; i < moreFields?.length; i++) {
            let obj = {};
            data.map((res) => {
              obj[moreFields[i] + "_" + res.language_code] = res[moreFields[i]];
            });
            this.$store.commit("school_overviews/setForData", {
              key: moreFields[i],
              value: obj,
            });
          }

          var moreFields1 = [
            "title_1_paragraph",
            "title_1_content",
            "title_2_bullet_points",
            "title_3_paragraph",
            "title_4_paragraph",
            "title_5_paragraph",
            "title_6_paragraph",
            "title_7_paragraph",
            "title_8_paragraph",
            "title_9_paragraph",
            "title_10_paragraph",
            "title_11_paragraph",
            "title_12_bullet_points",
            "title_13_paragraph",
          ];
          for (var i = 0; i < moreFields1?.length; i++) {
            let obj = {};
            data.map((res) => {
              obj[moreFields1[i] + "_" + res.language_code] =
                res[moreFields1[i]];
            });
            this.$store.commit("school_overviews/setForData", {
              key: moreFields1[i],
              value: obj,
            });
            this.isDataLoaded = 1;
          }
        });
    },
    handleImage(e, key) {
      var file = new FormData();
      file.append("file", e.target.files[0]);
      axios.post("/api/web/image_again_upload", file).then((res) => {
        this.$store.commit("school_overviews/setForData", {
          key: key,
          value: res?.data,
          language: "",
        });
      });
    },
  },

  created() {
    this.$store.commit("school_overviews/setForData", {
      key: "school_id",
      value: this.$route.params.id,
    });
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        if (res.data.status == "Success") {
          this.$store.commit("school_overviews/setLanguages", res.data.data);

          setTimeout(() => {
            let data = res.data.data;
            var moreFields = [
              "title_1_paragraph",
              "title_1_content",
              "title_2_bullet_points",
              "title_3_paragraph",
              "title_4_paragraph",
              "title_5_paragraph",
              "title_6_paragraph",
              "title_7_paragraph",
              "title_8_paragraph",
              "title_9_paragraph",
              "title_10_paragraph",
              "title_11_paragraph",
              "title_12_bullet_points",
              "title_13_paragraph",
            ];
            for (var i = 0; i < moreFields?.length; i++) {
              let obj = {};
              data.map((res) => {
                obj[moreFields[i] + "_" + res.abbreviation] = "";
              });
              this.$store.commit("school_overviews/setForData", {
                key: moreFields[i],
                value: obj,
              });
            }
            var moreFields = [
              "title_1",
              "title_2",
              "title_3_subtitle",
              "title_3_button_title",
              "title_3_image_name",
              "title_4",
              "title_5",
              "title_6",
              "title_6_button_title",
              "title_7",
              "title_7_button_title",
              "title_8",
              "title_9",
              "title_9_subtitle",
              "title_9_button_title",
              "title_9_image_name",
              "title_10",
              "title_11",
              "title_12",
              "title_13",
            ];
            for (var i = 0; i < moreFields?.length; i++) {
              let obj = {};
              data.map((res) => {
                obj[moreFields[i] + "_" + res.abbreviation] = "";
              });
              this.$store.commit("school_overviews/setForData", {
                key: moreFields[i],
                value: obj,
              });
            }
            if (this.$route.params.id) {
              this.fetchSchoolOverviews();
            } else {
              this.isDataLoaded = 1;
            }
          }, 1000);
        }
      });
  },
};
</script>
