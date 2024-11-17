<template>
  <Filters :filters="props.filters" />
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">
    <Listing v-for="listing in props.listings.data" :key="listing.id" :listing="listing" />
  </div>

  <div v-if="props.listings.data.length" class="w-full flex justify-center mt-4 mb-4">
    <!-- links is a property that Laravel returns with paginate -->
    <Pagination :links="listings.links" />
  </div>
</template>

<script setup>
  import Listing from '@/Components/Listing/Listing.vue';
  import Pagination from '@/Components/UI/Pagination.vue';
  import Filters from '@/Components/Listing/Filters.vue';

  const props = defineProps({
    listings: Object, //formerly array
    filters: Object
  });
</script>
