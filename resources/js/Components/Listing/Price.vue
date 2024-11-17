<template>
  <span>{{ formattedPrice }}</span>
</template>

<script setup>
  import { computed } from 'vue';
  const props = defineProps({
    // multi-type
    price: [Number, String]
  });

  const formattedPrice = computed(() =>
    //    JS Number to toLocaleString method
    Number(props.price).toLocaleString('en-US', {
      style: 'currency',
      currency: 'USD',
      maximumFractionDigits: 0
    })
  );
</script>
