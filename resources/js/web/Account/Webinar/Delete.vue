<template>
    <button class="can-edu-btn-fill" @click="deleteWebinar">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="w-5 h-5"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
            />
        </svg>
    </button>
</template>

<script>
import { mapState } from "vuex";
export default {
    props: ["logged_in_customer", "webinar", "lang"],
    computed: {
        ...mapState({
            form: (state) => state.webinars.form,
            webinars: (state) => state.webinars.webinars,
            pagination: (state) => state.webinars.pagination,
            errors: (state) => state.webinars.validationErros,
            searchParam: (state) => state.webinars.searchParam,
            loading: (state) => state.webinars.loading,
        }),
    },
    methods: {
        deleteWebinar() {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.$store
                            .dispatch("webinars/deleteWebinar", {
                                id: this.webinar,
                            })
                            .then((res) => {
                                if (res.data.status == "Success") {
                                    window.location.href =
                                        "/" +
                                        this.lang +
                                        "/ambassador/webinars";
                                }
                            });
                    }
                });
        },
    },
};
</script>
