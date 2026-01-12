<template>
    <div
        class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full"
    >
        <div class="mt-4 flex justify-between items-center gap-2 p-2">
            <p class="px-4 can-edu-h1">Webinar Setting</p>
        </div>
        <div class="mt-6 w-full md:w-8/12 ml-4">
            <p class="p-3">
                <b
                    >Creating a server-side app on Zoho and obtaining a Client
                    ID and Client Secret involves several steps. Zoho provides
                    an OAuth 2.0-based authentication mechanism for this
                    purpose. Here's a step-by-step guide to creating a
                    server-side app and getting the required credentials:</b
                >
            </p>
            <p class="p-3"><b>Sign in to Zoho Developer Console:</b></p>

            <p class="p-3">
                Visit the Zoho Developer Console at
                <a href="https://accounts.zoho.com/developerconsole"
                    >https://accounts.zoho.com/developerconsole</a
                >
                and sign in with your Zoho account credentials.
            </p>

            <p class="p-3"><b>Create a New Client:</b></p>

            <p class="p-3">Click on the "My Applications" tab.</p>
            <p class="p-3">
                Click the "Add Client" button and choose
                <b>Server-based Applicaton</b>. Provide Client Details:
            </p>

            <p class="p-3">
                <b>Fill out the details for your server-side app:</b>
            </p>

            <p class="p-3">Client Name: Give your app a name.</p>
            <p class="p-3">
                Authorized Redirect URIs: Enter the {{ redirect_url }} where
                Zoho will redirect users after they authorize your app. and home
                page uri will be {{ home_page_url }}
            </p>
            <p class="p-3"><b>Choose Authentication Type:</b></p>

            <p class="p-3">
                Select the "Server-based Applications" option since you're
                creating a server-side app.
            </p>

            <p class="p-3"><b>Save the Client:</b></p>

            <p class="p-3">
                Click the "Create" button to create the client. Zoho will
                generate a Client ID and Client Secret for your app.
            </p>
            <p>
                make sure user is an adminstrater by following
                <a href="https://meeting.zoho.com/"
                    >https://meeting.zoho.com/</a
                >
            </p>
            <p><b>To set up IP restrictions or allow specific IP addresses in Zoho</b></p>
            <p>
                Log in to your Zoho account as an administrator. Navigate to the
                settings or security section of the specific Zoho service you
                want to configure IP restrictions for. Look for an option
                related to IP restrictions, IP whitelisting, or security
                settings. Add the IP addresses or IP address ranges that you
                want to allow access to your Zoho service. You may need to enter
                these addresses manually. Save your changes.
            </p>
            <div class="relative">
                <input
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    placeholder="Zoho client id *"
                    v-model="client_id"
                />
                <div class="z-10 bottom-12 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="errors.has('client_id')"
                        v-text="errors.get('client_id')"
                    ></p>
                </div>
            </div>

            <div class="relative">
                <input
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    placeholder="Zoho client id *"
                    v-model="client_secret"
                />
                <div class="z-10 bottom-12 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="errors.has('client_secret')"
                        v-text="errors.get('client_secret')"
                    ></p>
                </div>
            </div>

            <button
                class="mt-4 can-edu-btn-fill"
                :class="loading ? 'bg-opacity-20' : ''"
                @click="addUpdate"
                :disabled="loading"
            >
                Save
            </button>
            <br /><br />
        </div>
    </div>
</template>

<script>
import ErrorHandling from "../../../ErrorHandling";
import Swal from "sweetalert2";
export default {
    props: [
        "school_ambassador_id",
        "zoho_client_id",
        "zoho_client_secret",
        "redirect_url",
        "home_page_url",
    ],
    data() {
        return {
            client_id: "",
            client_secret: "",
            errors: new ErrorHandling(),
        };
    },
    methods: {
        handleInput(e, key, language) {
            this[key] = e.target.value;
        },
        addUpdate() {
            console.log(this.client_id);
            console.log(this.client_secret);
            let dataToSend = {
                client_id: this.client_id,
                client_secret: this.client_secret,
                school_ambassador_id: this.school_ambassador_id,
            };
            axios
                .post(
                    `${process.env.MIX_WEB_API_URL}webinar-setting`,
                    dataToSend
                )
                .then((res) => {
                    console.log(res?.data);
                    if (res?.data?.status == "Success") {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your credentials are saved",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                    }
                })
                .catch((error) => {
                    this.errors = new ErrorHandling();
                    if (error.response.status == 422) {
                        if (error.response.data.status == "Error") {
                            this.$toaster.error(error.response.data.message);
                        } else {
                            this.errors.record(error.response.data.errors);
                        }
                    }
                })
                .finally(() => (this.$parent.loading = false));
        },
    },
    created() {
        this.client_id = this.zoho_client_id;
        this.client_secret = this.zoho_client_secret;
    },
};
</script>
