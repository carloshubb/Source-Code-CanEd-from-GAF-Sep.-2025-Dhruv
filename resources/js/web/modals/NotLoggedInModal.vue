<template>
    <div
        class="relative z-10"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
        v-if="!is_logged_id"
    >
        <div
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        ></div>

        <div class="fixed top-1/3 md:inset-0 z-10 overflow-y-auto">
            <div
                class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
            >
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl"
                >
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div
                            class="text-2xl text-center py-3 text-gray-700 font-semibold"
                        >
                            <p>
                                {{
                                    is_login_modal_setting
                                        ?.is_login_modal_setting_detail[0]
                                        ?.modal_title
                                }}
                            </p>
                        </div>
                    </div>
                    <div
                        class=" px-4 py-1 flex flex-row flex-wrap justify-center items-center gap-2 sm:px-6"
                    >
                        <div class="mb-4 text-center">
                            <span
                                class="cursor-pointer can-edu-btn-fill whitespace-nowrap"
                                @click="goBack"
                            >
                                {{
                                    is_login_modal_setting
                                        ?.is_login_modal_setting_detail[0]
                                        ?.back_button_text
                                }}
                            </span>
                        </div>
                        <!-- <div class="mb-4 text-center">
                            <a
                                class="can-edu-btn-fill whitespace-nowrap"
                                :href="`/${lang}/${register_slug}`"
                            >
                                {{
                                    is_login_modal_setting
                                        ?.is_login_modal_setting_detail[0]
                                        ?.register_button_text
                                }}
                            </a>
                        </div> -->
                        <div class="mb-4 text-center">
                            <a
                                class="can-edu-btn-fill whitespace-nowrap"
                                :href="`/${lang}/${login_slug}`"
                            >
                                {{
                                    is_login_modal_setting
                                        ?.is_login_modal_setting_detail[0]
                                        ?.login_button_text
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
    props: [
        "is_logged_id",
        "is_login_modal_setting",
        "login_slug",
        "register_slug",
        "lang"
    ],
    methods:{
        goBack(){
            window.history.go(-1); 
            return false;
        }
    }
};
</script>
