<template>
    <header class="mb-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">Register page setting</h1>
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
                        >Page title<span class="text-primary">*</span></label
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

                <!-- first name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_first_name_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register first name label<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_first_name_label_${selectedLanguage}`"
                        :id="`reg_first_name_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_first_name_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_first_name_label'] &&
                            form['reg_first_name_label'][
                                `reg_first_name_label_${selectedLanguage}`
                            ]
                                ? form['reg_first_name_label'][
                                      `reg_first_name_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_first_name_label.reg_first_name_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_first_name_label.reg_first_name_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_first_name_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register first name placeholder<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_first_name_placeholder_${selectedLanguage}`"
                        :id="`reg_first_name_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_first_name_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_first_name_placeholder'] &&
                            form['reg_first_name_placeholder'][
                                `reg_first_name_placeholder_${selectedLanguage}`
                            ]
                                ? form['reg_first_name_placeholder'][
                                      `reg_first_name_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_first_name_placeholder.reg_first_name_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_first_name_placeholder.reg_first_name_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_first_name_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register first name error<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_first_name_error_${selectedLanguage}`"
                        :id="`reg_first_name_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_first_name_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_first_name_error'] &&
                            form['reg_first_name_error'][
                                `reg_first_name_error_${selectedLanguage}`
                            ]
                                ? form['reg_first_name_error'][
                                      `reg_first_name_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_first_name_error.reg_first_name_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_first_name_error.reg_first_name_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- last name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_last_name_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register last name label<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_last_name_label_${selectedLanguage}`"
                        :id="`reg_last_name_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_last_name_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_last_name_label'] &&
                            form['reg_last_name_label'][
                                `reg_last_name_label_${selectedLanguage}`
                            ]
                                ? form['reg_last_name_label'][
                                      `reg_last_name_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_last_name_label.reg_last_name_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_last_name_label.reg_last_name_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_last_name_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register last name placeholder<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_last_name_placeholder_${selectedLanguage}`"
                        :id="`reg_last_name_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_last_name_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_last_name_placeholder'] &&
                            form['reg_last_name_placeholder'][
                                `reg_last_name_placeholder_${selectedLanguage}`
                            ]
                                ? form['reg_last_name_placeholder'][
                                      `reg_last_name_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_last_name_placeholder.reg_last_name_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_last_name_placeholder.reg_last_name_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_last_name_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register last name error<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_last_name_error_${selectedLanguage}`"
                        :id="`reg_last_name_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_last_name_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_last_name_error'] &&
                            form['reg_last_name_error'][
                                `reg_last_name_error_${selectedLanguage}`
                            ]
                                ? form['reg_last_name_error'][
                                      `reg_last_name_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_last_name_error.reg_last_name_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_last_name_error.reg_last_name_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- email -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_email_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register email label<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_email_label_${selectedLanguage}`"
                        :id="`reg_email_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_email_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_email_label'] &&
                            form['reg_email_label'][
                                `reg_email_label_${selectedLanguage}`
                            ]
                                ? form['reg_email_label'][
                                      `reg_email_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_email_label.reg_email_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_email_label.reg_email_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_email_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register email placeholder<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_email_placeholder_${selectedLanguage}`"
                        :id="`reg_email_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_email_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_email_placeholder'] &&
                            form['reg_email_placeholder'][
                                `reg_email_placeholder_${selectedLanguage}`
                            ]
                                ? form['reg_email_placeholder'][
                                      `reg_email_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_email_placeholder.reg_email_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_email_placeholder.reg_email_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_email_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register email error<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_email_error_${selectedLanguage}`"
                        :id="`reg_email_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_email_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_email_error'] &&
                            form['reg_email_error'][
                                `reg_email_error_${selectedLanguage}`
                            ]
                                ? form['reg_email_error'][
                                      `reg_email_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_email_error.reg_email_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_email_error.reg_email_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_passowrd_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register password label<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_passowrd_label_${selectedLanguage}`"
                        :id="`reg_passowrd_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_passowrd_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_passowrd_label'] &&
                            form['reg_passowrd_label'][
                                `reg_passowrd_label_${selectedLanguage}`
                            ]
                                ? form['reg_passowrd_label'][
                                      `reg_passowrd_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_passowrd_label.reg_passowrd_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_passowrd_label.reg_passowrd_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_passowrd_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register password placeholder<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_passowrd_placeholder_${selectedLanguage}`"
                        :id="`reg_passowrd_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_passowrd_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_passowrd_placeholder'] &&
                            form['reg_passowrd_placeholder'][
                                `reg_passowrd_placeholder_${selectedLanguage}`
                            ]
                                ? form['reg_passowrd_placeholder'][
                                      `reg_passowrd_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_passowrd_placeholder.reg_passowrd_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_passowrd_placeholder.reg_passowrd_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_passowrd_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register password error<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_passowrd_error_${selectedLanguage}`"
                        :id="`reg_passowrd_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_passowrd_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_passowrd_error'] &&
                            form['reg_passowrd_error'][
                                `reg_passowrd_error_${selectedLanguage}`
                            ]
                                ? form['reg_passowrd_error'][
                                      `reg_passowrd_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_passowrd_error.reg_passowrd_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_passowrd_error.reg_passowrd_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- confirm password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_confirm_passowrd_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register confirm_password label<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_confirm_passowrd_label_${selectedLanguage}`"
                        :id="`reg_confirm_passowrd_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_confirm_passowrd_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_confirm_passowrd_label'] &&
                            form['reg_confirm_passowrd_label'][
                                `reg_confirm_passowrd_label_${selectedLanguage}`
                            ]
                                ? form['reg_confirm_passowrd_label'][
                                      `reg_confirm_passowrd_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_confirm_passowrd_label.reg_confirm_passowrd_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_confirm_passowrd_label.reg_confirm_passowrd_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_confirm_passowrd_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register confirm_password placeholder<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_confirm_passowrd_placeholder_${selectedLanguage}`"
                        :id="`reg_confirm_passowrd_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_confirm_passowrd_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_confirm_passowrd_placeholder'] &&
                            form['reg_confirm_passowrd_placeholder'][
                                `reg_confirm_passowrd_placeholder_${selectedLanguage}`
                            ]
                                ? form['reg_confirm_passowrd_placeholder'][
                                      `reg_confirm_passowrd_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_confirm_passowrd_placeholder.reg_confirm_passowrd_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_confirm_passowrd_placeholder.reg_confirm_passowrd_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_confirm_passowrd_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Register confirm_password error<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_confirm_passowrd_error_${selectedLanguage}`"
                        :id="`reg_confirm_passowrd_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_confirm_passowrd_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_confirm_passowrd_error'] &&
                            form['reg_confirm_passowrd_error'][
                                `reg_confirm_passowrd_error_${selectedLanguage}`
                            ]
                                ? form['reg_confirm_passowrd_error'][
                                      `reg_confirm_passowrd_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_confirm_passowrd_error.reg_confirm_passowrd_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_confirm_passowrd_error.reg_confirm_passowrd_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- privacy_terms_text -->
                <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                    
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`privacy_terms_text_${language.id}`"
                    ></div> -->
                    <label
                        :for="`privacy_terms_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Privacy terms text<span class="text-primary">*</span></label
                    >
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'privacy_terms_text'
                                )
                            "
                            :ref="`privacy_terms_text_${language.id}`"
                            :id="`privacy_terms_text_${language.id}`"
                            :initial-value="form[`privacy_terms_text`][`privacy_terms_text_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `privacy_terms_text.privacy_terms_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `privacy_terms_text.privacy_terms_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- reg_button_text -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`reg_button_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Registeration button text<span class="text-primary">*</span></label
                    >
                    <input
                        type="text"
                        :name="`reg_button_text_${selectedLanguage}`"
                        :id="`reg_button_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'reg_button_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['reg_button_text'] &&
                            form['reg_button_text'][
                                `reg_button_text_${selectedLanguage}`
                            ]
                                ? form['reg_button_text'][
                                      `reg_button_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `reg_button_text.reg_button_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `reg_button_text.reg_button_text_${selectedLanguage}`
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
            form: (state) => state.reg_page_setting.form,
            validationErros: (state) => state.reg_page_setting.validationErros,
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
            this.$store.commit(`reg_page_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`reg_page_setting/updatePageSetting`, {
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
                .dispatch("reg_page_setting/addUpdateForm")
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
        fetchRegPageSetting() {
            this.$store
                .dispatch("reg_page_setting/fetchRegPageSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}reg-page-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data && res.data.data.reg_page_setting_detail
                            ? res.data.data.reg_page_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["page_title_" + res.language_id] = res.page_title;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "page_title",
                        value: obj,
                    });

                    //first name
                    obj = {};
                    data.map((res) => {
                        obj["reg_first_name_label_" + res.language_id] =
                            res.reg_first_name_label;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_first_name_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["reg_first_name_placeholder_" + res.language_id] =
                            res.reg_first_name_placeholder;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_first_name_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["reg_first_name_error_" + res.language_id] =
                            res.reg_first_name_error;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_first_name_error",
                        value: obj,
                    });

                    //last name
                    obj = {};
                    data.map((res) => {
                        obj["reg_last_name_label_" + res.language_id] =
                            res.reg_last_name_label;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_last_name_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["reg_last_name_placeholder_" + res.language_id] =
                            res.reg_last_name_placeholder;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_last_name_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["reg_last_name_error_" + res.language_id] =
                            res.reg_last_name_error;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_last_name_error",
                        value: obj,
                    });
                    //email
                    obj = {};
                    data.map((res) => {
                        obj["reg_email_label_" + res.language_id] =
                            res.reg_email_label;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_email_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["reg_email_placeholder_" + res.language_id] =
                            res.reg_email_placeholder;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_email_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["reg_email_error_" + res.language_id] =
                            res.reg_email_error;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_email_error",
                        value: obj,
                    });
                    //passowrd
                    obj = {};
                    data.map((res) => {
                        obj["reg_passowrd_label_" + res.language_id] =
                            res.reg_passowrd_label;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_passowrd_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["reg_passowrd_placeholder_" + res.language_id] =
                            res.reg_passowrd_placeholder;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_passowrd_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["reg_passowrd_error_" + res.language_id] =
                            res.reg_passowrd_error;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_passowrd_error",
                        value: obj,
                    });

                    //confirm passowrd
                    obj = {};
                    data.map((res) => {
                        obj["reg_confirm_passowrd_label_" + res.language_id] =
                            res.reg_confirm_passowrd_label;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_confirm_passowrd_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj[
                            "reg_confirm_passowrd_placeholder_" +
                                res.language_id
                        ] = res.reg_confirm_passowrd_placeholder;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_confirm_passowrd_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["reg_confirm_passowrd_error_" + res.language_id] =
                            res.reg_confirm_passowrd_error;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_confirm_passowrd_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["privacy_terms_text_" + res.language_id] =
                            res.privacy_terms_text;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "privacy_terms_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["reg_button_text_" + res.language_id] =
                            res.reg_button_text;
                    });
                    this.$store.commit("reg_page_setting/setPageSetting", {
                        key: "reg_button_text",
                        value: obj,
                    });

                    this.isDataLoaded = 1;
                    // obj = {};
                    // data.map((res) => {
                    //     obj[
                    //         "protect_your_account_description_" +
                    //             res.language_id
                    //     ] = res.protect_your_account_description;
                    // });
                    // this.$store.commit("reg_page_setting/setPageSetting", {
                    //     key: "protect_your_account_description",
                    //     value: obj,
                    // });
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
                    `reg_email_label.reg_email_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `reg_email_placeholder.reg_email_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `reg_email_error.reg_email_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `reg_passowrd_label.reg_passowrd_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `reg_passowrd_placeholder.reg_passowrd_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `reg_passowrd_error.reg_passowrd_error_${this.selectedLanguage}`
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
        this.$store.commit("reg_page_setting/resetForm");
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
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "page_title",
                    value: obj,
                });

                //first name
                obj = {};
                data.map((res) => {
                    obj["reg_first_name_label_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_first_name_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_first_name_placeholder_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_first_name_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_first_name_error_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_first_name_error",
                    value: obj,
                });

                //last name
                obj = {};
                data.map((res) => {
                    obj["reg_last_name_label_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_last_name_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_last_name_placeholder_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_last_name_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_last_name_error_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_last_name_error",
                    value: obj,
                });
                //email
                obj = {};
                data.map((res) => {
                    obj["reg_email_label_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_email_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_email_placeholder_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_email_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_email_error_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_email_error",
                    value: obj,
                });
                //passowrd
                obj = {};
                data.map((res) => {
                    obj["reg_passowrd_label_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_passowrd_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_passowrd_placeholder_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_passowrd_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_passowrd_error_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_passowrd_error",
                    value: obj,
                });

                //confirm passowrd
                obj = {};
                data.map((res) => {
                    obj["reg_confirm_passowrd_label_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_confirm_passowrd_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_confirm_passowrd_placeholder_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_confirm_passowrd_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_confirm_passowrd_error_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_confirm_passowrd_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["privacy_terms_text_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "privacy_terms_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["reg_button_text_" + res.id] = "";
                });
                this.$store.commit("reg_page_setting/setPageSetting", {
                    key: "reg_button_text",
                    value: obj,
                });

                // obj = {};
                // data.map((res) => {
                //     obj["protect_your_account_description_" + res.id] = "";
                // });
                // this.$store.commit("reg_page_setting/setPageSetting", {
                //     key: "protect_your_account_description",
                //     value: obj,
                // });
                if(this.$route.params.id){
                    this.fetchRegPageSetting();
                }
                else{
                    this.isDataLoaded = 1;
                }
            });
    },
    watch: {
        selectedLanguage: function (newVal, oldVal) {
        },
    },
    // mounted() {
    //     let ckEditorScript = document.createElement('script')
    //     ckEditorScript.setAttribute('src', `${process.env.MIX_APP_URL}/plugins/ckeditor5/ckeditor.js`)
    //     document.head.appendChild(ckEditorScript)
    // },
};
</script>
