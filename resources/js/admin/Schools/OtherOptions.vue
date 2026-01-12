<template>
    <div class="container mx-auto">
        <div class="grid grid-cols-3 md:grid-cols-6 gap-2 xl:gap-4 m-2 xl:m-0">
            <!-- Tab 1: Admission -->
            <div
                :class="
                    type == 'admission'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/admission'"
                    class="tab-link"
                    >Admission</router-link
                >
            </div>
            <div
                :class="
                    type == 'admission-faq'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/admission/faq'"
                    class="tab-link"
                    >Admission FAQ</router-link
                >
            </div>
            <div
                :class="
                    type == 'contact'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/contact'"
                    class="tab-link"
                    >Contact</router-link
                >
            </div>
            <div
            :class="
                type == 'ambassador'
                    ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                    : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
            "
        >
            <router-link
                :to="'/admin/schools/' + id + '/ambassador'"
                class="tab-link"
                >Ambassador</router-link
            >
        </div>
            <div
                :class="
                    type == 'financial'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/financial'"
                    class="tab-link"
                    >Financial</router-link
                >
            </div>
            <div
                :class="
                    type == 'financial-faq'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/financial/faq'"
                    class="tab-link"
                    >Financial FAQ</router-link
                >
            </div>
            <div
                :class="
                    type == 'information'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/edit'"
                    class="tab-link"
                    >Information</router-link
                >
            </div>
            <div
                :class="
                    type == 'overview'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/overview'"
                    class="tab-link"
                    >Overview</router-link
                >
            </div>
            <div
                :class="
                    type == 'overview-faq'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/overview/faq'"
                    class="tab-link"
                    >Overview FAQ</router-link
                >
            </div>
            <div
                :class="
                    type == 'quick_facts'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/quick_facts'"
                    class="tab-link"
                    >Quick Facts</router-link
                >
            </div>
            <div
                :class="
                    type == 'quick-facts-faq'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/quick_facts/faq'"
                    class="tab-link"
                    >Quick Facts FAQ</router-link
                >
            </div>
            <div
                :class="
                    type == 'programs'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/program'"
                    class="tab-link"
                    >Program</router-link
                >
            </div>
            <div
                :class="
                    type == 'programs-faq'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/programs/faq'"
                    class="tab-link"
                    >Programs FAQ</router-link
                >
            </div>
            
            <div
                :class="
                    type == 'scholarship'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/scholarship'"
                    class="tab-link"
                    >Scholarship</router-link
                >
            </div>
            <div
                :class="
                    type == 'scholarship-faq'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/scholarship/faq'"
                    class="tab-link"
                    >Scholarship FAQ</router-link
                >
            </div>
            <div
                :class="
                    type == 'blog'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/blog'"
                    class="tab-link"
                    >Blogs</router-link
                >
            </div>
            <div
                :class="
                    type == 'school-team'
                        ? 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT bg-primary text-white'
                        : 'col-span-1 p-1.5 md:p-3 border xl:m-4 text-base lg:text-lg font-FuturaMdCnBT'
                "
            >
                <router-link
                    :to="'/admin/schools/' + id + '/school-team'"
                    class="tab-link"
                    >Team members</router-link
                >
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["id", "type"],
};
</script>
