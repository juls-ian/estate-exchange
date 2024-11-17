<template>
  <div>
    <span class="font-bold">{{ props.listing.beds }} beds</span>
    <span class="text-gray-400 mx-1">|</span>
    <span class="font-bold">{{ props.listing.baths }} baths</span>
    <span class="text-gray-400 mx-1">|</span>
    <span class="font-bold">{{ props.listing.area }}m²</span>
  </div>
</template>

<script setup>
  const props = defineProps({
    listing: Object
  });
</script>
