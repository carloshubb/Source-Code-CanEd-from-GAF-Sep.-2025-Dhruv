<template>
    <header class="my-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">Login page setting</h1>
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

        <div class="my-5" v-for="language in languages" :key="language.id" :class="(selectedLanguage == null && language.is_default) ||
                language.id == selectedLanguage
                ? 'block'
                : 'hidden'
            ">
            <div class="grid my-5 md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full group">
                    <label :for="`page_title_${selectedLanguage}`" class="block text-base lg:text-lg">Page title<span class="text-primary">*</span></label>
                    <input type="text" :name="`page_title_${selectedLanguage}`" :id="`page_title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'page_title',
                                'updatePageSetting'
                            )
                            " :value="form['page_title'] &&
                                form['page_title'][`page_title_${selectedLanguage}`]
                                ? form['page_title'][
                                `page_title_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `page_title.page_title_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `page_title.page_title_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`login_email_label_${selectedLanguage}`" class="block text-base lg:text-lg">Login email
                        label<span class="text-primary">*</span></label>
                    <input type="text" :name="`login_email_label_${selectedLanguage}`"
                        :id="`login_email_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'login_email_label',
                                'updatePageSetting'
                            )
                            " :value="form['login_email_label'] &&
                                form['login_email_label'][
                                `login_email_label_${selectedLanguage}`
                                ]
                                ? form['login_email_label'][
                                `login_email_label_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `login_email_label.login_email_label_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `login_email_label.login_email_label_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`login_email_placeholder_${selectedLanguage}`" class="block text-base lg:text-lg">Login
                        email placeholder<span class="text-primary">*</span></label>
                    <input type="text" :name="`login_email_placeholder_${selectedLanguage}`"
                        :id="`login_email_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'login_email_placeholder',
                                'updatePageSetting'
                            )
                            " :value="form['login_email_placeholder'] &&
                                form['login_email_placeholder'][
                                `login_email_placeholder_${selectedLanguage}`
                                ]
                                ? form['login_email_placeholder'][
                                `login_email_placeholder_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `login_email_placeholder.login_email_placeholder_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `login_email_placeholder.login_email_placeholder_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`login_email_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Login email error</label
                    >
                    <input
                        type="text"
                        :name="`login_email_error_${selectedLanguage}`"
                        :id="`login_email_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'login_email_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['login_email_error'] &&
                            form['login_email_error'][
                                `login_email_error_${selectedLanguage}`
                            ]
                                ? form['login_email_error'][
                                      `login_email_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `login_email_error.login_email_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `login_email_error.login_email_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <div class="relative z-0 w-full group">
                    <label :for="`login_passowrd_label_${selectedLanguage}`" class="block text-base lg:text-lg">Login
                        password label<span class="text-primary">*</span></label>
                    <input type="text" :name="`login_passowrd_label_${selectedLanguage}`"
                        :id="`login_passowrd_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'login_passowrd_label',
                                'updatePageSetting'
                            )
                            " :value="form['login_passowrd_label'] &&
                                form['login_passowrd_label'][
                                `login_passowrd_label_${selectedLanguage}`
                                ]
                                ? form['login_passowrd_label'][
                                `login_passowrd_label_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `login_passowrd_label.login_passowrd_label_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `login_passowrd_label.login_passowrd_label_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`login_passowrd_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg">Login password placeholder<span class="text-primary">*</span></label>
                    <input type="text" :name="`login_passowrd_placeholder_${selectedLanguage}`"
                        :id="`login_passowrd_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'login_passowrd_placeholder',
                                'updatePageSetting'
                            )
                            " :value="form['login_passowrd_placeholder'] &&
                                form['login_passowrd_placeholder'][
                                `login_passowrd_placeholder_${selectedLanguage}`
                                ]
                                ? form['login_passowrd_placeholder'][
                                `login_passowrd_placeholder_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `login_passowrd_placeholder.login_passowrd_placeholder_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `login_passowrd_placeholder.login_passowrd_placeholder_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`login_passowrd_error_${selectedLanguage}`" class="block text-base lg:text-lg">Login
                        password error<span class="text-primary">*</span></label>
                    <input type="text" :name="`login_passowrd_error_${selectedLanguage}`"
                        :id="`login_passowrd_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'login_passowrd_error',
                                'updatePageSetting'
                            )
                            " :value="form['login_passowrd_error'] &&
                                form['login_passowrd_error'][
                                `login_passowrd_error_${selectedLanguage}`
                                ]
                                ? form['login_passowrd_error'][
                                `login_passowrd_error_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `login_passowrd_error.login_passowrd_error_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `login_passowrd_error.login_passowrd_error_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`keep_me_logged_in_text_${selectedLanguage}`" class="block text-base lg:text-lg">Keep
                        me logged in text<span class="text-primary">*</span></label>
                    <input type="text" :name="`keep_me_logged_in_text_${selectedLanguage}`"
                        :id="`keep_me_logged_in_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'keep_me_logged_in_text',
                                'updatePageSetting'
                            )
                            " :value="form['keep_me_logged_in_text'] &&
                                form['keep_me_logged_in_text'][
                                `keep_me_logged_in_text_${selectedLanguage}`
                                ]
                                ? form['keep_me_logged_in_text'][
                                `keep_me_logged_in_text_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `keep_me_logged_in_text.keep_me_logged_in_text_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `keep_me_logged_in_text.keep_me_logged_in_text_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`forget_password_text_${selectedLanguage}`" class="block text-base lg:text-lg">Forget
                        password text<span class="text-primary">*</span></label>
                    <input type="text" :name="`forget_password_text_${selectedLanguage}`"
                        :id="`forget_password_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'forget_password_text',
                                'updatePageSetting'
                            )
                            " :value="form['forget_password_text'] &&
                                form['forget_password_text'][
                                `forget_password_text_${selectedLanguage}`
                                ]
                                ? form['forget_password_text'][
                                `forget_password_text_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `forget_password_text.forget_password_text_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `forget_password_text.forget_password_text_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`not_register_yet_text_${selectedLanguage}`" class="block text-base lg:text-lg">Not
                        register yet text<span class="text-primary">*</span></label>
                    <input type="text" :name="`not_register_yet_text_${selectedLanguage}`"
                        :id="`not_register_yet_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'not_register_yet_text',
                                'updatePageSetting'
                            )
                            " :value="form['not_register_yet_text'] &&
                                form['not_register_yet_text'][
                                `not_register_yet_text_${selectedLanguage}`
                                ]
                                ? form['not_register_yet_text'][
                                `not_register_yet_text_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `not_register_yet_text.not_register_yet_text_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `not_register_yet_text.not_register_yet_text_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`create_account_button_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg">Create account button text<span class="text-primary">*</span></label>
                    <input type="text" :name="`create_account_button_text_${selectedLanguage}`"
                        :id="`create_account_button_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'create_account_button_text',
                                'updatePageSetting'
                            )
                            " :value="form['create_account_button_text'] &&
                                form['create_account_button_text'][
                                `create_account_button_text_${selectedLanguage}`
                                ]
                                ? form['create_account_button_text'][
                                `create_account_button_text_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `create_account_button_text.create_account_button_text_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `create_account_button_text.create_account_button_text_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`protect_your_account_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg">Protect your account text<span class="text-primary">*</span></label>
                    <input type="text" :name="`protect_your_account_text_${selectedLanguage}`"
                        :id="`protect_your_account_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'protect_your_account_text',
                                'updatePageSetting'
                            )
                            " :value="form['protect_your_account_text'] &&
                                form['protect_your_account_text'][
                                `protect_your_account_text_${selectedLanguage}`
                                ]
                                ? form['protect_your_account_text'][
                                `protect_your_account_text_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `protect_your_account_text.protect_your_account_text_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `protect_your_account_text.protect_your_account_text_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group md:col-span-2" v-if="isDataLoaded">
                    <!-- <input
                        type="text"
                        :name="`protect_your_account_description_${selectedLanguage}`"
                        :id="`protect_your_account_description_${selectedLanguage}`"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'protect_your_account_description',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['protect_your_account_description'] &&
                            form['protect_your_account_description'][
                                `protect_your_account_description_${selectedLanguage}`
                            ]
                                ? form['protect_your_account_description'][
                                      `protect_your_account_description_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    /> -->

                    <label :for="`protect_your_account_description_${selectedLanguage}`"
                        class="block text-base lg:text-lg">Protect your account description<span class="text-primary">*</span></label>
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`protect_your_account_description_${language.id}`"
                    ></div> -->
                    <editor @selectionChange="
                        handleSelectionChange(
                            language,
                            'protect_your_account_description'
                        )
                        " :ref="`protect_your_account_description_${language.id}`"
                        :id="`protect_your_account_description_${language.id}`" :initial-value="form[`protect_your_account_description`][`protect_your_account_description_${language?.id}`]
                            " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `protect_your_account_description.protect_your_account_description_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `protect_your_account_description.protect_your_account_description_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`facebook_login_text_${selectedLanguage}`" class="block text-base lg:text-lg">Facebook
                        Login Button Text<span class="text-primary">*</span></label>
                    <input type="text" :name="`facebook_login_text_${selectedLanguage}`"
                        :id="`facebook_login_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'facebook_login_text',
                                'updatePageSetting'
                            )
                            " :value="form['facebook_login_text'] &&
                                form['facebook_login_text'][
                                `facebook_login_text_${selectedLanguage}`
                                ]
                                ? form['facebook_login_text'][
                                `facebook_login_text_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `facebook_login_text.facebook_login_text_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `facebook_login_text.facebook_login_text_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`google_login_text_${selectedLanguage}`" class="block text-base lg:text-lg">Google
                        Login button text<span class="text-primary">*</span></label>
                    <input type="text" :name="`google_login_text_${selectedLanguage}`"
                        :id="`google_login_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'google_login_text',
                                'updatePageSetting'
                            )
                            " :value="form['google_login_text'] &&
                                form['google_login_text'][
                                `google_login_text_${selectedLanguage}`
                                ]
                                ? form['google_login_text'][
                                `google_login_text_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `google_login_text.google_login_text_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `google_login_text.google_login_text_${selectedLanguage}`
                        )
                            "></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label :for="`linkedin_login_text_${selectedLanguage}`" class="block text-base lg:text-lg">Linkedin
                        Login button text<span class="text-primary">*</span></label>
                    <input type="text" :name="`linkedin_login_text_${selectedLanguage}`"
                        :id="`linkedin_login_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'linkedin_login_text',
                                'updatePageSetting'
                            )
                            " :value="form['linkedin_login_text'] &&
                                form['linkedin_login_text'][
                                `linkedin_login_text_${selectedLanguage}`
                                ]
                                ? form['linkedin_login_text'][
                                `linkedin_login_text_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `linkedin_login_text.linkedin_login_text_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `linkedin_login_text.linkedin_login_text_${selectedLanguage}`
                        )
                            "></p>
                </div>
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`email_format_error_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email Format Validation Error Text</label
                    >
                    <input
                        type="text"
                        :name="`email_format_error_text_${selectedLanguage}`"
                        :id="`email_format_error_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_format_error_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_format_error_text'] &&
                            form['email_format_error_text'][
                                `email_format_error_text_${selectedLanguage}`
                            ]
                                ? form['email_format_error_text'][
                                      `email_format_error_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_format_error_text.email_format_error_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_format_error_text.email_format_error_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->
                <div class="relative z-0 w-full group">
                    <label :for="`credentails_match_error_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg">Credentials Match Validation Error Text<span class="text-primary">*</span></label>
                    <input type="text" :name="`credentails_match_error_text_${selectedLanguage}`"
                        :id="`credentails_match_error_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'credentails_match_error_text',
                                'updatePageSetting'
                            )
                            " :value="form['credentails_match_error_text'] &&
                                form['credentails_match_error_text'][
                                `credentails_match_error_text_${selectedLanguage}`
                                ]
                                ? form['credentails_match_error_text'][
                                `credentails_match_error_text_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `credentails_match_error_text.credentails_match_error_text_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `credentails_match_error_text.credentails_match_error_text_${selectedLanguage}`
                        )
                            "></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label :for="`login_button_text_${selectedLanguage}`" class="block text-base lg:text-lg">Login
                        button text<span class="text-primary">*</span></label>
                    <input type="text" :name="`login_button_text_${selectedLanguage}`"
                        :id="`login_button_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" " @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'login_button_text',
                                'updatePageSetting'
                            )
                            " :value="form['login_button_text'] &&
                                form['login_button_text'][
                                `login_button_text_${selectedLanguage}`
                                ]
                                ? form['login_button_text'][
                                `login_button_text_${selectedLanguage}`
                                ]
                                : ''
                            " />
                    <p class="mt-2 text-base text-primary" v-if="
                        validationErros.has(
                            `login_button_text.login_button_text_${selectedLanguage}`
                        )
                    " v-text="validationErros.get(
                            `login_button_text.login_button_text_${selectedLanguage}`
                        )
                            "></p>
                </div>
            </div>
        </div>
        <ListErrors :validationErrors="validationErros" />
        <button type="submit" class="can-edu-btn-fill">
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
            form: (state) => state.login_page_setting.form,
            validationErros: (state) =>
                state.login_page_setting.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    components: {
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
            this.$store.commit(`login_page_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`login_page_setting/updatePageSetting`, {
                value: content,
                id: language.id,
                key: key,
            });
            if (content.trim()) {
                this.validationErros.clear(`${key}.${key}_${language.id}`);
            }
        },
        addUpdateForm() {
            this.$store
                .dispatch("login_page_setting/addUpdateForm")
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
        fetchLoginPageSetting() {
            this.$store
                .dispatch("login_page_setting/fetchLoginPageSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}login-page-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data && res.data.data.login_page_setting_detail
                            ? res.data.data.login_page_setting_detail
                            : [];

                    var obj = {};
                    data.map((res) => {
                        obj["page_title_" + res.language_id] = res.page_title;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "page_title",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["login_email_label_" + res.language_id] =
                            res.login_email_label;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "login_email_label",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["login_email_placeholder_" + res.language_id] =
                            res.login_email_placeholder;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "login_email_placeholder",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["login_email_error_" + res.language_id] =
                            res.login_email_error;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "login_email_error",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["login_passowrd_label_" + res.language_id] =
                            res.login_passowrd_label;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "login_passowrd_label",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["login_passowrd_placeholder_" + res.language_id] =
                            res.login_passowrd_placeholder;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "login_passowrd_placeholder",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["login_passowrd_error_" + res.language_id] =
                            res.login_passowrd_error;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "login_passowrd_error",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["keep_me_logged_in_text_" + res.language_id] =
                            res.keep_me_logged_in_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "keep_me_logged_in_text",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["forget_password_text_" + res.language_id] =
                            res.forget_password_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "forget_password_text",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["login_button_text_" + res.language_id] =
                            res.login_button_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "login_button_text",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["not_register_yet_text_" + res.language_id] =
                            res.not_register_yet_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "not_register_yet_text",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["create_account_button_text_" + res.language_id] =
                            res.create_account_button_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "create_account_button_text",
                        value: obj,
                    });

                    var obj = {};
                    data.map((res) => {
                        obj["protect_your_account_text_" + res.language_id] =
                            res.protect_your_account_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "protect_your_account_text",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {

                        this.$store.commit(
                            "login_page_setting/updatePageSetting",
                            {
                                key: "protect_your_account_description",
                                id: res.language_id,
                                value: res.protect_your_account_description,
                            }
                        );
                    });


                    obj = {};
                    data.map((res) => {
                        obj["email_format_error_text_" + res.language_id] =
                            res.email_format_error_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "email_format_error_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["credentails_match_error_text_" + res.language_id] =
                            res.credentails_match_error_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "credentails_match_error_text",
                        value: obj,
                    });


                    obj = {};
                    data.map((res) => {
                        obj["facebook_login_text_" + res.language_id] =
                            res.facebook_login_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "facebook_login_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["google_login_text_" + res.language_id] =
                            res.google_login_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "google_login_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["linkedin_login_text_" + res.language_id] =
                            res.linkedin_login_text;
                    });
                    this.$store.commit("login_page_setting/setPageSetting", {
                        key: "linkedin_login_text",
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
                    `login_email_label.login_email_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `login_email_placeholder.login_email_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `login_email_error.login_email_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `login_passowrd_label.login_passowrd_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `login_passowrd_placeholder.login_passowrd_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `login_passowrd_error.login_passowrd_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `keep_me_logged_in_text.keep_me_logged_in_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `forget_password_text.forget_password_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `login_button_text.login_button_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `not_register_yet_text.not_register_yet_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `create_account_button_text.create_account_button_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `protect_your_account_text.protect_your_account_text_${selectedLanguage}`
                ) ||
                validationErros.has(
                    `protect_your_account_description.protect_your_account_description_${selectedLanguage}`
                )
            );
        },
    },
    created() {
        this.$store.commit("login_page_setting/resetForm");
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
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "page_title",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["login_email_label_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "login_email_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["login_email_placeholder_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "login_email_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["login_email_error_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "login_email_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["login_passowrd_label_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "login_passowrd_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["login_passowrd_placeholder_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "login_passowrd_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["login_passowrd_error_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "login_passowrd_error",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["keep_me_logged_in_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "keep_me_logged_in_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["forget_password_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "forget_password_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["login_button_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "login_button_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["not_register_yet_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "not_register_yet_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["create_account_button_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "create_account_button_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["protect_your_account_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "protect_your_account_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["protect_your_account_description_" + res.id] = "";
                });

                obj = {};
                data.map((res) => {
                    obj["facebook_login_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "facebook_login_text",
                    value: obj,
                });


                obj = {};
                data.map((res) => {
                    obj["google_login_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "google_login_text",
                    value: obj,
                });



                obj = {};
                data.map((res) => {
                    obj["linkedin_login_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "linkedin_login_text",
                    value: obj,
                });


                obj = {};
                data.map((res) => {
                    obj["email_format_error_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "email_format_error_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["credentails_match_error_text_" + res.id] = "";
                });
                this.$store.commit("login_page_setting/setPageSetting", {
                    key: "credentails_match_error_text",
                    value: obj,
                });
                if (this.$route.params.id) {
                    this.fetchLoginPageSetting();
                }
                else {
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
