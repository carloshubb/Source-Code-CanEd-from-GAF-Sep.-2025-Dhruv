<template>
    <AppLayout>
        <div class="relative shadow-md sm:rounded-lg bg-white">
        <header class=" py-3">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">Chat</h1>
                    <router-link
                        :to="{ name: 'admin.proxima_requests.index' }"
                        class="can-edu-btn-fill"
                    >
                        Back
                    </router-link>
                </div>
            </div>
        </header>

        <div
            id="messages"
            class="flex flex-col flex-auto space-y-4 p-3 bg-gray-100 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch"
        >
            <div class="flex justify-center">
                <div
                    class="w-full md:w-3/5 bg-amber-100 border rounded-full mx-auto px-3 py-1.5 flex items-center justify-center"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="w-4 h-4 mr-1"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <p class="text-gray-600 text-xs md:text-sm font-medium">
                        Messages you send to this chat are secure and kept
                        anonymised.
                    </p>
                </div>
            </div>
            <div class="flex justify-center items-center">
                <p class="text-gray-600">Jun 9, 2023</p>
            </div>
            <div
                v-for="message in messages"
                :key="message.id"
                class="chat-message"
            >
                <div
                    :class="
                        message?.type == 'admin'
                            ? 'flex items-start'
                            : 'flex items-start justify-end'
                    "
                >
                    <div
                        :class="
                            message?.type == 'admin'
                                ? 'flex flex-col space-y-2 text-sm font-medium max-w-lg mx-2 order-2 items-start'
                                : 'flex flex-col space-y-2 text-sm font-medium max-w-lg mx-2 order-1 justify-end'
                        "
                    >
                        <div
                            :class="
                                message?.type == 'admin'
                                    ? 'bg-white px-4 py-2 shadow-lg rounded-lg inline-block text-gray-600'
                                    : 'px-4 py-2 rounded-lg shadow-lg bg-blue-600 text-white'
                            "
                        >
                            <div class="mb-3">
                                {{ message.message }}
                            </div>
                            <time>{{ message.created_at }}</time>
                        </div>
                    </div>
                    <img
                        :src="
                            message.type == 'customer'
                                ? message?.conversation?.customer?.image
                                : '/admin.jpeg'
                        "
                        alt="My profile"
                        :class="
                            message.type == 'admin'
                                ? 'w-6 h-6 rounded-full order-1'
                                : 'w-6 h-6 rounded-full order-2'
                        "
                    />
                </div>
            </div>
        </div>
        <div class="flex-initial border-t-2 border-white p-1.5 mb-2 py-3 sm:mb-0">
            <div class="relative flex">
                <form @submit.prevent="saveMessage" class="w-full">
                    <input
                        type="text"
                        required
                        v-model="message"
                        placeholder="Type here..."
                        class="w-full focus:outline-none border-0 focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 placeholder:font-medium pl-4 bg-white py-2"
                    />
                    <div
                        class="absolute right-0 items-center inset-y-0 hidden sm:flex"
                    >
                        <button
                            type="submit"
                            class="inline-flex rounded px-6 py-1.5 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none"
                        >
                            <span class="font-bold">Send</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </AppLayout>
</template>
<script>
import ErrorHandling from "../../ErrorHandling";
export default {
    data() {
        return {
            messages: [],
            message: "",
            type: "admin",
            errors: new ErrorHandling(),
        };
    },
    methods: {
        saveMessage() {
            axios
                .post("/api/admin/proxima-save-message", {
                    customer_id: this.$route.params.id,
                    message: this.message,
                    type: this.type,
                })
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.messages.push(res.data.data);
                        this.message = "";
                        setTimeout(() => {
                            var objDiv = document.getElementById("messages");
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }, 200);
                    }
                })
                .catch((error) => {
                })
                .finally(() => (this.$parent.loading = false));
        },
        fetchMessages() {
            axios
                .post("/api/admin/proxima-messages", {
                    customer_id: this.$route.params.id,
                })
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.messages = res.data.data;
                        setTimeout(() => {
                            var objDiv = document.getElementById("messages");
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }, 1000);
                    }
                })
                .catch((error) => {
                })
                .finally(() => (this.$parent.loading = false));
        },
    },
    created(){
        this.fetchMessages();
    }
};
</script>
