<template>
    <!-- <div class="relative tooltip -bottom-4 group-hover:flex" v-if="validationErros.has(fieldName)">
        <div role="tooltip" class="relative tooltiptext -top-2 wfull z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-primary text-gray-600 w_full md:w_half rounded "  :class="full_width ? 'w-full' : 'w-1/2'">
                -- <svg class="relative top-0 -mt-4" width="16px" height="8px" viewBox="0 0 16 8" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Tooltips-" transform="translate(-93.000000, -355.000000)" fill="#b1040e">
                            <g id="Group-3-Copy-3" transform="translate(76.000000, 331.000000)">
                                <polygon id="Triangle" transform="translate(25.000000, 28.000000) rotate(-360.000000) translate(-25.000000, -28.000000) " points="25 24 33 32 17 32"></polygon>
                            </g>
                        </g>
                    </g>
                </svg> --
                <p class="text-white leading-none text-sm lg:text-base">{{validationErros.get(fieldName)}}</p>
            </div>
    </div> -->
    <div v-if="validationErros.has(fieldName)">
        <p class="mt-2 text-base text-primary">{{validationErros.get(fieldName)}}</p>
    </div>
</template>

<script>
export default {
    props:['validationErros', 'fieldName','full_width'],
    mounted(){
    }
}
</script>
