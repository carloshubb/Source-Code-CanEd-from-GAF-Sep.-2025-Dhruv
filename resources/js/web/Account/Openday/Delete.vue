<template>
    <button @click="deleteOpenDay" class="can-edu-btn-fill rounded-full">
        Delete
    </button>
</template>

<script>
import { mapState } from "vuex";
export default {
    props: ["logged_in_customer", "open_day_id", "lang"],
    computed: {
        ...mapState({
            form: (state) => state.open_days.form,
            open_days: (state) => state.open_days.open_days,
            pagination: (state) => state.open_days.pagination,
            errors: (state) => state.open_days.validationErros,
            searchParam: (state) => state.open_days.searchParam,
            loading: (state) => state.open_days.loading,
        }),
    },
    methods: {
        deleteOpenDay() {
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
                            .dispatch("open_days/deleteOpenDay", {
                                id: this.open_day_id,
                            })
                            // .then((res) => {
                            //     if (res.data.status == "Success") {
                            //         window.location.href =
                            //             "/" + this.lang + "/our-profile/open-house";
                            //     }
                            // });
                            .then((res) => {
                                if (res.data.status === "Success") {
                                    this.$swal.fire({
                                        title: "Deleted!",
                                        text: "Your record has been deleted.",
                                        icon: "success",
                                        allowOutsideClick: true, 
                                        allowEscapeKey: false, 
                                        showConfirmButton: true 
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            })
                            .catch((error) => {
                                console.error("Deletion failed", error);
                            });
                    }
                });
        },
    },
};
</script>
