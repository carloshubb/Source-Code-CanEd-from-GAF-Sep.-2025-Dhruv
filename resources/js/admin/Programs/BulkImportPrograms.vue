<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <!-- <div
            v-if="showPopup"
            class="fixed top-4 right-4 bg-blue-600 text-white py-2 px-4 rounded-lg shadow-lg transition-opacity duration-500 mt-9"
            style="z-index: 50;"
        >
            File uploaded successfully!
        </div> -->
        <header class="">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">Programs bulk upload</h1>
                </div>
            </div>
        </header>
        <form
            class="px-4 md:px-6 lg:px-8"
            action="/upload-programs"
            method="POST"
            enctype="multipart/form-data"
        >
            <input type="hidden" name="_token" v-bind:value="csrf" />
            <input
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                name="excel_file"
                type="file"
                id="fileUpload"
                accept=".xls,.xlsx"
                @change="uploadFile($event)"
            />
            <br />
            <button
                class="mt-5 can-edu-btn-fill mb-2"
                type="submit"
                id="uploadExcel"
                :disabled="!files"
                @click="popup"
            >
                Import
            </button>
        </form>
        </div>
    </AppLayout>
</template>

<script>
import { mapState } from "vuex";
import Swal from "sweetalert2";
export default {
    data(){
          return {
            //csrf token
             csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
             files:null,
            //  showPopup: false,
       }
    },
    methods:{
        uploadFile(e) {
        this.files = e.target.files[0];
        // if (this.files) {
        //         this.showPopup = true;
        //         setTimeout(() => {
        //             this.showPopup = false;
        //         }, 3000);
        //     }
      },
      popup(){
        if (this.files) {
                Swal.fire({
                    toast: true,
                    position: "top-right",
                    showConfirmButton: false,
                    showCloseButton: true,
                    timer: 5000,
                    background: "rgb(220 252 231)",
                    timerProgressBar: true,
                    customClass: {
                        title: "swalSuccessClass",
                        htmlContainer: "swalSuccessClass",
                    },
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                    text: "File imported successfully!",
                });
            }
      }

    }
};
</script>
