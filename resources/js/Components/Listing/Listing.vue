<template>
  <Box>
    <div>
      <Link :href="route('listing.show', { listing: listing.id })">
        <div class="flex items-center gap-1">
          <Price :price="listing.price" class="text-2xl font-bold text-blue-400" />
          <div class="text-xs text-gray-500">
            <Price :price="monthlyPayment" />
            payment
          </div>
        </div>
        <ListingSpace :listing="props.listing" class="text-lg" />
        <ListingAddress :listing="props.listing" class="text-gray-500" />
      </Link>
    </div>
  </Box>
</template>

<script setup>
  import ListingAddress from '@/Components/Listing/ListingAddress.vue';
  import ListingSpace from '@/Components/Listing/ListingSpace.vue';
  import { Link } from '@inertiajs/vue3';
  import Box from '@/Components/UI/Box.vue';
  import Price from '@/Components/Listing/Price.vue';
  import { useMonthlyPayment } from '@/Composables/useMonthlyPayment';

  const props = defineProps({
    listing: Object //formerly array
  });

  const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(
    props.listing.price,
    2.25,
    25
  );
</script>
