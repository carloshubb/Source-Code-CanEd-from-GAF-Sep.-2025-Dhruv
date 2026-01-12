<template>
    <header class="my-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">School request page setting</h1>
            </div>
        </div>
    </header>
    <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
        <!-- <div
            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
        >
            <ul class="flex gap-2 flex-wrap my-4">
                <li
                    class="mr-2"
                    v-for="language in languages"
                    :key="selectedLanguage"
                >
                    <a
                        @click.prevent="changeLanguageTab(language)"
                        href="#"
                        :class="[
                            'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                            ((activeTab == null && language.is_default) ||
                            activeTab == selectedLanguage
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
        </div> -->

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
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
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

                <!-- first name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >School name label</label
                    >
                    <input
                        type="text"
                        :name="`name_label_${selectedLanguage}`"
                        :id="`name_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['name_label'] &&
                            form['name_label'][`name_label_${selectedLanguage}`]
                                ? form['name_label'][
                                      `name_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `name_label.name_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `name_label.name_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >School name placeholder</label
                    >
                    <input
                        type="text"
                        :name="`name_placeholder_${selectedLanguage}`"
                        :id="`name_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
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
                        >School name error</label
                    >
                    <input
                        type="text"
                        :name="`name_error_${selectedLanguage}`"
                        :id="`name_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
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
                            form['name_error'][`name_error_${selectedLanguage}`]
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

                <!-- first name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`description_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Your name and title label</label
                    >
                    <input
                        type="text"
                        :name="`description_label_${selectedLanguage}`"
                        :id="`description_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'description_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['description_label'] &&
                            form['description_label'][
                                `description_label_${selectedLanguage}`
                            ]
                                ? form['description_label'][
                                      `description_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `description_label.description_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `description_label.description_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`description_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Your name and title placeholder</label
                    >
                    <input
                        type="text"
                        :name="`description_placeholder_${selectedLanguage}`"
                        :id="`description_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
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
                        >Your name and title error</label
                    >
                    <input
                        type="text"
                        :name="`description_error_${selectedLanguage}`"
                        :id="`description_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
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

                <!-- last name -->
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`website_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Website Field Lable</label
                    >
                    <input
                        type="text"
                        :name="`website_label_${selectedLanguage}`"
                        :id="`website_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'website_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['website_label'] &&
                            form['website_label'][
                                `website_label_${selectedLanguage}`
                            ]
                                ? form['website_label'][
                                      `website_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `website_label.website_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `website_label.website_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`website_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Website field placeholder</label
                    >
                    <input
                        type="text"
                        :name="`website_placeholder_${selectedLanguage}`"
                        :id="`website_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'website_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['website_placeholder'] &&
                            form['website_placeholder'][
                                `website_placeholder_${selectedLanguage}`
                            ]
                                ? form['website_placeholder'][
                                      `website_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `website_placeholder.website_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `website_placeholder.website_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`website_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Website Field error</label
                    >
                    <input
                        type="text"
                        :name="`website_error_${selectedLanguage}`"
                        :id="`website_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'website_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['website_error'] &&
                            form['website_error'][
                                `website_error_${selectedLanguage}`
                            ]
                                ? form['website_error'][
                                      `website_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `website_error.website_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `website_error.website_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <!-- email -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email field label</label
                    >
                    <input
                        type="text"
                        :name="`email_label_${selectedLanguage}`"
                        :id="`email_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_label'] &&
                            form['email_label'][
                                `email_label_${selectedLanguage}`
                            ]
                                ? form['email_label'][
                                      `email_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_label.email_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_label.email_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email field placeholder</label
                    >
                    <input
                        type="text"
                        :name="`email_placeholder_${selectedLanguage}`"
                        :id="`email_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
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
                        >Email field error</label
                    >
                    <input
                        type="text"
                        :name="`email_error_${selectedLanguage}`"
                        :id="`email_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
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
                <!-- password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`phone_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Password field label</label
                    >
                    <input
                        type="text"
                        :name="`phone_label_${selectedLanguage}`"
                        :id="`phone_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'phone_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['phone_label'] &&
                            form['phone_label'][
                                `phone_label_${selectedLanguage}`
                            ]
                                ? form['phone_label'][
                                      `phone_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `phone_label.phone_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `phone_label.phone_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`phone_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Password field placeholder</label
                    >
                    <input
                        type="text"
                        :name="`phone_placeholder_${selectedLanguage}`"
                        :id="`phone_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
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
                        >Password field error</label
                    >
                    <input
                        type="text"
                        :name="`phone_error_${selectedLanguage}`"
                        :id="`phone_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
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

                <!-- confirm password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`time_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Confirm password field label</label
                    >
                    <input
                        type="text"
                        :name="`time_label_${selectedLanguage}`"
                        :id="`time_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'time_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['time_label'] &&
                            form['time_label'][`time_label_${selectedLanguage}`]
                                ? form['time_label'][
                                      `time_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `time_label.time_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `time_label.time_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`time_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Confirm password field placeholder</label
                    >
                    <input
                        type="text"
                        :name="`time_placeholder_${selectedLanguage}`"
                        :id="`time_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'time_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['time_placeholder'] &&
                            form['time_placeholder'][
                                `time_placeholder_${selectedLanguage}`
                            ]
                                ? form['time_placeholder'][
                                      `time_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `time_placeholder.time_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `time_placeholder.time_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`time_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Confirm password field error</label
                    >
                    <input
                        type="text"
                        :name="`time_error_${selectedLanguage}`"
                        :id="`time_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'time_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['time_error'] &&
                            form['time_error'][`time_error_${selectedLanguage}`]
                                ? form['time_error'][
                                      `time_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `time_error.time_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `time_error.time_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- confirm password  -->
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`time_zone_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >TimeZone field label</label
                    >
                    <input
                        type="text"
                        :name="`time_zone_label_${selectedLanguage}`"
                        :id="`time_zone_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'time_zone_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['time_zone_label'] &&
                            form['time_zone_label'][
                                `time_zone_label_${selectedLanguage}`
                            ]
                                ? form['time_zone_label'][
                                      `time_zone_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `time_zone_label.time_zone_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `time_zone_label.time_zone_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`time_zone_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >TimeZone field placeholder</label
                    >
                    <input
                        type="text"
                        :name="`time_zone_placeholder_${selectedLanguage}`"
                        :id="`time_zone_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'time_zone_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['time_zone_placeholder'] &&
                            form['time_zone_placeholder'][
                                `time_zone_placeholder_${selectedLanguage}`
                            ]
                                ? form['time_zone_placeholder'][
                                      `time_zone_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `time_zone_placeholder.time_zone_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `time_zone_placeholder.time_zone_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`time_zone_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >TimeZone field error</label
                    >
                    <input
                        type="text"
                        :name="`time_zone_error_${selectedLanguage}`"
                        :id="`time_zone_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'time_zone_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['time_zone_error'] &&
                            form['time_zone_error'][
                                `time_zone_error_${selectedLanguage}`
                            ]
                                ? form['time_zone_error'][
                                      `time_zone_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `time_zone_error.time_zone_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `time_zone_error.time_zone_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <!-- confirm password  -->
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`province_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Province field label</label
                    >
                    <input
                        type="text"
                        :name="`province_label_${selectedLanguage}`"
                        :id="`province_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'province_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['province_label'] &&
                            form['province_label'][
                                `province_label_${selectedLanguage}`
                            ]
                                ? form['province_label'][
                                      `province_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `province_label.province_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `province_label.province_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`province_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Province field placeholder</label
                    >
                    <input
                        type="text"
                        :name="`province_placeholder_${selectedLanguage}`"
                        :id="`province_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'province_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['province_placeholder'] &&
                            form['province_placeholder'][
                                `province_placeholder_${selectedLanguage}`
                            ]
                                ? form['province_placeholder'][
                                      `province_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `province_placeholder.province_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `province_placeholder.province_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`province_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Province field error</label
                    >
                    <input
                        type="text"
                        :name="`province_error_${selectedLanguage}`"
                        :id="`province_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'province_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['province_error'] &&
                            form['province_error'][
                                `province_error_${selectedLanguage}`
                            ]
                                ? form['province_error'][
                                      `province_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `province_error.province_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `province_error.province_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <!-- country  -->
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`country_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Country field label</label
                    >
                    <input
                        type="text"
                        :name="`country_label_${selectedLanguage}`"
                        :id="`country_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['country_label'] &&
                            form['country_label'][
                                `country_label_${selectedLanguage}`
                            ]
                                ? form['country_label'][
                                      `country_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `country_label.country_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `country_label.country_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`country_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Country field placeholder</label
                    >
                    <input
                        type="text"
                        :name="`country_placeholder_${selectedLanguage}`"
                        :id="`country_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['country_placeholder'] &&
                            form['country_placeholder'][
                                `country_placeholder_${selectedLanguage}`
                            ]
                                ? form['country_placeholder'][
                                      `country_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `country_placeholder.country_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `country_placeholder.country_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`country_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Country field error</label
                    >
                    <input
                        type="text"
                        :name="`country_error_${selectedLanguage}`"
                        :id="`country_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['country_error'] &&
                            form['country_error'][
                                `country_error_${selectedLanguage}`
                            ]
                                ? form['country_error'][
                                      `country_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `country_error.country_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `country_error.country_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <!-- city -->
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`city_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >City field label</label
                    >
                    <input
                        type="text"
                        :name="`city_label_${selectedLanguage}`"
                        :id="`city_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'city_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['city_label'] &&
                            form['city_label'][`city_label_${selectedLanguage}`]
                                ? form['city_label'][
                                      `city_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `city_label.city_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `city_label.city_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`city_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >City field placeholder</label
                    >
                    <input
                        type="text"
                        :name="`city_placeholder_${selectedLanguage}`"
                        :id="`city_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'city_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['city_placeholder'] &&
                            form['city_placeholder'][
                                `city_placeholder_${selectedLanguage}`
                            ]
                                ? form['city_placeholder'][
                                      `city_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `city_placeholder.city_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `city_placeholder.city_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`city_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >City field error</label
                    >
                    <input
                        type="text"
                        :name="`city_error_${selectedLanguage}`"
                        :id="`city_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'city_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['city_error'] &&
                            form['city_error'][`city_error_${selectedLanguage}`]
                                ? form['city_error'][
                                      `city_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `city_error.city_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `city_error.city_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->


                <!-- image upload -->
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`image_upload_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Image field label</label
                    >
                    <input
                        type="text"
                        :name="`image_upload_label_${selectedLanguage}`"
                        :id="`image_upload_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'image_upload_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['image_upload_label'] &&
                            form['image_upload_label'][`image_upload_label_${selectedLanguage}`]
                                ? form['image_upload_label'][
                                      `image_upload_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `image_upload_label.image_upload_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `image_upload_label.image_upload_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`image_upload_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Image field placeholder</label
                    >
                    <input
                        type="text"
                        :name="`image_upload_placeholder_${selectedLanguage}`"
                        :id="`image_upload_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'image_upload_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['image_upload_placeholder'] &&
                            form['image_upload_placeholder'][
                                `image_upload_placeholder_${selectedLanguage}`
                            ]
                                ? form['image_upload_placeholder'][
                                      `image_upload_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `image_upload_placeholder.image_upload_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `image_upload_placeholder.image_upload_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`image_upload_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Image field error</label
                    >
                    <input
                        type="text"
                        :name="`image_upload_error_${selectedLanguage}`"
                        :id="`image_upload_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'image_upload_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['image_upload_error'] &&
                            form['image_upload_error'][`image_upload_error_${selectedLanguage}`]
                                ? form['image_upload_error'][
                                      `image_upload_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `image_upload_error.image_upload_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `image_upload_error.image_upload_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->
                <!-- reg_button_text -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`submit_button_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Submit button text</label
                    >
                    <input
                        type="text"
                        :name="`submit_button_text_${selectedLanguage}`"
                        :id="`submit_button_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'submit_button_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['submit_button_text'] &&
                            form['submit_button_text'][
                                `submit_button_text_${selectedLanguage}`
                            ]
                                ? form['submit_button_text'][
                                      `submit_button_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `submit_button_text.submit_button_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `submit_button_text.submit_button_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`protect_your_account_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Protect your account text</label
                    >
                    <input
                        type="text"
                        :name="`protect_your_account_text_${selectedLanguage}`"
                        :id="`protect_your_account_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'protect_your_account_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['protect_your_account_text'] &&
                            form['protect_your_account_text'][
                                `protect_your_account_text_${selectedLanguage}`
                            ]
                                ? form['protect_your_account_text'][
                                      `protect_your_account_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `protect_your_account_text.protect_your_account_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `protect_your_account_text.protect_your_account_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <div class="relative z-0 w-full group mt-4 md:col-span-2" v-if="isDataLoaded">
                    <label
                        :for="`protect_your_account_description_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Privacy terms text</label
                    >
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'protect_your_account_description'
                                )
                            "
                            :ref="`protect_your_account_description_${language.id}`"
                            :id="`protect_your_account_description_${language.id}`"
                            :initial-value="form[`protect_your_account_description`][`protect_your_account_description_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `protect_your_account_description.protect_your_account_description_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `protect_your_account_description.protect_your_account_description_${selectedLanguage}`
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
            form: (state) => state.school_request_setting.form,
            validationErros: (state) =>
                state.school_request_setting.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    components:{
        ListErrors,
        editor: Editor,
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
            this.$store.commit(`school_request_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`school_request_setting/updatePageSetting`, {
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
                .dispatch("school_request_setting/addUpdateForm")
                .then(() => {
                    this.$emit("addUpdateFormParent");
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
        fetchSchoolRequestSetting() {
            this.$store
                .dispatch("school_request_setting/fetchSchoolRequestSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}school-request-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data &&
                        res.data.data.school_request_setting_detail
                            ? res.data.data.school_request_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["page_title_" + res.language_id] = res.page_title;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "page_title",
                            value: obj,
                        }
                    );

                    //first name
                    obj = {};
                    data.map((res) => {
                        obj["name_label_" + res.language_id] = res.name_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "name_label",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["name_placeholder_" + res.language_id] =
                            res.name_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "name_placeholder",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["name_error_" + res.language_id] = res.name_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "name_error",
                            value: obj,
                        }
                    );

                    //description
                    obj = {};
                    data.map((res) => {
                        obj["description_label_" + res.language_id] =
                            res.description_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "description_label",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["description_placeholder_" + res.language_id] =
                            res.description_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "description_placeholder",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["description_error_" + res.language_id] =
                            res.description_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "description_error",
                            value: obj,
                        }
                    );

                    //last name
                    obj = {};
                    data.map((res) => {
                        obj["website_label_" + res.language_id] =
                            res.website_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "website_label",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["website_placeholder_" + res.language_id] =
                            res.website_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "website_placeholder",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["website_error_" + res.language_id] =
                            res.website_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "website_error",
                            value: obj,
                        }
                    );
                    //email
                    obj = {};
                    data.map((res) => {
                        obj["email_label_" + res.language_id] = res.email_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "email_label",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["email_placeholder_" + res.language_id] =
                            res.email_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "email_placeholder",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["email_error_" + res.language_id] = res.email_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "email_error",
                            value: obj,
                        }
                    );
                    //passowrd
                    obj = {};
                    data.map((res) => {
                        obj["phone_label_" + res.language_id] = res.phone_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "phone_label",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["phone_placeholder_" + res.language_id] =
                            res.phone_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "phone_placeholder",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["phone_error_" + res.language_id] = res.phone_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "phone_error",
                            value: obj,
                        }
                    );

                    //confirm passowrd
                    obj = {};
                    data.map((res) => {
                        obj["time_label_" + res.language_id] = res.time_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "time_label",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["time_placeholder_" + res.language_id] =
                            res.time_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "time_placeholder",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["time_error_" + res.language_id] = res.time_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "time_error",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["time_zone_label_" + res.language_id] =
                            res.time_zone_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "time_zone_label",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["time_zone_placeholder_" + res.language_id] =
                            res.time_zone_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "time_zone_placeholder",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["time_zone_error_" + res.language_id] =
                            res.time_zone_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "time_zone_error",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["province_label_" + res.language_id] =
                            res.province_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "province_label",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["province_placeholder_" + res.language_id] =
                            res.province_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "province_placeholder",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["province_error_" + res.language_id] =
                            res.province_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "province_error",
                            value: obj,
                        }
                    );

                    //country
                    obj = {};
                    data.map((res) => {
                        obj["country_label_" + res.language_id] =
                            res.country_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "country_label",
                            value: obj,
                        }
                    );
                    obj = {};
                    data.map((res) => {
                        obj["country_placeholder_" + res.language_id] =
                            res.country_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "country_placeholder",
                            value: obj,
                        }
                    );
                    obj = {};
                    data.map((res) => {
                        obj["country_error_" + res.language_id] =
                            res.country_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "country_error",
                            value: obj,
                        }
                    );

                    //city
                    obj = {};
                    data.map((res) => {
                        obj["city_label_" + res.language_id] = res.city_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "city_label",
                            value: obj,
                        }
                    );
                    //image upload
                    obj = {};
                    data.map((res) => {
                        obj["image_upload_label_" + res.language_id] = res.image_upload_label;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "image_upload_label",
                            value: obj,
                        }
                    );
                    obj = {};
                    data.map((res) => {
                        obj["image_upload_placeholder_" + res.language_id] = res.image_upload_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "image_upload_placeholder",
                            value: obj,
                        }
                    );
                    obj = {};
                    data.map((res) => {
                        obj["image_upload_error_" + res.language_id] = res.image_upload_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "image_upload_error",
                            value: obj,
                        }
                    );
                    obj = {};
                    data.map((res) => {
                        obj["city_placeholder_" + res.language_id] =
                            res.city_placeholder;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "city_placeholder",
                            value: obj,
                        }
                    );
                    obj = {};
                    data.map((res) => {
                        obj["city_error_" + res.language_id] = res.city_error;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "city_error",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["description_" + res.language_id] = res.description;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "description",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["submit_button_text_" + res.language_id] =
                            res.submit_button_text;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "submit_button_text",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        obj["protect_your_account_text_" + res.language_id] =
                            res.protect_your_account_text;
                    });
                    this.$store.commit(
                        "school_request_setting/setPageSetting",
                        {
                            key: "protect_your_account_text",
                            value: obj,
                        }
                    );

                    obj = {};
                    data.map((res) => {
                        // obj[
                        //     "protect_your_account_description_" +
                        //         res.language_id
                        // ] = res.protect_your_account_description;
                        this.$store.commit(
                        "school_request_setting/updatePageSetting",
                        {
                            key: "protect_your_account_description",
                            id:res.language_id,
                            value: res.protect_your_account_description,
                        }
                    );
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
                    `email_label.email_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `email_placeholder.email_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `email_error.email_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `phone_label.phone_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `phone_placeholder.phone_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `phone_error.phone_error_${this.selectedLanguage}`
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
                ) ||
                validationErros.has(
                    `protect_your_account_text.protect_your_account_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `protect_your_account_description.protect_your_account_description_${this.selectedLanguage}`
                )
            );
        },
    },
    created() {
        this.$store.commit("school_request_setting/resetForm");
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
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "page_title",
                    value: obj,
                });

                //first name
                obj = {};
                data.map((res) => {
                    obj["name_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "name_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["name_placeholder_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "name_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["name_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "name_error",
                    value: obj,
                });

                //description
                obj = {};
                data.map((res) => {
                    obj["description_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "description_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["description_placeholder_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "description_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["description_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "description_error",
                    value: obj,
                });

                //last name
                obj = {};
                data.map((res) => {
                    obj["website_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "website_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["website_placeholder_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "website_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["website_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "website_error",
                    value: obj,
                });
                //email
                obj = {};
                data.map((res) => {
                    obj["email_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "email_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["email_placeholder_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "email_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["email_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "email_error",
                    value: obj,
                });
                //passowrd
                obj = {};
                data.map((res) => {
                    obj["phone_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "phone_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["phone_placeholder_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "phone_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["phone_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "phone_error",
                    value: obj,
                });

                //confirm passowrd
                obj = {};
                data.map((res) => {
                    obj["time_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "time_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["time_placeholder_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "time_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["time_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "time_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["time_zone_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "time_zone_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["time_zone_placeholder_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "time_zone_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["time_zone_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "time_zone_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["province_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "province_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["province_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "province_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["province_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "province_error",
                    value: obj,
                });
                //country
                obj = {};
                data.map((res) => {
                    obj["country_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "country_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["country_placeholder_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "country_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["country_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "country_error",
                    value: obj,
                });

                //city
                obj = {};
                data.map((res) => {
                    obj["city_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "city_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["city_placeholder_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "city_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["city_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "city_error",
                    value: obj,
                });


                //image upload
                obj = {};
                data.map((res) => {
                    obj["image_upload_label_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "image_upload_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["image_upload_placeholder_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "image_upload_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["image_upload_error_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "image_upload_error",
                    value: obj,
                });

                //description

                obj = {};
                data.map((res) => {
                    obj["description_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "description",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["submit_button_text_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "submit_button_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["protect_your_account_text_" + res.id] = "";
                });
                this.$store.commit("school_request_setting/setPageSetting", {
                    key: "protect_your_account_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["protect_your_account_description_" + res.id] = "";
                });
                if(this.$route.params.id){
                    this.fetchSchoolRequestSetting();
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
