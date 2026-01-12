<template>
    <header class="mb-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">Demetra page setting</h1>
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
                <!-- Min GPA -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`min_cgpa_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >GPA label</label
                    >
                    <input
                        type="text"
                        :name="`min_cgpa_label_${selectedLanguage}`"
                        :id="`min_cgpa_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'min_cgpa_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['min_cgpa_label'] &&
                            form['min_cgpa_label'][
                                `min_cgpa_label_${selectedLanguage}`
                            ]
                                ? form['min_cgpa_label'][
                                      `min_cgpa_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `min_cgpa_label.min_cgpa_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `min_cgpa_label.min_cgpa_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`min_cgpa_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >GPA placeholder</label
                    >
                    <input
                        type="text"
                        :name="`min_cgpa_placeholder_${selectedLanguage}`"
                        :id="`min_cgpa_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'min_cgpa_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['min_cgpa_placeholder'] &&
                            form['min_cgpa_placeholder'][
                                `min_cgpa_placeholder_${selectedLanguage}`
                            ]
                                ? form['min_cgpa_placeholder'][
                                      `min_cgpa_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `min_cgpa_placeholder.min_cgpa_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `min_cgpa_placeholder.min_cgpa_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`min_cgpa_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >GPA error</label
                    >
                    <input
                        type="text"
                        :name="`min_cgpa_error_${selectedLanguage}`"
                        :id="`min_cgpa_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'min_cgpa_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['min_cgpa_error'] &&
                            form['min_cgpa_error'][
                                `min_cgpa_error_${selectedLanguage}`
                            ]
                                ? form['min_cgpa_error'][
                                      `min_cgpa_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `min_cgpa_error.min_cgpa_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `min_cgpa_error.min_cgpa_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                
                <!-- password -->
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`max_cgpa_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Max Cgpa label</label
                    >
                    <input
                        type="text"
                        :name="`max_cgpa_label_${selectedLanguage}`"
                        :id="`max_cgpa_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'max_cgpa_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['max_cgpa_label'] &&
                            form['max_cgpa_label'][
                                `max_cgpa_label_${selectedLanguage}`
                            ]
                                ? form['max_cgpa_label'][
                                      `max_cgpa_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `max_cgpa_label.max_cgpa_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `max_cgpa_label.max_cgpa_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`max_cgpa_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Max Cgpa placeholder</label
                    >
                    <input
                        type="text"
                        :name="`max_cgpa_placeholder_${selectedLanguage}`"
                        :id="`max_cgpa_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'max_cgpa_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['max_cgpa_placeholder'] &&
                            form['max_cgpa_placeholder'][
                                `max_cgpa_placeholder_${selectedLanguage}`
                            ]
                                ? form['max_cgpa_placeholder'][
                                      `max_cgpa_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `max_cgpa_placeholder.max_cgpa_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `max_cgpa_placeholder.max_cgpa_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`max_cgpa_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Max Cgpa error</label
                    >
                    <input
                        type="text"
                        :name="`max_cgpa_error_${selectedLanguage}`"
                        :id="`max_cgpa_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'max_cgpa_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['max_cgpa_error'] &&
                            form['max_cgpa_error'][
                                `max_cgpa_error_${selectedLanguage}`
                            ]
                                ? form['max_cgpa_error'][
                                      `max_cgpa_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `max_cgpa_error.max_cgpa_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `max_cgpa_error.max_cgpa_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->
                <!-- sport -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_sport_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra sport label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_sport_label_${selectedLanguage}`"
                        :id="`demetra_sport_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_sport_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_sport_label'] &&
                            form['demetra_sport_label'][
                                `demetra_sport_label_${selectedLanguage}`
                            ]
                                ? form['demetra_sport_label'][
                                      `demetra_sport_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_sport_label.demetra_sport_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_sport_label.demetra_sport_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_sport_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra sport placeholder</label
                    >
                    <input
                        type="text"
                        :name="`demetra_sport_placeholder_${selectedLanguage}`"
                        :id="`demetra_sport_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_sport_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_sport_placeholder'] &&
                            form['demetra_sport_placeholder'][
                                `demetra_sport_placeholder_${selectedLanguage}`
                            ]
                                ? form['demetra_sport_placeholder'][
                                      `demetra_sport_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_sport_placeholder.demetra_sport_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_sport_placeholder.demetra_sport_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_sport_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra sport error</label
                    >
                    <input
                        type="text"
                        :name="`demetra_sport_error_${selectedLanguage}`"
                        :id="`demetra_sport_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_sport_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_sport_error'] &&
                            form['demetra_sport_error'][
                                `demetra_sport_error_${selectedLanguage}`
                            ]
                                ? form['demetra_sport_error'][
                                      `demetra_sport_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_sport_error.demetra_sport_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_sport_error.demetra_sport_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- comunity_service -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_comunity_service_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra comunity service label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_comunity_service_label_${selectedLanguage}`"
                        :id="`demetra_comunity_service_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_comunity_service_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_comunity_service_label'] &&
                            form['demetra_comunity_service_label'][
                                `demetra_comunity_service_label_${selectedLanguage}`
                            ]
                                ? form['demetra_comunity_service_label'][
                                      `demetra_comunity_service_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_comunity_service_label.demetra_comunity_service_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_comunity_service_label.demetra_comunity_service_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_comunity_service_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra comunity service placeholder</label
                    >
                    <input
                        type="text"
                        :name="`demetra_comunity_service_placeholder_${selectedLanguage}`"
                        :id="`demetra_comunity_service_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_comunity_service_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_comunity_service_placeholder'] &&
                            form['demetra_comunity_service_placeholder'][
                                `demetra_comunity_service_placeholder_${selectedLanguage}`
                            ]
                                ? form['demetra_comunity_service_placeholder'][
                                      `demetra_comunity_service_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_comunity_service_placeholder.demetra_comunity_service_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_comunity_service_placeholder.demetra_comunity_service_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_comunity_service_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra comunity service error</label
                    >
                    <input
                        type="text"
                        :name="`demetra_comunity_service_error_${selectedLanguage}`"
                        :id="`demetra_comunity_service_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_comunity_service_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_comunity_service_error'] &&
                            form['demetra_comunity_service_error'][
                                `demetra_comunity_service_error_${selectedLanguage}`
                            ]
                                ? form['demetra_comunity_service_error'][
                                      `demetra_comunity_service_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_comunity_service_error.demetra_comunity_service_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_comunity_service_error.demetra_comunity_service_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>


                 <!-- comunity_service -->
                 <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`conditional_acceptance_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Conditional Acceptance label</label
                    >
                    <input
                        type="text"
                        :name="`conditional_acceptance_label_${selectedLanguage}`"
                        :id="`conditional_acceptance_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'conditional_acceptance_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['conditional_acceptance_label'] &&
                            form['conditional_acceptance_label'][
                                `conditional_acceptance_label_${selectedLanguage}`
                            ]
                                ? form['conditional_acceptance_label'][
                                      `conditional_acceptance_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `conditional_acceptance_label.conditional_acceptance_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `conditional_acceptance_label.conditional_acceptance_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`conditional_acceptance_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Conditional Acceptance placeholder</label
                    >
                    <input
                        type="text"
                        :name="`conditional_acceptance_placeholder_${selectedLanguage}`"
                        :id="`conditional_acceptance_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'conditional_acceptance_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['conditional_acceptance_placeholder'] &&
                            form['conditional_acceptance_placeholder'][
                                `conditional_acceptance_placeholder_${selectedLanguage}`
                            ]
                                ? form['conditional_acceptance_placeholder'][
                                      `conditional_acceptance_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `conditional_acceptance_placeholder.conditional_acceptance_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `conditional_acceptance_placeholder.conditional_acceptance_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`conditional_acceptance_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Conditional Acceptance error</label
                    >
                    <input
                        type="text"
                        :name="`conditional_acceptance_error_${selectedLanguage}`"
                        :id="`conditional_acceptance_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'conditional_acceptance_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['conditional_acceptance_error'] &&
                            form['conditional_acceptance_error'][
                                `conditional_acceptance_error_${selectedLanguage}`
                            ]
                                ? form['conditional_acceptance_error'][
                                      `conditional_acceptance_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `conditional_acceptance_error.conditional_acceptance_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `conditional_acceptance_error.conditional_acceptance_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <!-- demetra_button_text -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_button_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Search button text</label
                    >
                    <input
                        type="text"
                        :name="`demetra_button_text_${selectedLanguage}`"
                        :id="`demetra_button_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_button_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_button_text'] &&
                            form['demetra_button_text'][
                                `demetra_button_text_${selectedLanguage}`
                            ]
                                ? form['demetra_button_text'][
                                      `demetra_button_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_button_text.demetra_button_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_button_text.demetra_button_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- curricular -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_curricular_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra curricular label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_curricular_label_${selectedLanguage}`"
                        :id="`demetra_curricular_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_curricular_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_curricular_label'] &&
                            form['demetra_curricular_label'][
                                `demetra_curricular_label_${selectedLanguage}`
                            ]
                                ? form['demetra_curricular_label'][
                                      `demetra_curricular_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_curricular_label.demetra_curricular_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_curricular_label.demetra_curricular_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- demetra_entrepreneurship_label -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_entrepreneurship_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra entrepreneurship label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_entrepreneurship_label_${selectedLanguage}`"
                        :id="`demetra_entrepreneurship_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_entrepreneurship_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_entrepreneurship_label'] &&
                            form['demetra_entrepreneurship_label'][
                                `demetra_entrepreneurship_label_${selectedLanguage}`
                            ]
                                ? form['demetra_entrepreneurship_label'][
                                      `demetra_entrepreneurship_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_entrepreneurship_label.demetra_entrepreneurship_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_entrepreneurship_label.demetra_entrepreneurship_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- demetra_environmental_label -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_environmental_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra environmental label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_environmental_label_${selectedLanguage}`"
                        :id="`demetra_environmental_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_environmental_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_environmental_label'] &&
                            form['demetra_environmental_label'][
                                `demetra_environmental_label_${selectedLanguage}`
                            ]
                                ? form['demetra_environmental_label'][
                                      `demetra_environmental_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_environmental_label.demetra_environmental_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_environmental_label.demetra_environmental_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- demetra_extracurricular_label -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_extracurricular_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra extracurricular label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_extracurricular_label_${selectedLanguage}`"
                        :id="`demetra_extracurricular_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_extracurricular_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_extracurricular_label'] &&
                            form['demetra_extracurricular_label'][
                                `demetra_extracurricular_label_${selectedLanguage}`
                            ]
                                ? form['demetra_extracurricular_label'][
                                      `demetra_extracurricular_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_extracurricular_label.demetra_extracurricular_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_extracurricular_label.demetra_extracurricular_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- demetra_health_wellness_label -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_health_wellness_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra health wellness label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_health_wellness_label_${selectedLanguage}`"
                        :id="`demetra_health_wellness_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_health_wellness_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_health_wellness_label'] &&
                            form['demetra_health_wellness_label'][
                                `demetra_health_wellness_label_${selectedLanguage}`
                            ]
                                ? form['demetra_health_wellness_label'][
                                      `demetra_health_wellness_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_health_wellness_label.demetra_health_wellness_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_health_wellness_label.demetra_health_wellness_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- demetra_leadership_label -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_leadership_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra leadership label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_leadership_label_${selectedLanguage}`"
                        :id="`demetra_leadership_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_leadership_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_leadership_label'] &&
                            form['demetra_leadership_label'][
                                `demetra_leadership_label_${selectedLanguage}`
                            ]
                                ? form['demetra_leadership_label'][
                                      `demetra_leadership_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_leadership_label.demetra_leadership_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_leadership_label.demetra_leadership_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- demetra_media_label -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_media_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra media label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_media_label_${selectedLanguage}`"
                        :id="`demetra_media_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_media_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_media_label'] &&
                            form['demetra_media_label'][
                                `demetra_media_label_${selectedLanguage}`
                            ]
                                ? form['demetra_media_label'][
                                      `demetra_media_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_media_label.demetra_media_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_media_label.demetra_media_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- demetra_music_performance_label -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_music_performance_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra music performance label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_music_performance_label_${selectedLanguage}`"
                        :id="`demetra_music_performance_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_music_performance_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_music_performance_label'] &&
                            form['demetra_music_performance_label'][
                                `demetra_music_performance_label_${selectedLanguage}`
                            ]
                                ? form['demetra_music_performance_label'][
                                      `demetra_music_performance_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_music_performance_label.demetra_music_performance_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_music_performance_label.demetra_music_performance_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- demetra_social_activism_label -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_social_activism_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra social activism label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_social_activism_label_${selectedLanguage}`"
                        :id="`demetra_social_activism_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_social_activism_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_social_activism_label'] &&
                            form['demetra_social_activism_label'][
                                `demetra_social_activism_label_${selectedLanguage}`
                            ]
                                ? form['demetra_social_activism_label'][
                                      `demetra_social_activism_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_social_activism_label.demetra_social_activism_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_social_activism_label.demetra_social_activism_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- demetra_stem_competitions_label -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_stem_competitions_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra stem competitions label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_stem_competitions_label_${selectedLanguage}`"
                        :id="`demetra_stem_competitions_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_stem_competitions_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_stem_competitions_label'] &&
                            form['demetra_stem_competitions_label'][
                                `demetra_stem_competitions_label_${selectedLanguage}`
                            ]
                                ? form['demetra_stem_competitions_label'][
                                      `demetra_stem_competitions_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_stem_competitions_label.demetra_stem_competitions_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_stem_competitions_label.demetra_stem_competitions_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- demetra_technology_label -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`demetra_technology_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Demetra technology label</label
                    >
                    <input
                        type="text"
                        :name="`demetra_technology_label_${selectedLanguage}`"
                        :id="`demetra_technology_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'demetra_technology_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['demetra_technology_label'] &&
                            form['demetra_technology_label'][
                                `demetra_technology_label_${selectedLanguage}`
                            ]
                                ? form['demetra_technology_label'][
                                      `demetra_technology_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `demetra_technology_label.demetra_technology_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `demetra_technology_label.demetra_technology_label_${selectedLanguage}`
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
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    components:{
    ListErrors
},
    props: ["selectedLanguage"],
    computed: {
        ...mapState({
            form: (state) => state.demetra_page_setting.form,
            validationErros: (state) =>
                state.demetra_page_setting.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
            collapseStates: [true, false, false, false, false, false, false],
        };
    },
    methods: {
        handleInput(value, language, key, mutationName) {
            this.$store.commit(`demetra_page_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        addUpdateForm() {
            this.$store
                .dispatch("demetra_page_setting/addUpdateForm")
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
        fetchDemetraPageSetting() {
            this.$store
                .dispatch("demetra_page_setting/fetchDemetraPageSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}demetra-page-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data &&
                        res.data.data.demetra_page_setting_detail
                            ? res.data.data.demetra_page_setting_detail
                            : [];

                    let obj = {};

                    //GPA
                    obj = {};
                    data.map((res) => {
                        obj["min_cgpa_label_" + res.language_id] =
                            res.min_cgpa_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "min_cgpa_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["min_cgpa_placeholder_" + res.language_id] =
                            res.min_cgpa_placeholder;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "min_cgpa_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["min_cgpa_error_" + res.language_id] =
                            res.min_cgpa_error;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "min_cgpa_error",
                        value: obj,
                    });

                    //curruicluar
                    obj = {};
                    data.map((res) => {
                        obj["demetra_curricular_label_" + res.language_id] =
                            res.demetra_curricular_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_curricular_label",
                        value: obj,
                    });
                    //demetra_entrepreneurship_label
                    obj = {};
                    data.map((res) => {
                        obj["demetra_entrepreneurship_label_" + res.language_id] =
                            res.demetra_entrepreneurship_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_entrepreneurship_label",
                        value: obj,
                    });
                    //demetra_environmental_label
                    obj = {};
                    data.map((res) => {
                        obj["demetra_environmental_label_" + res.language_id] =
                            res.demetra_environmental_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_environmental_label",
                        value: obj,
                    });
                    //demetra_extracurricular_label
                    obj = {};
                    data.map((res) => {
                        obj["demetra_extracurricular_label_" + res.language_id] =
                            res.demetra_extracurricular_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_extracurricular_label",
                        value: obj,
                    });
                    //demetra_health_wellness_label
                    obj = {};
                    data.map((res) => {
                        obj["demetra_health_wellness_label_" + res.language_id] =
                            res.demetra_health_wellness_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_health_wellness_label",
                        value: obj,
                    });
                    //demetra_leadership_label
                    obj = {};
                    data.map((res) => {
                        obj["demetra_leadership_label_" + res.language_id] =
                            res.demetra_leadership_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_leadership_label",
                        value: obj,
                    });
                    //demetra_media_label
                    obj = {};
                    data.map((res) => {
                        obj["demetra_media_label_" + res.language_id] =
                            res.demetra_media_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_media_label",
                        value: obj,
                    });
                    //demetra_music_performance_label
                    obj = {};
                    data.map((res) => {
                        obj["demetra_music_performance_label_" + res.language_id] =
                            res.demetra_music_performance_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_music_performance_label",
                        value: obj,
                    });
                    //demetra_social_activism_label
                    obj = {};
                    data.map((res) => {
                        obj["demetra_social_activism_label_" + res.language_id] =
                            res.demetra_social_activism_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_social_activism_label",
                        value: obj,
                    });
                    //demetra_stem_competitions_label
                    obj = {};
                    data.map((res) => {
                        obj["demetra_stem_competitions_label_" + res.language_id] =
                            res.demetra_stem_competitions_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_stem_competitions_label",
                        value: obj,
                    });
                    //demetra_technology_label
                    obj = {};
                    data.map((res) => {
                        obj["demetra_technology_label_" + res.language_id] =
                            res.demetra_technology_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_technology_label",
                        value: obj,
                    });

                    //sport
                    obj = {};
                    data.map((res) => {
                        obj["demetra_sport_label_" + res.language_id] =
                            res.demetra_sport_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_sport_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["demetra_sport_placeholder_" + res.language_id] =
                            res.demetra_sport_placeholder;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_sport_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["demetra_sport_error_" + res.language_id] =
                            res.demetra_sport_error;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_sport_error",
                        value: obj,
                    });
                    //email
                    obj = {};
                    data.map((res) => {
                        obj[
                            "demetra_comunity_service_label_" + res.language_id
                        ] = res.demetra_comunity_service_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_comunity_service_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj[
                            "demetra_comunity_service_placeholder_" +
                                res.language_id
                        ] = res.demetra_comunity_service_placeholder;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_comunity_service_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj[
                            "demetra_comunity_service_error_" + res.language_id
                        ] = res.demetra_comunity_service_error;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_comunity_service_error",
                        value: obj,
                    });
                    //passowrd
                    obj = {};
                    data.map((res) => {
                        obj["max_cgpa_label_" + res.language_id] =
                            res.max_cgpa_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "max_cgpa_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj[
                            "max_cgpa_placeholder_" +
                                res.language_id
                        ] = res.max_cgpa_placeholder;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "max_cgpa_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["max_cgpa_error_" + res.language_id] =
                            res.max_cgpa_error;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "max_cgpa_error",
                        value: obj,
                    });

                   

                    obj = {};
                    data.map((res) => {
                        obj["demetra_button_text_" + res.language_id] =
                            res.demetra_button_text;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "demetra_button_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj[
                            "conditional_acceptance_label_" + res.language_id
                        ] = res.conditional_acceptance_label;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "conditional_acceptance_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj[
                            "conditional_acceptance_placeholder_" +
                                res.language_id
                        ] = res.conditional_acceptance_placeholder;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "conditional_acceptance_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj[
                            "conditional_acceptance_error_" + res.language_id
                        ] = res.conditional_acceptance_error;
                    });
                    this.$store.commit("demetra_page_setting/setPageSetting", {
                        key: "conditional_acceptance_error",
                        value: obj,
                    });
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
                    `demetra_comunity_service_label.demetra_comunity_service_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `demetra_comunity_service_placeholder.demetra_comunity_service_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `demetra_comunity_service_error.demetra_comunity_service_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `max_cgpa_label.max_cgpa_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `max_cgpa_placeholder.max_cgpa_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `max_cgpa_error.max_cgpa_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `demetra_button_text.demetra_button_text_${this.selectedLanguage}`
                )
            );
        },
    },
    created() {
        this.$store.commit("demetra_page_setting/resetForm");
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
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "page_title",
                    value: obj,
                });

                //GPA
                obj = {};
                data.map((res) => {
                    obj["min_cgpa_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "min_cgpa_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["min_cgpa_placeholder_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "min_cgpa_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["min_cgpa_error_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "min_cgpa_error",
                    value: obj,
                });

                //curricular
                obj = {};
                data.map((res) => {
                    obj["demetra_curricular_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_curricular_label",
                    value: obj,
                });
                //demetra_entrepreneurship_label
                obj = {};
                data.map((res) => {
                    obj["demetra_entrepreneurship_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_entrepreneurship_label",
                    value: obj,
                });
                //demetra_environmental_label
                obj = {};
                data.map((res) => {
                    obj["demetra_environmental_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_environmental_label",
                    value: obj,
                });
                //demetra_extracurricular_label
                obj = {};
                data.map((res) => {
                    obj["demetra_extracurricular_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_extracurricular_label",
                    value: obj,
                });
                //demetra_health_wellness_label
                obj = {};
                data.map((res) => {
                    obj["demetra_health_wellness_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_health_wellness_label",
                    value: obj,
                });
                //demetra_leadership_label
                obj = {};
                data.map((res) => {
                    obj["demetra_leadership_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_leadership_label",
                    value: obj,
                });
                //demetra_media_label
                obj = {};
                data.map((res) => {
                    obj["demetra_media_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_media_label",
                    value: obj,
                });
                //demetra_music_performance_label
                obj = {};
                data.map((res) => {
                    obj["demetra_music_performance_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_music_performance_label",
                    value: obj,
                });
                //demetra_social_activism_label
                obj = {};
                data.map((res) => {
                    obj["demetra_social_activism_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_social_activism_label",
                    value: obj,
                });
                //demetra_stem_competitions_label
                obj = {};
                data.map((res) => {
                    obj["demetra_stem_competitions_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_stem_competitions_label",
                    value: obj,
                });
                //demetra_technology_label
                obj = {};
                data.map((res) => {
                    obj["demetra_technology_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_technology_label",
                    value: obj,
                });

                //sport
                obj = {};
                data.map((res) => {
                    obj["demetra_sport_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_sport_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["demetra_sport_placeholder_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_sport_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["demetra_sport_error_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_sport_error",
                    value: obj,
                });
                //email
                obj = {};
                data.map((res) => {
                    obj["demetra_comunity_service_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_comunity_service_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["demetra_comunity_service_placeholder_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_comunity_service_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["demetra_comunity_service_error_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_comunity_service_error",
                    value: obj,
                });
                //passowrd
                obj = {};
                data.map((res) => {
                    obj["max_cgpa_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "max_cgpa_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["max_cgpa_placeholder_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "max_cgpa_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["max_cgpa_error_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "max_cgpa_error",
                    value: obj,
                });


                obj = {};
                data.map((res) => {
                    obj["demetra_button_text_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "demetra_button_text",
                    value: obj,
                });

                //confirm passowrd
                obj = {};
                data.map((res) => {
                    obj["conditional_acceptance_label_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "conditional_acceptance_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["conditional_acceptance_placeholder_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "conditional_acceptance_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["conditional_acceptance_error_" + res.id] = "";
                });
                this.$store.commit("demetra_page_setting/setPageSetting", {
                    key: "conditional_acceptance_error",
                    value: obj,
                });
                this.fetchDemetraPageSetting();
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
