<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
        <header class="">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">Business categories bulk upload</h1>
                </div>
            </div>
        </header>
        <form
            class="px-4 md:px-6 lg:px-8"
            action="/upload-business-category"
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
            <button
                class="mt-8 can-edu-btn-fill mb-2"
                type="submit"
                id="uploadExcel"
                :disabled="files == null"
            >
            Import
            </button>
        </form>
        </div>
    </AppLayout>
</template>

<script>
import { mapState } from "vuex";
export default {
    data(){
          return {
            //csrf token
             csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
             files:null
       }
    },
    methods:{
        uploadFile(e) {
        this.files = e.target.files[0];
      },
    }
};
</script>
