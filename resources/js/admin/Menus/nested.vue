<template>
  <draggable class="dragArea ml-2" tag="ul" :list="menus" :group="{ name: 'g1' }" item-key="id">
      <template #item="{ element }">
          <li class="bg-white p-2 border border-gray-500 rounded cursor-move mt-2">
              <div class="flex justify-between items-center">
                  <p>
                      {{ element . name }}
                  </p>
                  
                  <div class="flex justify-between">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                          class="w-5 h-5 cursor-pointer" @click.prevent="updateCurrentId(element.id)"
                          v-if="currnetItemId != element.id || currnetItemId == null">
                          <path fill-rule="evenodd"
                              d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z"
                              clip-rule="evenodd" />
                      </svg>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                          class="w-5 h-5 cursor-pointer" v-else @click.prevent="updateCurrentId(null)">
                          <path fill-rule="evenodd"
                              d="M11.47 7.72a.75.75 0 011.06 0l7.5 7.5a.75.75 0 11-1.06 1.06L12 9.31l-6.97 6.97a.75.75 0 01-1.06-1.06l7.5-7.5z"
                              clip-rule="evenodd" />
                      </svg>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                          class="w-5 h-5 cursor-pointer" @click="deleteMenuItem(element.id)">
                          <path fill-rule="evenodd"
                              d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                              clip-rule="evenodd" />
                      </svg>
                  </div>
              </div>
              <div v-if="currnetItemId == element.id" class="border mt-2 rounded p-3 shadow">
                  <div class="grid md:grid-cols-1 md:gap-2">
                      <div class="relative z-0 w-full group mt-2">
                          <label for="link">Link</label>
                          <input type="link" name="link" id="link"
                              class="can-edu-input w-full block border border-gray-300 rounded"
                              placeholder=" " :value="element.link"
                              @input="updateMenuItem(element, $event.target.value, 'link')" />
                      </div>
                      <div class="relative z-0 w-full group mt-2">
                          <label for="name">Name</label>
                          <input type="text" name="name" id="name"
                              class="can-edu-input w-full block border border-gray-300 rounded"
                              placeholder=" " :value="element.name"
                              @input="updateMenuItem(element, $event.target.value, 'name')" />
                      </div>
                  </div>
              </div>
              <nested-draggable :menus="element.menus" @update-menu="updateMenuItem" @delete-menu="deleteMenuItem" />
          </li>
      </template>
  </draggable>
</template>

  <script>
  import draggable from "vuedraggable";
  import { mapState } from "vuex";
  export default {
    computed: {
      ...mapState({
          currnetItemId: (state) => state.menus.currnetItemId,
      })
    },
    name:"nested-draggable",
    props:['menus'],
    created(){
      this.$store.commit('menus/setCurrentId', null)
    },
    methods:{
      updateCurrentId(currnetItemId){
        this.$store.commit('menus/setCurrentId', currnetItemId)
      },
      
    updateMenuItem(element, value, type){
      if(type == 'link'){
        this.$emit('updateMenu', element, value, type)
      }
      else if(type == 'name'){
        this.$emit('updateMenu', element, value, type)
      }
    },
    deleteMenuItem(id){
      this.$emit('deleteMenu', id)
      }
    },
    components: {
      draggable
    },
  };
  </script>
  <style scoped>
  .sortable-ghost {
    height: 35px !important;
  }
  .dragArea {
    min-height: 50px;
    /* min-height: 50px;
    outline: 1px dashed; */
  }
  </style>