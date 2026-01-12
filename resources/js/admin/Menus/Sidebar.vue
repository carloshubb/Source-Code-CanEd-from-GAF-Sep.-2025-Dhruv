<template>
    <div>
        <div>
            <h2 class="can-edu-h2">Pages</h2>
        </div>
        <div class="h-40 overflow-y-auto border rounded p-4 mt-2">
            <ul v-for="page in pages" :key="page.id" class="space-y-2">
                <li class="gap-2 items-center flex">
                    <input type="checkbox" name="pages" @click="updateSelectedPages($event.target.checked, page)"
                        :id="`page_${page.id}`"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" />
                    <label
                        :for="`page_${page.id}`">{{ page . page_detail && page . page_detail[0] ? page . page_detail[0] . name : '' }}</label>
                </li>
            </ul>
        </div>
        <div class="flex justify-end mt-2">
            <button type="button" class="can-edu-btn-fill" @click.prevent="addToMenu()">Add to menu</button>
        </div>
        <div>
            <h2 class="can-edu-h2">Custom links</h2>
        </div>
        <div class="grid md:grid-cols-1 md:gap-2">
            <div class="relative z-0 w-full group mt-2">
                <label for="link">Link</label>
                <input type="link" name="link" id="link"
                    class="w-full focus:ring-primary  border focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                    placeholder=" " v-model="custom_link" />
            </div>
            <div class="relative z-0 w-full group mt-2">
                <label for="name">Name</label>
                <input type="text" name="name" id="name"
                    class="w-full focus:ring-primary  border focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                    placeholder=" " v-model="custom_name" />
            </div>
        </div>
        <div class="flex justify-end mt-2">
            <button type="button" class="can-edu-btn-fill" @click.prevent="addNewItemInMenu">Add to menu</button>
        </div>
    </div>
</template>
<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            pages: (state) => state.pages.pages,
        })
    },
    data(){
        return {
            selectedPages: [],
            custom_name: null,
            custom_link: null,
        }
    },
    created(){
        this.selectedPages = [];
        this.custom_name = null;
        this.custom_link = null;
    },
    methods:{
        updateSelectedPages(value, page){
            if(value){
                this.selectedPages.push({
                    id:Math.floor(Math.random() * 1000000),
                    page_id:page.id,
                    name:page.page_detail[0].name,
                    slug:`${page.slug}`,
                });
            }
            else{
                this.selectedPages.map((res, index) => {
                    if(res.page_id == page.id){
                        // delete res[index]
                        this.selectedPages.splice(index, 1);
                        return true;
                    }
                });
            }
        },
        addToMenu(){
            this.selectedPages.map(res => {
                this.$emit('addMenuItem', res.id, res.page_id, res.name, res.slug)
            });
            document.querySelectorAll('input[name=pages]').forEach(el => el.checked = false);
            this.selectedPages = []
        },
        addNewItemInMenu(){
            if(this.custom_name == null || this.custom_name == '' || this.custom_link == null || this.custom_link == ''){
                helper.swalErrorMessage("Name and link is required.");
                return false;
            }
            this.$emit('addMenuItem', Math.floor(Math.random() * 1000000), null, this.custom_name, this.custom_link)
        }
    }
};
</script>