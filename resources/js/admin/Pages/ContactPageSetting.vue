<template>
    <header class="mb-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">
                    Contact page setting
                </h1>
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
                        :for="`page_title_1_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Page title 1</label
                    >
                    <input
                        type="text"
                        :name="`page_title_1_${selectedLanguage}`"
                        :id="`page_title_1_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'page_title_1',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['page_title_1'] &&
                            form['page_title_1'][
                                `page_title_1_${selectedLanguage}`
                            ]
                                ? form['page_title_1'][
                                      `page_title_1_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `page_title_1.page_title_1_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `page_title_1.page_title_1_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- first name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`page_title_2_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Page title 2</label
                    >
                    <input
                        type="text"
                        :name="`page_title_2_${selectedLanguage}`"
                        :id="`page_title_2_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'page_title_2',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['page_title_2'] &&
                            form['page_title_2'][
                                `page_title_2_${selectedLanguage}`
                            ]
                                ? form['page_title_2'][
                                      `page_title_2_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `page_title_2.page_title_2_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `page_title_2.page_title_2_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`description_${language.id}`"
                    ></div> -->
                    <label
                        :for="`description_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Description</label
                    >
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'description'
                                )
                            "
                            :ref="`description1_${language.id}`"
                            :id="`description1_${language.id}`"
                            :initial-value="form[`description`][`description_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
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
                <div class="relative z-0 w-full group">
                    <label
                        :for="`mainling_address_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Mainling Address Lable</label
                    >
                    <input
                        type="text"
                        :name="`mainling_address_lable_${selectedLanguage}`"
                        :id="`mainling_address_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'mainling_address_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['mainling_address_lable'] &&
                            form['mainling_address_lable'][`mainling_address_lable_${selectedLanguage}`]
                                ? form['mainling_address_lable'][
                                      `mainling_address_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `mainling_address_lable.mainling_address_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `mainling_address_lable.mainling_address_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`mainling_address_${language.id}`"
                    ></div> -->
                    <label
                        :for="`mainling_address_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Mailing Address</label
                    >
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'mainling_address'
                                )
                            "
                            :ref="`mainling_address_${language.id}`"
                            :id="`mainling_address_${language.id}`"
                            :initial-value="form[`mainling_address`][`mainling_address_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `mainling_address.mainling_address_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `mainling_address.mainling_address_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`toll_free_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Toll Free Lable</label
                    >
                    <input
                        type="text"
                        :name="`toll_free_lable_${selectedLanguage}`"
                        :id="`toll_free_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'toll_free_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['toll_free_lable'] &&
                            form['toll_free_lable'][`toll_free_lable_${selectedLanguage}`]
                                ? form['toll_free_lable'][
                                      `toll_free_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `toll_free_lable.toll_free_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `toll_free_lable.toll_free_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`toll_free_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Toll Free</label
                    >
                    <input
                        type="text"
                        :name="`toll_free_${selectedLanguage}`"
                        :id="`toll_free_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'toll_free',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['toll_free'] &&
                            form['toll_free'][`toll_free_${selectedLanguage}`]
                                ? form['toll_free'][
                                      `toll_free_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `toll_free.toll_free_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `toll_free.toll_free_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`phone_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone Lable</label
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
                            form['phone_lable'][`phone_lable_${selectedLanguage}`]
                                ? form['phone_lable'][`phone_lable_${selectedLanguage}`]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `phone.phone_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `phone.phone_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`phone_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone</label
                    >
                    <input
                        type="text"
                        :name="`phone_${selectedLanguage}`"
                        :id="`phone_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'phone',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['phone'] &&
                            form['phone'][`phone_${selectedLanguage}`]
                                ? form['phone'][`phone_${selectedLanguage}`]
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
                        :for="`email_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email Lable</label
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
                            form['email_lable'][`email_lable_${selectedLanguage}`]
                                ? form['email_lable'][`email_lable_${selectedLanguage}`]
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
                        :for="`email_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email</label
                    >
                    <input
                        type="text"
                        :name="`email_${selectedLanguage}`"
                        :id="`email_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email'] &&
                            form['email'][`email_${selectedLanguage}`]
                                ? form['email'][`email_${selectedLanguage}`]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email.email_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email.email_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`website_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Website Lable</label
                    >
                    <input
                        type="text"
                        :name="`website_lable_${selectedLanguage}`"
                        :id="`website_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'website_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['website_lable'] &&
                            form['website_lable'][`website_lable_${selectedLanguage}`]
                                ? form['website_lable'][`website_lable_${selectedLanguage}`]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `website_lable.website_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `website_lable.website_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`website_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Website</label
                    >
                    <input
                        type="text"
                        :name="`website_${selectedLanguage}`"
                        :id="`website_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'website',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['website'] &&
                            form['website'][`website_${selectedLanguage}`]
                                ? form['website'][`website_${selectedLanguage}`]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `website.website_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `website.website_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_input_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Name Lable</label
                    >
                    <input
                        type="text"
                        :name="`name_input_lable_${selectedLanguage}`"
                        :id="`name_input_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_input_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['name_input_lable'] &&
                            form['name_input_lable'][
                                `name_input_lable_${selectedLanguage}`
                            ]
                                ? form['name_input_lable'][
                                      `name_input_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `name_input_lable.name_input_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `name_input_lable.name_input_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_input_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Name placeholder</label
                    >
                    <input
                        type="text"
                        :name="`name_input_placeholder_${selectedLanguage}`"
                        :id="`name_input_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_input_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['name_input_placeholder'] &&
                            form['name_input_placeholder'][
                                `name_input_placeholder_${selectedLanguage}`
                            ]
                                ? form['name_input_placeholder'][
                                      `name_input_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `name_input_placeholder.name_input_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `name_input_placeholder.name_input_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_input_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Name Error</label
                    >
                    <input
                        type="text"
                        :name="`name_input_error_${selectedLanguage}`"
                        :id="`name_input_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_input_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['name_input_error'] &&
                            form['name_input_error'][
                                `name_input_error_${selectedLanguage}`
                            ]
                                ? form['name_input_error'][
                                      `name_input_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `name_input_error.name_input_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `name_input_error.name_input_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_input_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email Lable</label
                    >
                    <input
                        type="text"
                        :name="`email_input_lable_${selectedLanguage}`"
                        :id="`email_input_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_input_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_input_lable'] &&
                            form['email_input_lable'][
                                `email_input_label_${selectedLanguage}`
                            ]
                                ? form['email_input_lable'][
                                      `email_input_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_input_lable.email_input_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_input_lable.email_input_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_input_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email placeholder</label
                    >
                    <input
                        type="text"
                        :name="`email_input_placeholder_${selectedLanguage}`"
                        :id="`email_input_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_input_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_input_placeholder'] &&
                            form['email_input_placeholder'][
                                `email_input_placeholder_${selectedLanguage}`
                            ]
                                ? form['email_input_placeholder'][
                                      `email_input_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_input_placeholder.email_input_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_input_placeholder.email_input_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_input_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email Error</label
                    >
                    <input
                        type="text"
                        :name="`email_input_error_${selectedLanguage}`"
                        :id="`email_input_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_input_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_input_error'] &&
                            form['email_input_error'][
                                `email_input_error_${selectedLanguage}`
                            ]
                                ? form['email_input_error'][
                                      `email_input_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_input_error.email_input_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_input_error.email_input_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`message_input_lable_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Message Lable</label
                    >
                    <input
                        type="text"
                        :name="`message_input_lable_${selectedLanguage}`"
                        :id="`message_input_lable_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_input_lable',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['message_input_lable'] &&
                            form['message_input_lable'][
                                `message_input_lable_${selectedLanguage}`
                            ]
                                ? form['message_input_lable'][
                                      `message_input_lable_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `message_input_lable.message_input_lable_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `message_input_lable.message_input_lable_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`message_input_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Message placeholder</label
                    >
                    <input
                        type="text"
                        :name="`message_input_placeholder_${selectedLanguage}`"
                        :id="`message_input_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_input_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['message_input_placeholder'] &&
                            form['message_input_placeholder'][
                                `message_input_placeholder_${selectedLanguage}`
                            ]
                                ? form['message_input_placeholder'][
                                      `message_input_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `message_input_placeholder.message_input_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `message_input_placeholder.message_input_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label
                        :for="`message_input_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Message Error</label
                    >
                    <input
                        type="text"
                        :name="`message_input_error_${selectedLanguage}`"
                        :id="`message_input_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'message_input_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['message_input_error'] &&
                            form['message_input_error'][
                                `message_input_error_${selectedLanguage}`
                            ]
                                ? form['message_input_error'][
                                      `message_input_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `message_input_error.message_input_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `message_input_error.message_input_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`button_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Contactation button text</label
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
            form: (state) => state.contact_page_setting.form,
            validationErros: (state) =>
                state.contact_page_setting.validationErros,
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
            this.$store.commit(`contact_page_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        handleSelectionChange(language, key) {
            let value = null;
            if(key == 'description'){
                value = tinymce.get(`${key}1_${language.id}`).getContent();
            }
            else{
                value = tinymce.get(`${key}_${language.id}`).getContent();
            }
            this.$store.commit(`contact_page_setting/updatePageSetting`, {
                value: value,
                id: language.id,
                key:key,
            });
            if (value.trim() !== '') {
        this.validationErros.clear(`${key}.${key}_${language.id}`);
        this.validationErros.clear(`${key}.${key}_${this.selectedLanguage}`);
    }
        },
        addUpdateForm() {
            this.$store
                .dispatch("contact_page_setting/addUpdateForm")
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

        checkValidationError(validationErros, language) {
            return (
                validationErros.has(
                    `page_title_1.page_title_1_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `page_title_1.page_title_1_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `description.description_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `mainling_address.mainling_address_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `toll_free.toll_free_${this.selectedLanguage}`
                ) ||
                validationErros.has(`phone.phone_${this.selectedLanguage}`) ||
                validationErros.has(`email.email_${this.selectedLanguage}`) ||
                validationErros.has(
                    `website.website_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `name_input_lable.name_input_lable_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `name_input_placeholder.name_input_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `name_input_error.name_input_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `email_input_lable.email_input_lable_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `email_input_placeholder.email_input_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `email_input_error.email_input_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `button_text.button_text_${this.selectedLanguage}`
                )
            );
        },
        fetchContactPageSetting() {
            this.$store
                .dispatch("contact_page_setting/fetchContactPageSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}contact-page-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data &&
                        res.data.data.contact_page_setting_detail
                            ? res.data.data.contact_page_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["page_title_1_" + res.language_id] = res?.page_title_1;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "page_title_1",
                        value: obj,
                    });

                    //first name
                    obj = {};
                    data.map((res) => {
                        obj["page_title_2_" + res.language_id] = res?.page_title_2;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "page_title_2",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["toll_free_" + res.language_id] = res?.toll_free;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "toll_free",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["toll_free_lable_" + res.language_id] = res?.toll_free_lable;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "toll_free_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["phone_" + res.language_id] = res?.phone;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "phone",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["phone_lable_" + res.language_id] = res?.phone_lable;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "phone_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["email_lable_" + res.language_id] = res?.email_lable;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "email_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["email_" + res.language_id] = res?.email;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "email",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["website_lable_" + res.language_id] = res?.website_lable;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "website_lable",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["website_" + res.language_id] = res?.website;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "website",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["mainling_address_lable_" + res.language_id] = res?.mainling_address_lable;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "mainling_address_lable",
                        value: obj,
                    });

                    

                    obj = {};
                    data.map((res) => {
                        obj["name_input_lable_" + res.language_id] =
                            res?.name_input_lable;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "name_input_lable",
                        value: obj,
                    });
                    
                    //email
                    obj = {};
                    data.map((res) => {
                        obj["name_input_placeholder_" + res.language_id] =
                            res?.name_input_placeholder;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "name_input_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["name_input_error_" + res.language_id] =
                            res?.name_input_error;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "name_input_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["email_input_lable_" + res.language_id] =
                            res?.email_input_lable;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "email_input_lable",
                        value: obj,
                    });
                    //passowrd
                    obj = {};
                    data.map((res) => {
                        obj["email_input_placeholder_" + res.language_id] =
                            res?.email_input_placeholder;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "email_input_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["email_input_error_" + res.language_id] =
                            res?.email_input_error;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "email_input_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["message_input_lable_" + res.language_id] =
                            res?.message_input_lable;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "message_input_lable",
                        value: obj,
                    });

                    //confirm passowrd
                    obj = {};
                    data.map((res) => {
                        obj["message_input_placeholder_" + res.language_id] =
                            res?.message_input_placeholder;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "message_input_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["message_input_error_" + res.language_id] =
                            res?.message_input_error;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "message_input_error",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["button_text_" + res.language_id] = res?.button_text;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "button_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["description_" + res.language_id] = res?.description;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "description",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["mainling_address_" + res.language_id] =
                            res?.mainling_address;
                    });
                    this.$store.commit("contact_page_setting/setPageSetting", {
                        key: "mainling_address",
                        value: obj,
                    });
                    this.isDataLoaded = 1;
                });
        },
    },
    created() {
        this.$store.commit("contact_page_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["page_title_1_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "page_title_1",
                    value: obj,
                });

                //first name
                obj = {};
                data.map((res) => {
                    obj["page_title_2_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "page_title_2",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["toll_free_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "toll_free",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["phone_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "phone",
                    value: obj,
                });

                //last name
                obj = {};
                data.map((res) => {
                    obj["email_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "email",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["website_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "website",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["name_input_lable_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "name_input_lable",
                    value: obj,
                });
                //email
                obj = {};
                data.map((res) => {
                    obj["name_input_placeholder_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "name_input_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["name_input_error_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "name_input_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["email_input_lable_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "email_input_lable",
                    value: obj,
                });
                //passowrd
                obj = {};
                data.map((res) => {
                    obj["email_input_placeholder_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "email_input_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["email_input_error_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "email_input_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["message_input_lable_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "message_input_lable",
                    value: obj,
                });

                //confirm passowrd
                obj = {};
                data.map((res) => {
                    obj["message_input_placeholder_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "message_input_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["message_input_error_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "message_input_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["button_text_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "button_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["description_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "description",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["mainling_address_lable_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "mainling_address_lable",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["mainling_address_" + res.id] = "";
                });
                this.$store.commit("contact_page_setting/setPageSetting", {
                    key: "mainling_address",
                    value: obj,
                });

                if(this.$route.params.id){
                    this.fetchContactPageSetting();
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
