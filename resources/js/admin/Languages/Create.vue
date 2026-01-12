<template>
  <AppLayout>
    <div class="relative shadow-md rounded-lg bg-white py-4">
      <header class="">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h1 class="can-edu-h1">{{ isFormEdit ? 'Edit' : 'Create' }} language</h1>
            <router-link :to="{ name: 'admin.languages.index' }" class="can-edu-btn-fill">
              Back
            </router-link>
          </div>
        </div>
      </header>
      <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
        <div class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
          <div class="relative z-0 w-full group">
            <label for="name" class="block text-base lg:text-lg">Name<span class="text-primary">*</span></label>
            <!-- <input type="text" name="name" id="name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " :value="form.name" @input="updateForm('name', $event.target.value)" /> -->
            <select @change="updateLangName($event.target.value)" name="name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary">
              <option value="">Select language...</option>
              <option v-for="languageCode in languageCodes" :key="languageCode.code"
                :value="JSON.stringify(languageCode)" :selected="languageCode.name == form.name">
                {{ languageCode.name }}
              </option>
            </select>
            <p class="mt-2 text-sm lg:text-base text-primary" v-if="validationErros.has('name')"
              v-text="validationErros.get('name')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="abbreviation" class="block text-base lg:text-lg">Abbreviation<span class="text-primary">*</span></label>
            <input type="text" name="abbreviation" id="abbreviation"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder=" " :value="form.abbreviation" @input="updateForm('abbreviation', $event.target.value)"
              disabled tabindex="-1" />
            <p class="mt-2 text-sm lg:text-base text-primary" v-if="validationErros.has('abbreviation')"
              v-text="validationErros.get('abbreviation')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="position" class="block text-base lg:text-lg">Abbreviation</label>
            <select id="position" name="position"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder=" " @input="updateForm('position', $event.target.value)">
              <option :selected="form.position == 'ltr'" value="ltr">
                LTR
              </option>
              <option :selected="form.position == 'rtl'" value="rtl">
                RTL
              </option>
            </select>
            <p class="mt-2 text-sm lg:text-base text-primary" v-if="validationErros.has('position')"
              v-text="validationErros.get('position')"></p>
          </div>
          <div class="relative z-0 w-full group">
            <label for="native_name" class="block text-base lg:text-lg">Native name<span class="text-primary">*</span></label>
            <input type="text" name="native_name" id="native_name"
              class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
              placeholder=" " :value="form.native_name" @input="updateForm('native_name', $event.target.value)" disabled
              tabindex="-1" />
            <p class="mt-2 text-sm lg:text-base text-primary" v-if="validationErros.has('native_name')"
              v-text="validationErros.get('native_name')"></p>
          </div>
          <div class="relative z-0 w-full mb-6 group">
            <fieldset>
              <legend class="sr-only">Set as default</legend>
              <div class="flex items-center mb-4">
                <input id="is_default" name="is_default" type="checkbox" value=""
                  class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  :checked="is_default" v-model="is_default" />
                <label for="is_default"
                  class="ml-2 text-sm lg:text-base font-medium text-gray-900 dark:text-gray-300">Set as default</label>
              </div>
            </fieldset>
            <p class="mt-2 text-sm lg:text-base text-primary" v-if="validationErros.has('is_default')"
              v-text="validationErros.get('is_default')"></p>
          </div>
          <div class="relative z-0 w-full mb-4 group col-span-2 lg:col-span-1">
            <FilePond name="flag_icon" class-name="my-pond" accepted-file-types="image/*" @init="handleFilePondInit"
              @processfile="handleFilePondFlagIconProcess" @removefile="handleFilePondFlagIconRemoveFile" />
            <p class="mt-2 text-sm lg:text-base text-primary" v-if="validationErros.has('flag_icon')"
              v-text="validationErros.get('flag_icon')"></p>
          </div>
        </div>
        <ListErrors :validationErrors="validationErros" />


        <button type="submit" class="can-edu-btn-fill mb-2">Submit</button>
      </form>
    </div>
  </AppLayout>
</template>

