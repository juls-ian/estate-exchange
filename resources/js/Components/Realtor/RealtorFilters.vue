<template>
  <form action="">
    <div class="mb-4 mt-4 flex flex-wrap gap-4">
      <div class="flex flex-nowrap items-center gap-2">
        <input
          id="deleted"
          v-model="filterForm.deleted"
          type="checkbox"
          class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
        />
        <label for="deleted">Deleted</label>
      </div>

      <div>
        <select class="input-filter-left w-24" v-model="filterForm.column">
          <option value="created_at">Order</option>
          <option value="price">Price</option>
        </select>
        <!-- SORT OPTIONS -->
        <select class="input-filter-right w-32" v-model="filterForm.orderBy">
          <option v-for="option in sortOptions" :key="option.value" :value="option.value">
            {{ option.label }}
          </option>
        </select>
      </div>
    </div>
  </form>
</template>

<script setup>
  import { computed, reactive, watch } from 'vue';
  import { router as Inertia } from '@inertiajs/vue3';
  import { debounce } from 'lodash';

  const props = defineProps({
    filters: Object
  });

  const sortLabels = {
    // 1st option - created_at
    created_at: [
      {
        label: 'Latest',
        value: 'desc'
      },
      {
        label: 'Oldest',
        value: 'asc'
      }
    ],
    // 2nd option - price
    price: [
      {
        label: 'Expensive',
        value: 'desc'
      },
      {
        label: 'Cheapest',
        value: 'asc'
      }
    ]
  };
  // initialization | default values
  const filterForm = reactive({
    deleted: props.filters.deleted ?? false,
    column: props.filters.column ?? 'created_at', // col name {price, created_at}
    orderBy: props.filters.orderBy ?? 'desc' // value: desc or asc
  });

  const sortOptions = computed(() => sortLabels[filterForm.column]);

  // ref, reactive, computed
  watch(
    filterForm,
    debounce(
      () =>
        Inertia.get(route('realtor.listing.index'), filterForm, {
          preserveState: true,
          preserveScroll: true
        }),
      1000 // timeout
    )
  );
</script>
