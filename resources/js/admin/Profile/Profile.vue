<template>
  <AppLayout>
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
      <div class="px-4 py-5 sm:px-6">
        <h1 class="can-edu-h1">Profile</h1>
        <!-- <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p> -->
      </div>
      <div class="border-t border-gray-200">
        <form class="py-4 px-4 bg-white" @submit.prevent="updateProfile()">
          <div class="grid md:grid-cols-2 md:gap-6 mb-6">
            <div class="relative z-0 w-full group">
              <label for="name" class="block text-base lg:text-lg">Name</label>
              <input
                type="text"
                name="name"
                id="name"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" "
                @input="updateForm('name', $event.target.value)"
                :value="loggedInUser ? loggedInUser.name : ''"
              />
              <p
                class="mt-2 text-base text-primary"
                v-if="validationErros.has('name')"
                v-text="validationErros.get('name')"
              ></p>
            </div>
            <div class="relative z-0 w-full group">
              <label for="email" class="block text-base lg:text-lg"
                >Email</label
              >
              <input
                type="email"
                name="email"
                id="email"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" "
                @input="updateForm('email', $event.target.value)"
                :value="loggedInUser ? loggedInUser.email : ''"
              />
              <p
                class="mt-2 text-base text-primary"
                v-if="validationErros.has('email')"
                v-text="validationErros.get('email')"
              ></p>
            </div>
            <div class="relative z-0 w-full group">
              <label for="current_password" class="block text-base lg:text-lg"
                >Current password</label
              >
              <input
                type="password"
                name="current_password"
                id="current_password"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" "
                @input="updateForm('current_password', $event.target.value)"
                :value="form.current_password"
              />
              <p
                class="mt-2 text-base text-primary"
                v-if="validationErros.has('current_password')"
                v-text="validationErros.get('current_password')"
              ></p>
            </div>
            <div class="relative z-0 w-full group">
              <label for="new_password" class="block text-base lg:text-lg"
                >New password</label
              >
              <input
                type="password"
                name="new_password"
                id="new_password"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" "
                @input="updateForm('new_password', $event.target.value)"
                :value="form.new_password"
              />
              <p
                class="mt-2 text-base text-primary"
                v-if="validationErros.has('new_password')"
                v-text="validationErros.get('new_password')"
              ></p>
            </div>
            <div class="relative z-0 w-full group">
              <label
                for="new_password_confirmation"
                class="block text-base lg:text-lg"
                >Password confirmation</label
              >
              <input
                type="password"
                name="new_password_confirmation"
                id="new_password_confirmation"
                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                placeholder=" "
                @input="
                  updateForm('new_password_confirmation', $event.target.value)
                "
                :value="form.new_password_confirmation"
              />
              <p
                class="mt-2 text-base text-primary"
                v-if="validationErros.has('new_password_confirmation')"
                v-text="validationErros.get('new_password_confirmation')"
              ></p>
            </div>
          </div>
          <button type="submit" class="can-edu-btn-fill" :disabled="loading">
            <svg
              class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              v-if="loading"
            >
              <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
              ></circle>
              <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
              ></path>
            </svg>
            Save
          </button>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      loggedInUser: (state) => state.auth.loggedInUser,
      form: (state) => state.auth.form,
      validationErros: (state) => state.auth.validationErros,
      loading: (state) => state.auth.loading,
    }),
  },
  methods: {
    updateForm(field, value) {
      this.$store.commit("auth/setForm", {
        [field]: value,
      });
    },
    updateProfile() {
      this.$store.dispatch("auth/updateUserProfile");
    },
  },
};
</script>
