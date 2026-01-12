<template>
  <AppLayout>
      <div class="relative shadow-md rounded-lg bg-white py-4 grid grid-cols-12 gap-4 p-4">
        <div class="col-span-12 flex items-center justify-between">
          <h3 class="can-edu-h1">Menu builder</h3>
              <router-link :to="{ name: 'admin.menus.index'}" class="inline-flex items-center can-edu-btn-fill">
                  Back
              </router-link>
        </div>
          <div class="md:col-span-8 col-span-12">
              <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                  <ul class="flex flex-wrap mb-2 overflow-x-auto gap-1 mt-4">
                      <li class="mr-2" v-for="language in languages" :key="language.id">
                          <a @click.prevent="changeLanguageTab(language)" href="#"
                              :class="['inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                  ((activeTab == null && language.is_default) || activeTab == language.id ?
                                      'text-white bg-primary active' : ''), (validationErros.has(
                                      `menu_${language.id}`) ? 'bg-red-600 text-white hover:text-white' : '')
                              ]">{{ language . name }}</a>
                      </li>

                  </ul>
              </div>
              <p class="mt-2 text-sm text-red-400" v-if="validationErros.has(`menu_${activeTab}`)"
                  v-text="validationErros.get(`menu_${activeTab}`)"></p>
              <nested-draggable v-if="activeTab != null"
                  :menus="menu['menu_' + activeTab] ? menu['menu_' + activeTab] : []" @update-menu="updateMenuItem"
                  @delete-menu="deleteMenuItem" />

              <div class="flex justify-end mt-2">
                  <button type="button" class="can-edu-btn-fill" @click.prevent="updateMenuBuilder">Save menu</button>
              </div>
          </div>

          <Sidebar class="md:col-span-4 col-span-12" @add-menu-item="addMenuItem" />
          <!-- <rawDisplayer class="md:col-span-4 col-span-12" v-if="activeTab != null" :value="menu['menu_' + activeTab] ? menu['menu_' + activeTab] : []" title="List" /> -->
      </div>
  </AppLayout>
</template>

  <script>
  import nestedDraggable from "./nested.vue";
  import rawDisplayer from "./raw-dusplayer.vue";
  import Sidebar from "./Sidebar.vue";
  import { mapState } from "vuex";
  export default {
    computed: {
      ...mapState({
          languages: (state) => state.languages.languages,
          validationErros: (state) => state.menus.validationErros,
      })
    },
    components: {
      nestedDraggable, rawDisplayer, Sidebar
    },
    created(){
      this.$store.commit("pages/setLimit", 2000);
      this.$store.commit("pages/setSortBy", "id");
      this.$store.commit("pages/setSortType", "desc");
      this.$store.commit("pages/setSearchParam", '');
      this.$store.commit('menus/setEmptyError')
      let id = this.$route.params ? this.$route.params.id : null;
      if(id){
        this.activeTab = null;
        this.$store.dispatch('languages/fetchLanguages', {
            url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`
        }).then(res => {
          let data = res.data.data;
          let obj = {};
          data.map(res => {
            if(res.is_default == '1'){
              this.activeTab = res.id;
            }
              obj['menu_'+res.id] = [];
          });
          this.menu = obj;
          this.$store.dispatch("pages/fetchPages", {
            url:`${process.env.MIX_ADMIN_API_URL}pages?getAll=1`
          }).then(response => {

            this.$store.dispatch("menus/fetchMenus", {
              url:`${process.env.MIX_ADMIN_API_URL}menus/${id}?withMenuDetail=1`
            }).then(result => {
              let data = result.data.data;
              if(data.menu_detail){
                data.menu_detail.map(menu_detail => {
                  this.menu['menu_'+menu_detail.language_id] = JSON.parse(JSON.stringify(menu_detail.menu_items));
                })
              }
            })
          });
        });
      }
    },
    data() {
      return {
        activeTab: null,
        menu:[]
      };
    },
    methods:{
      changeLanguageTab(language){
          this.activeTab = language.id;
      },
      addMenuItem(id, page_id, name, link){
        let obj = {
          id:id,
          page_id:page_id,
          name:name,
          link:link,
          menus:[]
        }
        this.menu['menu_'+this.activeTab].push(obj);
      },
      updateItem(array, id, newName, newLink, type) {
        for (let i = 0; i < array.length; i++) {
          if (Array.isArray(array[i])) {
            this.updateItem(array[i], id, newName, newLink, type);
          } else if (
            typeof array[i] === "object" &&
            array[i].hasOwnProperty("id") &&
            array[i].id == id
          ) {
            if (type == "name" && array[i].hasOwnProperty("name")) {
              array[i].name = newName;
            } else if (type == "link" && array[i].hasOwnProperty("link")) {
              array[i].link = newLink;
            }
          } else if (
            typeof array[i] === "object" &&
            array[i].hasOwnProperty("menus") &&
            Array.isArray(array[i].menus) &&
            array[i].menus.length > 0
          ) {
            this.updateItem(array[i].menus, id, newName, newLink, type);
          }
        }
      },
      updateMenuItem(element, value, type){
        if(type == 'name'){
          this.updateItem(this.menu['menu_'+this.activeTab], element.id, value, element.link, type);
        }
        else if(type == 'link'){
          this.updateItem(this.menu['menu_'+this.activeTab], element.id, element.name, value, type);
        }
      },
      updateMenuBuilder(){
        let id = this.$route.params ? this.$route.params.id : null;
        if(id){
          this.$store.dispatch('menus/updateMenuBuilder', {
            id:id,
            menu:this.menu
          })
          .then(() => this.$router.push({name: 'admin.menus.index'}));
        }
      },
      deleteMenuItem(id){
        this.deleteItem(this.menu['menu_'+this.activeTab], id);
      },
      deleteItem(array, id) {
        for (let i = 0; i < array.length; i++) {
          if (Array.isArray(array[i].menus)) {
            array[i].menus = this.deleteItem(array[i].menus, id); // recursively remove object from menus array
          }
          if (array[i].id === id) {
            array.splice(i, 1); // remove object from array
            i--; // decrement the loop index to account for the removed object
          }
        }
        return array;
      }
    }
  };
  </script>
  <style scoped></style>
