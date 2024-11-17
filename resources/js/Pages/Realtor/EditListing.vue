<template>
  <form @submit.prevent="update">
    <div class="grid grid-cols-6 gap-4">
      <div class="col-span-2">
        <label class="label">Beds</label>
        <input class="input" v-model.number="form.beds" type="text" />
        <div v-if="form.errors.beds">{{ form.errors.beds }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Baths</label>
        <input class="input" v-model.number="form.baths" type="text" />
        <div v-if="form.errors.baths">{{ form.errors.baths }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Area</label>
        <input class="input" v-model.number="form.area" type="text" />
        <div v-if="form.errors.area">{{ form.errors.area }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">City</label>
        <input class="input" v-model="form.city" type="text" />
        <div v-if="form.errors.city">{{ form.errors.city }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Post Code</label>
        <input class="input" v-model="form.code" type="text" />
        <div v-if="form.errors.code">{{ form.errors.code }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Street</label>
        <input class="input" v-model="form.street" type="text" />
        <div v-if="form.errors.street">{{ form.errors.street }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Street Nr</label>
        <input class="input" v-model.number="form.street_num" type="text" />
        <div v-if="form.errors.street_num">{{ form.errors.street_num }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Price</label>
        <input class="input" v-model.number="form.price" type="text" />
        <div v-if="form.errors.price">{{ form.errors.price }}</div>
      </div>
      <div class="col-span-6">
        <button type="submit" @click="notify" class="btn-primary">Update</button>
      </div>
    </div>
  </form>
</template>

<script setup>
  import { useForm } from '@inertiajs/vue3';
  import { toast } from 'vue3-toastify';

  const props = defineProps({
    listing: Object
  });

  const form = useForm({
    beds: props.listing.beds,
    baths: props.listing.baths,
    area: props.listing.area,
    city: props.listing.city,
    code: props.listing.street,
    street: props.listing.code,
    street_num: props.listing.street_num,
    price: props.listing.price
  });
  const update = () => form.put(route('realtor.listing.update', { id: props.listing.id }));
</script>
