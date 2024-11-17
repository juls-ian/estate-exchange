<template>
  <form @submit.prevent="create">
    <div class="grid grid-cols-6 gap-4">
      <div class="col-span-2">
        <label class="label">Beds</label>
        <input class="input" v-model.number="form.beds" type="text" />
        <div class="input-error" v-if="form.errors.beds">{{ form.errors.beds }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Baths</label>
        <input class="input" v-model.number="form.baths" type="text" />
        <div class="input-error" v-if="form.errors.baths">{{ form.errors.baths }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Area</label>
        <input class="input" v-model.number="form.area" type="text" />
        <div class="input-error" v-if="form.errors.area">{{ form.errors.area }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">City</label>
        <input class="input" v-model="form.city" type="text" />
        <div class="input-error" v-if="form.errors.city">{{ form.errors.city }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Post Code</label>
        <input class="input" v-model="form.code" type="text" />
        <div class="input-error" v-if="form.errors.code">{{ form.errors.code }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Street</label>
        <input class="input" v-model="form.street" type="text" />
        <div class="input-error" v-if="form.errors.street">{{ form.errors.street }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Street Nr</label>
        <input class="input" v-model.number="form.street_num" type="text" />
        <div class="input-error" v-if="form.errors.street_num">{{ form.errors.street_num }}</div>
      </div>
      <div class="col-span-2">
        <label class="label">Price</label>
        <input class="input" v-model.number="form.price" type="text" />
        <div class="input-error" v-if="form.errors.price">{{ form.errors.price }}</div>
      </div>
      <div class="col-span-6">
        <button type="submit" @click="notify" class="btn-primary">Create</button>
      </div>
    </div>
  </form>
</template>

<script setup>
  import { useForm } from '@inertiajs/vue3';
  import { toast } from 'vue3-toastify';

  const form = useForm({
    beds: 0,
    baths: 0,
    area: 0,
    city: null,
    code: null,
    street: null,
    street_num: null,
    price: 0
  });
  const create = () => form.post(route('realtor.listing.store'));
</script>
