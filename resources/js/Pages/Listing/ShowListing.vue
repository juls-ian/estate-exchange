<template>
  <div class="mx-10 py-10 flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
    <Box class="md:col-span-7 flex items-center w-full">
      <div v-if="props.listing.images.length" class="grid grid-cols-2 gap-1">
        <img v-for="image in props.listing.images" :key="image.id" :src="image.src" />
      </div>
    </Box>

    <div class="md:col-span-5 flex-col gap-4">
      <Box>
        <Price :price="listing.price" class="text-2xl font-bold text-blue-400" />
        <ListingSpace :listing="listing" class="text-lg" />
        <ListingAddress :listing="listing" class="text-gray-500" />
      </Box>

      <Box class="pt-2 mt-2">
        <template #header>Offer</template>
        <div>
          <label class="label">Interest rate {{ interestRate }}</label>
          <input
            v-model.number="interestRate"
            type="range"
            min="0.1"
            max="30"
            step="0.1"
            class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
          />

          <label class="label">Duration {{ duration }} years</label>
          <input
            v-model.number="duration"
            type="range"
            min="3"
            max="35"
            step="1"
            class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
          />
        </div>

        <div class="text-gray-600 dark:text-gray-300 mt-2">
          <div class="text-gray-400">Your monthly payment</div>
          <Price :price="monthlyPayment" class="text-2xl font-bold text-blue-400" />
        </div>

        <div class="mt-2 text-gray-500">
          <div class="flex justify-between">
            <!-- left  -->
            <div>Total Paid</div>
            <!-- right -->
            <div>
              <Price :price="totalPaid" class="font-medium" />
            </div>
          </div>

          <div class="flex justify-between">
            <!-- left  -->
            <div>Principal Paid</div>
            <!-- right -->
            <div>
              <Price :price="listing.price" class="font-medium" />
            </div>
          </div>

          <div class="flex justify-between">
            <!-- left  -->
            <div>Interest Paid</div>
            <!-- right -->
            <div>
              <Price :price="totalInterest" class="font-medium" />
            </div>
          </div>
        </div>
      </Box>
    </div>
  </div>
</template>

<script setup>
  import ListingAddress from '@/Components/Listing/ListingAddress.vue';
  import ListingSpace from '@/Components/Listing/ListingSpace.vue';
  import Box from '@/Components/UI/Box.vue';
  import Price from '@/Components/Listing/Price.vue';
  import { ref } from 'vue';
  import { useMonthlyPayment } from '@/Composables/useMonthlyPayment';

  const interestRate = ref(2.5);
  const duration = ref(25);
  const props = defineProps({
    listing: Object
  });

  console.log(props.listing);
  //  extract the monthlyPayment for composable
  const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(
    props.listing.price,
    interestRate,
    duration
  );
</script>
