<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
        <header class="">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">Footer setting</h1>
                </div>
            </div>
        </header>
        <header class="mt-3">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
              Select language(s) of the footer setting
            </p>
          </div>
        </div>
      </header>
        <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
            >
                <ul class="flex gap-2 flex-wrap my-4">
                    <li
                        class="mr-2"
                        v-for="language in languages"
                        :key="language.id"
                    >
                        <a
                            @click.prevent="changeLanguageTab(language)"
                            href="#"
                            :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                ((activeTab == null && language.is_default) ||
                                activeTab == language.id
                                    ? 'text-white bg-primary active'
                                    : '',
                                checkValidationError(validationErros, language)
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : ''),
                            ]"
                            >{{ language.name }}</a
                        >
                    </li>
                </ul>
            </div>
            <div
                class="my-5"
                v-for="language in languages"
                :key="language.id"
                :class="
                    (activeTab == null && language.is_default) ||
                    language.id == activeTab
                        ? 'block'
                        : 'hidden'
                "
            >
                <div
                    class="border rounded w-full"
                    :class="collapseStates[0] ? 'bg-gray-50' : ''"
                >
                    <div
                        class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[0] = !collapseStates[0]"
                    >
                        <h2 class="text-lg font-medium">Section 1</h2>
                        <svg
                            class="w-5 h-5 fill-current text-gray-500"
                            viewBox="0 0 20 20"
                        >
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div
                        class="p-4 bg-gray-100 border-t"
                        v-show="collapseStates[0]"
                    >
                        <div class="grid my-5 md:grid-cols-2 md:gap-6">
                            <div class="relative z-10 w-full mb-6 group">
                                <label :for="`section_1_title_${language.id}`" class="block text-base lg:text-lg">Section 1 title</label>
                                <input
                                    type="text"
                                    :name="`section_1_title_${language.id}`"
                                    :id="`section_1_title_${language.id}`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="
                                        handleInput(
                                            $event.target.value,
                                            language,
                                            'section_1_title',
                                            'updatePageSetting'
                                        )
                                    "
                                    :value="
                                        form['section_1_title'] &&
                                        form['section_1_title'][
                                            `section_1_title_${language.id}`
                                        ]
                                            ? form['section_1_title'][
                                                  `section_1_title_${language.id}`
                                              ]
                                            : ''
                                    "
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="
                                        validationErros.has(
                                            `section_1_title.section_1_title_${language.id}`
                                        )
                                    "
                                    v-text="
                                        validationErros.get(
                                            `section_1_title.section_1_title_${language.id}`
                                        )
                                    "
                                ></p>
                            </div>
                            <div class="relative w-full mb-6 group">
                                <label
                                    class="block text-sm lg:text-base"
                                    >Menu items</label
                                >
                                <select
                                    @change="
                                        handleInput1(
                                            $event.target.value,
                                            'menu1'
                                        )
                                    "
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                >
                                    <option>Select</option>
                                    <template
                                        v-for="(menu, key) in menus"
                                        :key="key"
                                    >
                                        <option
                                            v-if="
                                                !menu.is_main_menu &&
                                                !menu.is_top_menu
                                            "
                                            :value="menu?.id"
                                            :selected="form['menu1'] == menu?.id"
                                            
                                        >
                                            {{ menu?.name }}
                                        </option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="border rounded w-full"
                    :class="collapseStates[1] ? 'bg-gray-50' : ''"
                >
                    <div
                        class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[1] = !collapseStates[1]"
                    >
                        <h2 class="text-lg font-medium">Section 2</h2>
                        <svg
                            class="w-5 h-5 fill-current text-gray-500"
                            viewBox="0 0 20 20"
                        >
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div
                        class="p-4 bg-gray-100 border-t"
                        v-show="collapseStates[1]"
                    >
                        <div class="grid my-5 md:grid-cols-2 md:gap-6">
                            <div class="relative z-10 w-full mb-6 group">
                                <label :for="`section_2_title_${language.id}`" class="block text-base lg:text-lg">Section 2 title</label>
                                <input
                                    type="text"
                                    :name="`section_2_title_${language.id}`"
                                    :id="`section_2_title_${language.id}`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="
                                        handleInput(
                                            $event.target.value,
                                            language,
                                            'section_2_title',
                                            'updatePageSetting'
                                        )
                                    "
                                    :value="
                                        form['section_2_title'] &&
                                        form['section_2_title'][
                                            `section_2_title_${language.id}`
                                        ]
                                            ? form['section_2_title'][
                                                  `section_2_title_${language.id}`
                                              ]
                                            : ''
                                    "
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="
                                        validationErros.has(
                                            `section_2_title.section_2_title_${language.id}`
                                        )
                                    "
                                    v-text="
                                        validationErros.get(
                                            `section_2_title.section_2_title_${language.id}`
                                        )
                                    "
                                ></p>
                            </div>
                            <div class="relative w-full mb-6 group">
                                <label
                                    class="block text-base lg:text-lg"
                                    >Menu items</label
                                >
                                <select
                                    @change="
                                        handleInput1(
                                            $event.target.value,
                                            'menu2'
                                        )
                                    "
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                >
                                    <option>Select</option>
                                    <template
                                        v-for="(menu, key) in menus"
                                        :key="key"
                                    >
                                        <option
                                            v-if="
                                                !menu.is_main_menu &&
                                                !menu.is_top_menu
                                            "
                                            :value="menu?.id"
                                            :selected="form['menu2'] == menu?.id"
                                        >
                                            {{ menu?.name }}
                                        </option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="border rounded w-full"
                    :class="collapseStates[2] ? 'bg-gray-50' : ''"
                >
                    <div
                        class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[2] = !collapseStates[2]"
                    >
                        <h2 class="text-lg font-medium">Section 3</h2>
                        <svg
                            class="w-5 h-5 fill-current text-gray-500"
                            viewBox="0 0 20 20"
                        >
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div class="p-4 bg-gray-100 border-t">
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-10 w-full mb-6 group">
                            <label :for="`section_3_title_${language.id}`" class="block text-base lg:text-lg">Section 3 title</label>
                            <input
                                type="text"
                                :name="`section_3_title_${language.id}`"
                                :id="`section_3_title_${language.id}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'section_3_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['section_3_title'] &&
                                    form['section_3_title'][
                                        `section_3_title_${language.id}`
                                    ]
                                        ? form['section_3_title'][
                                              `section_3_title_${language.id}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `section_3_title.section_3_title_${language.id}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `section_3_title.section_3_title_${language.id}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative w-full mb-6 group">
                            <label
                                class="block text-base lg:text-lg"
                                >Menu items</label
                            >
                            <select
                                @change="
                                    handleInput1($event.target.value, 'menu3')
                                "
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                            >
                                <option>Select</option>
                                <template
                                    v-for="(menu, key) in menus"
                                    :key="key"
                                >
                                    <option
                                        v-if="
                                            !menu.is_main_menu &&
                                            !menu.is_top_menu
                                        "
                                        :value="menu?.id"
                                        :selected="form['menu3'] == menu?.id"
                                    >
                                        {{ menu?.name }}
                                    </option>
                                </template>
                            </select>
                        </div>
                    </div>
                    </div>
                </div>

                <div
                    class="border rounded w-full"
                    :class="collapseStates[4] ? 'bg-gray-50' : ''"
                >
                    <div
                        class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                        @click.prevent="collapseStates[4] = !collapseStates[4]"
                    >
                        <h2 class="text-lg font-medium">Section 4</h2>
                        <svg
                            class="w-5 h-5 fill-current text-gray-500"
                            viewBox="0 0 20 20"
                        >
                            <path d="M6 9l4 4 4-4"></path>
                        </svg>
                    </div>
                    <div
                        class="p-4 bg-gray-100 border-t"
                        v-show="collapseStates[4]"
                    >
                        <div class="grid my-5 md:grid-cols-2 md:gap-6">
                            <div class="relative z-10 w-full group col-span-2" v-if="isDataLoaded">
                                <!-- <div
                                    class="mt-5 ckeditorText"
                                    :id="`copy_right_text_${language.id}`"
                                ></div> -->
                                <label :for="`copy_right_text_${language.id}`" class="block text-base lg:text-lg">Description</label>
                                <editor
                                    @selectionChange="
                                        handleSelectionChange(
                                            language,
                                            'copy_right_text'
                                        )
                                    "
                                    :ref="`copy_right_text_${language.id}`"
                                    :id="`copy_right_text_${language.id}`"
                                    :initial-value="form[`copy_right_text`][`copy_right_text_${language?.id}`]
                                    "
                                    :init="editorConfig"
                                    :tinymce-script-src="tinymceScriptSrc"
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="
                                        validationErros.has(
                                            `copy_right_text.copy_right_text_${language.id}`
                                        )
                                    "
                                    v-text="
                                        validationErros.get(
                                            `copy_right_text.copy_right_text_${language.id}`
                                        )
                                    "
                                ></p>
                            </div>
                            <!-- facebook -->
                            <div class="relative z-10 w-full group">
                                <label :for="`facebook_url`" class="block text-base lg:text-lg">Facebook URL</label>
                                <input
                                    type="text"
                                    :name="`facebook_url`"
                                    :id="`facebook_url`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="
                                        handleInput1(
                                            $event.target.value,
                                            'facebook_url'
                                        )
                                    "
                                    :value="form['facebook_url']"
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`facebook_url`)"
                                    v-text="validationErros.get(`facebook_url`)"
                                ></p>
                            </div>
                            <div class="relative z-10 w-full group">
                                <label :for="`facebook_icon`" class="block text-base lg:text-lg">Facebook icon</label>
                                <input
                                    :key="`facebook_icon`"
                                    type="file"
                                    :name="`facebook_icon`"
                                    :id="`facebook_icon`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="
                                        handleImage($event, 'facebook_icon')
                                    "
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`facebook_icon`)"
                                    v-text="
                                        validationErros.get(`facebook_icon`)
                                    "
                                ></p>

                                <img
                                    v-if="form['facebook_icon']"
                                    :src="form['facebook_icon']"
                                    style="height: 100px; width: 100px"
                                />
                            </div>
                            <!-- twitter -->
                            <div class="relative z-10 w-full group">
                                <label :for="`twitter_url`" class="block text-base lg:text-lg">Twitter URL</label>
                                <input
                                    type="text"
                                    :name="`twitter_url`"
                                    :id="`twitter_url`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="
                                        handleInput1(
                                            $event.target.value,
                                            'twitter_url'
                                        )
                                    "
                                    :value="form['twitter_url']"
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`twitter_url`)"
                                    v-text="validationErros.get(`twitter_url`)"
                                ></p>
                            </div>
                            <div class="relative z-10 w-full group">
                                <label :for="`twitter_icon`" class="block text-base lg:text-lg">Twitter icon</label>
                                <input
                                    :key="`twitter_icon`"
                                    type="file"
                                    :name="`twitter_icon`"
                                    :id="`twitter_icon`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="handleImage($event, 'twitter_icon')"
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`twitter_icon`)"
                                    v-text="validationErros.get(`twitter_icon`)"
                                ></p>

                                <img
                                    v-if="form['twitter_icon']"
                                    :src="form['twitter_icon']"
                                    style="height: 100px; width: 100px"
                                />
                            </div>

                            <!-- insta -->
                            <div class="relative z-10 w-full group">
                                <label :for="`insta_url`" class="block text-base lg:text-lg">Insta URL</label>
                                <input
                                    type="text"
                                    :name="`insta_url`"
                                    :id="`insta_url`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="
                                        handleInput1(
                                            $event.target.value,
                                            'insta_url'
                                        )
                                    "
                                    :value="form['insta_url']"
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`insta_url`)"
                                    v-text="validationErros.get(`insta_url`)"
                                ></p>
                            </div>
                            <div class="relative z-10 w-full group">
                                <label :for="`insta_icon`" class="block text-base lg:text-lg">Insta icon</label>
                                <input
                                    :key="`insta_icon`"
                                    type="file"
                                    :name="`insta_icon`"
                                    :id="`insta_icon`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="handleImage($event, 'insta_icon')"
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`insta_icon`)"
                                    v-text="validationErros.get(`insta_icon`)"
                                ></p>

                                <img
                                    v-if="form['insta_icon']"
                                    :src="form['insta_icon']"
                                    style="height: 100px; width: 100px"
                                />
                            </div>

                            <!-- linkedin -->
                            <div class="relative z-10 w-full group">
                                <label :for="`linkedin_url`" class="block text-base lg:text-lg">Linked In URL</label>
                                <input
                                    type="text"
                                    :name="`linkedin_url`"
                                    :id="`linkedin_url`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="
                                        handleInput1(
                                            $event.target.value,
                                            'linkedin_url'
                                        )
                                    "
                                    :value="form['linkedin_url']"
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`linkedin_url`)"
                                    v-text="validationErros.get(`linkedin_url`)"
                                ></p>
                            </div>
                            <div class="relative z-10 w-full group">
                                <label :for="`linkedin_icon`" class="block text-base lg:text-lg">Linked In icon</label>
                                <input
                                    :key="`linkedin_icon`"
                                    type="file"
                                    :name="`linkedin_icon`"
                                    :id="`linkedin_icon`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="
                                        handleImage($event, 'linkedin_icon')
                                    "
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`linkedin_icon`)"
                                    v-text="
                                        validationErros.get(`linkedin_icon`)
                                    "
                                ></p>

                                <img
                                    v-if="form['linkedin_icon']"
                                    :src="form['linkedin_icon']"
                                    style="height: 100px; width: 100px"
                                />
                            </div>

                            <!-- youtube -->
                            <div class="relative z-10 w-full group">
                                <label :for="`youtube_url`" class="block text-base lg:text-lg">Youtube URL</label>
                                <input
                                    type="text"
                                    :name="`youtube_url`"
                                    :id="`youtube_url`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="
                                        handleInput1(
                                            $event.target.value,
                                            'youtube_url'
                                        )
                                    "
                                    :value="form['youtube_url']"
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`youtube_url`)"
                                    v-text="validationErros.get(`youtube_url`)"
                                ></p>
                            </div>
                            <div class="relative z-10 w-full group">
                                <label :for="`youtube_icon`" class="block text-base lg:text-lg">Youtub icon</label>
                                <input
                                    :key="`youtube_icon`"
                                    type="file"
                                    :name="`youtube_icon`"
                                    :id="`youtube_icon`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white" 
                                    placeholder=" "
                                    @input="handleImage($event, 'youtube_icon')"
                                />
                                <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`youtube_icon`)"
                                    v-text="validationErros.get(`youtube_icon`)"
                                ></p>

                                <img
                                    v-if="form['youtube_icon']"
                                    :src="form['youtube_icon']"
                                    style="height: 100px; width: 100px"
                                />
                            </div>
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
import axios from "axios";
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
export default {
    components: {
        ListErrors,
        vSelect,
        editor: Editor
    },
    computed: {
        ...mapState({
            form: (state) => state.footer_setting.form,
            validationErros: (state) => state.footer_setting.validationErros,
            languages: (state) => state.languages.languages,
            banners: (state) => state.banners.banners,
            menus: (state) => state.menus.menus,
        }),
    },
    data() {
        return {
            activeTab: null,
            collapseStates: [true, false, false, false, false, false, false],
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
        handleInput1(value, key) {
            this.$store.commit(`footer_setting/setPageSetting`, {
                value: value,
                key,
            });
        },
        handleSelectionChange(language, key) {
            this.$store.commit(`footer_setting/updatePageSetting`, {
                value: tinymce.get(`${key}_${language.id}`).getContent(),
                id: language.id,
                key:key,
            });
        },
        handleInput(value, language, key, mutationName) {
            this.$store.commit(`footer_setting/${mutationName}`, {
                value: value,
                id: language.id,
                key,
            });
        },
        handleImage(e, key) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.$store.commit(`footer_setting/setPageSetting`, {
                        value: res?.data,
                        key,
                    });
                });
        },
        addUpdateForm() {
            this.$store.dispatch("footer_setting/addUpdateForm").then((res) => {
                if (res.data.status == "Success") {
                    this.$emit("addUpdateFormParent");
                }
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchFooterSetting() {
            this.$store
                .dispatch("footer_setting/fetchFooterSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}footer-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data && res.data.data.footer_setting_detail
                            ? res.data.data.footer_setting_detail
                            : [];
                    let data1 = res.data.data ? res.data.data : {};
                    // facebook
                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "menu1",
                        value: data1?.menu1,
                    });
                    // facebook
                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "menu2",
                        value: data1?.menu2,
                    });
                    // facebook
                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "menu3",
                        value: data1?.menu3,
                    });
                    // facebook
                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "menu4",
                        value: data1?.menu4,
                    });
                    // facebook
                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "facebook_url",
                        value: data1?.facebook_url,
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "facebook_icon",
                        value: data1?.facebook_icon,
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "facebook_url",
                        value: data1?.facebook_url,
                    });

                    // twitter

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "twitter_url",
                        value: data1?.twitter_url,
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "twitter_icon",
                        value: data1?.twitter_icon,
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "twitter_url",
                        value: data1?.twitter_url,
                    });

                    // youtube

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "youtube_url",
                        value: data1?.youtube_url,
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "youtube_icon",
                        value: data1?.youtube_icon,
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "youtube_url",
                        value: data1?.youtube_url,
                    });

                    // linkedin

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "linkedin_url",
                        value: data1?.linkedin_url,
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "linkedin_icon",
                        value: data1?.linkedin_icon,
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "linkedin_url",
                        value: data1?.linkedin_url,
                    });

                    // insta

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "insta_url",
                        value: data1?.insta_url,
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "insta_icon",
                        value: data1?.insta_icon,
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "insta_url",
                        value: data1?.insta_url,
                    });

                    //welcome settings
                    let obj = {};
                    data.map((res) => {
                        obj["section_1_title_" + res.language_id] =
                            res.section_1_title;
                    });
                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "section_1_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["section_2_title_" + res.language_id] =
                            res.section_2_title;
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "section_2_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["section_3_title_" + res.language_id] =
                            res.section_3_title;
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "section_3_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["section_4_title_" + res.language_id] =
                            res.section_4_title;
                    });

                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "section_4_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        console.log('des', res);
                        obj["copy_right_text_" + res.language_id] =
                            res.copy_right_text;
                    });
                    this.$store.commit("footer_setting/setPageSetting", {
                        key: "copy_right_text",
                        value: obj,
                    });
                    this.isDataLoaded = 1;
                });
            this.$store.dispatch("banners/fetchBanners");
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(
                    `section_1_title.section_1_title_${language.id}`
                ) ||
                validationErros.has(
                    `section_2_title.section_2_title_${language.id}`
                ) ||
                validationErros.has(
                    `section_3_title.section_3_title_${language.id}`
                ) ||
                validationErros.has(
                    `section_4_title.section_4_title_${language.id}`
                ) ||
                validationErros.has(
                    `copy_right_text.copy_right_text_${language.id}`
                ) ||
                validationErros.has(`facebook_url_${language.id}`) ||
                validationErros.has(`linkedin_ul.linkedin_ul_${language.id}`) ||
                validationErros.has(`insta_url_${language.id}`) ||
                validationErros.has(`youtube_url_${language.id}`) ||
                validationErros.has(`twitter_url_${language.id}`) ||
                validationErros.has(`facebook_icon_${language.id}`) ||
                validationErros.has(`twitter_icon_${language.id}`) ||
                validationErros.has(`youtube_icon_${language.id}`) ||
                validationErros.has(`insta_icon_${language.id}`) ||
                validationErros.has(`linkedin_icon_${language.id}`)
            );
        },
    },
    created() {
        this.fetchFooterSetting();
        this.$store.commit("footer_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["section_1_title_" + res.id] = "";
                });

                this.$store.commit("footer_setting/setPageSetting", {
                    key: "section_1_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["section_2_title_" + res.id] = "";
                });

                this.$store.commit("footer_setting/setPageSetting", {
                    key: "section_2_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["section_3_title_" + res.id] = "";
                });

                this.$store.commit("footer_setting/setPageSetting", {
                    key: "section_3_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["section_4_title_" + res.id] = "";
                });

                this.$store.commit("footer_setting/setPageSetting", {
                    key: "section_4_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    console.log('created res des', res);
                    obj["copy_right_text_" + res.id] = "";
                });
                this.$store.commit("footer_setting/setPageSetting", {
                    key: "copy_right_text",
                    value: obj,
                });
                // this.fetchFooterSetting();

                if(this.$route.params.id){
                    this.fetchFooterSetting();
                }
                else{
                    this.isDataLoaded = 1;
                }
                this.$store.dispatch("menus/fetchMenus", {
                    url: `${process.env.MIX_ADMIN_API_URL}menus?q=1&limit=2000`,
                });
                this.fetchFooterSetting();
            });
    },
};
</script>
