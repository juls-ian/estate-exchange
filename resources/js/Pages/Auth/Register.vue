<template>
  <form @submit.prevent="register">
    <div class="w-1/2 mx-auto items-center">
      <div>
        <label for="name" class="label">Name</label>
        <input type="text" id="name" class="input" v-model="form.name" />
        <div class="input-error" v-if="form.errors.name">{{ form.errors.name }}</div>
      </div>
      <div class="mt-4">
        <label for="email" class="label">Email</label>
        <input type="text" id="email" class="input" v-model="form.email" />
        <div class="input-error" v-if="form.errors.email">{{ form.errors.email }}</div>
      </div>
      <div class="mt-4">
        <label for="password" class="label">Password</label>
        <input type="password" id="password" class="input" v-model="form.password" />
        <div class="input-error" v-if="form.errors.password">{{ form.errors.password }}</div>
      </div>
      <div class="mt-4">
        <label for="confirm_password" class="label">Confirm Password</label>
        <input
          type="password"
          id="password_confirmation"
          class="input"
          v-model="form.password_confirmation"
        />
        <div class="input-error" v-if="form.errors.password_confirmation">
          {{ form.errors.password_confirmation }}
        </div>
      </div>
      <div class="mt-4 text-center">
        <button class="btn-primary w-1/2" type="submit">Register</button>
        <p class="mt-2">
          Already registered? Click
          <Link :href="route('login')" class="font-bold text-green-400">here</Link>
        </p>
      </div>
    </div>
  </form>
</template>

<script setup>
  import { useForm, Link } from '@inertiajs/vue3';

  const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null
  });

  const register = () => form.post(route('user.store'));
</script>
