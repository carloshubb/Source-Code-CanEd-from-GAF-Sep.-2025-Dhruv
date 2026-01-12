<template>
    <div class="modal-content py-6 text-left px-6">
        <div class="flex justify-between items-center pb-3">
            <h2 class="can-school-h2 text-primary">Update password</h2>
        </div>
        <div class="modal-body">
            <div class="w-full mt-2 relative">
                <label for="" class="text-gray-700 font-semibold text-sm lg:text-base">Current password</label>
                <input type="text" placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="old_password" />
                <error :fieldName="`old_password`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label for="" class="text-gray-700 font-semibold text-sm lg:text-base">New password</label>
                <textarea rows="2"
                    placeholder="Your password must be at least 8 characters including a lowercase letter, an uppercase letter, a number, and a special character"
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="new_password" ></textarea>
                <error :fieldName="`new_password`" :validationErros="errors" />
            </div>
            <div class="w-full mt-2 relative">
                <label for="" class="text-gray-700 font-semibold text-sm lg:text-base">Confirm new password</label>
                <textarea rows="2"
                    placeholder="Your password must be at least 8 characters including a lowercase letter, an uppercase letter, a number, and a special character"
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="confirm_new_password" ></textarea>
                <error :fieldName="`confirm_new_password`" :validationErros="errors" />
            </div>
            <div class="flex justify-center items-center gap-3 mt-4">
                <div>
                    <button class="can-edu-btn-fill" @click="addUpdate">
                        Update password
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import ErrorHandling from "../../ErrorHandling";
import Error from "../Error.vue";
export default
    {
        components: { Error },
        data() {
            return {
                old_password: "",
                new_password: "",
                confirm_new_password: '',
                errors: new ErrorHandling(),
            };
        },
        methods: {
            addUpdate() {
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

                this.errors = new ErrorHandling();

                if (!passwordRegex.test(this.new_password)) {
                    this.errors.record({
                        new_password: ['Password must be at least 8 characters including a lowercase letter, an uppercase letter, a number, and a special character']
                    });
                    return;
                }
                if (this.new_password !== this.confirm_new_password) {
                    this.errors.record({ confirm_new_password: ['Passwords do not match'] });
                    return;
                }

                var data = {
                    old_password: this.old_password,
                    new_password: this.new_password,
                };
                axios
                    .post("/api/web/update-password", data)
                    .then((res) => {
                        this.errors = new ErrorHandling();
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            window.location.reload();
                        } else {
                            helper.swalErrorMessage(res.data.message);
                        }
                    })
                    .catch((error) => {
                        if (error.response && error.response.status == 422) {
                            helper.swalErrorMessage(error.response.data.message);
                            this.errors.record(error.response.data.errors);
                        } else if (error.response && error.response.data && error.response.data.status == "Error") {
                            helper.swalErrorMessage(error.response.data.message);
                        }
                    });
            },
        },
        watch: {
            new_password() {
                this.errors.clear('new_password');
            },
            confirm_new_password() {
                this.errors.clear('confirm_new_password');
            },
        },
    };
</script>
