<template>
  <form @submit.prevent="login">
    <div class="w-1/2 mx-auto items-center">
      <div>
        <label for="email" class="label">Email</label>
        <input type="text" id="email" class="input" v-model="form.email" />
        <div class="input-error" v-if="form.errors.email">{{ form.errors.email }}</div>
      </div>
      <div class="mt-4">
        <label for="password" class="label">Password</label>
        <input type="password" id="password" class="input" v-model="form.password" />
        <div class="input-error" v-if="form.errors.password">{{ form.errors.password }}</div>
      </div>
      <div class="mt-4 text-center">
        <button class="btn-primary w-1/2" type="submit">Login</button>
        <p class="mt-2">
          No account yet? Click
          <Link :href="route('user.create')" class="font-bold text-green-400">here</Link>
        </p>
      </div>
    </div>
  </form>
</template>

<script setup>
  import { useForm } from '@inertiajs/vue3';
  import { Link } from '@inertiajs/vue3';

  const form = useForm({
    email: null,
    password: null
  });

  const login = () => form.post(route('login.store'));
</script>
