<template>
    <div
        class="relative flex items-center border border-gray-300 rounded"
    >
        <button
            class="can-edu-btn-fill whitespace-nowrap"
            @click="toggleModal"
        >
            {{
                static_translations?.open_modal_button_text
                    ? static_translations?.open_modal_button_text
                    : ""
            }}
        </button>
    </div>
</template>
<script>
export default {
    props: ["lang", "event_modal_translation", "logged_in_user_type"],
    data() {
        return {
            static_translations: {},
        };
    },
    methods: {
        toggleModal() {
            if (this.logged_in_user_type === 'school' || this.logged_in_user_type === 'business') {
                window.location.href =
                    window.location.href = "/" + this.lang +"/add-event";
            } else {
                // window.location.href = "/" + this.lang + "/login?url="+window.location.href;
                window.location.href = "/" + this.lang +"/add-event";
            }
        },
    },
    created() {
        this.static_translations = JSON.parse(this.event_modal_translation);
    },
};
</script>
