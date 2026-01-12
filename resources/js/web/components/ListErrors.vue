<template>
    <div v-if="validationErrors && validationErrors.any()">
      <p class="mt-2 text-sm lg:text-base text-primary font-bold">Please fill in the missing fields above</p>
          <!-- <div v-for="(messages, field) in validationErrors.errors" :key="field">
            <ul>
              <li v-for="(message, index) in messages" :key="index" class="mt-2 text-sm lg:text-base text-primary">
                {{ message }}
              </li>
            </ul>
          </div> -->
        </div>
</template>
<script>
export default{
    props:['validationErrors']
}
</script>
