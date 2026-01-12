<template>
    <div class="tab-content tab-space">
        <div class="block" id="tab-chat">
            <div>
                <div class="flex-1 justify-between flex flex-col h-screen border rounded" :class="messages.length > 0?  'h-full' :'max-h-[40rem]'">
                    <div class="flex flex-initial sm:items-center justify-between py-3 border-b-2 border-gray-200 px-4">
                        <div class="relative flex items-center space-x-4">
                            <div class="relative">
                                <img :src="app_url + '/admin.jpeg'" alt=""
                                    class="w-10 sm:w-14 h-10 sm:h-14 rounded-full" />
                            </div>
                            <!-- <div class="flex flex-col leading-tight">
                                <div class="text-lg mt-1 flex items-center">
                                    <span class="text-gray-700 mr-3">
                                        Administration
                                    </span>
                                </div>
                                <span
                                    class="font-semibold text-sm leading-5 text-gray-600"
                                    >admin</span
                                >
                            </div> -->
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- <button
                                type="button"
                                class="inline-flex items-center justify-center h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                                    />
                                </svg>
                            </button> -->
                        </div>
                    </div>

                    <div id="messages"
                        class="flex flex-col flex-auto space-y-4 p-3 bg-gray-100 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch "
                        :class="messages.length > 0?  'h-full' :'max-h-96'"
                        >
                        <div class="flex justify-center">
                            <div
                                class="w-full md:w-11/12 text-center bg-amber-100 border rounded-full mx-auto px-3 py-1.5 flex items-start justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="text-gray-600 text-xs md:text-sm font-medium text-center">
                                    Messages you send to this chat are secure and confidential. We never share your
                                    information with anyone other the the employees and partners who will offer you the
                                    services that you ask for
                                </p>
                            </div>
                        </div>
                        <div v-for="message in messages" :key="message.id" class="chat-message">
                            <div :class="message?.type == 'admin'
                                    ? 'flex items-start'
                                    : 'flex items-start justify-end'
                                ">
                                <div :class="message?.type == 'admin'
                                        ? 'flex flex-col space-y-2 text-sm font-medium max-w-lg mx-2 order-2 items-start'
                                        : 'flex flex-col space-y-2 text-sm font-medium max-w-lg mx-2 order-1 justify-end'
                                    ">
                                    <div :class="message?.type == 'admin'
                                            ? 'bg-white px-4 py-2 rounded-lg inline-block text-gray-600'
                                            : 'px-4 py-2 rounded-lg bg-blue-600 text-white'
                                        ">
                                        <div class="mb-3" style="white-space: pre-wrap;">{{ message.message }}</div>

                                        <time>{{ message.created_at }}</time>
                                    </div>
                                </div>
                                <!-- <img
                                    :src="
                                         message.type == 'customer'
                                            ? message?.conversation?.customer
                                                  ?.image
                                            : app_url+'/admin.jpeg'
                                    "
                                    alt="My profile"
                                    :class="
                                        message.type == 'admin'
                                            ? 'w-6 h-6 rounded-full order-1'
                                            : 'w-6 h-6 rounded-full order-2'
                                    "
                                /> -->
                                <img
                                :src="
                                  message.type == 'customer'
                                    ? message?.conversation?.customer?.image || 'https://www.w3schools.com/howto/img_avatar.png'
                                    : app_url + '/admin.jpeg'
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
                    <div class="flex-initial border-t-2 border-gray-300 p-1.5 mb-2 sm:mb-0">
                        <!-- <div class="relative flex">
                            <form @submit.prevent="saveMessage" class="w-full">
                                <input
                                    type="text"
                                    required
                                    v-model="message"
                                    placeholder="Type your message here. Remember, be as detailed as possible"
                                    class="w-full focus:outline-none border-0 focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-4 bg-white py-2"
                                />
                                <div
                                    class="absolute right-0 items-center inset-y-0 hidden sm:flex"
                                >
                                    <button
                                        type="submit"
                                        class="can-edu-btn-fill"
                                    >Send message
                                    </button>
                                </div>
                            </form>
                        </div> -->
                        <div class="relative flex">
                            <form @submit.prevent="saveMessage" class="w-full">
                                <textarea required v-model="message"
                                    placeholder="Type your message here. Remember, be as detailed as possible"
                                    class="w-full focus:outline-none border-0 mb-8 focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-4 bg-white py-2 resize-none"
                                    rows="6"></textarea>
                                <div class="absolute right-0 items-end inset-y-0 hidden sm:flex mr-4 ">
                                    <button type="submit" class="can-edu-btn-fill">Send message</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ErrorHandling from "../ErrorHandling";
export default {
    props: ["customer_id", "app_url", "loggedInCustomer"],
    data() {
        return {
            messages: [],
            message: "",
            type: "customer",
            customer: null,
            errors: new ErrorHandling(),
        };
    },
    methods: {
        saveMessage() {
            axios
                .post("/api/web/proxima-save-message", {
                    customer_id: this.customer_id,
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
                    console.log(error);
                })
                .finally(() => (this.$parent.loading = false));
        },
        fetchMessages() {
            axios
                .post("/api/web/proxima-messages", {
                    customer_id: this.customer_id,
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
                    console.log(error);
                })
                .finally(() => (this.$parent.loading = false));
        },
    },
    created() {
        this.fetchMessages();
        Echo.channel("my-channel").listen(
            ".my-event",
            (data) => {
                this.fetchMessages();
            }
        );
    },
};
</script>
