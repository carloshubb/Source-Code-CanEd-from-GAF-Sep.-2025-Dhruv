<template>
    <div class="tab-content tab-space">
        <div class="block" id="tab-chat">
            <div>
                <h1 class="mb-5 text-gray-900 font-bold text-3xl">Chat</h1>
                <!-- component -->
                <div class="flex-1 justify-between flex flex-col h-screen border rounded ">
                    <div class="flex flex-initial sm:items-center justify-between py-3 border-b-2 border-gray-200 px-4">
                        <div class="relative flex items-center space-x-4 cursor-pointer" @click="redirectToChats">
                            <div class="relative">
                                <img :src="ambassador?.image ? ambassador?.image : ''" alt=""
                                    class="w-10 sm:w-14 h-10 sm:h-14 rounded-full" />
                            </div>
                            <div class="flex flex-col leading-tight">
                                <div class="text-lg mt-1 flex items-center">
                                    <span class="text-gray-700 mr-3">
                                        {{
                                            ambassador?.school_ambassador_detail &&
                                                ambassador?.school_ambassador_detail?.length > 0
                                                ? ambassador?.school_ambassador_detail[0].name
                                                : ""
                                        }}
                                    </span>
                                </div>
                                <span class="font-semibold text-sm leading-5 text-gray-600">
                                    {{ ambassador?.category ? ambassador?.category : "" }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div id="messages"
                        class="flex flex-col flex-auto space-y-4 p-3 bg-gray-100 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                        <div class="flex justify-center">
                            <div
                                class="w-full md:w-3/5 bg-amber-100 border rounded-full mx-auto px-3 py-1.5 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4 mr-1">
                                    <path fill-rule="evenodd"
                                        d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="text-gray-600 text-xs md:text-sm font-medium">
                                    Messages you send to this chat are secure and confidential. We never share your
                                    information with anyone other the the employees and partners who will offer you the
                                    services that you ask for
                                </p>
                            </div>
                        </div>

                        <!-- Grouped Messages by Date -->
                        <div v-for="(messages, date) in groupedMessages" :key="date">
                            <div class="flex justify-center items-center">
                                <!-- <p class="text-gray-600">{{ formatDate(date) }}</p> -->
                                <p class="text-gray-600">{{ date }}</p>
                            </div>
                            <div v-for="message in messages" :key="message.id" class="chat-message">
                                <div
                                    :class="message?.type == 'ambassador' ? 'flex items-start' : 'flex items-start justify-end'">
                                    <div :class="message?.type == 'ambassador'
                                            ? 'flex flex-col space-y-2 text-sm font-medium max-w-lg mx-2 order-2 items-start'
                                            : 'flex flex-col space-y-2 text-sm font-medium max-w-lg mx-2 order-1 justify-end'
                                        ">
                                        <div :class="message?.type == 'ambassador'
                                                ? 'bg-white px-4 py-2 rounded-lg inline-block text-gray-600'
                                                : 'px-4 py-2 rounded-lg bg-blue-600 text-white'
                                            ">
                                            <div class="mb-3">{{ message.message }}</div>
                                            <time>{{ message.created_at }}</time>
                                        </div>
                                    </div>
                                    <img :src="message.type == 'customer'
                                            ? message?.conversation?.customer?.image
                                            : message?.conversation?.school_ambassador?.image
                                        " alt="My profile" :class="message.type == 'ambassador'
                                                ? 'w-6 h-6 rounded-full order-1'
                                                : 'w-6 h-6 rounded-full order-2'
                                            " />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-initial border-t-2 border-white p-1.5 mb-2 sm:mb-0">
                        <div class="relative flex">
                            <form @submit.prevent="saveMessage" class="w-full">
                                <textarea rows="2" type="text" required v-model="message" placeholder="Type here..."
                                    class="w-full focus:outline-none border-0 mb-8 focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-4 bg-white py-2 resize-none" />
                                <div class="absolute right-0 items-end inset-y-0 hidden sm:flex">
                                    <button type="submit"
                                        class="can-edu-btn-fill">
                                        Send
                                    </button>
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
    props: ["ambassador_id", "ambassador_object", "default_lang"],
    data() {
        return {
            messages: [],
            message: "",
            type: "customer",
            ambassador: null,
            errors: new ErrorHandling(),
        };
    },
    computed: {
        // Group messages by date
        groupedMessages() {
            return this.messages.reduce((acc, message) => {
                const date = message.created_at.split('T')[0]; // Extract date part (YYYY-MM-DD)
                if (!acc[date]) {
                    acc[date] = [];
                }
                acc[date].push(message);
                return acc;
            }, {});
        },
    },
    methods: {
        redirectToChats() {
            window.location.href = `/${this.default_lang}/my-ambassadors`
        },
        saveMessage() {
            axios
                .post("/api/web/save-message", {
                    ambassador_id: this.ambassador_id,
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
                .post("/api/web/messages", {
                    ambassador_id: this.ambassador_id,
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
        formatDate(date) {
            // Format date as "Jun 9, 2023"
            console.log('date', date)
            return new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
            });
        },
        formatTime(dateTime) {
            // Format time as "10:00 AM"
            return new Date(dateTime).toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
            });
        },
    },
    created() {
        this.ambassador = this?.ambassador_object ? JSON.parse(this.ambassador_object) : {};
        this.fetchMessages();
        Echo.channel("my-channel").listen(".my-event", (data) => {
            this.fetchMessages();
        });
        console.log(this.messages)

    },
};
</script>

<style scoped>
/* Add any custom styles here */
</style>