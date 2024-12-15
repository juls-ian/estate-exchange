<template>
  <Box>
    <template #header> Offer Made </template>

    <Price :price="offer.amount" class="text-3xl" />

    <div class="mt-2 flex flex-col md:flex-row justify-between text-gray-500">
      <div>Made on</div>
      <div class="font-medium">{{ offerMadeOn }}</div>
    </div>
  </Box>
</template>

<script setup>
  import Box from '@/Components/UI/Box.vue';
  import Price from '@/Components/Listing/Price.vue';
  import { computed } from 'vue';

  const props = defineProps({
    offer: Object
  });
  // reformat the date from db
  const offerMadeOn = computed(() => new Date(props.offer.created_at).toDateString());
</script>
