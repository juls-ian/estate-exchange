<template>
  <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 w-full">
    <div class="container mx-auto">
      <nav class="p-4 flex items-center justify-between">
        <div class="text-lg font-medium">
          <Link :href="route('listing.index')">Listings</Link>
        </div>
        <div class="text-xl text-indigo-600 dark:text-indigo-300 font-bold text-center">
          <Link :href="route('listing.index')">Estate Exchange</Link>
        </div>
        <!-- IF AUTHENTICATED  -->
        <div class="flex items-center gap-5" v-if="loggedUser">
          <!-- Notification -->
          <Link
            :href="route('notification.index')"
            class="text-gray-500 relative pr-1 py-1 text-base"
          >
            🔔
            <div
              v-if="notificationCount"
              class="absolute right-0 top-0 w-4 h-4 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center"
            >
              {{ notificationCount }}
            </div>
          </Link>
          <!-- LOGGED IN USER -->
          <Link class="text-sm text-gray-500 font-bold" :href="route('realtor.listing.index')">
            {{ loggedUser.name }}
          </Link>
          <Link
            :href="route('realtor.listing.create')"
            class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium p-2 rounded-md"
          >
            New Listing
          </Link>
          <div><Link :href="route('logout')" method="delete" as="button">Logout</Link></div>
        </div>
        <!-- IF UNAUTHENTICATED  -->
        <div v-else class="flex items-center gap-3">
          <Link :href="route('login')">Login</Link>
          <Link :href="route('user.create')">Register</Link>
        </div>
      </nav>
    </div>
  </header>

  <main class="container px-5 my-10 w-full">
    <slot></slot>
  </main>
</template>

<script setup>
  import { Link, useForm, usePage } from '@inertiajs/vue3';
  import { computed, watch } from 'vue';
  import { toast } from 'vue3-toastify';

  const page = usePage();
  const loggedUser = computed(() => page.props.user);

  watch(
    () => page.props.flash.success,
    (flash) => {
      if (flash) {
        toast(flash, {
          type: 'success',
          position: toast.POSITION.BOTTOM_RIGHT,
          autoClose: 2000
        });
      }
    },
    { immediate: true }
  );

  const notificationCount = computed(() => Math.min(page.props.user.notificationCount, 9));
</script>
