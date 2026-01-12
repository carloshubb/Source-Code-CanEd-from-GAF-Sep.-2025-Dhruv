<template>
    <div class="container mx-auto">
        <div class="bg-white py-6 lg:hidden">
            <div
                class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4"
            >
                <div
                    class="bg-gray-50 border rounded"
                    v-for="(degree, key) in local_degrees"
                    :key="key"
                >
                    <div class="p-2 flex justify-center items-center gap-2">
                        <a :href="'/'+lang+'/school/school-degree/'+degree?.id+'/'+degree?.degree_detail[0]?.slug">
                            <div class="">
                                <img
                                    class="md:h-10 h-10 mx-auto"
                                    :src="degree?.degree_image?.thumbnail_image"
                                    alt=""
                                />
                            </div>
                            <div class="mt-2 text-sm font-semibold text-center">
                                {{ degree?.degree_detail[0]?.name }}
                            </div>
                        </a>
                    </div>
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
        this.local_degrees = JSON.parse(this.degrees);
    },
};
</script>
