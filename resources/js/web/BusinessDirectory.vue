<template>
    <form>
        <div class="w-full mx-auto mt-10 flex flex-col xl:flex-row xl:items-end space-x-4 space-y-4 xl:space-y-0">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4">
                <div class="ml-2">
                    <label for="" class="block text-base lg:text-lg">{{
                            business_directory?.bus_directory_setting_detail
                                ?.length > 0
                                ? business_directory
                                      ?.bus_directory_setting_detail[0]
                                      .company_name_label
                                : ""
                        }}</label>
                    <input
                        type="text"
                        name="keyword"
                        v-model="keyword"
                        class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position === 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                        "
                    />
                </div>
                <div class="ml-2">
                    <label for="" class="block text-base lg:text-lg">{{
                            business_directory?.bus_directory_setting_detail
                                ?.length > 0
                                ? business_directory
                                      ?.bus_directory_setting_detail[0]
                                      .city_label
                                : ""
                        }}</label>
                    <input
                        type="text"
                        name="city"
                        v-model="city"
                        class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position === 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                        "
                    />
                </div>
                <div class="ml-2">
                    <label for="" class="block text-base lg:text-lg">{{
                            business_directory?.bus_directory_setting_detail
                                ?.length > 0
                                ? business_directory
                                      ?.bus_directory_setting_detail[0]
                                      .province_label
                                : ""
                        }}</label>
                    <input
                        type="text"
                        name="province"
                        v-model="province"
                        class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position === 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                        "
                    />
                </div>
                <div class="ml-2">
                    <label for="" class="block text-base lg:text-lg">{{
                            business_directory?.bus_directory_setting_detail
                                ?.length > 0
                                ? business_directory
                                      ?.bus_directory_setting_detail[0]
                                      .industry_label
                                : ""
                        }}</label>
                    <v-select
                        v-model="industry"
                        :options="industries"
                        :settings="{ width: '100%', multiple: true }"
                        
                    />
                </div>
            </div>
                <div class="mb-0.5">
                    <button
                        @click="filter"
                        type="button"
                        class="can-edu-btn-fill"
                    >
                        {{
                            business_directory?.bus_directory_setting_detail
                                ?.length > 0
                                ? business_directory
                                      ?.bus_directory_setting_detail[0]
                                      .button_text
                                : ""
                        }}
                    </button>
                </div>
        </div>
    </form>
</template>

<script>
import Select2 from "vue3-select2-component";
export default {
    components: {
        Select2,
    },
    props: ["position", "lang", "industs", "business_directory_settings"],
    data() {
        return {
            business_directory: {},
            industries: [],
            industry: [],
            keyword: "",
            city: "",
            province: "",
        };
    },
    methods:{
        filter(){
            console.log(this.city);
            window.location.href = '/'+this.lang+'/search/business-directory?city='+this.city+'&province='+this.province+'&keyword='+this.keyword+'&industry='+this.industry.label
        }
    },
    created() {
        this.business_directory = JSON.parse(this.business_directory_settings);
        this.industries = JSON.parse(this.industs);
        this.industries = this.industries.map(industry => {
            return { 
                value: industry,  // You can use the entire string as value or make it more specific 
                label: industry    // Set the label to the industry name or description
            };
        });

        // this.industries = JSON.parse(this.industs).slice().sort((a, b) => a.text.localeCompare(b.text));
        console.log(this.industries);
    },
};
</script>
