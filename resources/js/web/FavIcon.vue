<template>
  <div class="relative">
    <div class="peer p-1" @click="addToFav">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-5 md:w-6 h-5 md:h-6 cursor-pointer text-primary"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
        />
      </svg>
    </div>

    <div class="relative tooltip -bottom-4 group-hover:flex hidden peer-hover:flex">
      <div
        role="tooltip"
        class="absolute tooltiptext_icon1 after:right-1.5 right-0 -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-red-100 border border-primary text-gray-600 rounded w-48 px-4"
      >
        <p class="text-primary font-semibold leading-none text-sm lg:text-base">
          {{ tooltiptext }}
        </p>
      </div>
    </div>

    <!-- Modal -->
    <transition name="slide">
      <div
        v-if="showModal"
        class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full" @click.self="showModal = false"
      >
        <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto">
          <div class="py-6 px-10 text-center">
            <div class="absolute top-3 right-3 cursor-pointer" @click="showModal = false">
              <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                  <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                  </svg>
              </button>
            </div>
            <p class="text-center can-edu-p mt-2">
              {{ modalMessage }}
            </p>
            <div class="flex justify-center">
            <button
              type="button"
              class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
              @click="showModal = false"
            >
              Close
            </button>
          </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: ["model", "record_id", "is_favourit", "tooltiptext"],
  data() {
    return {
      showModal: false,
      modalMessage: "",
    };
  },
  methods: {
    addToFav() {
      let dataToSend = {
        model: this.model,
        record_id: this.record_id,
      };
      let url = `${process.env.MIX_WEB_API_URL}add-to-favorite`;
      console.log("API URL:", url);


      axios
        .post(url, dataToSend)
        .then((res) => {
          if (res.data.status == "Success") {
            // window.location.reload();
            this.modalMessage = res.data.message;
          } else {
            this.modalMessage = res.data.message;
          }
          this.showModal = true;
        })
        .catch((error) => {
          if (error.response && error.response.status == 422) {
            this.modalMessage = "Validation error. Please check your input.";
          } else if (
            error.response &&
            error.response.data &&
            error.response.data.status == "Error"
          ) {
            this.modalMessage = error.response.data.message;
          } else {
            this.modalMessage = "An error occurred. Please try again.";
          }
          this.showModal = true;
        });
    },
  },
  mounted() {
    console.log(this.model, this.record_id, this.is_favourit);
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
