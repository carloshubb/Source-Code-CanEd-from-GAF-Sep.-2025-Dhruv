<template>
    <!-- <button @click="deleteVirtualTour"> -->
    <button class="can-edu-btn-fill rounded-full" :disabled="disabled" @click="deleteVirtualTour" :class="{'cursor-not-allowed': disabled}">
        Delete
    </button>
</template>

<script>
import { mapState } from "vuex";
export default {
    props: ["logged_in_customer", "virtual_tour_id", "lang","disabled"],
    computed: {
        ...mapState({
            form: (state) => state.virtual_tours.form,
            virtual_tours: (state) => state.virtual_tours.virtual_tours,
            pagination: (state) => state.virtual_tours.pagination,
            errors: (state) => state.virtual_tours.validationErros,
            searchParam: (state) => state.virtual_tours.searchParam,
            loading: (state) => state.virtual_tours.loading,
        }),
    },
    methods: {
        deleteVirtualTour() {
            if (this.disabled) return;
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
                            .dispatch("virtual_tours/deleteVirtualTour", {
                                id: this.virtual_tour_id,
                            })
                            .then((res) => {
                                if (res.data.status == "Success") {
                                    window.location.href =
                                        "/" +
                                        this.lang +
                                        "/our-profile/virtual-tour";
                                }
                            });
                    }
                });
        },
    },
};
</script>
