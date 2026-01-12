<template>
    <div
        class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full"
    >
        <InformationSetting
            :logged_in_customer="logged_in_customer"
            :languages_with_names="languages_with_names"
        ></InformationSetting>
    </div>
</template>
<script>
import _ from "lodash";
import { mapState } from "vuex";
import InformationSetting from "./InformationSetting.vue";

export default {
    props: ["logged_in_customer","languages_with_names"],
    components: {
        InformationSetting,
    },
    computed: {
        ...mapState({
            form: (state) => state.school_informations.form,
            school_informations: (state) =>
                state.school_informations.school_informations,
            pagination: (state) => state.school_informations.pagination,
            validationErros: (state) => state.school_informations.validationErros,
            searchParam: (state) => state.school_informations.searchParam,
            loading: (state) => state.school_informations.loading,
        }),
    },
    data() {
        return {
            quickSearch: null,
        };
    },
    methods: {
        toggleModal() {
            this.$store.commit("school_informations/setShowModal", 1);
        },
        fetchSchoolInformations(page_url, type) {
            this.$store.dispatch("school_informations/fetchSchoolInformations", {
                url: page_url,
                type,
            });
        },
        updateLimit(value) {
            this.$store.commit("school_informations/setLimit", value);
        },
        editSchoolInformation(school_information) {
            console.log(school_information);
            this.$store.commit(
                "school_informations/setSchoolInformation",
                school_information
            );
        },
        quickSearchFilter: _.debounce(function () {
            this.$store.commit(
                "school_informations/setSearchParam",
                this.quickSearch
            );
        }, 500),
    },
    created() {
        this.$store.commit("school_informations/setLimit", 10);
        this.$store.commit("school_informations/setSortBy", "id");
        this.$store.commit("school_informations/setSortType", "desc");
        this.$store.dispatch("school_informations/fetchSchoolInformations");
    },
    watch: {
        quickSearch: function () {
            this.quickSearchFilter();
        },
    },
};
</script>
