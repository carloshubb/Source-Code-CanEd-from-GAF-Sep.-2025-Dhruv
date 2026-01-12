<template>
    <button :disabled="loader" :class="loader ? 'bg-gray-300 text-lg font-FuturaMdCnBT rounded p-2 px-5 text-white whitespace-nowrap' : 'can-edu-btn-fill'" @click="synchWebinars()">
        Synch Webinars 
    </button>
</template>

<script>
import axios from 'axios';
export default {
    data(){
        return{
            loader:false,
        }
    },
    methods: {
        synchWebinars() {
            this.loader = true;
            let url = `${process.env.MIX_WEB_API_URL}synch-webinars`;
            axios.get(url).then((res) => {
                if (res.data.status == "Success") {
                    helper.swalSuccessMessage(res.data.message);
                    window.location.reload();
                } else if (res.data.status == "Error") {
                    this.loader = false;
                    helper.swalErrorMessage(res.data.message);
                }
            });
        },
    },
};
</script>
