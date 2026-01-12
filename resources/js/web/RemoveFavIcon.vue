<template>
    <div class="absolute top-2 right-2">
        <div class="cursor-pointer peer border border-primary rounded-full p-0.5" @click="addToFav">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-3.5 h-3.5 text-primary">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </div>
    </div>
</template>

<script>
export default {
    // props: ["model", "record_id", "is_favourit", "tooltiptext"],
    props: ["model", "record_id"],
    methods: {
        addToFav() {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Go back",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                    
                        let dataToSend = {
                model: this.model,
                record_id: this.record_id,
            };
            let url = `${process.env.MIX_WEB_API_URL}add-to-favorite`;

            axios
                .post(url, dataToSend)
                .then((res) => {
                    if (res.data.status == "Success") {
                        window.location.reload();
                        helper.swalSuccessMessage(res.data.message);
                    } else {
                        helper.swalErrorMessage(res.data.message);
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status == 422) {
                        this.errors.record(error.response.data.errors);
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessage(error.response.data.message);
                    }
                })
                .finally();
                    }
                });  
        },
    },
    mounted() {
        console.log(this.model, this.record_id, this.is_favourit);
    },
};
</script>