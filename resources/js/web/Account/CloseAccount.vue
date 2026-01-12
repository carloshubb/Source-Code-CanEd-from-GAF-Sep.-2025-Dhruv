<template>
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full">
        <h2 class="px-4 pt-4 can-school-h2 text-primary">Close my account</h2>
        <div class="p-4">
            <textarea
                rows="2"
                class="mt-2 mb-5 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder="Please help us improve by telling us why you are closing your account. This is optional, but we will appreciate your input as it helps us provide better services to your fellow students"
            ></textarea>
            <div class="md:col-span-8 col-span-12 flex justify-center items-center mt-4">
                <button @click="showFirstModal = true" class="can-edu-btn-fill">Close my account</button>
            </div>
        </div>
    </div>

    <!-- First Confirmation Modal -->
    <transition name="slide">
        <div v-if="showFirstModal" class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4"
            @click.self="showFirstModal = false">
            <div class="relative w-full max-w-lg bg-white py-6 px-10 rounded shadow-lg text-center">
                <div class="absolute top-3 right-3 cursor-pointer" @click="showFirstModal = false">
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                        <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-center text-lg font-semibold mt-4">Are you sure?</p>
                <p class="text-center text-sm text-gray-600">You won't be able to revert this!</p>
                <div class="mt-4 flex justify-center gap-4">
                    <button class="can-edu-btn-fill bg-gray-300 text-black" @click="showFirstModal = false">Go back</button>
                    <button class="can-edu-btn-fill" @click="deleteAccount">Yes, close it</button>
                </div>
            </div>
        </div>
    </transition>

    <!-- Final Confirmation Modal -->
    <!-- <transition name="slide">
        <div v-if="showFinalModal" class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4"
            @click.self="showFinalModal = false">
            <div class="relative w-full max-w-lg bg-white py-6 px-10 rounded shadow-lg text-center">
                <div class="absolute top-2 right-2 cursor-pointer" @click="showFinalModal = false">
                    <svg class="fill-current h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M14.348 14.849a1 1 0 0 1-1.415 0L10 11.415l-2.933 2.934a1 1 0 1 1-1.415-1.415l2.934-2.933L5.651 7.068a1 1 0 1 1 1.415-1.415L10 8.585l2.933-2.934a1 1 0 0 1 1.415 1.415l-2.934 2.933 2.934 2.933a1 1 0 0 1 0 1.415z" />
                    </svg>
                </div>
                <p class="text-center text-lg font-semibold">Account Closed</p>
                <p class="text-center text-sm text-gray-600">
                    Your account has been closed. Please accept our best wishes. Farewell.
                </p>
                <div class="mt-4 flex justify-center">
                    <button class="can-edu-btn-fill" @click="redirectToHome">Close</button>
                </div>
            </div>
        </div>
    </transition> -->
    <transition name="slide">
        <div v-if="showFinalModal" class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4"
            @click.self="redirectToHome">  <!-- Clicking outside redirects to home -->
            <div class="relative w-full max-w-lg bg-white py-6 px-10 rounded shadow-lg text-center">
                <div class="absolute top-3 right-3 cursor-pointer" @click="redirectToHome">  <!-- Clicking X redirects to home -->
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                        <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-center text-lg font-semibold mt-4">Account Closed</p>
                <p class="text-center text-sm text-gray-600">
                    Your account has been closed. Please accept our best wishes. Farewell.
                </p>
                <div class="mt-4 flex justify-center">
                    <button class="can-edu-btn-fill" @click="redirectToHome">Close</button>  <!-- Clicking button redirects to home -->
                </div>
            </div>
        </div>
    </transition>
    
</template>

<script>
import axios from "axios";

export default {
    props: ["logged_in_customer"],
    data() {
        return {
            showFirstModal: false,
            showFinalModal: false,
        };
    },
    methods: {
        deleteAccount() {
            this.showFirstModal = false; // Close the first modal
            axios
                .post(`${process.env.MIX_WEB_API_URL}delete-account`, {
                    customer_id: this.logged_in_customer,
                })
                .then((res) => {
                    if (res.data.status === "Success") {
                        this.showFinalModal = true; // Show final confirmation modal
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        redirectToHome() {
            window.location.href = "/";
        },
    },
};
</script>
<style scoped>
/* Slide Animation */
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}
.slide-enter-from, .slide-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>