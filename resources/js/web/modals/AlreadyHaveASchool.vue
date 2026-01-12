<template>
    <div>
        <!-- Main modal -->
        <div
            id="defaultModal"
            tabindex="-1"
            aria-hidden="true"
            class="bg-black bg-opacity-50 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-[calc(100%-1rem)] h-full"
            v-if="showModal"
        >
            <div
                class="relative w-full h-full max-w-2xl md:h-auto flex items-center justify-center"
            >
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                >
                    <!-- Modal body -->
                    <div class="p-6 space-y-6 content-center">
                        <p class="text-lg">
                            {{
                                this.static_translations
                                    ?.modal_description
                            }}
                        </p>
                        <div class="flex justify-center">
                        <a
                            class="can-edu-btn-fill"
                            :href="`/${lang}/${slug}/our-profile`"
                        >
                            {{
                                this.static_translations
                                    ?.button_text
                            }}
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["lang", "slug", "already_have_school_modal_translations"],
    data() {
        return {
            showModal: true,
            static_translations:{},
        };
    },
    methods: {
        toggleLanguageModal() {
            this.showModal = !this.showModal;
        },
    },
    created() {
        this.static_translations = JSON.parse(this.already_have_school_modal_translations);
    },
};
</script>
