<template>
    <header class="my-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">Register business setting</h1>
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
            <div class="grid my-5 md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full group">
                    <label
                        :for="`page_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Page title</label
                    >
                    <input
                        type="text"
                        :name="`page_title_${selectedLanguage}`"
                        :id="`page_title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'page_title',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['page_title'] &&
                            form['page_title'][`page_title_${selectedLanguage}`]
                                ? form['page_title'][
                                      `page_title_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `page_title.page_title_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `page_title.page_title_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`package_section_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category title</label
                    >
                    <input
                        type="text"
                        :name="`package_section_title_${selectedLanguage}`"
                        :id="`package_section_title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'package_section_title',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['package_section_title'] &&
                            form['package_section_title'][
                                `package_section_title_${selectedLanguage}`
                            ]
                                ? form['package_section_title'][
                                      `package_section_title_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `package_section_title.package_section_title_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `package_section_title.package_section_title_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_category_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category main text</label
                    >
                    <input
                        type="text"
                        :name="`business_category_text_${selectedLanguage}`"
                        :id="`business_category_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_category_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_category_text'] &&
                            form['business_category_text'][
                                `business_category_text_${selectedLanguage}`
                            ]
                                ? form['business_category_text'][
                                      `business_category_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_category_text.business_category_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_category_text.business_category_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- first name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_category_1_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category 1 label</label
                    >
                    <input
                        type="text"
                        :name="`business_category_1_lable_${selectedLanguage}`"
                        :id="`business_category_1_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_category_1_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_category_1_lable'] &&
                            form['business_category_1_lable'][
                                `business_category_1_lable_${selectedLanguage}`
                            ]
                                ? form['business_category_1_lable'][
                                      `business_category_1_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_category_1_lable.business_category_1_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_category_1_lable.business_category_1_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_category_1_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category 1 placeholder</label
                    >
                    <input
                        type="text"
                        :name="`business_category_1_placeholder_${selectedLanguage}`"
                        :id="`business_category_1_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_category_1_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_category_1_placeholder'] &&
                            form['business_category_1_placeholder'][
                                `business_category_1_placeholder_${selectedLanguage}`
                            ]
                                ? form['business_category_1_placeholder'][
                                      `business_category_1_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_category_1_placeholder.business_category_1_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_category_1_placeholder.business_category_1_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_category_1_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category 1 error</label
                    >
                    <input
                        type="text"
                        :name="`business_category_1_error_${selectedLanguage}`"
                        :id="`business_category_1_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_category_1_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_category_1_error'] &&
                            form['business_category_1_error'][
                                `business_category_1_error_${selectedLanguage}`
                            ]
                                ? form['business_category_1_error'][
                                      `business_category_1_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_category_1_error.business_category_1_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_category_1_error.business_category_1_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- last name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_category_2_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category 2 label</label
                    >
                    <input
                        type="text"
                        :name="`business_category_2_lable_${selectedLanguage}`"
                        :id="`business_category_2_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_category_2_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_category_2_lable'] &&
                            form['business_category_2_lable'][
                                `business_category_2_lable_${selectedLanguage}`
                            ]
                                ? form['business_category_2_lable'][
                                      `business_category_2_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_category_2_lable.business_category_2_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_category_2_lable.business_category_2_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_category_2_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category 2 placeholder</label
                    >
                    <input
                        type="text"
                        :name="`business_category_2_placeholder_${selectedLanguage}`"
                        :id="`business_category_2_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_category_2_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_category_2_placeholder'] &&
                            form['business_category_2_placeholder'][
                                `business_category_2_placeholder_${selectedLanguage}`
                            ]
                                ? form['business_category_2_placeholder'][
                                      `business_category_2_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_category_2_placeholder.business_category_2_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_category_2_placeholder.business_category_2_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_category_2_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category 2 error</label
                    >
                    <input
                        type="text"
                        :name="`business_category_2_error_${selectedLanguage}`"
                        :id="`business_category_2_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_category_2_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_category_2_error'] &&
                            form['business_category_2_error'][
                                `business_category_2_error_${selectedLanguage}`
                            ]
                                ? form['business_category_2_error'][
                                      `business_category_2_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_category_2_error.business_category_2_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_category_2_error.business_category_2_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- email -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_category_3_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category 3 label</label
                    >
                    <input
                        type="text"
                        :name="`business_category_3_lable_${selectedLanguage}`"
                        :id="`business_category_3_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_category_3_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_category_3_lable'] &&
                            form['business_category_3_lable'][
                                `business_category_3_lable_${selectedLanguage}`
                            ]
                                ? form['business_category_3_lable'][
                                      `business_category_3_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_category_3_lable.business_category_3_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_category_3_lable.business_category_3_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_category_3_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category 3 placeholder</label
                    >
                    <input
                        type="text"
                        :name="`business_category_3_placeholder_${selectedLanguage}`"
                        :id="`business_category_3_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_category_3_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_category_3_placeholder'] &&
                            form['business_category_3_placeholder'][
                                `business_category_3_placeholder_${selectedLanguage}`
                            ]
                                ? form['business_category_3_placeholder'][
                                      `business_category_3_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_category_3_placeholder.business_category_3_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_category_3_placeholder.business_category_3_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_category_3_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business Category 3 error</label
                    >
                    <input
                        type="text"
                        :name="`business_category_3_error_${selectedLanguage}`"
                        :id="`business_category_3_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_category_3_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_category_3_error'] &&
                            form['business_category_3_error'][
                                `business_category_3_error_${selectedLanguage}`
                            ]
                                ? form['business_category_3_error'][
                                      `business_category_3_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_category_3_error.business_category_3_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_category_3_error.business_category_3_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`description_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Description label</label
                    >
                    <input
                        type="text"
                        :name="`description_lable_${selectedLanguage}`"
                        :id="`description_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'description_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['description_lable'] &&
                            form['description_lable'][
                                `description_lable_${selectedLanguage}`
                            ]
                                ? form['description_lable'][
                                      `description_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `description_lable.description_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `description_lable.description_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`description_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Description placeholder</label
                    >
                    <input
                        type="text"
                        :name="`description_placeholder_${selectedLanguage}`"
                        :id="`description_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'description_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['description_placeholder'] &&
                            form['description_placeholder'][
                                `description_placeholder_${selectedLanguage}`
                            ]
                                ? form['description_placeholder'][
                                      `description_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `description_placeholder.description_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `description_placeholder.description_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`description_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Description error</label
                    >
                    <input
                        type="text"
                        :name="`description_error_${selectedLanguage}`"
                        :id="`description_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'description_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['description_error'] &&
                            form['description_error'][
                                `description_error_${selectedLanguage}`
                            ]
                                ? form['description_error'][
                                      `description_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `description_error.description_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `description_error.description_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                
                <div class="relative z-0 w-full group">
                    <label
                        :for="`detail_description_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Detailed business description label</label
                    >
                    <input
                        type="text"
                        :name="`detail_description_lable_${selectedLanguage}`"
                        :id="`detail_description_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'detail_description_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['detail_description_lable'] &&
                            form['detail_description_lable'][
                                `detail_description_lable_${selectedLanguage}`
                            ]
                                ? form['detail_description_lable'][
                                      `detail_description_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `detail_description_lable.detail_description_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `detail_description_lable.detail_description_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`detail_description_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Detailed business description placeholder</label
                    >
                    <input
                        type="text"
                        :name="`detail_description_placeholder_${selectedLanguage}`"
                        :id="`detail_description_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'detail_description_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['detail_description_placeholder'] &&
                            form['detail_description_placeholder'][
                                `detail_description_placeholder_${selectedLanguage}`
                            ]
                                ? form['detail_description_placeholder'][
                                      `detail_description_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `detail_description_placeholder.detail_description_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `detail_description_placeholder.detail_description_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`detail_description_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Detailed business description error</label
                    >
                    <input
                        type="text"
                        :name="`detail_description_error_${selectedLanguage}`"
                        :id="`detail_description_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'detail_description_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['detail_description_error'] &&
                            form['detail_description_error'][
                                `detail_description_error_${selectedLanguage}`
                            ]
                                ? form['detail_description_error'][
                                      `detail_description_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `detail_description_error.detail_description_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `detail_description_error.detail_description_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`keywords_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Keywords label</label
                    >
                    <input
                        type="text"
                        :name="`keywords_label_${selectedLanguage}`"
                        :id="`keywords_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'keywords_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['keywords_label'] &&
                            form['keywords_label'][
                                `keywords_label_${selectedLanguage}`
                            ]
                                ? form['keywords_label'][
                                      `keywords_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `keywords_label.keywords_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `keywords_label.keywords_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`keywords_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Keywords placeholder</label
                    >
                    <input
                        type="text"
                        :name="`keywords_placeholder_${selectedLanguage}`"
                        :id="`keywords_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'keywords_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['keywords_placeholder'] &&
                            form['keywords_placeholder'][
                                `keywords_placeholder_${selectedLanguage}`
                            ]
                                ? form['keywords_placeholder'][
                                      `keywords_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `keywords_placeholder.keywords_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `keywords_placeholder.keywords_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`keywords_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Keywords error</label
                    >
                    <input
                        type="text"
                        :name="`keywords_error_${selectedLanguage}`"
                        :id="`keywords_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'keywords_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['keywords_error'] &&
                            form['keywords_error'][
                                `keywords_error_${selectedLanguage}`
                            ]
                                ? form['keywords_error'][
                                      `keywords_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `keywords_error.keywords_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `keywords_error.keywords_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`business_profile_heading_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Business profile heading text</label
                    >
                    <input
                        type="text"
                        :name="`business_profile_heading_text_${selectedLanguage}`"
                        :id="`business_profile_heading_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'business_profile_heading_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['business_profile_heading_text'] &&
                            form['business_profile_heading_text'][
                                `business_profile_heading_text_${selectedLanguage}`
                            ]
                                ? form['business_profile_heading_text'][
                                      `business_profile_heading_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `business_profile_heading_text.business_profile_heading_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `business_profile_heading_text.business_profile_heading_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`registration_package_heading_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Registration package heading text</label
                    >
                    <input
                        type="text"
                        :name="`registration_package_heading_text_${selectedLanguage}`"
                        :id="`registration_package_heading_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'registration_package_heading_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['registration_package_heading_text'] &&
                            form['registration_package_heading_text'][
                                `registration_package_heading_text_${selectedLanguage}`
                            ]
                                ? form['registration_package_heading_text'][
                                      `registration_package_heading_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `registration_package_heading_text.registration_package_heading_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `registration_package_heading_text.registration_package_heading_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Name label</label
                    >
                    <input
                        type="text"
                        :name="`name_lable_${selectedLanguage}`"
                        :id="`name_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['name_lable'] &&
                            form['name_lable'][
                                `name_lable_${selectedLanguage}`
                            ]
                                ? form['name_lable'][
                                      `name_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `name_lable.name_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `name_lable.name_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Name placeholder</label
                    >
                    <input
                        type="text"
                        :name="`name_placeholder_${selectedLanguage}`"
                        :id="`name_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['name_placeholder'] &&
                            form['name_placeholder'][
                                `name_placeholder_${selectedLanguage}`
                            ]
                                ? form['name_placeholder'][
                                      `name_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `name_placeholder.name_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `name_placeholder.name_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Name error</label
                    >
                    <input
                        type="text"
                        :name="`name_error_${selectedLanguage}`"
                        :id="`name_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['name_error'] &&
                            form['name_error'][
                                `name_error_${selectedLanguage}`
                            ]
                                ? form['name_error'][
                                      `name_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `name_error.name_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `name_error.name_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`website_url_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Website URL label</label
                    >
                    <input
                        type="text"
                        :name="`website_url_lable_${selectedLanguage}`"
                        :id="`website_url_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'website_url_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['website_url_lable'] &&
                            form['website_url_lable'][
                                `website_url_lable_${selectedLanguage}`
                            ]
                                ? form['website_url_lable'][
                                      `website_url_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `website_url_lable.website_url_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `website_url_lable.website_url_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`website_url_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Website URL placeholder</label
                    >
                    <input
                        type="text"
                        :name="`website_url_placeholder_${selectedLanguage}`"
                        :id="`website_url_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'website_url_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['website_url_placeholder'] &&
                            form['website_url_placeholder'][
                                `website_url_placeholder_${selectedLanguage}`
                            ]
                                ? form['website_url_placeholder'][
                                      `website_url_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `website_url_placeholder.website_url_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `website_url_placeholder.website_url_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`website_url_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Website URL error</label
                    >
                    <input
                        type="text"
                        :name="`website_url_error_${selectedLanguage}`"
                        :id="`website_url_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'website_url_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['website_url_error'] &&
                            form['website_url_error'][
                                `website_url_error_${selectedLanguage}`
                            ]
                                ? form['website_url_error'][
                                      `website_url_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `website_url_error.website_url_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `website_url_error.website_url_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- confirm password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`contact_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Contact label</label
                    >
                    <input
                        type="text"
                        :name="`contact_lable_${selectedLanguage}`"
                        :id="`contact_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'contact_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['contact_lable'] &&
                            form['contact_lable'][
                                `contact_lable_${selectedLanguage}`
                            ]
                                ? form['contact_lable'][
                                      `contact_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `contact_lable.contact_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `contact_lable.contact_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`contact_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Contact placeholder</label
                    >
                    <input
                        type="text"
                        :name="`contact_placeholder_${selectedLanguage}`"
                        :id="`contact_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'contact_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['contact_placeholder'] &&
                            form['contact_placeholder'][
                                `contact_placeholder_${selectedLanguage}`
                            ]
                                ? form['contact_placeholder'][
                                      `contact_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `contact_placeholder.contact_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `contact_placeholder.contact_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`contact_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Contact error</label
                    >
                    <input
                        type="text"
                        :name="`contact_error_${selectedLanguage}`"
                        :id="`contact_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'contact_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['contact_error'] &&
                            form['contact_error'][
                                `contact_error_${selectedLanguage}`
                            ]
                                ? form['contact_error'][
                                      `contact_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `contact_error.contact_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `contact_error.contact_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- email_lable password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email label</label
                    >
                    <input
                        type="text"
                        :name="`email_lable_${selectedLanguage}`"
                        :id="`email_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_lable'] &&
                            form['email_lable'][
                                `email_lable_${selectedLanguage}`
                            ]
                                ? form['email_lable'][
                                      `email_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_lable.email_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_lable.email_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email placeholder</label
                    >
                    <input
                        type="text"
                        :name="`email_placeholder_${selectedLanguage}`"
                        :id="`email_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_placeholder'] &&
                            form['email_placeholder'][
                                `email_placeholder_${selectedLanguage}`
                            ]
                                ? form['email_placeholder'][
                                      `email_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_placeholder.email_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_placeholder.email_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email error</label
                    >
                    <input
                        type="text"
                        :name="`email_error_${selectedLanguage}`"
                        :id="`email_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_error'] &&
                            form['email_error'][
                                `email_error_${selectedLanguage}`
                            ]
                                ? form['email_error'][
                                      `email_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_error.email_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_error.email_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`password_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Select password label</label
                    >
                    <input
                        type="text"
                        :name="`password_label_${selectedLanguage}`"
                        :id="`password_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'password_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['password_label'] &&
                            form['password_label'][
                                `password_label_${selectedLanguage}`
                            ]
                                ? form['password_label'][
                                      `password_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `password_label.password_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `password_label.password_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`password_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Select password placeholder</label
                    >
                    <input
                        type="text"
                        :name="`password_placeholder_${selectedLanguage}`"
                        :id="`password_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'password_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['password_placeholder'] &&
                            form['password_placeholder'][
                                `password_placeholder_${selectedLanguage}`
                            ]
                                ? form['password_placeholder'][
                                      `password_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `password_placeholder.password_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `password_placeholder.password_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`password_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Select password error</label
                    >
                    <input
                        type="text"
                        :name="`password_error_${selectedLanguage}`"
                        :id="`password_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'password_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['password_error'] &&
                            form['password_error'][
                                `password_error_${selectedLanguage}`
                            ]
                                ? form['password_error'][
                                      `password_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `password_error.password_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `password_error.password_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`confirm_password_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Confirm password label</label
                    >
                    <input
                        type="text"
                        :name="`confirm_password_label_${selectedLanguage}`"
                        :id="`confirm_password_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'confirm_password_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['confirm_password_label'] &&
                            form['confirm_password_label'][
                                `confirm_password_label_${selectedLanguage}`
                            ]
                                ? form['confirm_password_label'][
                                      `confirm_password_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `confirm_password_label.confirm_password_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `confirm_password_label.confirm_password_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`confirm_password_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Confirm password placeholder</label
                    >
                    <input
                        type="text"
                        :name="`confirm_password_placeholder_${selectedLanguage}`"
                        :id="`confirm_password_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'confirm_password_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['confirm_password_placeholder'] &&
                            form['confirm_password_placeholder'][
                                `confirm_password_placeholder_${selectedLanguage}`
                            ]
                                ? form['confirm_password_placeholder'][
                                      `confirm_password_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `confirm_password_placeholder.confirm_password_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `confirm_password_placeholder.confirm_password_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`confirm_password_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Confirm password error</label
                    >
                    <input
                        type="text"
                        :name="`confirm_password_error_${selectedLanguage}`"
                        :id="`confirm_password_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'confirm_password_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['confirm_password_error'] &&
                            form['confirm_password_error'][
                                `confirm_password_error_${selectedLanguage}`
                            ]
                                ? form['confirm_password_error'][
                                      `confirm_password_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `confirm_password_error.confirm_password_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `confirm_password_error.confirm_password_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- phone_lable password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`phone_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone no label</label
                    >
                    <input
                        type="text"
                        :name="`phone_lable_${selectedLanguage}`"
                        :id="`phone_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'phone_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['phone_lable'] &&
                            form['phone_lable'][
                                `phone_lable_${selectedLanguage}`
                            ]
                                ? form['phone_lable'][
                                      `phone_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `phone_lable.phone_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `phone_lable.phone_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`phone_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone no placeholder</label
                    >
                    <input
                        type="text"
                        :name="`phone_placeholder_${selectedLanguage}`"
                        :id="`phone_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'phone_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['phone_placeholder'] &&
                            form['phone_placeholder'][
                                `phone_placeholder_${selectedLanguage}`
                            ]
                                ? form['phone_placeholder'][
                                      `phone_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `phone_placeholder.phone_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `phone_placeholder.phone_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`phone_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone no error</label
                    >
                    <input
                        type="text"
                        :name="`phone_error_${selectedLanguage}`"
                        :id="`phone_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'phone_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['phone_error'] &&
                            form['phone_error'][
                                `phone_error_${selectedLanguage}`
                            ]
                                ? form['phone_error'][
                                      `phone_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `phone_error.phone_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `phone_error.phone_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- address_lable password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`address_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Address label</label
                    >
                    <input
                        type="text"
                        :name="`address_lable_${selectedLanguage}`"
                        :id="`address_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'address_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['address_lable'] &&
                            form['address_lable'][
                                `address_lable_${selectedLanguage}`
                            ]
                                ? form['address_lable'][
                                      `address_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `address_lable.address_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `address_lable.address_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`address_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Address placeholder</label
                    >
                    <input
                        type="text"
                        :name="`address_placeholder_${selectedLanguage}`"
                        :id="`address_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'address_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['address_placeholder'] &&
                            form['address_placeholder'][
                                `address_placeholder_${selectedLanguage}`
                            ]
                                ? form['address_placeholder'][
                                      `address_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `address_placeholder.address_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `address_placeholder.address_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`address_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Address error</label
                    >
                    <input
                        type="text"
                        :name="`address_error_${selectedLanguage}`"
                        :id="`address_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'address_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['address_error'] &&
                            form['address_error'][
                                `address_error_${selectedLanguage}`
                            ]
                                ? form['address_error'][
                                      `address_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `address_error.address_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `address_error.address_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                       <!-- logo_lable password -->
                       <div class="relative z-0 w-full group">
                        <label
                            :for="`logo_lable_${selectedLanguage}`"
                            class="block text-base lg:text-lg"
                            >Logo label</label
                        >
                        <input
                            type="text"
                            :name="`logo_lable_${selectedLanguage}`"
                            :id="`logo_lable_${selectedLanguage}`"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'logo_lable',
                                    'updatePageSetting'
                                )
                            "
                            :value="
                                form['logo_lable'] &&
                                form['logo_lable'][
                                    `logo_lable_${selectedLanguage}`
                                ]
                                    ? form['logo_lable'][
                                          `logo_lable_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(
                                    `logo_lable.logo_lable_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `logo_lable.logo_lable_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>
    
                    <!-- <div class="relative z-0 w-full group">
                        <label
                            :for="`logo_placeholder_${selectedLanguage}`"
                            class="block text-base lg:text-lg"
                            >Logo placeholder</label
                        >
                        <input
                            type="text"
                            :name="`logo_placeholder_${selectedLanguage}`"
                            :id="`logo_placeholder_${selectedLanguage}`"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'logo_placeholder',
                                    'updatePageSetting'
                                )
                            "
                            :value="
                                form['logo_placeholder'] &&
                                form['logo_placeholder'][
                                    `logo_placeholder_${selectedLanguage}`
                                ]
                                    ? form['logo_placeholder'][
                                          `logo_placeholder_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(
                                    `logo_placeholder.logo_placeholder_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `logo_placeholder.logo_placeholder_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div> -->
    
                    <div class="relative z-0 w-full group">
                        <label
                            :for="`logo_error_${selectedLanguage}`"
                            class="block text-base lg:text-lg"
                            >Logo error</label
                        >
                        <input
                            type="text"
                            :name="`logo_error_${selectedLanguage}`"
                            :id="`logo_error_${selectedLanguage}`"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'logo_error',
                                    'updatePageSetting'
                                )
                            "
                            :value="
                                form['logo_error'] &&
                                form['logo_error'][
                                    `logo_error_${selectedLanguage}`
                                ]
                                    ? form['logo_error'][
                                          `logo_error_${selectedLanguage}`
                                      ]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(
                                    `logo_error.logo_error_${selectedLanguage}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `logo_error.logo_error_${selectedLanguage}`
                                )
                            "
                        ></p>
                    </div>

                <!-- file_lable password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`media_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Media section title</label
                    >
                    <input
                        type="text"
                        :name="`media_title_${selectedLanguage}`"
                        :id="`media_title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'media_title',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['media_title'] &&
                            form['media_title'][`media_title_${selectedLanguage}`]
                                ? form['media_title'][
                                      `media_title_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `media_title.media_title_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `media_title.media_title_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`media_title_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Media title label</label
                    >
                    <input
                        type="text"
                        :name="`media_title_label_${selectedLanguage}`"
                        :id="`media_title_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'media_title_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['media_title_label'] &&
                            form['media_title_label'][`media_title_label_${selectedLanguage}`]
                                ? form['media_title_label'][
                                      `media_title_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `media_title_label.media_title_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `media_title_label.media_title_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`media_title_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Media title placeholder</label
                    >
                    <input
                        type="text"
                        :name="`media_title_placeholder_${selectedLanguage}`"
                        :id="`media_title_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'media_title_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['media_title_placeholder'] &&
                            form['media_title_placeholder'][`media_title_placeholder_${selectedLanguage}`]
                                ? form['media_title_placeholder'][
                                      `media_title_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `media_title_placeholder.media_title_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `media_title_placeholder.media_title_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`media_title_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Media title error</label
                    >
                    <input
                        type="text"
                        :name="`media_title_error_${selectedLanguage}`"
                        :id="`media_title_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'media_title_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['media_title_error'] &&
                            form['media_title_error'][`media_title_error_${selectedLanguage}`]
                                ? form['media_title_error'][
                                      `media_title_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `media_title_error.media_title_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `media_title_error.media_title_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`media_description_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Media description label</label
                    >
                    <input
                        type="text"
                        :name="`media_description_label_${selectedLanguage}`"
                        :id="`media_description_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'media_description_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['media_description_label'] &&
                            form['media_description_label'][`media_description_label_${selectedLanguage}`]
                                ? form['media_description_label'][
                                      `media_description_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `media_description_label.media_description_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `media_description_label.media_description_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`media_description_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Media description placeholder</label
                    >
                    <input
                        type="text"
                        :name="`media_description_placeholder_${selectedLanguage}`"
                        :id="`media_description_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'media_description_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['media_description_placeholder'] &&
                            form['media_description_placeholder'][`media_description_placeholder_${selectedLanguage}`]
                                ? form['media_description_placeholder'][
                                      `media_description_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `media_description_placeholder.media_description_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `media_description_placeholder.media_description_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`media_description_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Media description error</label
                    >
                    <input
                        type="text"
                        :name="`media_description_error_${selectedLanguage}`"
                        :id="`media_description_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'media_description_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['media_description_error'] &&
                            form['media_description_error'][`media_description_error_${selectedLanguage}`]
                                ? form['media_description_error'][
                                      `media_description_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `media_description_error.media_description_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `media_description_error.media_description_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`welcome_video_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Welcome video label</label
                    >
                    <input
                        type="text"
                        :name="`welcome_video_label_${selectedLanguage}`"
                        :id="`welcome_video_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'welcome_video_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['welcome_video_label'] &&
                            form['welcome_video_label'][`welcome_video_label_${selectedLanguage}`]
                                ? form['welcome_video_label'][
                                      `welcome_video_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `welcome_video_label.welcome_video_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `welcome_video_label.welcome_video_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`welcome_video_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Welcome video placeholder</label
                    >
                    <input
                        type="text"
                        :name="`welcome_video_placeholder_${selectedLanguage}`"
                        :id="`welcome_video_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'welcome_video_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['welcome_video_placeholder'] &&
                            form['welcome_video_placeholder'][`welcome_video_placeholder_${selectedLanguage}`]
                                ? form['welcome_video_placeholder'][
                                      `welcome_video_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `welcome_video_placeholder.welcome_video_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `welcome_video_placeholder.welcome_video_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`welcome_video_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Welcome video error</label
                    >
                    <input
                        type="text"
                        :name="`welcome_video_error_${selectedLanguage}`"
                        :id="`welcome_video_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'welcome_video_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['welcome_video_error'] &&
                            form['welcome_video_error'][`welcome_video_error_${selectedLanguage}`]
                                ? form['welcome_video_error'][
                                      `welcome_video_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `welcome_video_error.welcome_video_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `welcome_video_error.welcome_video_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`file_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Image (Files must be less than 5MB. Allowed file types: PNG, GIF, JPG, JPEG) label</label
                    >
                    <input
                        type="text"
                        :name="`file_lable_${selectedLanguage}`"
                        :id="`file_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'file_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['file_lable'] &&
                            form['file_lable'][`file_lable_${selectedLanguage}`]
                                ? form['file_lable'][
                                      `file_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `file_lable.file_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `file_lable.file_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`file_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Image placeholder</label
                    >
                    <input
                        type="text"
                        :name="`file_placeholder_${selectedLanguage}`"
                        :id="`file_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'file_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['file_placeholder'] &&
                            form['file_placeholder'][
                                `file_placeholder_${selectedLanguage}`
                            ]
                                ? form['file_placeholder'][
                                      `file_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `file_placeholder.file_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `file_placeholder.file_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`file_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Image error</label
                    >
                    <input
                        type="text"
                        :name="`file_error_${selectedLanguage}`"
                        :id="`file_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'file_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['file_error'] &&
                            form['file_error'][`file_error_${selectedLanguage}`]
                                ? form['file_error'][
                                      `file_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `file_error.file_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `file_error.file_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- facebook_lable password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`facebook_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Facebook label</label
                    >
                    <input
                        type="text"
                        :name="`facebook_lable_${selectedLanguage}`"
                        :id="`facebook_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'facebook_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['facebook_lable'] &&
                            form['facebook_lable'][
                                `facebook_lable_${selectedLanguage}`
                            ]
                                ? form['facebook_lable'][
                                      `facebook_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `facebook_lable.facebook_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `facebook_lable.facebook_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`facebook_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Facebook placeholder</label
                    >
                    <input
                        type="text"
                        :name="`facebook_placeholder_${selectedLanguage}`"
                        :id="`facebook_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'facebook_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['facebook_placeholder'] &&
                            form['facebook_placeholder'][
                                `facebook_placeholder_${selectedLanguage}`
                            ]
                                ? form['facebook_placeholder'][
                                      `facebook_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `facebook_placeholder.facebook_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `facebook_placeholder.facebook_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`facebook_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Facebook error</label
                    >
                    <input
                        type="text"
                        :name="`facebook_error_${selectedLanguage}`"
                        :id="`facebook_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'facebook_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['facebook_error'] &&
                            form['facebook_error'][
                                `facebook_error_${selectedLanguage}`
                            ]
                                ? form['facebook_error'][
                                      `facebook_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `facebook_error.facebook_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `facebook_error.facebook_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- twitter_lable password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`twitter_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Twitter label</label
                    >
                    <input
                        type="text"
                        :name="`twitter_lable_${selectedLanguage}`"
                        :id="`twitter_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'twitter_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['twitter_lable'] &&
                            form['twitter_lable'][
                                `twitter_lable_${selectedLanguage}`
                            ]
                                ? form['twitter_lable'][
                                      `twitter_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `twitter_lable.twitter_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `twitter_lable.twitter_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`twitter_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Twitter placeholder</label
                    >
                    <input
                        type="text"
                        :name="`twitter_placeholder_${selectedLanguage}`"
                        :id="`twitter_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'twitter_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['twitter_placeholder'] &&
                            form['twitter_placeholder'][
                                `twitter_placeholder_${selectedLanguage}`
                            ]
                                ? form['twitter_placeholder'][
                                      `twitter_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `twitter_placeholder.twitter_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `twitter_placeholder.twitter_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`twitter_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Twitter error</label
                    >
                    <input
                        type="text"
                        :name="`twitter_error_${selectedLanguage}`"
                        :id="`twitter_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'twitter_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['twitter_error'] &&
                            form['twitter_error'][
                                `twitter_error_${selectedLanguage}`
                            ]
                                ? form['twitter_error'][
                                      `twitter_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `twitter_error.twitter_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `twitter_error.twitter_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- youtube_lable password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`youtube_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Youtube label</label
                    >
                    <input
                        type="text"
                        :name="`youtube_lable_${selectedLanguage}`"
                        :id="`youtube_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'youtube_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['youtube_lable'] &&
                            form['youtube_lable'][
                                `youtube_lable_${selectedLanguage}`
                            ]
                                ? form['youtube_lable'][
                                      `youtube_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `youtube_lable.youtube_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `youtube_lable.youtube_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`youtube_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Youtube placeholder</label
                    >
                    <input
                        type="text"
                        :name="`youtube_placeholder_${selectedLanguage}`"
                        :id="`youtube_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'youtube_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['youtube_placeholder'] &&
                            form['youtube_placeholder'][
                                `youtube_placeholder_${selectedLanguage}`
                            ]
                                ? form['youtube_placeholder'][
                                      `youtube_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `youtube_placeholder.youtube_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `youtube_placeholder.youtube_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`youtube_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Youtube error</label
                    >
                    <input
                        type="text"
                        :name="`youtube_error_${selectedLanguage}`"
                        :id="`youtube_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'youtube_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['youtube_error'] &&
                            form['youtube_error'][
                                `youtube_error_${selectedLanguage}`
                            ]
                                ? form['youtube_error'][
                                      `youtube_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `youtube_error.youtube_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `youtube_error.youtube_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- linkedin_lable password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`linkedin_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >LinkedIn label</label
                    >
                    <input
                        type="text"
                        :name="`linkedin_lable_${selectedLanguage}`"
                        :id="`linkedin_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'linkedin_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['linkedin_lable'] &&
                            form['linkedin_lable'][
                                `linkedin_lable_${selectedLanguage}`
                            ]
                                ? form['linkedin_lable'][
                                      `linkedin_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `linkedin_lable.linkedin_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `linkedin_lable.linkedin_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`linkedin_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >LinkedIn placeholder</label
                    >
                    <input
                        type="text"
                        :name="`linkedin_placeholder_${selectedLanguage}`"
                        :id="`linkedin_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'linkedin_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['linkedin_placeholder'] &&
                            form['linkedin_placeholder'][
                                `linkedin_placeholder_${selectedLanguage}`
                            ]
                                ? form['linkedin_placeholder'][
                                      `linkedin_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `linkedin_placeholder.linkedin_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `linkedin_placeholder.linkedin_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`linkedin_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Other social media label</label
                    >
                    <input
                        type="text"
                        :name="`linkedin_error_${selectedLanguage}`"
                        :id="`linkedin_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'linkedin_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['linkedin_error'] &&
                            form['linkedin_error'][
                                `linkedin_error_${selectedLanguage}`
                            ]
                                ? form['linkedin_error'][
                                      `linkedin_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `linkedin_error.linkedin_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `linkedin_error.linkedin_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- privacy_text_1 -->
                <div class="relative z-0 w-full group  col-span-2" v-if="isDataLoaded">
                    
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`privacy_text_1_${language.id}`"
                    ></div> -->
                    <label
                        :for="`privacy_text_1_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Privacy terms text</label
                    >
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'privacy_text_1'
                                )
                            "
                            :ref="`privacy_text_1_${language.id}`"
                            :id="`privacy_text_1_${language.id}`"
                            :initial-value="form[`privacy_text_1`][`privacy_text_1_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `privacy_text_1.privacy_text_1_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `privacy_text_1.privacy_text_1_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`social_media_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Social media title</label
                    >
                    <input
                        type="text"
                        :name="`social_media_title_${selectedLanguage}`"
                        :id="`social_media_title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'social_media_title',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['social_media_title'] &&
                            form['social_media_title'][
                                `social_media_title_${selectedLanguage}`
                            ]
                                ? form['social_media_title'][
                                      `social_media_title_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `social_media_title.social_media_title_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `social_media_title.social_media_title_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- reg_button_text -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`proceed_button_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Proceed button text</label
                    >
                    <input
                        type="text"
                        :name="`proceed_button_text_${selectedLanguage}`"
                        :id="`proceed_button_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'proceed_button_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['proceed_button_text'] &&
                            form['proceed_button_text'][
                                `proceed_button_text_${selectedLanguage}`
                            ]
                                ? form['proceed_button_text'][
                                      `proceed_button_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `proceed_button_text.proceed_button_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `proceed_button_text.proceed_button_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- privacy_text_2 -->
                <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                    
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`privacy_text_2_${language.id}`"
                    ></div> -->
                    <label
                        :for="`privacy_text_2_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Privacy terms text 2</label
                    >
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'privacy_text_2'
                                )
                            "
                            :ref="`privacy_text_2_${language.id}`"
                            :id="`privacy_text_2_${language.id}`"
                            :initial-value="form[`privacy_text_2`][`privacy_text_2_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `privacy_text_2.privacy_text_2_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `privacy_text_2.privacy_text_2_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
            </div>
        </div>
        <ListErrors :validationErrors="validationErros" />
        <button
            type="submit"
            class="can-edu-btn-fill"
        >
            Submit
        </button>
    </form>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    props: ["selectedLanguage"],
    computed: {
        ...mapState({
            form: (state) => state.register_business.form,
            validationErros: (state) => state.register_business.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    components:{
        editor: Editor,
        ListErrors,
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
        handleInput(value, language, key, mutationName) {
            this.$store.commit(`register_business/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`register_business/updatePageSetting`, {
                value: content,
                id: language.id,
                key:key,
            });
            if (content.trim()) {
        this.validationErros.clear(`${key}.${key}_${language.id}`);
      }
        },
        addUpdateForm() {
            this.$store
                .dispatch("register_business/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$emit("addUpdateFormParent");
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
            this.activeTab = this.selectedLanguage;
        },
        fetchRegisterBusiness() {
            this.$store
                .dispatch("register_business/fetchRegisterBusiness", {
                    url: `${process.env.MIX_ADMIN_API_URL}register-business`,
                })
                .then((res) => {
                    let data =
                        res.data.data && res.data.data.register_business_detail
                            ? res.data.data.register_business_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["page_title_" + res.language_id] = res.page_title;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "page_title",
                        value: obj,
                    });

                    //first name
                    obj = {};
                    data.map((res) => {
                        obj["business_category_1_lable_" + res.language_id] =
                            res.business_category_1_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_category_1_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["package_section_title_" + res.language_id] =
                            res.package_section_title;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "package_section_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["business_category_text_" + res.language_id] =
                            res.business_category_text;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_category_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj[
                            "business_category_1_placeholder_" + res.language_id
                        ] = res.business_category_1_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_category_1_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["business_category_1_error_" + res.language_id] =
                            res.business_category_1_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_category_1_error",
                        value: obj,
                    });

                    //last name
                    obj = {};
                    data.map((res) => {
                        obj["business_category_2_lable_" + res.language_id] =
                            res.business_category_2_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_category_2_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj[
                            "business_category_2_placeholder_" + res.language_id
                        ] = res.business_category_2_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_category_2_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["business_category_2_error_" + res.language_id] =
                            res.business_category_2_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_category_2_error",
                        value: obj,
                    });
                    //email
                    obj = {};
                    data.map((res) => {
                        obj["business_category_3_lable_" + res.language_id] =
                            res.business_category_3_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_category_3_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj[
                            "business_category_3_placeholder_" + res.language_id
                        ] = res.business_category_3_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_category_3_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["business_category_3_error_" + res.language_id] =
                            res.business_category_3_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_category_3_error",
                        value: obj,
                    });
                    //passowrd
                    obj = {};
                    data.map((res) => {
                        obj["description_lable_" + res.language_id] =
                            res.description_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "description_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["detail_description_lable_" + res.language_id] =
                            res.detail_description_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "detail_description_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["keywords_label_" + res.language_id] =
                            res.keywords_label;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "keywords_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["description_placeholder_" + res.language_id] =
                            res.description_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "description_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["detail_description_placeholder_" + res.language_id] =
                            res.detail_description_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "detail_description_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["keywords_placeholder_" + res.language_id] =
                            res.keywords_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "keywords_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["description_error_" + res.language_id] =
                            res.description_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "description_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["detail_description_error_" + res.language_id] =
                            res.detail_description_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "detail_description_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["keywords_error_" + res.language_id] =
                            res.keywords_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "keywords_error",
                        value: obj,
                    });

                    //passowrd
                    obj = {};
                    data.map((res) => {
                        obj["name_lable_" + res.language_id] =
                            res.name_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "name_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["name_placeholder_" + res.language_id] =
                            res.name_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "name_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["registration_package_heading_text_" + res.language_id] =
                            res.registration_package_heading_text;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "registration_package_heading_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["business_profile_heading_text_" + res.language_id] =
                            res.business_profile_heading_text;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "business_profile_heading_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["name_error_" + res.language_id] =
                            res.name_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "name_error",
                        value: obj,
                    });

                    //passowrd
                    obj = {};
                    data.map((res) => {
                        obj["website_url_lable_" + res.language_id] =
                            res.website_url_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "website_url_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["website_url_placeholder_" + res.language_id] =
                            res.website_url_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "website_url_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["website_url_error_" + res.language_id] =
                            res.website_url_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "website_url_error",
                        value: obj,
                    });

                    //confirm passowrd
                    obj = {};
                    data.map((res) => {
                        obj["contact_lable_" + res.language_id] =
                            res.contact_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "contact_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["contact_placeholder_" + res.language_id] =
                            res.contact_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "contact_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["contact_error_" + res.language_id] =
                            res.contact_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "contact_error",
                        value: obj,
                    });

                    //email passowrd
                    obj = {};
                    data.map((res) => {
                        obj["email_lable_" + res.language_id] = res.email_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "email_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["email_placeholder_" + res.language_id] =
                            res.email_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "email_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["email_error_" + res.language_id] = res.email_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "email_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["password_label_" + res.language_id] = res.password_label;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "password_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["password_placeholder_" + res.language_id] =
                            res.password_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "password_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["password_error_" + res.language_id] = res.password_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "password_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["confirm_password_label_" + res.language_id] = res.confirm_password_label;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "confirm_password_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["confirm_password_placeholder_" + res.language_id] =
                            res.confirm_password_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "confirm_password_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["confirm_password_error_" + res.language_id] = res.confirm_password_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "confirm_password_error",
                        value: obj,
                    });

                    //phone passowrd
                    obj = {};
                    data.map((res) => {
                        obj["phone_lable_" + res.language_id] = res.phone_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "phone_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["phone_placeholder_" + res.language_id] =
                            res.phone_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "phone_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["phone_error_" + res.language_id] = res.phone_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "phone_error",
                        value: obj,
                    });

                    //address passowrd
                    obj = {};
                    data.map((res) => {
                        obj["address_lable_" + res.language_id] =
                            res.address_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "address_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["address_placeholder_" + res.language_id] =
                            res.address_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "address_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["address_error_" + res.language_id] =
                            res.address_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "address_error",
                        value: obj,
                    });

                      //logo 
                      obj = {};
                    data.map((res) => {
                        obj["logo_lable_" + res.language_id] =
                            res.logo_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "logo_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["logo_placeholder_" + res.language_id] =
                            res.logo_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "logo_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["logo_error_" + res.language_id] =
                            res.logo_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "logo_error",
                        value: obj,
                    });

                    //file passowrd
                    obj = {};
                    data.map((res) => {
                        obj["file_lable_" + res.language_id] = res.file_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "file_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["media_title_" + res.language_id] = res.media_title;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "media_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["media_title_label_" + res.language_id] = res.media_title_label;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "media_title_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["media_title_placeholder_" + res.language_id] = res.media_title_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "media_title_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["media_title_error_" + res.language_id] = res.media_title_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "media_title_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["media_description_label_" + res.language_id] = res.media_description_label;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "media_description_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["media_description_placeholder_" + res.language_id] = res.media_description_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "media_description_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["media_description_error_" + res.language_id] = res.media_description_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "media_description_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["welcome_video_label_" + res.language_id] = res.welcome_video_label;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "welcome_video_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["welcome_video_placeholder_" + res.language_id] = res.welcome_video_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "welcome_video_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["welcome_video_error_" + res.language_id] = res.welcome_video_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "welcome_video_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["file_placeholder_" + res.language_id] =
                            res.file_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "file_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["file_error_" + res.language_id] = res.file_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "file_error",
                        value: obj,
                    });

                    //facebook passowrd
                    obj = {};
                    data.map((res) => {
                        obj["facebook_lable_" + res.language_id] =
                            res.facebook_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "facebook_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["facebook_placeholder_" + res.language_id] =
                            res.facebook_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "facebook_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["facebook_error_" + res.language_id] =
                            res.facebook_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "facebook_error",
                        value: obj,
                    });

                    //twitter passowrd
                    obj = {};
                    data.map((res) => {
                        obj["twitter_lable_" + res.language_id] =
                            res.twitter_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "twitter_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["twitter_placeholder_" + res.language_id] =
                            res.twitter_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "twitter_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["twitter_error_" + res.language_id] =
                            res.twitter_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "twitter_error",
                        value: obj,
                    });

                    //youtube passowrd
                    obj = {};
                    data.map((res) => {
                        obj["youtube_lable_" + res.language_id] =
                            res.youtube_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "youtube_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["youtube_placeholder_" + res.language_id] =
                            res.youtube_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "youtube_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["youtube_error_" + res.language_id] =
                            res.youtube_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "youtube_error",
                        value: obj,
                    });

                    //linkedin passowrd
                    obj = {};
                    data.map((res) => {
                        obj["linkedin_lable_" + res.language_id] =
                            res.linkedin_lable;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "linkedin_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["linkedin_placeholder_" + res.language_id] =
                            res.linkedin_placeholder;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "linkedin_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["linkedin_error_" + res.language_id] =
                            res.linkedin_error;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "linkedin_error",
                        value: obj,
                    });

                    //privacy_text_1 passowrd
                    obj = {};
                    data.map((res) => {
                        obj["privacy_text_1_" + res.language_id] =
                            res.privacy_text_1;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "privacy_text_1",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["privacy_text_2_" + res.language_id] =
                            res.privacy_text_2;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "privacy_text_2",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["proceed_button_text_" + res.language_id] =
                            res.proceed_button_text;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "proceed_button_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["social_media_title_" + res.language_id] =
                            res.social_media_title;
                    });
                    this.$store.commit("register_business/setPageSetting", {
                        key: "social_media_title",
                        value: obj,
                    });
                    this.isDataLoaded = 1;
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(
                    `page_title.page_title_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `page_description.page_description_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `business_category_3_lable.business_category_3_lable_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `business_category_3_placeholder.business_category_3_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `business_category_3_error.business_category_3_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `description_lable.description_lable_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `detail_description_lable.detail_description_lable_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `keywords_label.keywords_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `description_placeholder.description_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `detail_description_placeholder.detail_description_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `keywords_placeholder.keywords_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `description_error.description_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `detail_description_error.detail_description_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `keywords_error.keywords_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `keep_me_logged_in_text.keep_me_logged_in_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `forget_password_text.forget_password_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `reg_button_text.reg_button_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `not_register_yet_text.not_register_yet_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `create_account_button_text.create_account_button_text_${this.selectedLanguage}`
                )
            );
        },
    },
    created() {
        this.$store.commit("register_business/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["page_title_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "page_title",
                    value: obj,
                });

                //first name
                obj = {};
                data.map((res) => {
                    obj["business_category_1_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_category_1_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["business_category_1_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_category_1_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["business_category_1_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_category_1_error",
                    value: obj,
                });

                //last name
                obj = {};
                data.map((res) => {
                    obj["business_category_2_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_category_2_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["business_category_2_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_category_2_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["business_category_2_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_category_2_error",
                    value: obj,
                });
                //email
                obj = {};
                data.map((res) => {
                    obj["business_category_3_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_category_3_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["business_category_3_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_category_3_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["business_category_3_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_category_3_error",
                    value: obj,
                });
                //passowrd
                obj = {};
                data.map((res) => {
                    obj["description_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "description_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["detail_description_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "detail_description_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["keywords_label_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "keywords_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["description_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "description_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["detail_description_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "detail_description_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["keywords_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "keywords_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["description_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "description_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["detail_description_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "detail_description_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["keywords_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "keywords_error",
                    value: obj,
                });

                //passowrd
                obj = {};
                data.map((res) => {
                    obj["name_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "name_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["name_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "name_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["business_profile_heading_text_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_profile_heading_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["registration_package_heading_text_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "registration_package_heading_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["name_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "name_error",
                    value: obj,
                });

                //passowrd
                obj = {};
                data.map((res) => {
                    obj["website_url_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "website_url_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["website_url_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "website_url_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["website_url_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "website_url_error",
                    value: obj,
                });

                //confirm passowrd
                obj = {};
                data.map((res) => {
                    obj["contact_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "contact_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["contact_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "contact_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["contact_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "contact_error",
                    value: obj,
                });

                //email passowrd
                obj = {};
                data.map((res) => {
                    obj["email_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "email_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["email_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "email_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["email_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "email_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["password_label_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "password_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["password_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "password_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["password_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "password_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["confirm_password_label_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "confirm_password_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["confirm_password_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "confirm_password_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["confirm_password_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "confirm_password_error",
                    value: obj,
                });

                //phone passowrd
                obj = {};
                data.map((res) => {
                    obj["phone_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "phone_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["phone_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "phone_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["phone_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "phone_error",
                    value: obj,
                });

                //address passowrd
                obj = {};
                data.map((res) => {
                    obj["address_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "address_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["address_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "address_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["address_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "address_error",
                    value: obj,
                });

                  //logo
                  obj = {};
                data.map((res) => {
                    obj["logo_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "logo_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["logo_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "logo_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["logo_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "logo_error",
                    value: obj,
                });

                //file passowrd
                obj = {};
                data.map((res) => {
                    obj["file_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "file_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["media_title_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "media_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["media_title_label_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "media_title_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["media_title_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "media_title_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["media_title_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "media_title_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["media_description_label_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "media_description_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["media_description_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "media_description_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["media_description_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "media_description_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["welcome_video_label_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "welcome_video_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["welcome_video_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "welcome_video_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["welcome_video_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "welcome_video_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["file_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "file_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["file_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "file_error",
                    value: obj,
                });

                //facebook passowrd
                obj = {};
                data.map((res) => {
                    obj["facebook_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "facebook_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["facebook_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "facebook_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["facebook_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "facebook_error",
                    value: obj,
                });

                //twitter passowrd
                obj = {};
                data.map((res) => {
                    obj["twitter_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "twitter_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["twitter_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "twitter_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["twitter_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "twitter_error",
                    value: obj,
                });

                //youtube passowrd
                obj = {};
                data.map((res) => {
                    obj["youtube_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "youtube_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["youtube_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "youtube_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["youtube_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "youtube_error",
                    value: obj,
                });

                //linkedin passowrd
                obj = {};
                data.map((res) => {
                    obj["linkedin_lable_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "linkedin_lable",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["linkedin_placeholder_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "linkedin_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["linkedin_error_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "linkedin_error",
                    value: obj,
                });

                //privacy_text_1 passowrd
                obj = {};
                data.map((res) => {
                    obj["privacy_text_1_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "privacy_text_1",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["privacy_text_2_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "privacy_text_2",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["package_section_title_" + res.language_id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "package_section_title",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["business_category_text_" + res.language_id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "business_category_text",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["proceed_button_text_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "proceed_button_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["social_media_title_" + res.id] = "";
                });
                this.$store.commit("register_business/setPageSetting", {
                    key: "social_media_title",
                    value: obj,
                });

                if(this.$route.params.id){
                    this.fetchRegisterBusiness();
                }
                else{
                    this.isDataLoaded = 1;
                }
            });
    },
    watch: {
        selectedLanguage: function (newVal, oldVal) {
            // watch it
        },
    },
    // mounted() {
    //     let ckEditorScript = document.createElement('script')
    //     ckEditorScript.setAttribute('src', `${process.env.MIX_APP_URL}/plugins/ckeditor5/ckeditor.js`)
    //     document.head.appendChild(ckEditorScript)
    // },
};
</script>
