<template>
    <AppLayout>
        <header class="py-4 bg-white">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">School overview</h1>
                    <router-link
                        :to="{ name: 'admin.schools.index' }"
                        class="can-edu-btn-fill"
                    >
                        Back
                    </router-link>
                </div>
            </div>
            <div v-if="$route?.params?.id">
                <other-options type="ambassador" :id="$route?.params?.id" />
            </div>
        </header>
        <div class="p-5 bg-white dark:bg-gray-800">
            <SchoolAmbassadorSetting
                :logged_in_customer="logged_in_customer"
                :school_id="school_id"
            ></SchoolAmbassadorSetting>
        </div>
    </AppLayout>
</template>
<script>
import SchoolAmbassadorSetting from "./SchoolAmbassadorSetting.vue";
import OtherOptions from "./OtherOptions.vue";

export default {
    components: {
        SchoolAmbassadorSetting,
        OtherOptions,
    },
    created(){
        console.log('main logged in customer',this.logged_in_customer)
    }
    
};
</script>
