<template>
    <header class="mb-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">Master application setting</h1>
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
                <div class="relative z-0 w-full group col-span-2 md:col-span-1"> 
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
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`description_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Description</label
                    >
                    <input
                        type="text"
                        :name="`description_${selectedLanguage}`"
                        :id="`description_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'description',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['description'] &&
                            form['description'][
                                `description_${selectedLanguage}`
                            ]
                                ? form['description'][
                                      `description_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `description.description_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `description.description_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- school -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`school_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >school label</label
                    >
                    <input
                        type="text"
                        :name="`school_lable_${selectedLanguage}`"
                        :id="`school_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'school_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['school_lable'] &&
                            form['school_lable'][
                                `school_lable_${selectedLanguage}`
                            ]
                                ? form['school_lable'][
                                      `school_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `school_lable.school_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `school_lable.school_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`school_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >school placeholder</label
                    >
                    <input
                        type="text"
                        :name="`school_placeholder_${selectedLanguage}`"
                        :id="`school_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'school_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['school_placeholder'] &&
                            form['school_placeholder'][
                                `school_placeholder_${selectedLanguage}`
                            ]
                                ? form['school_placeholder'][
                                      `school_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `school_placeholder.school_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `school_placeholder.school_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`school_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >school error</label
                    >
                    <input
                        type="text"
                        :name="`school_error_${selectedLanguage}`"
                        :id="`school_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'school_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['school_error'] &&
                            form['school_error'][
                                `school_error_${selectedLanguage}`
                            ]
                                ? form['school_error'][
                                      `school_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `school_error.school_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `school_error.school_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- first name -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`first_name_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >first name label</label
                    >
                    <input
                        type="text"
                        :name="`first_name_label_${selectedLanguage}`"
                        :id="`first_name_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'first_name_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['first_name_label'] &&
                            form['first_name_label'][
                                `first_name_label_${selectedLanguage}`
                            ]
                                ? form['first_name_label'][
                                      `first_name_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `first_name_label.first_name_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `first_name_label.first_name_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`first_name_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >first name placeholder</label
                    >
                    <input
                        type="text"
                        :name="`first_name_placeholder_${selectedLanguage}`"
                        :id="`first_name_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'first_name_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['first_name_placeholder'] &&
                            form['first_name_placeholder'][
                                `first_name_placeholder_${selectedLanguage}`
                            ]
                                ? form['first_name_placeholder'][
                                      `first_name_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `first_name_placeholder.first_name_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `first_name_placeholder.first_name_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`first_name_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >first name error</label
                    >
                    <input
                        type="text"
                        :name="`first_name_error_${selectedLanguage}`"
                        :id="`first_name_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'first_name_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['first_name_error'] &&
                            form['first_name_error'][
                                `first_name_error_${selectedLanguage}`
                            ]
                                ? form['first_name_error'][
                                      `first_name_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `first_name_error.first_name_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `first_name_error.first_name_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- last name -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`last_name_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >last name label</label
                    >
                    <input
                        type="text"
                        :name="`last_name_label_${selectedLanguage}`"
                        :id="`last_name_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'last_name_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['last_name_label'] &&
                            form['last_name_label'][
                                `last_name_label_${selectedLanguage}`
                            ]
                                ? form['last_name_label'][
                                      `last_name_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `last_name_label.last_name_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `last_name_label.last_name_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`last_name_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >last name placeholder</label
                    >
                    <input
                        type="text"
                        :name="`last_name_placeholder_${selectedLanguage}`"
                        :id="`last_name_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'last_name_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['last_name_placeholder'] &&
                            form['last_name_placeholder'][
                                `last_name_placeholder_${selectedLanguage}`
                            ]
                                ? form['last_name_placeholder'][
                                      `last_name_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `last_name_placeholder.last_name_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `last_name_placeholder.last_name_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`last_name_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >last name error</label
                    >
                    <input
                        type="text"
                        :name="`last_name_error_${selectedLanguage}`"
                        :id="`last_name_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'last_name_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['last_name_error'] &&
                            form['last_name_error'][
                                `last_name_error_${selectedLanguage}`
                            ]
                                ? form['last_name_error'][
                                      `last_name_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `last_name_error.last_name_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `last_name_error.last_name_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- email -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`email_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >email label</label
                    >
                    <input
                        type="text"
                        :name="`email_label_${selectedLanguage}`"
                        :id="`email_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
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

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`email_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >email placeholder</label
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

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`email_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >email error</label
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

                <!-- confirm email -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`confirm_email_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Confirm email label</label
                    >
                    <input
                        type="text"
                        :name="`confirm_email_label_${selectedLanguage}`"
                        :id="`confirm_email_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'confirm_email_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['confirm_email_label'] &&
                            form['confirm_email_label'][
                                `confirm_email_label_${selectedLanguage}`
                            ]
                                ? form['confirm_email_label'][
                                      `confirm_email_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `confirm_email_label.confirm_email_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `confirm_email_label.confirm_email_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`confirm_email_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Confirm email placeholder</label
                    >
                    <input
                        type="text"
                        :name="`confirm_email_placeholder_${selectedLanguage}`"
                        :id="`confirm_email_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'confirm_email_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['confirm_email_placeholder'] &&
                            form['confirm_email_placeholder'][
                                `confirm_email_placeholder_${selectedLanguage}`
                            ]
                                ? form['confirm_email_placeholder'][
                                      `confirm_email_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `confirm_email_placeholder.confirm_email_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `confirm_email_placeholder.confirm_email_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`confirm_email_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Confirm email error</label
                    >
                    <input
                        type="text"
                        :name="`confirm_email_error_${selectedLanguage}`"
                        :id="`confirm_email_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'confirm_email_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['confirm_email_error'] &&
                            form['confirm_email_error'][
                                `confirm_email_error_${selectedLanguage}`
                            ]
                                ? form['confirm_email_error'][
                                      `confirm_email_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `confirm_email_error.confirm_email_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `confirm_email_error.confirm_email_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- dob -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`dob_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Dob label</label
                    >
                    <input
                        type="text"
                        :name="`dob_label_${selectedLanguage}`"
                        :id="`dob_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'dob_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['dob_label'] &&
                            form['dob_label'][`dob_label_${selectedLanguage}`]
                                ? form['dob_label'][
                                      `dob_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `dob_label.dob_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `dob_label.dob_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`dob_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Dob placeholder</label
                    >
                    <input
                        type="text"
                        :name="`dob_placeholder_${selectedLanguage}`"
                        :id="`dob_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'dob_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['dob_placeholder'] &&
                            form['dob_placeholder'][
                                `dob_placeholder_${selectedLanguage}`
                            ]
                                ? form['dob_placeholder'][
                                      `dob_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `dob_placeholder.dob_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `dob_placeholder.dob_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`dob_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Dob error</label
                    >
                    <input
                        type="text"
                        :name="`dob_error_${selectedLanguage}`"
                        :id="`dob_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'dob_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['dob_error'] &&
                            form['dob_error'][`dob_error_${selectedLanguage}`]
                                ? form['dob_error'][
                                      `dob_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `dob_error.dob_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `dob_error.dob_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- gender -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`gender_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Gender Lable</label
                    >
                    <input
                        type="text"
                        :name="`gender_label_${selectedLanguage}`"
                        :id="`gender_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'gender_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['gender_label'] &&
                            form['gender_label'][
                                `gender_label_${selectedLanguage}`
                            ]
                                ? form['gender_label'][
                                      `gender_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `gender_label.gender_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `gender_label.gender_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`gender_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Gender placeholder</label
                    >
                    <input
                        type="text"
                        :name="`gender_placeholder_${selectedLanguage}`"
                        :id="`gender_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'gender_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['gender_placeholder'] &&
                            form['gender_placeholder'][
                                `gender_placeholder_${selectedLanguage}`
                            ]
                                ? form['gender_placeholder'][
                                      `gender_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `gender_placeholder.gender_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `gender_placeholder.gender_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`gender_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Gender error</label
                    >
                    <input
                        type="text"
                        :name="`gender_error_${selectedLanguage}`"
                        :id="`gender_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'gender_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['gender_error'] &&
                            form['gender_error'][
                                `gender_error_${selectedLanguage}`
                            ]
                                ? form['gender_error'][
                                      `gender_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `gender_error.gender_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `gender_error.gender_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- phone -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`phone_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone lable</label
                    >
                    <input
                        type="text"
                        :name="`phone_label_${selectedLanguage}`"
                        :id="`phone_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
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
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`phone_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone placeholder</label
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
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`phone_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone error</label
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

                <!-- can_school_text -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`can_school_text_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Can school text you lable</label
                    >
                    <input
                        type="text"
                        :name="`can_school_text_label_${selectedLanguage}`"
                        :id="`can_school_text_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'can_school_text_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['can_school_text_label'] &&
                            form['can_school_text_label'][
                                `can_school_text_label_${selectedLanguage}`
                            ]
                                ? form['can_school_text_label'][
                                      `can_school_text_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `can_school_text_label.can_school_text_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `can_school_text_label.can_school_text_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`can_school_text_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Can school text you placeholder</label
                    >
                    <input
                        type="text"
                        :name="`can_school_text_placeholder_${selectedLanguage}`"
                        :id="`can_school_text_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'can_school_text_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['can_school_text_placeholder'] &&
                            form['can_school_text_placeholder'][
                                `can_school_text_placeholder_${selectedLanguage}`
                            ]
                                ? form['can_school_text_placeholder'][
                                      `can_school_text_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `can_school_text_placeholder.can_school_text_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `can_school_text_placeholder.can_school_text_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`can_school_text_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Can school text you error</label
                    >
                    <input
                        type="text"
                        :name="`can_school_text_error_${selectedLanguage}`"
                        :id="`can_school_text_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'can_school_text_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['can_school_text_error'] &&
                            form['can_school_text_error'][
                                `can_school_text_error_${selectedLanguage}`
                            ]
                                ? form['can_school_text_error'][
                                      `can_school_text_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `can_school_text_error.can_school_text_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `can_school_text_error.can_school_text_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- message_app -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`message_app_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Message App lable</label
                    >
                    <input
                        type="text"
                        :name="`message_app_label_${selectedLanguage}`"
                        :id="`message_app_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_app_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['message_app_label'] &&
                            form['message_app_label'][
                                `message_app_label_${selectedLanguage}`
                            ]
                                ? form['message_app_label'][
                                      `message_app_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `message_app_label.message_app_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `message_app_label.message_app_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`message_app_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Message App placeholder</label
                    >
                    <input
                        type="text"
                        :name="`message_app_placeholder_${selectedLanguage}`"
                        :id="`message_app_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_app_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['message_app_placeholder'] &&
                            form['message_app_placeholder'][
                                `message_app_placeholder_${selectedLanguage}`
                            ]
                                ? form['message_app_placeholder'][
                                      `message_app_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `message_app_placeholder.message_app_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `message_app_placeholder.message_app_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`message_app_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Message App error</label
                    >
                    <input
                        type="text"
                        :name="`message_app_error_${selectedLanguage}`"
                        :id="`message_app_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_app_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['message_app_error'] &&
                            form['message_app_error'][
                                `message_app_error_${selectedLanguage}`
                            ]
                                ? form['message_app_error'][
                                      `message_app_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `message_app_error.message_app_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `message_app_error.message_app_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!--  message_app_username -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`message_app_username_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Message App username lable</label
                    >
                    <input
                        type="text"
                        :name="`message_app_username_label_${selectedLanguage}`"
                        :id="`message_app_username_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_app_username_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['message_app_username_label'] &&
                            form['message_app_username_label'][
                                `message_app_username_label_${selectedLanguage}`
                            ]
                                ? form['message_app_username_label'][
                                      `message_app_username_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `message_app_username_label.message_app_username_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `message_app_username_label.message_app_username_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`message_app_username_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Message App username placeholder</label
                    >
                    <input
                        type="text"
                        :name="`message_app_username_placeholder_${selectedLanguage}`"
                        :id="`message_app_username_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_app_username_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['message_app_username_placeholder'] &&
                            form['message_app_username_placeholder'][
                                `message_app_username_placeholder_${selectedLanguage}`
                            ]
                                ? form['message_app_username_placeholder'][
                                      `message_app_username_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `message_app_username_placeholder.message_app_username_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `message_app_username_placeholder.message_app_username_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`message_app_username_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Message App username error</label
                    >
                    <input
                        type="text"
                        :name="`message_app_username_error_${selectedLanguage}`"
                        :id="`message_app_username_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_app_username_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['message_app_username_error'] &&
                            form['message_app_username_error'][
                                `message_app_username_error_${selectedLanguage}`
                            ]
                                ? form['message_app_username_error'][
                                      `message_app_username_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `message_app_username_error.message_app_username_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `message_app_username_error.message_app_username_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- currently_study -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`currently_study_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Currently study lable</label
                    >
                    <input
                        type="text"
                        :name="`currently_study_label_${selectedLanguage}`"
                        :id="`currently_study_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'currently_study_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['currently_study_label'] &&
                            form['currently_study_label'][
                                `currently_study_label_${selectedLanguage}`
                            ]
                                ? form['currently_study_label'][
                                      `currently_study_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `currently_study_label.currently_study_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `currently_study_label.currently_study_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`currently_study_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Currently study placeholder</label
                    >
                    <input
                        type="text"
                        :name="`currently_study_placeholder_${selectedLanguage}`"
                        :id="`currently_study_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'currently_study_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['currently_study_placeholder'] &&
                            form['currently_study_placeholder'][
                                `currently_study_placeholder_${selectedLanguage}`
                            ]
                                ? form['currently_study_placeholder'][
                                      `currently_study_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `currently_study_placeholder.currently_study_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `currently_study_placeholder.currently_study_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`currently_study_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Currently study error</label
                    >
                    <input
                        type="text"
                        :name="`currently_study_error_${selectedLanguage}`"
                        :id="`currently_study_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'currently_study_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['currently_study_error'] &&
                            form['currently_study_error'][
                                `currently_study_error_${selectedLanguage}`
                            ]
                                ? form['currently_study_error'][
                                      `currently_study_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `currently_study_error.currently_study_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `currently_study_error.currently_study_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- country_citzenship -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`country_citzenship_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Country citzenship lable</label
                    >
                    <input
                        type="text"
                        :name="`country_citzenship_label_${selectedLanguage}`"
                        :id="`country_citzenship_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_citzenship_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['country_citzenship_label'] &&
                            form['country_citzenship_label'][
                                `country_citzenship_label_${selectedLanguage}`
                            ]
                                ? form['country_citzenship_label'][
                                      `country_citzenship_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `country_citzenship_label.country_citzenship_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `country_citzenship_label.country_citzenship_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`country_citzenship_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Country citzenship placeholder</label
                    >
                    <input
                        type="text"
                        :name="`country_citzenship_placeholder_${selectedLanguage}`"
                        :id="`country_citzenship_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_citzenship_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['country_citzenship_placeholder'] &&
                            form['country_citzenship_placeholder'][
                                `country_citzenship_placeholder_${selectedLanguage}`
                            ]
                                ? form['country_citzenship_placeholder'][
                                      `country_citzenship_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `country_citzenship_placeholder.country_citzenship_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `country_citzenship_placeholder.country_citzenship_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`country_citzenship_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Country citzenship error</label
                    >
                    <input
                        type="text"
                        :name="`country_citzenship_error_${selectedLanguage}`"
                        :id="`country_citzenship_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_citzenship_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['country_citzenship_error'] &&
                            form['country_citzenship_error'][
                                `country_citzenship_error_${selectedLanguage}`
                            ]
                                ? form['country_citzenship_error'][
                                      `country_citzenship_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `country_citzenship_error.country_citzenship_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `country_citzenship_error.country_citzenship_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- live_in_country_citzenship_label -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`live_in_country_citzenship_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Live in country citzenship lable</label
                    >
                    <input
                        type="text"
                        :name="`live_in_country_citzenship_label_${selectedLanguage}`"
                        :id="`live_in_country_citzenship_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'live_in_country_citzenship_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['live_in_country_citzenship_label'] &&
                            form['live_in_country_citzenship_label'][
                                `live_in_country_citzenship_label_${selectedLanguage}`
                            ]
                                ? form['live_in_country_citzenship_label'][
                                      `live_in_country_citzenship_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `live_in_country_citzenship_label.live_in_country_citzenship_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `live_in_country_citzenship_label.live_in_country_citzenship_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`live_in_country_citzenship_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Live in country citzenship placeholder</label
                    >
                    <input
                        type="text"
                        :name="`live_in_country_citzenship_placeholder_${selectedLanguage}`"
                        :id="`live_in_country_citzenship_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'live_in_country_citzenship_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['live_in_country_citzenship_placeholder'] &&
                            form['live_in_country_citzenship_placeholder'][
                                `live_in_country_citzenship_placeholder_${selectedLanguage}`
                            ]
                                ? form[
                                      'live_in_country_citzenship_placeholder'
                                  ][
                                      `live_in_country_citzenship_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `live_in_country_citzenship_placeholder.live_in_country_citzenship_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `live_in_country_citzenship_placeholder.live_in_country_citzenship_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`live_in_country_citzenship_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Live in country citzenship error</label
                    >
                    <input
                        type="text"
                        :name="`live_in_country_citzenship_error_${selectedLanguage}`"
                        :id="`live_in_country_citzenship_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'live_in_country_citzenship_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['live_in_country_citzenship_error'] &&
                            form['live_in_country_citzenship_error'][
                                `live_in_country_citzenship_error_${selectedLanguage}`
                            ]
                                ? form['live_in_country_citzenship_error'][
                                      `live_in_country_citzenship_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `live_in_country_citzenship_error.live_in_country_citzenship_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `live_in_country_citzenship_error.live_in_country_citzenship_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- current_residence -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`current_residence_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Current residence label</label
                    >
                    <input
                        type="text"
                        :name="`current_residence_label_${selectedLanguage}`"
                        :id="`current_residence_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'current_residence_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['current_residence_label'] &&
                            form['current_residence_label'][
                                `current_residence_label_${selectedLanguage}`
                            ]
                                ? form['current_residence_label'][
                                      `current_residence_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `current_residence_label.current_residence_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `current_residence_label.current_residence_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`current_residence_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Current residence placeholder</label
                    >
                    <input
                        type="text"
                        :name="`current_residence_placeholder_${selectedLanguage}`"
                        :id="`current_residence_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'current_residence_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['current_residence_placeholder'] &&
                            form['current_residence_placeholder'][
                                `current_residence_placeholder_${selectedLanguage}`
                            ]
                                ? form['current_residence_placeholder'][
                                      `current_residence_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `current_residence_placeholder.current_residence_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `current_residence_placeholder.current_residence_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`current_residence_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Current residence error</label
                    >
                    <input
                        type="text"
                        :name="`current_residence_error_${selectedLanguage}`"
                        :id="`current_residence_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'current_residence_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['current_residence_error'] &&
                            form['current_residence_error'][
                                `current_residence_error_${selectedLanguage}`
                            ]
                                ? form['current_residence_error'][
                                      `current_residence_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `current_residence_error.current_residence_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `current_residence_error.current_residence_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- country_residence_status -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`country_residence_status_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Country residence status label</label
                    >
                    <input
                        type="text"
                        :name="`country_residence_status_label_${selectedLanguage}`"
                        :id="`country_residence_status_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_residence_status_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['country_residence_status_label'] &&
                            form['country_residence_status_label'][
                                `country_residence_status_label_${selectedLanguage}`
                            ]
                                ? form['country_residence_status_label'][
                                      `country_residence_status_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `country_residence_status_label.country_residence_status_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `country_residence_status_label.country_residence_status_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`country_residence_status_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Country residence status placeholder</label
                    >
                    <input
                        type="text"
                        :name="`country_residence_status_placeholder_${selectedLanguage}`"
                        :id="`country_residence_status_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_residence_status_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['country_residence_status_placeholder'] &&
                            form['country_residence_status_placeholder'][
                                `country_residence_status_placeholder_${selectedLanguage}`
                            ]
                                ? form['country_residence_status_placeholder'][
                                      `country_residence_status_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `country_residence_status_placeholder.country_residence_status_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `country_residence_status_placeholder.country_residence_status_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`country_residence_status_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Country residence status error</label
                    >
                    <input
                        type="text"
                        :name="`country_residence_status_error_${selectedLanguage}`"
                        :id="`country_residence_status_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'country_residence_status_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['country_residence_status_error'] &&
                            form['country_residence_status_error'][
                                `country_residence_status_error_${selectedLanguage}`
                            ]
                                ? form['country_residence_status_error'][
                                      `country_residence_status_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `country_residence_status_error.country_residence_status_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `country_residence_status_error.country_residence_status_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- mailing_address -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`mailing_address_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Mailing address label</label
                    >
                    <input
                        type="text"
                        :name="`mailing_address_label_${selectedLanguage}`"
                        :id="`mailing_address_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'mailing_address_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['mailing_address_label'] &&
                            form['mailing_address_label'][
                                `mailing_address_label_${selectedLanguage}`
                            ]
                                ? form['mailing_address_label'][
                                      `mailing_address_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `mailing_address_label.mailing_address_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `mailing_address_label.mailing_address_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`mailing_address_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Mailing address placeholder</label
                    >
                    <input
                        type="text"
                        :name="`mailing_address_placeholder_${selectedLanguage}`"
                        :id="`mailing_address_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'mailing_address_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['mailing_address_placeholder'] &&
                            form['mailing_address_placeholder'][
                                `mailing_address_placeholder_${selectedLanguage}`
                            ]
                                ? form['mailing_address_placeholder'][
                                      `mailing_address_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `mailing_address_placeholder.mailing_address_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `mailing_address_placeholder.mailing_address_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                      :for="`mailing_address_placeholder_${selectedLanguage}`"
                      class="block text-base lg:text-lg"
                    >
                      Mailing address placeholder
                    </label>
                    <!-- <textarea
                      :name="`mailing_address_placeholder_${selectedLanguage}`"
                      :id="`mailing_address_placeholder_${selectedLanguage}`"
                      class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                      placeholder=" "
                      @input="
                        handleInput(
                          $event.target.value,
                          language,
                          'mailing_address_placeholder',
                          'updatePageSetting'
                        )
                      "
                      v-model="
                        form['mailing_address_placeholder']
                          ? form['mailing_address_placeholder'][
                              `mailing_address_placeholder_${selectedLanguage}`
                            ]
                          : ''
                      "
                    ></textarea> -->
                    <textarea
  :name="`mailing_address_placeholder_${selectedLanguage}`"
  :id="`mailing_address_placeholder_${selectedLanguage}`"
  class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
  placeholder=" "
  :value="
    form['mailing_address_placeholder']?.[`mailing_address_placeholder_${selectedLanguage}`] || ''
  "
  @input="
    handleInput(
      $event.target.value,
      selectedLanguage,
      'mailing_address_placeholder',
      'updatePageSetting'
    )
  "
></textarea>

                    <p
                      class="mt-2 text-base text-primary"
                      v-if="
                        validationErros.has(
                          `mailing_address_placeholder.mailing_address_placeholder_${selectedLanguage}`
                        )
                      "
                      v-text="
                        validationErros.get(
                          `mailing_address_placeholder.mailing_address_placeholder_${selectedLanguage}`
                        )
                      "
                    ></p>
                  </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`mailing_address_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Mailing address error</label
                    >
                    <input
                        type="text"
                        :name="`mailing_address_error_${selectedLanguage}`"
                        :id="`mailing_address_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'mailing_address_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['mailing_address_error'] &&
                            form['mailing_address_error'][
                                `mailing_address_error_${selectedLanguage}`
                            ]
                                ? form['mailing_address_error'][
                                      `mailing_address_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `mailing_address_error.mailing_address_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `mailing_address_error.mailing_address_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- high_school_name -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_name_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school name lable</label
                    >
                    <input
                        type="text"
                        :name="`high_school_name_label_${selectedLanguage}`"
                        :id="`high_school_name_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_name_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_name_label'] &&
                            form['high_school_name_label'][
                                `high_school_name_label_${selectedLanguage}`
                            ]
                                ? form['high_school_name_label'][
                                      `high_school_name_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_name_label.high_school_name_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_name_label.high_school_name_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_name_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school name placeholder</label
                    >
                    <input
                        type="text"
                        :name="`high_school_name_placeholder_${selectedLanguage}`"
                        :id="`high_school_name_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_name_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_name_placeholder'] &&
                            form['high_school_name_placeholder'][
                                `high_school_name_placeholder_${selectedLanguage}`
                            ]
                                ? form['high_school_name_placeholder'][
                                      `high_school_name_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_name_placeholder.high_school_name_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_name_placeholder.high_school_name_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_name_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school name error</label
                    >
                    <input
                        type="text"
                        :name="`high_school_name_error_${selectedLanguage}`"
                        :id="`high_school_name_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_name_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_name_error'] &&
                            form['high_school_name_error'][
                                `high_school_name_error_${selectedLanguage}`
                            ]
                                ? form['high_school_name_error'][
                                      `high_school_name_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_name_error.high_school_name_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_name_error.high_school_name_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                  <!-- letter_of_intent -->
                  <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`letter_of_intent_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Letter of intent lable</label
                    >
                    <input
                        type="text"
                        :name="`letter_of_intent_label_${selectedLanguage}`"
                        :id="`letter_of_intent_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'letter_of_intent_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['letter_of_intent_label'] &&
                            form['letter_of_intent_label'][
                                `letter_of_intent_label_${selectedLanguage}`
                            ]
                                ? form['letter_of_intent_label'][
                                      `letter_of_intent_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `letter_of_intent_label.letter_of_intent_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `letter_of_intent_label.letter_of_intent_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`letter_of_intent_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Letter of intent placeholder</label
                    >
                    <input
                        type="text"
                        :name="`letter_of_intent_placeholder_${selectedLanguage}`"
                        :id="`letter_of_intent_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'letter_of_intent_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['letter_of_intent_placeholder'] &&
                            form['letter_of_intent_placeholder'][
                                `letter_of_intent_placeholder_${selectedLanguage}`
                            ]
                                ? form['letter_of_intent_placeholder'][
                                      `letter_of_intent_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `letter_of_intent_placeholder.letter_of_intent_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `letter_of_intent_placeholder.letter_of_intent_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                      :for="`letter_of_intent_placeholder_${selectedLanguage}`"
                      class="block text-base lg:text-lg"
                    >
                    Letter of intent placeholder
                    </label>
                
                    <textarea
                    :name="`letter_of_intent_placeholder_${selectedLanguage}`"
                    :id="`letter_of_intent_placeholder_${selectedLanguage}`"
                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                    placeholder=" "
                    :value="
                        form['letter_of_intent_placeholder']?.[`letter_of_intent_placeholder_${selectedLanguage}`] || ''
                    "
                    @input="
                        handleInput(
                        $event.target.value,
                        selectedLanguage,
                        'letter_of_intent_placeholder',
                        'updatePageSetting'
                        )
                    "
                    ></textarea>

                    <p
                      class="mt-2 text-base text-primary"
                      v-if="
                        validationErros.has(
                          `letter_of_intent_placeholder.letter_of_intent_placeholder_${selectedLanguage}`
                        )
                      "
                      v-text="
                        validationErros.get(
                          `letter_of_intent_placeholder.letter_of_intent_placeholder_${selectedLanguage}`
                        )
                      "
                    ></p>
                  </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`letter_of_intent_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Letter of intent error</label
                    >
                    <input
                        type="text"
                        :name="`letter_of_intent_error_${selectedLanguage}`"
                        :id="`letter_of_intent_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'letter_of_intent_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['letter_of_intent_error'] &&
                            form['letter_of_intent_error'][
                                `letter_of_intent_error_${selectedLanguage}`
                            ]
                                ? form['letter_of_intent_error'][
                                      `letter_of_intent_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `letter_of_intent_error.letter_of_intent_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `letter_of_intent_error.letter_of_intent_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                  <!-- statement_of_purpose -->
                  <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`statement_of_purpose_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Statement of purpose lable</label
                    >
                    <input
                        type="text"
                        :name="`statement_of_purpose_label_${selectedLanguage}`"
                        :id="`statement_of_purpose_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'statement_of_purpose_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['statement_of_purpose_label'] &&
                            form['statement_of_purpose_label'][
                                `statement_of_purpose_label_${selectedLanguage}`
                            ]
                                ? form['statement_of_purpose_label'][
                                      `statement_of_purpose_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `statement_of_purpose_label.statement_of_purpose_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `statement_of_purpose_label.statement_of_purpose_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`statement_of_purpose_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Statement of purpose placeholder</label
                    >
                    <input
                        type="text"
                        :name="`statement_of_purpose_placeholder_${selectedLanguage}`"
                        :id="`statement_of_purpose_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'statement_of_purpose_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['statement_of_purpose_placeholder'] &&
                            form['statement_of_purpose_placeholder'][
                                `statement_of_purpose_placeholder_${selectedLanguage}`
                            ]
                                ? form['statement_of_purpose_placeholder'][
                                      `statement_of_purpose_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `statement_of_purpose_placeholder.statement_of_purpose_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `statement_of_purpose_placeholder.statement_of_purpose_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                      :for="`statement_of_purpose_placeholder_${selectedLanguage}`"
                      class="block text-base lg:text-lg"
                    >
                    Statement of purpose placeholder
                    </label>
                
                    <textarea
                    :name="`statement_of_purpose_placeholder_${selectedLanguage}`"
                    :id="`statement_of_purpose_placeholder_${selectedLanguage}`"
                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                    placeholder=" "
                    :value="
                        form['statement_of_purpose_placeholder']?.[`statement_of_purpose_placeholder_${selectedLanguage}`] || ''
                    "
                    @input="
                        handleInput(
                        $event.target.value,
                        selectedLanguage,
                        'statement_of_purpose_placeholder',
                        'updatePageSetting'
                        )
                    "
                    ></textarea>

                    <p
                      class="mt-2 text-base text-primary"
                      v-if="
                        validationErros.has(
                          `statement_of_purpose_placeholder.statement_of_purpose_placeholder_${selectedLanguage}`
                        )
                      "
                      v-text="
                        validationErros.get(
                          `statement_of_purpose_placeholder.statement_of_purpose_placeholder_${selectedLanguage}`
                        )
                      "
                    ></p>
                  </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`statement_of_purpose_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Statement of purpose error</label
                    >
                    <input
                        type="text"
                        :name="`statement_of_purpose_error_${selectedLanguage}`"
                        :id="`statement_of_purpose_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'statement_of_purpose_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['statement_of_purpose_error'] &&
                            form['statement_of_purpose_error'][
                                `statement_of_purpose_error_${selectedLanguage}`
                            ]
                                ? form['statement_of_purpose_error'][
                                      `statement_of_purpose_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `statement_of_purpose_error.statement_of_purpose_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `statement_of_purpose_error.statement_of_purpose_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- high_school_cgpa -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_cgpa_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school cgpa lable</label
                    >
                    <input
                        type="text"
                        :name="`high_school_cgpa_lable_${selectedLanguage}`"
                        :id="`high_school_cgpa_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_cgpa_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_cgpa_lable'] &&
                            form['high_school_cgpa_lable'][
                                `high_school_cgpa_lable_${selectedLanguage}`
                            ]
                                ? form['high_school_cgpa_lable'][
                                      `high_school_cgpa_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_cgpa_lable.high_school_cgpa_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_cgpa_lable.high_school_cgpa_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_cgpa_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school cgpa placeholder</label
                    >
                    <input
                        type="text"
                        :name="`high_school_cgpa_placeholder_${selectedLanguage}`"
                        :id="`high_school_cgpa_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_cgpa_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_cgpa_placeholder'] &&
                            form['high_school_cgpa_placeholder'][
                                `high_school_cgpa_placeholder_${selectedLanguage}`
                            ]
                                ? form['high_school_cgpa_placeholder'][
                                      `high_school_cgpa_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_cgpa_placeholder.high_school_cgpa_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_cgpa_placeholder.high_school_cgpa_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_cgpa_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school cgpa error</label
                    >
                    <input
                        type="text"
                        :name="`high_school_cgpa_error_${selectedLanguage}`"
                        :id="`high_school_cgpa_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_cgpa_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_cgpa_error'] &&
                            form['high_school_cgpa_error'][
                                `high_school_cgpa_error_${selectedLanguage}`
                            ]
                                ? form['high_school_cgpa_error'][
                                      `high_school_cgpa_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_cgpa_error.high_school_cgpa_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_cgpa_error.high_school_cgpa_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- high_school_city -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_city_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school city lable</label
                    >
                    <input
                        type="text"
                        :name="`high_school_city_lable_${selectedLanguage}`"
                        :id="`high_school_city_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_city_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_city_lable'] &&
                            form['high_school_city_lable'][
                                `high_school_city_lable_${selectedLanguage}`
                            ]
                                ? form['high_school_city_lable'][
                                      `high_school_city_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_city_lable.high_school_city_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_city_lable.high_school_city_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_city_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school city placeholder</label
                    >
                    <input
                        type="text"
                        :name="`high_school_city_placeholder_${selectedLanguage}`"
                        :id="`high_school_city_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_city_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_city_placeholder'] &&
                            form['high_school_city_placeholder'][
                                `high_school_city_placeholder_${selectedLanguage}`
                            ]
                                ? form['high_school_city_placeholder'][
                                      `high_school_city_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_city_placeholder.high_school_city_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_city_placeholder.high_school_city_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_city_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school city error</label
                    >
                    <input
                        type="text"
                        :name="`high_school_city_error_${selectedLanguage}`"
                        :id="`high_school_city_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_city_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_city_error'] &&
                            form['high_school_city_error'][
                                `high_school_city_error_${selectedLanguage}`
                            ]
                                ? form['high_school_city_error'][
                                      `high_school_city_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_city_error.high_school_city_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_city_error.high_school_city_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- high_school_country -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_country_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school country lable</label
                    >
                    <input
                        type="text"
                        :name="`high_school_country_lable_${selectedLanguage}`"
                        :id="`high_school_country_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_country_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_country_lable'] &&
                            form['high_school_country_lable'][
                                `high_school_country_lable_${selectedLanguage}`
                            ]
                                ? form['high_school_country_lable'][
                                      `high_school_country_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_country_lable.high_school_country_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_country_lable.high_school_country_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_country_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school country placeholder</label
                    >
                    <input
                        type="text"
                        :name="`high_school_country_placeholder_${selectedLanguage}`"
                        :id="`high_school_country_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_country_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_country_placeholder'] &&
                            form['high_school_country_placeholder'][
                                `high_school_country_placeholder_${selectedLanguage}`
                            ]
                                ? form['high_school_country_placeholder'][
                                      `high_school_country_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_country_placeholder.high_school_country_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_country_placeholder.high_school_country_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`high_school_country_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >High school country error</label
                    >
                    <input
                        type="text"
                        :name="`high_school_country_error_${selectedLanguage}`"
                        :id="`high_school_country_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'high_school_country_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['high_school_country_error'] &&
                            form['high_school_country_error'][
                                `high_school_country_error_${selectedLanguage}`
                            ]
                                ? form['high_school_country_error'][
                                      `high_school_country_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `high_school_country_error.high_school_country_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `high_school_country_error.high_school_country_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- student_type -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`student_type_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Student type lable</label
                    >
                    <input
                        type="text"
                        :name="`student_type_lable_${selectedLanguage}`"
                        :id="`student_type_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'student_type_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['student_type_lable'] &&
                            form['student_type_lable'][
                                `student_type_lable_${selectedLanguage}`
                            ]
                                ? form['student_type_lable'][
                                      `student_type_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `student_type_lable.student_type_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `student_type_lable.student_type_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`student_type_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Student type placeholder</label
                    >
                    <input
                        type="text"
                        :name="`student_type_placeholder_${selectedLanguage}`"
                        :id="`student_type_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'student_type_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['student_type_placeholder'] &&
                            form['student_type_placeholder'][
                                `student_type_placeholder_${selectedLanguage}`
                            ]
                                ? form['student_type_placeholder'][
                                      `student_type_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `student_type_placeholder.student_type_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `student_type_placeholder.student_type_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`student_type_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Student type error</label
                    >
                    <input
                        type="text"
                        :name="`student_type_error_${selectedLanguage}`"
                        :id="`student_type_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'student_type_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['student_type_error'] &&
                            form['student_type_error'][
                                `student_type_error_${selectedLanguage}`
                            ]
                                ? form['student_type_error'][
                                      `student_type_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `student_type_error.student_type_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `student_type_error.student_type_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- when_plan_to_start -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`when_plan_to_start_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >When plan to start lable</label
                    >
                    <input
                        type="text"
                        :name="`when_plan_to_start_label_${selectedLanguage}`"
                        :id="`when_plan_to_start_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'when_plan_to_start_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['when_plan_to_start_label'] &&
                            form['when_plan_to_start_label'][
                                `when_plan_to_start_label_${selectedLanguage}`
                            ]
                                ? form['when_plan_to_start_label'][
                                      `when_plan_to_start_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `when_plan_to_start_label.when_plan_to_start_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `when_plan_to_start_label.when_plan_to_start_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`when_plan_to_start_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >When plan to start placeholder</label
                    >
                    <input
                        type="text"
                        :name="`when_plan_to_start_placeholder_${selectedLanguage}`"
                        :id="`when_plan_to_start_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'when_plan_to_start_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['when_plan_to_start_placeholder'] &&
                            form['when_plan_to_start_placeholder'][
                                `when_plan_to_start_placeholder_${selectedLanguage}`
                            ]
                                ? form['when_plan_to_start_placeholder'][
                                      `when_plan_to_start_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `when_plan_to_start_placeholder.when_plan_to_start_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `when_plan_to_start_placeholder.when_plan_to_start_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`when_plan_to_start_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >When plan to start error</label
                    >
                    <input
                        type="text"
                        :name="`when_plan_to_start_error_${selectedLanguage}`"
                        :id="`when_plan_to_start_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'when_plan_to_start_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['when_plan_to_start_error'] &&
                            form['when_plan_to_start_error'][
                                `when_plan_to_start_error_${selectedLanguage}`
                            ]
                                ? form['when_plan_to_start_error'][
                                      `when_plan_to_start_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `when_plan_to_start_error.when_plan_to_start_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `when_plan_to_start_error.when_plan_to_start_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- intrested_in -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`intrested_in_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Intrested in label</label
                    >
                    <input
                        type="text"
                        :name="`intrested_in_label_${selectedLanguage}`"
                        :id="`intrested_in_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'intrested_in_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['intrested_in_label'] &&
                            form['intrested_in_label'][
                                `intrested_in_label_${selectedLanguage}`
                            ]
                                ? form['intrested_in_label'][
                                      `intrested_in_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `intrested_in_label.intrested_in_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `intrested_in_label.intrested_in_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`intrested_in_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Intrested in placeholder</label
                    >
                    <input
                        type="text"
                        :name="`intrested_in_placeholder_${selectedLanguage}`"
                        :id="`intrested_in_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'intrested_in_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['intrested_in_placeholder'] &&
                            form['intrested_in_placeholder'][
                                `intrested_in_placeholder_${selectedLanguage}`
                            ]
                                ? form['intrested_in_placeholder'][
                                      `intrested_in_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `intrested_in_placeholder.intrested_in_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `intrested_in_placeholder.intrested_in_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`intrested_in_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Intrested in error</label
                    >
                    <input
                        type="text"
                        :name="`intrested_in_error_${selectedLanguage}`"
                        :id="`intrested_in_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'intrested_in_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['intrested_in_error'] &&
                            form['intrested_in_error'][
                                `intrested_in_error_${selectedLanguage}`
                            ]
                                ? form['intrested_in_error'][
                                      `intrested_in_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `intrested_in_error.intrested_in_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `intrested_in_error.intrested_in_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- would_like_to_study -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`would_like_to_study_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Would like to study lable</label
                    >
                    <input
                        type="text"
                        :name="`would_like_to_study_label_${selectedLanguage}`"
                        :id="`would_like_to_study_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'would_like_to_study_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['would_like_to_study_label'] &&
                            form['would_like_to_study_label'][
                                `would_like_to_study_label_${selectedLanguage}`
                            ]
                                ? form['would_like_to_study_label'][
                                      `would_like_to_study_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `would_like_to_study_label.would_like_to_study_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `would_like_to_study_label.would_like_to_study_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`would_like_to_study_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Would like to study placeholder</label
                    >
                    <input
                        type="text"
                        :name="`would_like_to_study_placeholder_${selectedLanguage}`"
                        :id="`would_like_to_study_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'would_like_to_study_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['would_like_to_study_placeholder'] &&
                            form['would_like_to_study_placeholder'][
                                `would_like_to_study_placeholder_${selectedLanguage}`
                            ]
                                ? form['would_like_to_study_placeholder'][
                                      `would_like_to_study_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `would_like_to_study_placeholder.would_like_to_study_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `would_like_to_study_placeholder.would_like_to_study_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`would_like_to_study_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Would like to study error</label
                    >
                    <input
                        type="text"
                        :name="`would_like_to_study_error_${selectedLanguage}`"
                        :id="`would_like_to_study_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'would_like_to_study_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['would_like_to_study_error'] &&
                            form['would_like_to_study_error'][
                                `would_like_to_study_error_${selectedLanguage}`
                            ]
                                ? form['would_like_to_study_error'][
                                      `would_like_to_study_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `would_like_to_study_error.would_like_to_study_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `would_like_to_study_error.would_like_to_study_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- tuition_funding_source -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`tuition_funding_source_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Tuition Funding Source lable</label
                    >
                    <input
                        type="text"
                        :name="`tuition_funding_source_label_${selectedLanguage}`"
                        :id="`tuition_funding_source_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'tuition_funding_source_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['tuition_funding_source_label'] &&
                            form['tuition_funding_source_label'][
                                `tuition_funding_source_label_${selectedLanguage}`
                            ]
                                ? form['tuition_funding_source_label'][
                                      `tuition_funding_source_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `tuition_funding_source_label.tuition_funding_source_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `tuition_funding_source_label.tuition_funding_source_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`tuition_funding_source_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Tuition Funding Source placeholder</label
                    >
                    <input
                        type="text"
                        :name="`tuition_funding_source_placeholder_${selectedLanguage}`"
                        :id="`tuition_funding_source_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'tuition_funding_source_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['tuition_funding_source_placeholder'] &&
                            form['tuition_funding_source_placeholder'][
                                `tuition_funding_source_placeholder_${selectedLanguage}`
                            ]
                                ? form['tuition_funding_source_placeholder'][
                                      `tuition_funding_source_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `tuition_funding_source_placeholder.tuition_funding_source_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `tuition_funding_source_placeholder.tuition_funding_source_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`tuition_funding_source_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Tuition Funding Source error</label
                    >
                    <input
                        type="text"
                        :name="`tuition_funding_source_error_${selectedLanguage}`"
                        :id="`tuition_funding_source_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'tuition_funding_source_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['tuition_funding_source_error'] &&
                            form['tuition_funding_source_error'][
                                `tuition_funding_source_error_${selectedLanguage}`
                            ]
                                ? form['tuition_funding_source_error'][
                                      `tuition_funding_source_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `tuition_funding_source_error.tuition_funding_source_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `tuition_funding_source_error.tuition_funding_source_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- test_taken -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`test_taken_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Test taken label</label
                    >
                    <input
                        type="text"
                        :name="`test_taken_label_${selectedLanguage}`"
                        :id="`test_taken_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'test_taken_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['test_taken_label'] &&
                            form['test_taken_label'][
                                `test_taken_label_${selectedLanguage}`
                            ]
                                ? form['test_taken_label'][
                                      `test_taken_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `test_taken_label.test_taken_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `test_taken_label.test_taken_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`test_taken_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Test taken placeholder</label
                    >
                    <input
                        type="text"
                        :name="`test_taken_placeholder_${selectedLanguage}`"
                        :id="`test_taken_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'test_taken_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['test_taken_placeholder'] &&
                            form['test_taken_placeholder'][
                                `test_taken_placeholder_${selectedLanguage}`
                            ]
                                ? form['test_taken_placeholder'][
                                      `test_taken_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `test_taken_placeholder.test_taken_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `test_taken_placeholder.test_taken_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`test_taken_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Test taken error</label
                    >
                    <input
                        type="text"
                        :name="`test_taken_error_${selectedLanguage}`"
                        :id="`test_taken_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'test_taken_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['test_taken_error'] &&
                            form['test_taken_error'][
                                `test_taken_error_${selectedLanguage}`
                            ]
                                ? form['test_taken_error'][
                                      `test_taken_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `test_taken_error.test_taken_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `test_taken_error.test_taken_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- additional -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`additional_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Additional lable</label
                    >
                    <input
                        type="text"
                        :name="`additional_label_${selectedLanguage}`"
                        :id="`additional_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'additional_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['additional_label'] &&
                            form['additional_label'][
                                `additional_label_${selectedLanguage}`
                            ]
                                ? form['additional_label'][
                                      `additional_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `additional_label.additional_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `additional_label.additional_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`additional_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Additional placeholder</label
                    >
                    <input
                        type="text"
                        :name="`additional_placeholder_${selectedLanguage}`"
                        :id="`additional_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'additional_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['additional_placeholder'] &&
                            form['additional_placeholder'][
                                `additional_placeholder_${selectedLanguage}`
                            ]
                                ? form['additional_placeholder'][
                                      `additional_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `additional_placeholder.additional_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `additional_placeholder.additional_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                      :for="`additional_placeholder_${selectedLanguage}`"
                      class="block text-base lg:text-lg"
                    >
                    Additional placeholder
                    </label>
                
                    <textarea
                    :name="`additional_placeholder_${selectedLanguage}`"
                    :id="`additional_placeholder_${selectedLanguage}`"
                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                    placeholder=" "
                    :value="
                        form['additional_placeholder']?.[`additional_placeholder_${selectedLanguage}`] || ''
                    "
                    @input="
                        handleInput(
                        $event.target.value,
                        selectedLanguage,
                        'additional_placeholder',
                        'updatePageSetting'
                        )
                    "
                    ></textarea>

                    <p
                      class="mt-2 text-base text-primary"
                      v-if="
                        validationErros.has(
                          `additional_placeholder.additional_placeholder_${selectedLanguage}`
                        )
                      "
                      v-text="
                        validationErros.get(
                          `additional_placeholder.additional_placeholder_${selectedLanguage}`
                        )
                      "
                    ></p>
                  </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`additional_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Additional error</label
                    >
                    <input
                        type="text"
                        :name="`additional_error_${selectedLanguage}`"
                        :id="`additional_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'additional_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['additional_error'] &&
                            form['additional_error'][
                                `additional_error_${selectedLanguage}`
                            ]
                                ? form['additional_error'][
                                      `additional_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `additional_error.additional_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `additional_error.additional_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- add_something -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`add_something_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Add something lable</label
                    >
                    <input
                        type="text"
                        :name="`add_something_lable_${selectedLanguage}`"
                        :id="`add_something_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'add_something_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['add_something_lable'] &&
                            form['add_something_lable'][
                                `add_something_lable_${selectedLanguage}`
                            ]
                                ? form['add_something_lable'][
                                      `add_something_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `add_something_lable.add_something_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `add_something_lable.add_something_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`add_something_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Add something placeholder</label
                    >
                    <input
                        type="text"
                        :name="`add_something_placeholder_${selectedLanguage}`"
                        :id="`add_something_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'add_something_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['add_something_placeholder'] &&
                            form['add_something_placeholder'][
                                `add_something_placeholder_${selectedLanguage}`
                            ]
                                ? form['add_something_placeholder'][
                                      `add_something_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `add_something_placeholder.add_something_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `add_something_placeholder.add_something_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                      :for="`add_something_placeholder_${selectedLanguage}`"
                      class="block text-base lg:text-lg"
                    >
                    Add something placeholder
                    </label>
                
                    <textarea
                    :name="`add_something_placeholder_${selectedLanguage}`"
                    :id="`add_something_placeholder_${selectedLanguage}`"
                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                    placeholder=" "
                    :value="
                        form['add_something_placeholder']?.[`add_something_placeholder_${selectedLanguage}`] || ''
                    "
                    @input="
                        handleInput(
                        $event.target.value,
                        selectedLanguage,
                        'add_something_placeholder',
                        'updatePageSetting'
                        )
                    "
                    ></textarea>

                    <p
                      class="mt-2 text-base text-primary"
                      v-if="
                        validationErros.has(
                          `add_something_placeholder.add_something_placeholder_${selectedLanguage}`
                        )
                      "
                      v-text="
                        validationErros.get(
                          `add_something_placeholder.add_something_placeholder_${selectedLanguage}`
                        )
                      "
                    ></p>
                  </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`add_something_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Add something error</label
                    >
                    <input
                        type="text"
                        :name="`add_something_error_${selectedLanguage}`"
                        :id="`add_something_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'add_something_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['add_something_error'] &&
                            form['add_something_error'][
                                `add_something_error_${selectedLanguage}`
                            ]
                                ? form['add_something_error'][
                                      `add_something_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `add_something_error.add_something_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `add_something_error.add_something_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- currently_live_in -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`currently_live_in_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Currently live in lable</label
                    >
                    <input
                        type="text"
                        :name="`currently_live_in_lable_${selectedLanguage}`"
                        :id="`currently_live_in_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'currently_live_in_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['currently_live_in_lable'] &&
                            form['currently_live_in_lable'][
                                `currently_live_in_lable_${selectedLanguage}`
                            ]
                                ? form['currently_live_in_lable'][
                                      `currently_live_in_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `currently_live_in_lable.currently_live_in_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `currently_live_in_lable.currently_live_in_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`currently_live_in_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Currently live in placeholder</label
                    >
                    <input
                        type="text"
                        :name="`currently_live_in_placeholder_${selectedLanguage}`"
                        :id="`currently_live_in_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'currently_live_in_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['currently_live_in_placeholder'] &&
                            form['currently_live_in_placeholder'][
                                `currently_live_in_placeholder_${selectedLanguage}`
                            ]
                                ? form['currently_live_in_placeholder'][
                                      `currently_live_in_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `currently_live_in_placeholder.currently_live_in_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `currently_live_in_placeholder.currently_live_in_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`currently_live_in_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Currently live in error</label
                    >
                    <input
                        type="text"
                        :name="`currently_live_in_error_${selectedLanguage}`"
                        :id="`currently_live_in_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'currently_live_in_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['currently_live_in_error'] &&
                            form['currently_live_in_error'][
                                `currently_live_in_error_${selectedLanguage}`
                            ]
                                ? form['currently_live_in_error'][
                                      `currently_live_in_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `currently_live_in_error.currently_live_in_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `currently_live_in_error.currently_live_in_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- study_permet -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`study_permet_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Study permet lable</label
                    >
                    <input
                        type="text"
                        :name="`study_permet_lable_${selectedLanguage}`"
                        :id="`study_permet_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'study_permet_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['study_permet_lable'] &&
                            form['study_permet_lable'][
                                `study_permet_lable_${selectedLanguage}`
                            ]
                                ? form['study_permet_lable'][
                                      `study_permet_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `study_permet_lable.study_permet_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `study_permet_lable.study_permet_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`study_permet_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Study permet placeholder</label
                    >
                    <input
                        type="text"
                        :name="`study_permet_placeholder_${selectedLanguage}`"
                        :id="`study_permet_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'study_permet_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['study_permet_placeholder'] &&
                            form['study_permet_placeholder'][
                                `study_permet_placeholder_${selectedLanguage}`
                            ]
                                ? form['study_permet_placeholder'][
                                      `study_permet_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `study_permet_placeholder.study_permet_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `study_permet_placeholder.study_permet_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`study_permet_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Study permet error</label
                    >
                    <input
                        type="text"
                        :name="`study_permet_error_${selectedLanguage}`"
                        :id="`study_permet_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'study_permet_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['study_permet_error'] &&
                            form['study_permet_error'][
                                `study_permet_error_${selectedLanguage}`
                            ]
                                ? form['study_permet_error'][
                                      `study_permet_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `study_permet_error.study_permet_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `study_permet_error.study_permet_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- where_want_to_study_label -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`where_want_to_study_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Where want to study lable</label
                    >
                    <input
                        type="text"
                        :name="`where_want_to_study_lable_${selectedLanguage}`"
                        :id="`where_want_to_study_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'where_want_to_study_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['where_want_to_study_lable'] &&
                            form['where_want_to_study_lable'][
                                `where_want_to_study_lable_${selectedLanguage}`
                            ]
                                ? form['where_want_to_study_lable'][
                                      `where_want_to_study_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `where_want_to_study_lable.where_want_to_study_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `where_want_to_study_lable.where_want_to_study_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`where_want_to_study_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Where want to study placeholder</label
                    >
                    <input
                        type="text"
                        :name="`where_want_to_study_placeholder_${selectedLanguage}`"
                        :id="`where_want_to_study_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'where_want_to_study_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['where_want_to_study_placeholder'] &&
                            form['where_want_to_study_placeholder'][
                                `where_want_to_study_placeholder_${selectedLanguage}`
                            ]
                                ? form['where_want_to_study_placeholder'][
                                      `where_want_to_study_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `where_want_to_study_placeholder.where_want_to_study_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `where_want_to_study_placeholder.where_want_to_study_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`where_want_to_study_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Where want to study error</label
                    >
                    <input
                        type="text"
                        :name="`where_want_to_study_error_${selectedLanguage}`"
                        :id="`where_want_to_study_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'where_want_to_study_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['where_want_to_study_error'] &&
                            form['where_want_to_study_error'][
                                `where_want_to_study_error_${selectedLanguage}`
                            ]
                                ? form['where_want_to_study_error'][
                                      `where_want_to_study_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `where_want_to_study_error.where_want_to_study_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `where_want_to_study_error.where_want_to_study_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- send_copy -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`send_copy_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Send a copy lable</label
                    >
                    <input
                        type="text"
                        :name="`send_copy_lable_${selectedLanguage}`"
                        :id="`send_copy_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'send_copy_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['send_copy_lable'] &&
                            form['send_copy_lable'][
                                `send_copy_lable_${selectedLanguage}`
                            ]
                                ? form['send_copy_lable'][
                                      `send_copy_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `send_copy_lable.send_copy_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `send_copy_lable.send_copy_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`send_copy_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Send a copy placeholder</label
                    >
                    <input
                        type="text"
                        :name="`send_copy_placeholder_${selectedLanguage}`"
                        :id="`send_copy_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'send_copy_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['send_copy_placeholder'] &&
                            form['send_copy_placeholder'][
                                `send_copy_placeholder_${selectedLanguage}`
                            ]
                                ? form['send_copy_placeholder'][
                                      `send_copy_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `send_copy_placeholder.send_copy_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `send_copy_placeholder.send_copy_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`send_copy_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Send a copy error</label
                    >
                    <input
                        type="text"
                        :name="`send_copy_error_${selectedLanguage}`"
                        :id="`send_copy_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'send_copy_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['send_copy_error'] &&
                            form['send_copy_error'][
                                `send_copy_error_${selectedLanguage}`
                            ]
                                ? form['send_copy_error'][
                                      `send_copy_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `send_copy_error.send_copy_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `send_copy_error.send_copy_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- privacy_policy -->
                <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                    <!-- <input
                        type="text"
                        :name="`privacy_policy_${selectedLanguage}`"
                        :id="`privacy_policy_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'privacy_policy',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['privacy_policy'] &&
                            form['privacy_policy'][
                                `privacy_policy_${selectedLanguage}`
                            ]
                                ? form['privacy_policy'][
                                      `privacy_policy_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    /> -->

                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`privacy_policy_${language.id}`"
                    ></div> -->
                    <label
                        :for="`privacy_policy_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Privacy policy</label
                    >
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'privacy_policy'
                                )
                            "
                            :ref="`privacy_policy_${language.id}`"
                            :id="`privacy_policy_${language.id}`"
                            :initial-value="form[`privacy_policy`][`privacy_policy_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `privacy_policy.privacy_policy_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `privacy_policy.privacy_policy_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- button_text -->
                <div class="relative z-0 w-full group  col-span-2 md:col-span-1">
                    <label
                        :for="`button_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Button text</label
                    >
                    <input
                        type="text"
                        :name="`button_text_${selectedLanguage}`"
                        :id="`button_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'button_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['button_text'] &&
                            form['button_text'][
                                `button_text_${selectedLanguage}`
                            ]
                                ? form['button_text'][
                                      `button_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `button_text.button_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `button_text.button_text_${selectedLanguage}`
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
            form: (state) => state.master_application_setting.form,
            validationErros: (state) =>
                state.master_application_setting.validationErros,
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
            this.$store.commit(`master_application_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`master_application_setting/updatePageSetting`, {
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
                .dispatch("master_application_setting/addUpdateForm")
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
        fetchMasterApplicationSetting() {
            this.$store
                .dispatch(
                    "master_application_setting/fetchMasterApplicationSetting",
                    {
                        url: `${process.env.MIX_ADMIN_API_URL}master-application-setting`,
                    }
                )
                .then((res) => {
                    var keys = [
                        "page_title",
                        "description",
                        "first_name_label",
                        "first_name_placeholder",
                        "first_name_error",
                        "last_name_label",
                        "last_name_placeholder",
                        "last_name_error",
                        "email_label",
                        "email_placeholder",
                        "email_error",
                        "confirm_email_label",
                        "confirm_email_placeholder",
                        "confirm_email_error",
                        "dob_label",
                        "dob_placeholder",
                        "dob_error",
                        "gender_label",
                        "gender_placeholder",
                        "gender_error",
                        "phone_label",
                        "phone_placeholder",
                        "phone_error",
                        "can_school_text_label",
                        "can_school_text_placeholder",
                        "can_school_text_error",
                        "message_app_label",
                        "message_app_placeholder",
                        "message_app_error",
                        "message_app_username_label",
                        "message_app_username_placeholder",
                        "message_app_username_error",
                        "currently_study_label",
                        "currently_study_placeholder",
                        "currently_study_error",
                        "country_citzenship_label",
                        "country_citzenship_placeholder",
                        "country_citzenship_error",
                        "live_in_country_citzenship_label",
                        "live_in_country_citzenship_placeholder",
                        "live_in_country_citzenship_error",
                        "current_residence_label",
                        "current_residence_placeholder",
                        "current_residence_error",
                        "country_residence_status_label",
                        "country_residence_status_placeholder",
                        "country_residence_status_error",
                        "mailing_address_label",
                        "mailing_address_placeholder",
                        "mailing_address_error",
                        "high_school_name_label",
                        "high_school_name_placeholder",
                        "high_school_name_error",
                        "letter_of_intent_label",
                        "letter_of_intent_placeholder",
                        "letter_of_intent_error",
                        "statement_of_purpose_label",
                        "statement_of_purpose_placeholder",
                        "statement_of_purpose_error",
                        "when_plan_to_start_label",
                        "when_plan_to_start_placeholder",
                        "when_plan_to_start_error",
                        "intrested_in_label",
                        "intrested_in_placeholder",
                        "intrested_in_error",
                        "would_like_to_study_label",
                        "would_like_to_study_placeholder",
                        "would_like_to_study_error",
                        "tuition_funding_source_label",
                        "tuition_funding_source_placeholder",
                        "tuition_funding_source_error",
                        "test_taken_label",
                        "test_taken_placeholder",
                        "test_taken_error",
                        "additional_label",
                        "additional_placeholder",
                        "additional_error",
                        "add_something_lable",
                        "add_something_placeholder",
                        "add_something_error",
                        "currently_live_in_lable",
                        "currently_live_in_placeholder",
                        "currently_live_in_error",
                        "study_permet_lable",
                        "study_permet_placeholder",
                        "study_permet_error",
                        "send_copy_lable",
                        "send_copy_placeholder",
                        "send_copy_error",
                        "button_text",
                        "where_want_to_study_lable",
                        "where_want_to_study_placeholder",
                        "where_want_to_study_error",
                        "high_school_city_lable",
                        "high_school_city_placeholder",
                        "high_school_city_error",
                        "high_school_country_lable",
                        "high_school_country_placeholder",
                        "high_school_country_error",
                        "student_type_lable",
                        "student_type_placeholder",
                        "student_type_error",
                        "high_school_cgpa_lable",
                        "high_school_cgpa_placeholder",
                        "high_school_cgpa_error",
                        "school_lable",
                        "school_placeholder",
                        "school_error",
                    ];
                    let data =
                        res.data.data &&
                        res.data.data.master_application_setting_detail
                            ? res.data.data.master_application_setting_detail
                            : [];

                    keys.map((key) => {
                        var obj = {};
                        data.map((res) => {
                            obj[key + "_" + res.language_id] = res[key]
                                ? res[key]
                                : "";
                        });
                        this.$store.commit(
                            "master_application_setting/setPageSetting",
                            {
                                key,
                                value: obj,
                            }
                        );
                    });

                    data.map((res) => {
                        this.$store.commit(
                            "master_application_setting/updatePageSetting",
                            {
                                key: "privacy_policy",
                                id: res.language_id,
                                value: res.privacy_policy,
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
                    `dob_label.dob_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `dob_placeholder.dob_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `dob_error.dob_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `gender_label.gender_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `gender_placeholder.gender_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `button_text.button_text_${this.selectedLanguage}`
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
                    `description.description_${this.selectedLanguage}`
                )
            );
        },
    },
    created() {
        this.$store.commit("master_application_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                var keys = [
                    "page_title",
                    "description",
                    "first_name_label",
                    "first_name_placeholder",
                    "first_name_error",
                    "last_name_label",
                    "last_name_placeholder",
                    "last_name_error",
                    "email_label",
                    "email_placeholder",
                    "email_error",
                    "confirm_email_label",
                    "confirm_email_placeholder",
                    "confirm_email_error",
                    "dob_label",
                    "dob_placeholder",
                    "dob_error",
                    "gender_label",
                    "gender_placeholder",
                    "gender_error",
                    "phone_label",
                    "phone_placeholder",
                    "phone_error",
                    "can_school_text_label",
                    "can_school_text_placeholder",
                    "can_school_text_error",
                    "message_app_label",
                    "message_app_placeholder",
                    "message_app_error",
                    "message_app_username_label",
                    "message_app_username_placeholder",
                    "message_app_username_error",
                    "currently_study_label",
                    "currently_study_placeholder",
                    "currently_study_error",
                    "country_citzenship_label",
                    "country_citzenship_placeholder",
                    "country_citzenship_error",
                    "live_in_country_citzenship_label",
                    "live_in_country_citzenship_placeholder",
                    "live_in_country_citzenship_error",
                    "current_residence_label",
                    "current_residence_placeholder",
                    "current_residence_error",
                    "country_residence_status_label",
                    "country_residence_status_placeholder",
                    "country_residence_status_error",
                    "mailing_address_label",
                    "mailing_address_placeholder",
                    "mailing_address_error",
                    "high_school_name_label",
                    "high_school_name_placeholder",
                    "high_school_name_error",
                    "letter_of_intent_label",
                        "letter_of_intent_placeholder",
                        "letter_of_intent_error",
                        "statement_of_purpose_label",
                        "statement_of_purpose_placeholder",
                        "statement_of_purpose_error",
                    "when_plan_to_start_label",
                    "when_plan_to_start_placeholder",
                    "when_plan_to_start_error",
                    "intrested_in_label",
                    "intrested_in_placeholder",
                    "intrested_in_error",
                    "would_like_to_study_label",
                    "would_like_to_study_placeholder",
                    "would_like_to_study_error",
                    "tuition_funding_source_label",
                    "tuition_funding_source_placeholder",
                    "tuition_funding_source_error",
                    "test_taken_label",
                    "test_taken_placeholder",
                    "test_taken_error",
                    "additional_label",
                    "additional_placeholder",
                    "additional_error",
                    "add_something_lable",
                    "add_something_placeholder",
                    "add_something_error",
                    "currently_live_in_lable",
                    "currently_live_in_placeholder",
                    "currently_live_in_error",
                    "study_permet_lable",
                    "study_permet_placeholder",
                    "study_permet_error",
                    "send_copy_lable",
                    "send_copy_placeholder",
                    "send_copy_error",
                    "button_text",
                    "where_want_to_study_lable",
                    "where_want_to_study_placeholder",
                    "where_want_to_study_error",
                    "high_school_city_lable",
                    "high_school_city_placeholder",
                    "high_school_city_error",
                    "high_school_country_lable",
                    "high_school_country_placeholder",
                    "high_school_country_error",
                    "student_type_lable",
                    "student_type_placeholder",
                    "student_type_error",
                    "high_school_cgpa_lable",
                    "high_school_cgpa_placeholder",
                    "high_school_cgpa_error",
                    "school_lable",
                    "school_placeholder",
                    "school_error",
                ];

                keys.map((key) => {
                    var obj = {};
                    data.map((res) => {
                        obj[key + "_" + res.id] = "";
                    });
                    this.$store.commit(
                        "master_application_setting/setPageSetting",
                        {
                            key,
                            value: obj,
                        }
                    );
                });

                let obj = {};
                data.map((res) => {
                    obj["privacy_policy_" + res.id] = "";
                });
                if(this.$route.params.id){
                    this.fetchMasterApplicationSetting();
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
