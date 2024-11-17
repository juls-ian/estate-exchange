<template>
  <form @submit.prevent="filter">
    <div class="mb-8 mt-4 flex flex-wrap gap-2">
      <div class="flex flex-nowrap items-center">
        <input
          type="text"
          v-model.number="filterForm.priceFrom"
          placeholder="Price from"
          class="input-filter-left w-28"
        />
        <input
          type="text"
          v-model.number="filterForm.priceTo"
          placeholder="Price to"
          class="input-filter-right w-28"
        />
      </div>

      <div class="flex flex-nowrap items-center">
        <select v-model="filterForm.beds" class="input-filter-left w-28">
          <option :value="null">Beds</option>
          <option v-for="num in 5" :key="num" :value="num">{{ num }}</option>
          <option>6+</option>
        </select>
        <select v-model="filterForm.baths" class="input-filter-right w-28">
          <option :value="null">Baths</option>
          <option v-for="num in 5" :key="num" :value="num">{{ num }}</option>
          <option>6+</option>
        </select>
      </div>

      <div class="flex flex-nowrap items-center">
        <input
          type="text"
          v-model="filterForm.areaForm"
          placeholder="Area from"
          class="input-filter-left w-28"
        />
        <input
          type="text"
          v-model="filterForm.areaTo"
          placeholder="Area to"
          class="input-filter-right w-28"
        />
      </div>

      <button type="submit" class="btn-normal">Filter</button>
      <button type="reset" @click="clearForm">Clear</button>
    </div>
  </form>
</template>

<script setup>
  import { useForm } from '@inertiajs/vue3';

  const props = defineProps({
    filters: Object
  });

  const filterForm = useForm({
    priceFrom: props.filters.priceFrom ?? null,
    priceTo: props.filters.priceTo ?? null,
    beds: props.filters.beds ?? null,
    baths: props.filters.baths ?? null,
    areaFrom: props.filters.areaFrom ?? null,
    areaTo: props.filters.areaTo ?? null
  });

  //   SUBMITTING FILTER
  const filter = () => {
    filterForm.get(route('listing.index'), {
      preserveState: true,
      preserveScroll: true
    });
  };

  //   CLEARING THE FIELDS
  const clearForm = () => {
    filterForm.priceFrom = null;
    filterForm.priceTo = null;
    filterForm.beds = null;
    filterForm.baths = null;
    filterForm.areaFrom = null;
    filterForm.areaTo = null;
    filter(); // resetting & resending form
  };
</script>
