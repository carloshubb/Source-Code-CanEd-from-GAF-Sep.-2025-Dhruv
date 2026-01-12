<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">{{ isFormEdit ? 'Edit' : 'Create' }} Open house day</h1>
                        <router-link :to="{ name: 'admin.open_days.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full group">
                        <label for="school_name" class="block text-base lg:text-lg">School Name</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'school_name')"
                            :value="form['school_name'] ? form['school_name'] : ''" 
                            disabled
                            />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`school_name`)"
                            v-text="validationErros.get(`school_name`)"></p>
                    </div>
                      <div class="relative z-0 w-full group">
                        <label for="title" class="block text-base lg:text-lg">OpenHouse Title</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'title')"
                            :value="form['title'] ? form['title'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`title`)"
                            v-text="validationErros.get(`title`)"></p>
                    </div>
                    
                    
                    <div class="relative z-0 w-full group">
                        <label for="description" class="block text-base lg:text-lg">OpenHouse Description</label>
                        <textarea
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'description')">{{ form['description'] ? form['description'] : '' }}</textarea>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`description`)"
                            v-text="validationErros.get(`description`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="city" class="block text-base lg:text-lg">City</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'city')"
                            :value="form['city'] ? form['city'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`city`)"
                            v-text="validationErros.get(`city`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="country" class="block text-base lg:text-lg">Country</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'country')"
                            :value="form['country'] ? form['country'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`country`)"
                            v-text="validationErros.get(`country`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="address" class="block text-base lg:text-lg">Address</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'address')"
                            :value="form['address'] ? form['address'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`address`)"
                            v-text="validationErros.get(`address`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="time" class="block text-base lg:text-lg">Time</label>
                        <input type="time"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'time')"
                            :value="form['time'] ? form['time'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`time`)"
                            v-text="validationErros.get(`time`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="date" class="block text-base lg:text-lg">Date</label>
                        <input type="date"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'date')"
                            :value="form['date'] ? form['date'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`date`)"
                            v-text="validationErros.get(`date`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="school_email" class="block text-base lg:text-lg">School Email</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'school_email')
                                " :value="form['school_email'] ? form['school_email'] : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`school_email`)"
                            v-text="validationErros.get(`school_email`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="school_phone" class="block text-base lg:text-lg">School Phone</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'school_phone')
                                " :value="form['school_phone'] ? form['school_phone'] : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`school_phone`)"
                            v-text="validationErros.get(`school_phone`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="open_day_url" class="block text-base lg:text-lg">Open Day Url</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'open_day_url')
                                " :value="form['open_day_url'] ? form['open_day_url'] : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`open_day_url`)"
                            v-text="validationErros.get(`open_day_url`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="postal_code" class="block text-base lg:text-lg">Postal code</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'postal_code')
                                " :value="form['postal_code'] ? form['postal_code'] : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`postal_code`)"
                            v-text="validationErros.get(`postal_code`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="status" class="block text-base lg:text-lg">Status</label>
                        <select
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'status')">
                            <option :selected="form['status'] == 'pending'" value="pending">
                                Inactive
                            </option>
                            <option :selected="form['status'] == 'approved'" value="approved">
                                Active
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`status`)"
                            v-text="validationErros.get(`status`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <img v-if="form['image']" :src="form['image'] ? form['image'] : ''"
                            style="height: 100px; width: 100px" />
                    </div>
                </div>
                <ListErrors :validationErrors="validationErros" />
                <button type="submit" class="can-edu-btn-fill mb-2">
                    Submit
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    components: {
        ListErrors
    },
    computed: {
        ...mapState({
            isFormEdit: (state) => state.open_days.isFormEdit,
            form: (state) => state.open_days.form,
            validationErros: (state) => state.open_days.validationErros,
            languages: (state) => state.languages.languages,
            schools: (state) => state.schools.schools,
        }),
    },
    data() {
        return {
            activeTab: "en",
        };
    },
    methods: {
        handleInput(value, key) {
            this.$store.commit("open_days/setState", {
                key,
                value,
            });
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("open_days/updateState", {
                value: value,
                id: language.abbreviation,
                key,
            });
        },
        addUpdateForm() {
            this.$store.dispatch("open_days/addUpdateForm").then(() =>
                this.$router.push({
                    name: "admin.open_days.index",
                })
            );
        },
        changeLanguageTab(language) {
            this.activeTab = language.abbreviation;
        },
        fetchOpenDay() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("open_days/setIsFormEdit", 1);
                this.$store
                    .dispatch("open_days/fetchOpenDay", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}open_days/${id}?withSchoolDetail=1`,
                    })
                    .then((res) => {
                        console.log('openday res',res);
                        let keys = [
                            "city",
                            "country",
                            "address",
                            "time",
                            "date",
                            "school_email",
                            "school_phone",
                            "open_day_url",
                            "postal_code",
                            "image",
                            "status",
                            "open_days_detail_title"
                        ];
                        this.$store.commit("open_days/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("open_days/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }
                        // if (res.data.data.OpenDayDetail && res.data.data.OpenDayDetail.title) {
                        //     this.$store.commit("open_days/setState", {
                        //         key: "open_days_detail_title",
                        //         value: res.data.data.OpenDayDetail[0].title,
                        //     });
                        // }
                    });
            }
        },
        handleImage(e, key) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.$store.commit("open_days/setState", {
                        key,
                        value: res?.data,
                    });
                });
        },
    },
    created() {
        this.fetchOpenDay();
        console.log(this.form);
    },
};
</script>
