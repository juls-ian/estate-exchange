<template>
  <span>
    <span>{{ props.listing.street }} {{ props.listing.street_num }} {{ props.listing.city }}</span>
  </span>
</template>

<script setup>
  const props = defineProps({
    listing: Object
  });
</script>