<script>
// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      isFormEdit: (state) => state.languages.isFormEdit,
      form: (state) => state.languages.form,
      languageCodes: (state) => state.languages.languageCodes,
      validationErros: (state) => state.languages.validationErros,
    }),
    is_default: {
      get: function () {
        return this.$store.state.languages.form.is_default;
      },
      set: function (val) {
        this.$store.commit("languages/setForm", {
          is_default: val,
        });
      },
    },
  },
  methods: {
    //   updateLangName(lang) {
    //     lang = JSON.parse(lang);
    //     this.updateForm("name", lang.name);
    //     this.updateForm("abbreviation", lang.code);
    //     this.updateForm("native_name", lang.nativeName);
    //     ["name", "abbreviation", "native_name"].forEach(field => {
    //   if (this.validationErros.has(field)) {
    //     this.validationErros.clear(field);
    //   }
    // });
    //   },

    updateLangName(lang) {
      // console.log("Selected Language:", lang);
      lang = JSON.parse(lang);
      this.updateForm("name", lang.name);
      this.updateForm("abbreviation", lang.code);
      this.updateForm("native_name", lang.nativeName);

      // console.log("Form State After Update:", this.$store.state.languages.form);
      this.$store.commit("languages/clearValidationErrors", ["name", "abbreviation", "native_name"]);
      // console.log("Validation Errors After Clearing:", this.$store.state.languages.validationErros);
    },
    updateForm(field, value) {
      this.$store.commit("languages/setForm", {
        [field]: value,
      });
    },
    addUpdateForm() {
      this.$store
        .dispatch("languages/addUpdateForm")
        .then(() => this.$router.push({ name: "admin.languages.index" }
        )).catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.focusOnFirstErrorInput(error.response.data.errors);
                    }
                });
    },
    focusOnFirstErrorInput(errors) {
      console.log("Errors object:", errors);
      const firstErrorField = Object.keys(errors)[0];
      console.log("First error field name:", firstErrorField);

      if (!firstErrorField) {
        console.log("No error field found");
        return;
      }

      const fieldNameParts = firstErrorField.split(".");
      const fieldName = fieldNameParts[0];
      console.log("Stripped error field name:", fieldName);

      let inputElement = document.querySelector(
        `[name="${fieldName}"], [v-model="${fieldName}"], [data-v-model="${fieldName}"], [data-value="${fieldName}"]`
      );

      if (!inputElement) {
        console.log(`No standard input field found for ${fieldName}, checking for rich text editor...`);

        const editorId = fieldNameParts[1] || fieldName;
        const tinymceEditor = window.tinymce?.get(editorId);

        if (tinymceEditor) {
          console.log(`Focusing on TinyMCE editor: ${editorId}`);
          tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });

          setTimeout(() => {
            tinymceEditor.focus();
          }, 300); // Allow smooth scrolling before focusing

          return;
        } else {
          console.log(`TinyMCE editor instance not found for ${editorId}`);
        }
      }

      if (inputElement) {
        console.log("Found input element:", inputElement);
        inputElement.scrollIntoView({ behavior: "smooth", block: "center" });

        setTimeout(() => {
          inputElement.focus();
        }, 300); // Add a delay before focusing to allow smooth scrolling

      } else {
        console.log(`No input field found for ${fieldName}`);
      }
    },
    handleFilePondInit() {
      setOptions({
        credits: false,
        server: {
          url: process.env.MIX_ADMIN_API_URL,
          process: (
            fieldName,
            file,
            metadata,
            load,
            error,
            progress,
            abort,
            transfer,
            options
          ) => {
            const formData = new FormData();
            formData.append("media", file, file.name);
            formData.append("is_temp_media", 1);
            formData.append("type", "flag_icon");

            const request = new XMLHttpRequest();
            request.open(
              "POST",
              `${process.env.MIX_ADMIN_API_URL}media/process`
            );
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.upload.onprogress = (e) => {
              progress(e.lengthComputable, e.loaded, e.total);
            };
            request.onload = function () {
              if (request.status >= 200 && request.status < 300) {
                load(request.responseText);
              } else {
                error("oh no");
              }
            };

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          revert: (uniqueFileId, load, error) => {
            const formData = new FormData();
            formData.append("media", uniqueFileId);

            const request = new XMLHttpRequest();
            request.open(
              "POST",
              `${process.env.MIX_ADMIN_API_URL}media/revert`
            );
            request.setRequestHeader(
              "X-CSRF-TOKEN",
              document.head.querySelector('meta[name="csrf-token"]').content
            );

            request.send(formData);

            return {
              abort: () => {
                request.abort();
                abort();
              },
            };
          },
          headers: {
            "X-CSRF-TOKEN": document.head.querySelector(
              'meta[name="csrf-token"]'
            ).content,
          },
        },
      });
    },
    handleFilePondFlagIconProcess(error, file) {
      this.$store.commit("languages/setForm", {
        flag_icon: file.serverId,
      });
      if (this.validationErros.has("flag_icon")) {
        this.validationErros.clear("flag_icon");
      }
    },
    handleFilePondFlagIconRemoveFile(error, file) {
      this.$store.commit("languages/setForm", {
        flag_icon: null,
      });
      if (this.validationErros.has("flag_icon")) {
        this.validationErros.clear("flag_icon");
      }
    },
    convertImgUrlToBase64(url, type) {
      var image = new Image();

      image.onload = function () {
        var canvas = document.createElement("canvas");
        canvas.width = image.width;
        canvas.height = image.height;

        canvas.getContext("2d").drawImage(this, 0, 0);

        canvas.toBlob(
          function (source) {
            var newImg = document.createElement("img"),
              url = URL.createObjectURL(source);

            newImg.onload = function () {
              URL.revokeObjectURL(url);
            };

            newImg.src = url;
          },
          type,
          1
        );
        let dataUrl = canvas.toDataURL(type);
        let files = [
          {
            source: dataUrl,
            options: {
              type: "local",
            },
          },
        ];
        setOptions({ files: files });
      };
      image.src = url;
    },
  },
  components: {
    FilePond,
    ListErrors,
  },
  created() {
    setOptions({ files: [] });
    this.$store.commit("languages/resetForm");
    if (this.$route.params.id) {
      let id = this.$route.params.id;
      this.$store.commit("languages/setIsFormEdit", 1);
      this.$store
        .dispatch("languages/fetchLanguage", { id: id })
        .then((res) => {
          if (res.data.status == "Success") {
            if (this.form.flag_icon) {
              this.convertImgUrlToBase64(
                this.form.flag_icon.full_path,
                `image/${this.form.flag_icon.extension}`
              );
            }
          }
        });
    }
  },
};
</script>

<style scoped>
/**
 * FilePond Custom Styles
 */
.filepond--drop-label {
  color: #4c4e53;
}

.filepond--label-action {
  text-decoration-color: #babdc0;
}

.filepond--panel-root {
  border-radius: 2em;
  background-color: #edf0f4;
  height: 1em;
}

.filepond--item-panel {
  background-color: #595e68;
}

.filepond--drip-blob {
  background-color: #7f8a9a;
}
</style>