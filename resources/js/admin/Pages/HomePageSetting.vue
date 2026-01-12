<template>
    <header class="my-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">Home page setting</h1>
            </div>
        </div>
    </header>
    <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
        <div
            class="my-5"
            v-for="language in languages"
            :key="language.id"
            :class="
                (selectedLanguage == null && language.is_default) ||
                language.id == selectedLanguage
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
                    <p class="card_heading font-medium">
                        Home page top part
                    </p>
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
                    <div class="grid my-5 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="relative z-0 w-full col-span-2 group">
                            <label :for="`welcome_title_${selectedLanguage}`" class="block text-base lg:text-lg">Page title<span class="text-primary">*</span></label>
                            <input
                                type="text"
                                :name="`welcome_title_${selectedLanguage}`"
                                :id="`welcome_title_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'welcome_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['welcome_title'] &&
                                    form['welcome_title'][
                                        `welcome_title_${selectedLanguage}`
                                    ]
                                        ? form['welcome_title'][
                                              `welcome_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `welcome_title.welcome_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `welcome_title.welcome_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full col-span-2 group" v-if="isDataLoaded">
                            <!-- <div
                                class="mt-5 ckeditorText"
                                :id="`welcome_description_${language.id}`"
                            ></div> -->
                            <label :for="`welcome_description_${selectedLanguage}`" class="block text-base lg:text-lg">Welcome to Proxima description<span class="text-primary">*</span></label>
                            <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'welcome_description'
                                )
                            "
                            :ref="`welcome_description_${language.id}`"
                            :id="`welcome_description_${language.id}`"
                            :initial-value="form[`welcome_description`][`welcome_description_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />

                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `welcome_description.welcome_description_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `welcome_description.welcome_description_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>

                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label :for="`welcome_button_text_${selectedLanguage}`" class="block text-base lg:text-lg">Button Text<span class="text-primary">*</span></label>
                            <input
                                type="text"
                                :name="`welcome_button_text_${selectedLanguage}`"
                                :id="`welcome_button_text_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'welcome_button_text',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['welcome_button_text'] &&
                                    form['welcome_button_text'][
                                        `welcome_button_text_${selectedLanguage}`
                                    ]
                                        ? form['welcome_button_text'][
                                              `welcome_button_text_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `welcome_button_text.welcome_button_text_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `welcome_button_text.welcome_button_text_${selectedLanguage}`
                                    )
                                    "
                            ></p>
                        </div>
                        
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label :for="`welcome_button_link_${selectedLanguage}`" class="block text-base lg:text-lg">Button Link<span class="text-primary">*</span></label>
                            <input
                                type="text"
                                :name="`welcome_button_link_${selectedLanguage}`"
                                :id="`welcome_button_link_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'welcome_button_link',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['welcome_button_link'] &&
                                    form['welcome_button_link'][
                                        `welcome_button_link_${selectedLanguage}`
                                    ]
                                        ? form['welcome_button_link'][
                                              `welcome_button_link_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `welcome_button_link.welcome_button_link_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `welcome_button_link.welcome_button_link_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label :for="`welcome_image_${selectedLanguage}`" class="block text-base lg:text-lg">Image</label>
                            <input
                                :key="`welcome_image_${selectedLanguage}`"
                                type="file"
                                :name="`welcome_image_${selectedLanguage}`"
                                :id="`welcome_image_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleImage(
                                        $event,
                                        language,
                                        'welcome_image',
                                        'updatePageSetting'
                                    )
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `welcome_image.welcome_image_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `welcome_image.welcome_image_${selectedLanguage}`
                                    )
                                "
                            ></p>

                            <img
                                v-if="
                                    form['welcome_image'] &&
                                    form['welcome_image'][
                                        `welcome_image_${selectedLanguage}`
                                    ]
                                "
                                :src="
                                    form['welcome_image'] &&
                                    form['welcome_image'][
                                        `welcome_image_${selectedLanguage}`
                                    ]
                                        ? form['welcome_image'][
                                              `welcome_image_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                                class="mt-4"
                                style="height: 100px; width: 100px"
                            />
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
                    <p class="card_heading font-medium">Featured school</p>
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
                        <div class="relative z-0 w-full group col-span-2">
                            <label :for="`featured_title_${selectedLanguage}`" class="block text-base lg:text-lg">Featured Section Title<span class="text-primary">*</span></label>
                            <input
                                type="text"
                                :name="`featured_title_${selectedLanguage}`"
                                :id="`featured_title_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'featured_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['featured_title'] &&
                                    form['featured_title'][
                                        `featured_title_${selectedLanguage}`
                                    ]
                                        ? form['featured_title'][
                                              `featured_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `featured_title.featured_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `featured_title.featured_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                            <!-- <div
                                class="mt-5 ckeditorText"
                                :id="`featured_description_${language.id}`"
                            ></div> -->
                            <label :for="`featured_description_${selectedLanguage}`" class="block text-base lg:text-lg">Description<span class="text-primary">*</span></label>
                            <editor
                                @selectionChange="
                                    handleSelectionChange(
                                        language,
                                        'featured_description'
                                    )
                                "
                                :ref="`featured_description_${language.id}`"
                                :id="`featured_description_${language.id}`"
                                :initial-value="form[`featured_description`][`featured_description_${language?.id}`]
                                "
                                :init="editorConfig"
                                :tinymce-script-src="tinymceScriptSrc"
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `featured_description.featured_description_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `featured_description.featured_description_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="border rounded w-full"
                :class="collapseStates[9] ? 'bg-gray-50' : ''"
            >
                <div
                    class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                    @click.prevent="collapseStates[9] = !collapseStates[9]"
                >
                    <p class="card_heading font-medium">Featured business</p>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[9]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group col-span-2">
                            <label :for="`featured_business_title_${selectedLanguage}`" class="block text-base lg:text-lg">Featured Section Title<span class="text-primary">*</span></label>
                            <input
                                type="text"
                                :name="`featured_business_title_${selectedLanguage}`"
                                :id="`featured_business_title_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'featured_business_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['featured_business_title'] &&
                                    form['featured_business_title'][
                                        `featured_business_title_${selectedLanguage}`
                                    ]
                                        ? form['featured_business_title'][
                                              `featured_business_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `featured_business_title.featured_business_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `featured_business_title.featured_business_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                            <!-- <div
                                class="mt-5 ckeditorText"
                                :id="`featured_description_${language.id}`"
                            ></div> -->
                            <label :for="`featured_business_description_${selectedLanguage}`" class="block text-base lg:text-lg">Description<span class="text-primary">*</span></label>
                            <editor
                                @selectionChange="
                                    handleSelectionChange(
                                        language,
                                        'featured_business_description'
                                    )
                                "
                                :ref="`featured_business_description_${language.id}`"
                                :id="`featured_business_description_${language.id}`"
                                :initial-value="form[`featured_business_description`][`featured_business_description_${language?.id}`]
                                "
                                :init="editorConfig"
                                :tinymce-script-src="tinymceScriptSrc"
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `featured_business_description.featured_business_description_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `featured_business_description.featured_business_description_${selectedLanguage}`
                                    )
                                "
                            ></p>
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
                    <p class="card_heading font-medium">Financial matters</p>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[2]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label :for="`article_section_1_title_${selectedLanguage}`" class="block text-base lg:text-lg">Article Section 1 Title<span class="text-primary">*</span></label>
                            <input
                                type="text"
                                :name="`article_section_1_title_${selectedLanguage}`"
                                :id="`article_section_1_title_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'article_section_1_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['article_section_1_title'] &&
                                    form['article_section_1_title'][
                                        `article_section_1_title_${selectedLanguage}`
                                    ]
                                        ? form['article_section_1_title'][
                                              `article_section_1_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `article_section_1_title.article_section_1_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `article_section_1_title.article_section_1_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label
                                :for="`article_section_1_category_id`"
                                class="block text-base lg:text-lg"
                                >Article Section 1 Category</label
                            >
                            <select
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                @change="
                                    handleChangeBanner(
                                        $event.target.value,
                                        'article_section_1_category_id'
                                    )
                                "
                            >
                                <option value="">Select</option>
                                <option
                                    v-for="(
                                        article_category, key
                                    ) in article_categories"
                                    :key="key"
                                    :value="article_category?.id"
                                    :selected="
                                        form?.article_section_1_category_id ==
                                        article_category?.id
                                    "
                                >
                                    {{
                                        article_category
                                            ?.article_category_detail?.length >
                                        0
                                            ? article_category
                                                  ?.article_category_detail[0]
                                                  ?.name
                                            : ""
                                    }}
                                </option>
                            </select>
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `article_section_1_category_id`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `article_section_1_category_id`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                            <!-- <div
                                class="mt-5 ckeditorText"
                                :id="`article_section_1_description_${language.id}`"
                            ></div> -->
                            <label
                                :for="`article_section_1_description_${selectedLanguage}`"
                                class="block text-base lg:text-lg"
                                >Description<span class="text-primary">*</span></label
                            >
                            <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'article_section_1_description'
                                )
                            "
                            :ref="`article_section_1_description_${language.id}`"
                            :id="`article_section_1_description_${language.id}`"
                            :initial-value="form[`article_section_1_description`][`article_section_1_description_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `article_section_1_description.article_section_1_description_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `article_section_1_description.article_section_1_description_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="border rounded w-full"
                :class="collapseStates[3] ? 'bg-gray-50' : ''"
            >
                <div
                    class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                    @click.prevent="collapseStates[3] = !collapseStates[3]"
                >
                    <p class="card_heading font-medium">Banner 1 Section</p>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[3]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <select
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                @change="
                                    handleChangeBanner(
                                        $event.target.value,
                                        'banner_1'
                                    )
                                "
                            >
                                <option value="">Select</option>
                                <option
                                    v-for="(banner, key) in banners"
                                    :value="banner?.id"
                                    :key="key"
                                    :selected="
                                        parseInt(form?.banner_1) ==
                                        parseInt(banner?.id)
                                    "
                                >
                                    {{ banner?.banner_detail[0]?.title }}
                                </option>
                            </select>
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="validationErros.has(`banner_1`)"
                                v-text="validationErros.get(`banner_1`)"
                            ></p>
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
                    <p class="card_heading font-medium">Work & employment</p>
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
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label
                                :for="`article_section_2_title_${selectedLanguage}`"
                                class="block text-base lg:text-lg"
                                >Article Section 2 title<span class="text-primary">*</span></label
                            >
                            <input
                                type="text"
                                :name="`article_section_2_title_${selectedLanguage}`"
                                :id="`article_section_2_title_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'article_section_2_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['article_section_2_title'] &&
                                    form['article_section_2_title'][
                                        `article_section_2_title_${selectedLanguage}`
                                    ]
                                        ? form['article_section_2_title'][
                                              `article_section_2_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `article_section_2_title.article_section_2_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `article_section_2_title.article_section_2_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label
                                :for="`article_section_2_category_id`"
                                class="block text-base lg:text-lg"
                                >Article Section 1 Category</label
                            >
                            <select
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                @change="
                                    handleChangeBanner(
                                        $event.target.value,
                                        'article_section_2_category_id'
                                    )
                                "
                            >
                                <option value="">Select</option>
                                <option
                                    v-for="(
                                        article_category, key
                                    ) in article_categories"
                                    :key="key"
                                    :value="article_category?.id"
                                    :selected="
                                        form?.article_section_2_category_id ==
                                        article_category?.id
                                    "
                                >
                                    {{
                                        article_category
                                            ?.article_category_detail?.length >
                                        0
                                            ? article_category
                                                  ?.article_category_detail[0]
                                                  ?.name
                                            : ""
                                    }}
                                </option>
                            </select>
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `article_section_2_category_id`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `article_section_2_category_id`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group md:col-span-2" v-if="isDataLoaded">
                            <!-- <div
                                class="mt-5 ckeditorText"
                                :id="`article_section_2_description_${language.id}`"
                            ></div> -->
                            <label
                                :for="`article_section_2_description_${selectedLanguage}`"
                                class="block text-base lg:text-lg"
                                >Description<span class="text-primary">*</span></label
                            >
                            <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'article_section_2_description'
                                )
                            "
                            :ref="`article_section_2_description_${language.id}`"
                            :id="`article_section_2_description_${language.id}`"
                            :initial-value="form[`article_section_2_description`][`article_section_2_description_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `article_section_2_description.article_section_2_description_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `article_section_2_description.article_section_2_description_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="border rounded w-full"
                :class="collapseStates[5] ? 'bg-gray-50' : ''"
            >
                <div
                    class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                    @click.prevent="collapseStates[5] = !collapseStates[5]"
                >
                    <p class="card_heading font-medium">Banner 2 Section</p>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[5]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <select
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                @change="
                                    handleChangeBanner(
                                        $event.target.value,
                                        'banner_2'
                                    )
                                "
                            >
                                <option value="">Select</option>
                                <option
                                    v-for="(banner, key) in banners"
                                    :value="banner?.id"
                                    :key="key"
                                    :selected="
                                        parseInt(form?.banner_2) ==
                                        parseInt(banner?.id)
                                    "
                                >
                                    {{ banner?.banner_detail[0]?.title }}
                                </option>
                            </select>
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="validationErros.has(`banner_2`)"
                                v-text="validationErros.get(`banner_2`)"
                            ></p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="border rounded w-full"
                :class="collapseStates[6] ? 'bg-gray-50' : ''"
            >
                <div
                    class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                    @click.prevent="collapseStates[6] = !collapseStates[6]"
                >
                    <p class="card_heading font-medium">Miscellaneous</p>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[6]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label
                                :for="`article_section_3_title_${selectedLanguage}`"
                                class="block text-base lg:text-lg"
                                >Article Section 3 Title<span class="text-primary">*</span></label
                            >
                            <input
                                type="text"
                                :name="`article_section_3_title_${selectedLanguage}`"
                                :id="`article_section_3_title_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'article_section_3_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['article_section_3_title'] &&
                                    form['article_section_3_title'][
                                        `article_section_3_title_${selectedLanguage}`
                                    ]
                                        ? form['article_section_3_title'][
                                              `article_section_3_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `article_section_3_title.article_section_3_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `article_section_3_title.article_section_3_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label
                                :for="`article_section_3_category_id`"
                                class="block text-base lg:text-lg"
                                >Article Section 1 Category</label
                            >
                            <select
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                @change="
                                    handleChangeBanner(
                                        $event.target.value,
                                        'article_section_3_category_id'
                                    )
                                "
                            >
                                <option value="">Select</option>
                                <option
                                    v-for="(
                                        article_category, key
                                    ) in article_categories"
                                    :key="key"
                                    :value="article_category?.id"
                                    :selected="
                                        form?.article_section_3_category_id ==
                                        article_category?.id
                                    "
                                >
                                    {{
                                        article_category
                                            ?.article_category_detail?.length >
                                        0
                                            ? article_category
                                                  ?.article_category_detail[0]
                                                  ?.name
                                            : ""
                                    }}
                                </option>
                            </select>
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `article_section_3_category_id`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `article_section_3_category_id`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                            <!-- <div
                                class="mt-5 ckeditorText"
                                :id="`article_section_3_description_${language.id}`"
                            ></div> -->
                            <label
                                :for="`article_section_3_description_${selectedLanguage}`"
                                class="block text-base lg:text-lg"
                                >Description<span class="text-primary">*</span></label
                            >
                            <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'article_section_3_description'
                                )
                            "
                            :ref="`article_section_3_description_${language.id}`"
                            :id="`article_section_3_description_${language.id}`"
                            :initial-value="form[`article_section_3_description`][`article_section_3_description_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `article_section_3_description.article_section_3_description_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `article_section_3_description.article_section_3_description_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="border rounded w-full"
                :class="collapseStates[7] ? 'bg-gray-50' : ''"
            >
                <div
                    class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                    @click.prevent="collapseStates[7] = !collapseStates[7]"
                >
                    <p class="card_heading font-medium">Articles & videos</p>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[7]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label
                                :for="`recent_article_title_${selectedLanguage}`"
                                class="block text-base lg:text-lg"
                                >Recent article Section Title<span class="text-primary">*</span></label
                            >
                            <input
                                type="text"
                                :name="`recent_article_title_${selectedLanguage}`"
                                :id="`recent_article_title_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'recent_article_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['recent_article_title'] &&
                                    form['recent_article_title'][
                                        `recent_article_title_${selectedLanguage}`
                                    ]
                                        ? form['recent_article_title'][
                                              `recent_article_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `recent_article_title.recent_article_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `recent_article_title.recent_article_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full col-span-2 group" v-if="isDataLoaded">
                            <!-- <div
                                class="mt-5 ckeditorText"
                                :id="`recent_article_description_${language.id}`"
                            ></div> -->
                            <label
                                :for="`recent_article_description_${selectedLanguage}`"
                                class="block text-base lg:text-lg"
                                >Description<span class="text-primary">*</span></label
                            >
                            <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'recent_article_description'
                                )
                            "
                            :ref="`recent_article_description_${language.id}`"
                            :id="`recent_article_description_${language.id}`"
                            :initial-value="form[`recent_article_description`][`recent_article_description_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `recent_article_description.recent_article_description_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `recent_article_description.recent_article_description_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label
                                :for="`article_card_title_${selectedLanguage}`"
                                class="block text-base lg:text-lg"
                                >Article Card Title</label
                            >
                            <input
                                type="text"
                                :name="`article_card_title_${selectedLanguage}`"
                                :id="`article_card_title_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'article_card_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['article_card_title'] &&
                                    form['article_card_title'][
                                        `article_card_title_${selectedLanguage}`
                                    ]
                                        ? form['article_card_title'][
                                              `article_card_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `article_card_title.article_card_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `article_card_title.article_card_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label
                                :for="`video_card_title_${selectedLanguage}`"
                                class="block text-base lg:text-lg"
                                >Video Card Title</label
                            >
                            <input
                                type="text"
                                :name="`video_card_title_${selectedLanguage}`"
                                :id="`video_card_title_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'video_card_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['video_card_title'] &&
                                    form['video_card_title'][
                                        `video_card_title_${selectedLanguage}`
                                    ]
                                        ? form['video_card_title'][
                                              `video_card_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `video_card_title.video_card_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `video_card_title.video_card_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label :for="`recent_article_image_${selectedLanguage}`" class="block text-base lg:text-lg">Article card image</label>
                            <input
                                :key="`recent_article_image_${selectedLanguage}`"
                                type="file"
                                :name="`recent_article_image_${selectedLanguage}`"
                                :id="`recent_article_image_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleImage(
                                        $event,
                                        language,
                                        'recent_article_image',
                                        'updatePageSetting'
                                    )
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `recent_article_image.recent_article_image_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `recent_article_image.recent_article_image_${selectedLanguage}`
                                    )
                                "
                            ></p>

                            <img
                                v-if="
                                    form['recent_article_image'] &&
                                    form['recent_article_image'][
                                        `recent_article_image_${selectedLanguage}`
                                    ]
                                "
                                :src="
                                   form['recent_article_image'] &&
                                    form['recent_article_image'][
                                        `recent_article_image_${selectedLanguage}`
                                    ]
                                        ? form['recent_article_image'][
                                              `recent_article_image_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                                class="mt-4"
                                style="height: 100px; width: 100px"
                            />
                        </div>
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <label :for="`recent_video_image_${selectedLanguage}`" class="block text-base lg:text-lg">Video card image</label>
                            <input
                                :key="`recent_video_image_${selectedLanguage}`"
                                type="file"
                                :name="`recent_video_image_${selectedLanguage}`"
                                :id="`recent_video_image_${selectedLanguage}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                placeholder=" "
                                @input="
                                    handleImage(
                                        $event,
                                        language,
                                        'recent_video_image',
                                        'updatePageSetting'
                                    )
                                "
                            />
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `recent_video_image.recent_video_image_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `recent_video_image.recent_video_image_${selectedLanguage}`
                                    )
                                "
                            ></p>

                            <img
                                v-if="
                                    form['recent_video_image'] &&
                                    form['recent_video_image'][
                                        `recent_video_image_${selectedLanguage}`
                                    ]
                                "
                                :src="
                                   form['recent_video_image'] &&
                                    form['recent_video_image'][
                                        `recent_video_image_${selectedLanguage}`
                                    ]
                                        ? form['recent_video_image'][
                                              `recent_video_image_${selectedLanguage}`
                                          ]
                                        : ''                                "
                                class="mt-4"
                                style="height: 100px; width: 100px"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="border rounded w-full"
                :class="collapseStates[8] ? 'bg-gray-50' : ''"
            >
                <div
                    class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                    @click.prevent="collapseStates[8] = !collapseStates[8]"
                >
                    <p class="card_heading font-medium">Banner 3 Section</p>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[8]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                            <select
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                                @change="
                                    handleChangeBanner(
                                        $event.target.value,
                                        'banner_3'
                                    )
                                "
                            >
                                <option value="">Select</option>
                                <option
                                    v-for="(banner, key) in banners"
                                    :value="banner?.id"
                                    :key="key"
                                    :selected="
                                        parseInt(form?.banner_3) ==
                                        parseInt(banner?.id)
                                    "
                                >
                                    {{ banner?.banner_detail[0]?.title }}
                                </option>
                            </select>
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="validationErros.has(`banner_3`)"
                                v-text="validationErros.get(`banner_3`)"
                            ></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ListErrors :validationErrors="validationErros" />
        <button
            type="submit"
            class="can-edu-btn-fill dark:bg-primary dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        >
            Submit
        </button>
    </form>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    props: ["selectedLanguage"],
    computed: {
        ...mapState({
            form: (state) => state.home_page_setting.form,
            validationErros: (state) => state.home_page_setting.validationErros,
            languages: (state) => state.languages.languages,
            banners: (state) => state.banners.banners,
            article_categories: (state) =>
                state.article_categories.article_categories,
        }),
    },
    components:{
        ListErrors,
        editor: Editor
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
        handleChangeBanner(value, key) {
            this.$store.commit(`home_page_setting/setBanner`, {
                value,
                key,
            });
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`home_page_setting/updatePageSetting`, {
                value: content,
                id: language.id,
                key:key,
            });
            if (content.trim()) {
        this.validationErros.clear(`${key}.${key}_${language.id}`);
      }
        },
        handleInput(value, language, key, mutationName) {
            this.$store.commit(`home_page_setting/${mutationName}`, {
                value: value,
                id: language.id,
                key,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        handleImage(e, language, key, mutationName) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.$store.commit(`home_page_setting/${mutationName}`, {
                        value: res?.data,
                        id: language.id,
                        key,
                    });
                });
        },
        addUpdateForm() {
            this.$store
                .dispatch("home_page_setting/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$emit("addUpdateFormParent");

                        this.$router.push({ name: "admin.pages.index" });
                    }
                })
                .catch((error) => {
                    console.error("An error occurred:", error);
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
            const languageSpecificFieldName = `${fieldName}_${this.selectedLanguage}`;
            console.log("Stripped error field name:", fieldName);
            console.log("Language-specific field name:", languageSpecificFieldName);

            let inputElement = document.querySelector(
                `[name="${languageSpecificFieldName}"], [v-model="${fieldName}"], [data-v-model="${fieldName}"], [data-value="${fieldName}"]`
            );

            if (!inputElement) {
                console.log(`No standard input field found for ${languageSpecificFieldName}, checking for rich text editor...`);

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
                console.log(`No input field found for ${languageSpecificFieldName}`);
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchHomePageSetting() {
            this.$store
                .dispatch("home_page_setting/fetchHomePageSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}home-page-setting`,
                })
                .then((res) => {
                    this.$store.commit("home_page_setting/setBanner", {
                        key: "article_section_1_category_id",
                        value: res.data.data?.article_section_1_category_id,
                    });
                    this.$store.commit("home_page_setting/setBanner", {
                        key: "article_section_2_category_id",
                        value: res.data.data?.article_section_2_category_id,
                    });
                    this.$store.commit("home_page_setting/setBanner", {
                        key: "article_section_3_category_id",
                        value: res.data.data?.article_section_3_category_id,
                    });
                    this.$store.commit("home_page_setting/setBanner", {
                        key: "banner_1",
                        value: res.data.data?.banner_1,
                    });
                    this.$store.commit("home_page_setting/setBanner", {
                        key: "banner_2",
                        value: res.data.data?.banner_2,
                    });
                    this.$store.commit("home_page_setting/setBanner", {
                        key: "banner_3",
                        value: res.data.data?.banner_3,
                    });

                    let data =
                        res.data.data && res.data.data.home_page_setting_detail
                            ? res.data.data.home_page_setting_detail
                            : [];

                    //welcome settings
                    let obj = {};
                    data.map((res) => {
                        obj["welcome_title_" + res.language_id] =
                            res.welcome_title;
                    });
                    this.$store.commit("home_page_setting/setPageSetting", {
                        key: "welcome_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["welcome_button_text_" + res.language_id] =
                            res.welcome_button_text;
                    });
                    this.$store.commit("home_page_setting/setPageSetting", {
                        key: "welcome_button_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["welcome_button_link_" + res.language_id] =
                            res.welcome_button_link;
                    });
                    this.$store.commit("home_page_setting/setPageSetting", {
                        key: "welcome_button_link",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["welcome_image_" + res.language_id] =
                            res.welcome_image;
                    });
                    this.$store.commit("home_page_setting/setPageSetting", {
                        key: "welcome_image",
                        value: obj,
                    });

                    //featureed
                    obj = {};
                    data.map((res) => {
                        obj["featured_title_" + res.language_id] =
                            res.featured_title;
                    });
                    this.$store.commit("home_page_setting/setPageSetting", {
                        key: "featured_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["featured_business_title_" + res.language_id] =
                            res.featured_business_title;
                    });
                    this.$store.commit("home_page_setting/setPageSetting", {
                        key: "featured_business_title",
                        value: obj,
                    });

                    //financial
                    obj = {};
                    data.map((res) => {
                        obj["article_section_1_title_" + res.language_id] =
                            res.article_section_1_title;
                    });
                    this.$store.commit("home_page_setting/setPageSetting", {
                        key: "article_section_1_title",
                        value: obj,
                    });

                    //article_section_2
                    obj = {};
                    data.map((res) => {
                        obj["article_section_2_title_" + res.language_id] =
                            res.article_section_2_title;
                    });
                    this.$store.commit("home_page_setting/setPageSetting", {
                        key: "article_section_2_title",
                        value: obj,
                    });

                    //article_section_3
                    obj = {};
                    data.map((res) => {
                        obj["article_section_3_title_" + res.language_id] =
                            res.article_section_3_title;
                    });
                    this.$store.commit("home_page_setting/setPageSetting", {
                        key: "article_section_3_title",
                        value: obj,
                    });

                    //recent
                    obj = {};
                    data.map((res) => {
                        obj["recent_article_title_" + res.language_id] =
                            res.recent_article_title;
                    });
                    this.$store.commit("home_page_setting/setPageSetting", {
                        key: "recent_article_title",
                        value: obj,
                    });

                    setTimeout(() => {
                        obj = {};
                        data.map((res) => {
                            obj["welcome_description_" + res.language_id] =
                                res.welcome_description;
                        });
                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "welcome_description",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["featured_description_" + res.language_id] =
                                res.featured_description;
                        });

                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "featured_description",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["featured_business_description_" + res.language_id] =
                                res.featured_business_description;
                        });

                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "featured_business_description",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj[
                                "article_section_1_description_" +
                                    res.language_id
                            ] = res.article_section_1_description;
                        });
                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "article_section_1_description",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            
                            obj[
                                "article_section_2_description_" +
                                    res.language_id
                            ] = res.article_section_2_description;
                        });
                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "article_section_2_description",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj[
                                "article_section_3_description_" +
                                    res.language_id
                            ] = res.article_section_3_description;
                        });
                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "article_section_3_description",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj[
                                "recent_article_description_" + res.language_id
                            ] = res.recent_article_description;
                        });
                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "recent_article_description",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj["article_card_title_" + res.language_id] =
                                res.article_card_title;
                        });
                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "article_card_title",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj["video_card_title_" + res.language_id] =
                                res.video_card_title;
                        });
                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "video_card_title",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj["recent_article_image_" + res.language_id] =
                                res.recent_article_image;
                        });
                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "recent_article_image",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj["recent_video_image_" + res.language_id] =
                                res.recent_video_image;
                        });
                        this.$store.commit("home_page_setting/setPageSetting", {
                            key: "recent_video_image",
                            value: obj,
                        });
                        this.isDataLoaded = 1;
                    }, 1000);
                });
            this.$store.dispatch("banners/fetchBanners");
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(
                    `welcome_title.welcome_title_${language.id}`
                ) ||
                validationErros.has(
                    `welcome_description.welcome_description_${language.id}`
                ) ||
                validationErros.has(
                    `welcome_button_text.welcome_button_text_${language.id}`
                ) ||
                validationErros.has(
                    `welcome_button_link.welcome_button_link_${language.id}`
                ) ||
                validationErros.has(
                    `welcome_image.welcome_image_${language.id}`
                ) ||
                validationErros.has(
                    `featured_title.featured_title_${language.id}`
                ) ||
                validationErros.has(
                    `featured_business_title.featured_business_title_${language.id}`
                ) ||
                validationErros.has(
                    `featured_description.featured_description_${language.id}`
                ) ||
                validationErros.has(
                    `featured_business_description.featured_business_description_${language.id}`
                ) ||
                validationErros.has(
                    `article_section_1_title.article_section_1_title_${language.id}`
                ) ||
                validationErros.has(
                    `article_section_1_description.article_section_1_description_${language.id}`
                ) ||
                validationErros.has(
                    `article_section_2_title.article_section_2_title_${language.id}`
                ) ||
                validationErros.has(
                    `article_section_2_description.article_section_2_description_${language.id}`
                ) ||
                validationErros.has(
                    `article_section_3_title.article_section_3_title_${language.id}`
                ) ||
                validationErros.has(
                    `article_section_3_description.article_section_3_description_${language.id}`
                ) ||
                validationErros.has(
                    `recent_article_title.recent_article_title_${language.id}`
                ) ||
                validationErros.has(
                    `recent_article_description.recent_article_description_${language.id}`
                ) ||
                validationErros.has(
                    `article_card_title.article_card_title_${language.id}`
                ) ||
                validationErros.has(
                    `video_card_title.video_card_title_${language.id}`
                ) ||
                validationErros.has(
                    `recent_article_image.recent_article_image_${language.id}`
                ) ||
                validationErros.has(
                    `recent_video_image.recent_video_image_${language.id}`
                )
            );
        },
    },
    created() {
        this.$store.commit("home_page_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["welcome_title_" + res.id] = "";
                });

                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "welcome_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["welcome_description_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "welcome_description",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["featured_title_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "featured_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["featured_business_title_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "featured_business_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["featured_description_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "featured_description",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["featured_business_description_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "featured_business_description",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["article_section_1_title_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "article_section_1_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["article_section_1_description_" + res.id] = "";
                });

                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "article_section_1_description",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["article_section_2_title_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "article_section_2_title",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["article_section_2_description_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "article_section_2_description",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["article_section_3_title_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "article_section_3_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["article_section_3_description_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "article_section_3_description",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["recent_article_title_" + res.id] = "";
                });

                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "recent_article_title",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["recent_article_description_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "recent_article_description",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["welcom_button_text_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "welcom_button_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["welcom_button_link_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "welcom_button_link",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["welcom_button_image_" + res.id] = "";
                });
                this.$store.commit("home_page_setting/setPageSetting", {
                    key: "welcom_button_image",
                    value: obj,
                });
                if(this.$route.params.id){
                    this.fetchHomePageSetting();
                }
                else{
                    this.isDataLoaded = 1;
                }

                this.$store.commit("article_categories/setLimit", 20000);
                this.$store.commit("article_categories/setSortBy", "id");
                this.$store.commit("article_categories/setSortType", "desc");
                this.$store
                    .dispatch("article_categories/fetchArticleCategories")
                    .then((res) => {
                        if (res?.data?.data?.length > 0) {
                            this.local_categories = [];
                            for (var i = 0; i < res?.data?.data?.length; i++) {
                                this.local_categories.push({
                                    id: res?.data?.data[i].id,
                                    text:
                                        res?.data?.data[i]
                                            ?.article_category_detail?.length >
                                        0
                                            ? res?.data?.data[i]
                                                  ?.article_category_detail[0]
                                                  ?.name
                                            : "abc",
                                });
                            }
                        }
                    });
            });
    },
    watch: {
        selectedLanguage: function (newVal, oldVal) {
        },
    },
};
</script>
