<template>
    <div class="bg-white w-full border-b-2 border-primary hidden lg:block">
        <div class="container mx-auto">
            <div
                class="grid xl:grid-cols-9 lg:grid-cols-9 md:grid-cols-4 sm:grid-cols-4 items-start divide-x py-4 lg:py-4"
            >
                <div
                    class="py-2 px-0 h-full"
                    v-for="(degree, key) in local_degrees"
                    :key="key"
                >
                    <a :href="'/'+lang+'/school/school-degree/'+degree?.id+'/'+degree?.degree_detail[0]?.slug">
                        <div class="">
                            <img
                                class="h-12 mx-auto"
                                :src="degree?.degree_image?.thumbnail_image"
                                alt=""
                            />
                        </div>
                        <div
                            class="mt-2 text-sm hover:font-bold font-medium text-center white p-0.5"
                        >
                            <p class="h-auto leading-5 text-base text-center break-words">{{ degree?.degree_detail[0]?.name }}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["degrees","lang"],
    data() {
        return {
            local_degrees: [],
        };
    },
    mounted() {
        console.log("this.degrees",this.degrees)
        this.local_degrees = JSON.parse(this.degrees);
    },
};
</script>
