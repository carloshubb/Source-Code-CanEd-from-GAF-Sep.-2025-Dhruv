<template>
  <div class="relative flex items-center">
    <a :href="'/' + JSON.parse(lang)?.['abbreviation'] + '/become-sponsor'">
      <button class="can-edu-btn-fill whitespace-nowrap">
        Become a Sponsor
      </button>
    </a>
  </div>
</template>
<script>
export default {
  props: ["lang"],
};
</script>
