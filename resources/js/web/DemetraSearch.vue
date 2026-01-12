<template>
    <div class="mt-4">
        <form class="" @submit="reverSearch">
            <!-- <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg mb-2">
                    {{
                        demetra_settings?.demetra_page_setting_detail?.length >
                            0
                            ? demetra_settings.demetra_page_setting_detail[0]
                                .min_cgpa_label
                            : ""
                    }}
                </label>
                <input v-model="min_cgpa" type="text" step="any" :placeholder="demetra_settings?.demetra_page_setting_detail?.length >
                    0
                    ? demetra_settings.demetra_page_setting_detail[0]
                        .min_cgpa_placeholder
                    : ''
                    "
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                        " name="min_cgpa" />
            </div> -->
            <!-- <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg mb-2">
                    {{
                        demetra_settings?.demetra_page_setting_detail?.length >
                            0
                            ? demetra_settings.demetra_page_setting_detail[0]
                                .max_cgpa_label
                            : ""
                    }}
                </label>
                <input v-model="max_cgpa" type="text" step="any" :placeholder="demetra_settings?.demetra_page_setting_detail?.length >
                        0
                        ? demetra_settings.demetra_page_setting_detail[0]
                            .max_cgpa_placeholder
                        : ''
                    "
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                        " name="max_cgpa" />
            </div> -->

            <!-- <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg mb-2">{{
                    demetra_settings?.demetra_page_setting_detail?.length >
                        0
                        ? demetra_settings.demetra_page_setting_detail[0]
                            .demetra_sport_label
                        : ""
                }}</label>
                <v-select v-model="sportVModel" :options="local_sports" :settings="{ width: '100%', multiple: true }"
                    class="border w-full focus:ring-primary focus:outline-none rounded lg:text-lg border-gray-300"
                    multiple :trackBy="id" label="text" :reduce="option => option.id" /> -->
                <!-- <select
                    class="relative  w-full mb-2 flex items-center border-collapse border p-2 border-gray-300 rounded focus:ring-primary {{ isset(getDefaultLanguage(1)->position) && getDefaultLanguage(1)->position === 'rtl' ? 'border-r-[5px] border-r-primary' : 'border-l-primary border-l-[5px]' }}"
                    name="sport"
                >
                    <option value="">Select</option>
                    <option
                        v-for="(sport, key) in sports"
                        :value="sport.id"
                        :key="key"
                    >
                        {{
                            sport?.sport_detail?.length > 0
                                ? sport?.sport_detail[0].name
                                : ""
                        }}
                    </option>
                </select> -->
            <!-- </div> -->
            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg mb-2">{{
                    demetra_settings?.demetra_page_setting_detail?.length >
                        0
                        ? demetra_settings.demetra_page_setting_detail[0]
                            .demetra_comunity_service_label
                        : ""
                }}</label>
                <v-select v-model="csVModel" :options="local_comunity_services"
                    :settings="{ width: '100%', multiple: true }" multiple :trackBy="id" label="text"
                    :reduce="option => option.id"
                    class="border w-full focus:ring-primary focus:outline-none rounded lg:text-lg border-gray-300" />
                <!-- <select
                    class="relative  w-full mb-2 flex items-center border-collapse border p-2 border-gray-300 rounded focus:ring-primary  {{ isset(getDefaultLanguage(1)->position) && getDefaultLanguage(1)->position === 'rtl' ? 'border-r-[5px] border-r-primary' : 'border-l-primary border-l-[5px]' }}"
                    name="community_service"
                >
                    <option value="">Select</option>
                    <option
                        v-for="(comunityService, key) in comunity_services"
                        :key="key"
                        :value="comunityService.id"
                    >
                        {{
                            comunityService?.comunity_service_detail?.length > 0
                                ? comunityService?.comunity_service_detail[0]
                                      .name
                                : ""
                        }}
                    </option>
                </select> -->
            </div>
            <!-- <div v-for="(type, key) in activityTypes" :key="key" class="w-full mt-2 relative"> -->
            <div v-for="(type, key) in dynamicActivityTypes" :key="key" class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg mb-2">{{ type.label }}</label>
                <v-select  v-if="type.value !== 'min_cgpa' && type.value !== 'sports'" v-model="activityVModels[type.value]" :options="filteredActivities(type.value)"
                    :settings="{ width: '100%', multiple: true }" multiple :trackBy="id" label="text"
                    :reduce="option => option.id"
                    class="border w-full focus:ring-primary focus:outline-none rounded lg:text-lg border-gray-300" />


                    <input
                    v-else-if="type.value === 'min_cgpa'"
                    v-model="min_cgpa"
                    type="text"
                    step="any"
                    :placeholder="demetra_settings?.demetra_page_setting_detail?.[0]?.min_cgpa_placeholder || ''"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="position === 'rtl'
                      ? 'border-r-[5px] rounded-r border-r-primary'
                      : 'border-l-[5px] rounded-l border-l-primary'"
                    name="min_cgpa"
                  />
                
                  <!-- Sports dropdown -->
                  <v-select
                    v-else-if="type.value === 'sports'"
                    v-model="sportVModel"
                    :options="local_sports"
                    :settings="{ width: '100%', multiple: true }"
                    multiple
                    :trackBy="id"
                    label="text"
                    :reduce="option => option.id"
                    class="border w-full focus:ring-primary focus:outline-none rounded lg:text-lg border-gray-300"
                  />
            </div>
           

            <!-- <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg mb-2">{{
                    demetra_settings?.demetra_page_setting_detail?.length >
                        0
                        ? demetra_settings.demetra_page_setting_detail[0]
                            .conditional_acceptance_label
                        : ""
                }}</label>
                <select
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                        " name="conditional_acceptance" v-model="conditional_acceptance">
                    <option value="all">All</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div> -->
            <div class="flex justify-center items-center gap-3 mt-4">
                <div>
                    <!-- <button class="can-edu-btn-fill" :disabled="shouldDisableButton"> -->
                    <button class="can-edu-btn-fill">
                        {{
                            demetra_settings?.demetra_page_setting_detail
                                ?.length > 0
                                ? demetra_settings
                                    .demetra_page_setting_detail[0]
                                    .demetra_button_text
                                : ""
                        }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import Select2 from "vue3-select2-component";

export default {
    props: [
        "logged_in_user_type",
        "package_price",
        "is_logged_in",
        "lang",
        "activities",
        "demetra_page_setting",
        "sports",
        "comunity_services",
    ],
    data() {
        return {
            demetra_settings: {},
            local_sports: [],
            local_comunity_services: [],
            local_activities: [],
            conditional_acceptance: "all",
            min_cgpa: "",
            max_cgpa: "",
            sportVModel: [],
            csVModel: [],

            getActivityLabel: (value) => {
            if (!this.demetra_settings?.demetra_page_setting_detail?.[0]) return '';
            
            const setting = this.demetra_settings.demetra_page_setting_detail[0];
            const mapping = {
                curricular: 'demetra_curricular_label',
                entrepreneurship: 'demetra_entrepreneurship_label',
                environmental: 'demetra_environmental_label',
                extracurricular: 'demetra_extracurricular_label',
                health_wellness: 'demetra_health_wellness_label',
                leadership: 'demetra_leadership_label',
                media: 'demetra_media_label',
                min_cgpa: 'min_cgpa_label',
                music_performance: 'demetra_music_performance_label',
                social_activism: 'demetra_social_activism_label',
                sports: 'demetra_sport_label',
                stem_competitions: 'demetra_stem_competitions_label',
                technology: 'demetra_technology_label'
            };
            
            return setting[mapping[value]] || '';
        },

        activityTypes: [
            { value: 'curricular', defaultLabel: 'Curricular Activities' },
            { value: 'entrepreneurship', defaultLabel: 'Entrepreneurship' },
            { value: 'environmental', defaultLabel: 'Environmental & Sustainability' },
            { value: 'extracurricular', defaultLabel: 'Extracurricular Activities' },
            { value: 'health_wellness', defaultLabel: 'Health & Wellness' },
            { value: 'leadership', defaultLabel: 'Leadership' },
            { value: 'media', defaultLabel: 'Media' },
            { value: 'min_cgpa', defaultLabel: 'Minimum CGPA' },
            { value: 'music_performance', defaultLabel: 'Music & Performance' },
            { value: 'social_activism', defaultLabel: 'Social Activism' },
            { value: 'sports', defaultLabel: 'Sports' }, 
            { value: 'stem_competitions', defaultLabel: 'STEM Competitions' },
            { value: 'technology', defaultLabel: 'Technology' }
        ],
            activitiesVModel: [],
            activityVModels: {
                extracurricular: [],
                leadership: [],
                media: [],
                music_performance: [],
                social_activism: [],
                technology: [],
                entrepreneurship: [],
                environmental: [],
                stem_competitions: [],
                health_wellness: []
            }
        };
    },
    methods: {
        reverSearch(e) {
            e.preventDefault();
            let activitiesQuery = '';
            Object.keys(this.activityVModels).forEach(type => {
                if (this.activityVModels[type] && this.activityVModels[type].length > 0) {
                    if (activitiesQuery) activitiesQuery += '&';
                    activitiesQuery += `${type}_ids=${this.activityVModels[type].join(',')}`;
                }
            });

            window.location.href =
                "/" +
                this.lang +
                "/demetra-search-results?min_cgpa=" +
                this.min_cgpa +
                "&max_cgpa=" +
                this.max_cgpa +
                "&conditional_acceptance=" +
                this.conditional_acceptance +
                "&sports=" +
                this.sportVModel +
                "&community_services=" +
                this.csVModel +
                (activitiesQuery ? "&" + activitiesQuery : "");
        },
        filteredActivities(type) {
            return this.local_activities
                .filter(activity => activity.type === type)
                .sort((a, b) => a.text.localeCompare(b.text));
        }
    },
    computed: {
        dynamicActivityTypes() {
        // First create the array with labels
        const typesWithLabels = this.activityTypes.map(type => ({
            value: type.value,
            label: this.getActivityLabel(type.value) || type.defaultLabel
        }));
        
        // Then sort them alphabetically by label
        return typesWithLabels.sort((a, b) => a.label.localeCompare(b.label));
    },
        // shouldDisableButton() {
        //     return (
        //         this.logged_in_user_type !== 'student' ||
        //         (this.logged_in_user_type === 'student' && this.package_price === '0')
        //     );
        // },
    },

    mounted() {
        localStorage.removeItem("demetra_conditional_acceptance");
        localStorage.removeItem("demetra_min_cgpa");
        localStorage.removeItem("demetra_max_cgpa");
        localStorage.removeItem("demetra_sportVModel");
        localStorage.removeItem("demetra_csVModel");
        this.activityTypes.forEach(type => {
            localStorage.removeItem(`demetra_activity_${type.value}`);
        });

        this.conditional_acceptance = "";
        this.min_cgpa = "";
        this.max_cgpa = "";
        this.sportVModel = null;
        this.csVModel = null;
        this.activitiesVModel = null;
        Object.keys(this.activityVModels).forEach(type => {
            this.activityVModels[type] = null;
        });

        console.log(this.demetra_page_setting);
        this.demetra_settings = JSON.parse(this.demetra_page_setting);

        this.local_sports = [];
        JSON.parse(this.sports).map((sport) => {
            this.local_sports.push({
                id: sport.id,
                text: sport?.sport_detail[0].name,
            });
        });
        this.local_sports.sort((a, b) => a.text.localeCompare(b.text));

        this.local_comunity_services = [];
        JSON.parse(this.comunity_services).map((comunityService) => {
            this.local_comunity_services.push({
                id: comunityService.id,
                text: comunityService?.comunity_service_detail[0].name,
            });
        });
        this.local_comunity_services.sort((a, b) => a.text.localeCompare(b.text));
        this.local_activities = [];
        if (this.activities) {
            JSON.parse(this.activities).map((activity) => {
                this.local_activities.push({
                    id: activity.id,
                    text: activity?.details[0]?.name || '',
                    type: activity.type
                });
            });
        }
    },

    watch: {
        conditional_acceptance(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem(
                    "demetra_conditional_acceptance",
                    newValue
                );
            }
        },
        min_cgpa(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("demetra_min_cgpa", newValue);
            }
        },
        max_cgpa(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("demetra_max_cgpa", newValue);
            }
        },
        sportVModel(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem(
                    "demetra_sportVModel",
                    JSON.stringify(newValue)
                );
            }
        },
        csVModel(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem(
                    "demetra_csVModel",
                    JSON.stringify(newValue)
                );
            }
        },
        activityVModels: {
            handler(newValue) {
                Object.keys(newValue).forEach(type => {
                    if (newValue[type]) {
                        localStorage.setItem(`demetra_activity_${type}`, JSON.stringify(newValue[type]));
                    }
                });
            },
            deep: true
        }
    },
    components: { Select2 },
};
</script>
