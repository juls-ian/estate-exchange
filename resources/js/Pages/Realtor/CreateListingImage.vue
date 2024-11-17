<template>
  <Box>
    <template #header> Upload new images </template>
    <form @submit.prevent="uploadImages">
      <div class="flex items-center gap-2 my-5">
        <input
          type="file"
          multiple
          @input="addFiles"
          class="border rounded-md file:px-4 file:py-2 border-blue-200 dark:border-blue-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-sky-100 file:dark:bg-blue-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4"
        />
        <button
          type="submit"
          class="btn-outline disabled:opacity-30 disabled:cursor-not-allowed"
          :disabled="!canUpload"
        >
          Upload
        </button>
        <button type="reset" class="btn-outline" @click="resetForm">Reset</button>
      </div>
    </form>
    <div v-if="imageErrors.length" class="input-error">
      <div v-for="(error, index) in imageErrors" :key="index">
        {{ error }}
      </div>
    </div>
  </Box>

  <Box>
    <template #header>Current Listing Images</template>
    <div class="mt-4 grid grid-cols-3 gap-4">
      <div
        v-for="image in props.listing.images"
        :key="image.id"
        class="flex flex-col justify-between"
      >
        <img :src="image.src" class="rounded-md" />
        <Link
          :href="
            route('realtor.listing.image.destroy', { listing: props.listing.id, image: image.id })
          "
          method="delete"
          as="button"
          class="mt-2 btn-outline text-xs"
          >Delete</Link
        >
      </div>
    </div>
  </Box>
</template>

<script setup>
  import Box from '@/Components/UI/Box.vue';
  import { useForm, Link } from '@inertiajs/vue3';
  import { computed } from 'vue';
  import NProgress from 'nprogress';
  import { router as Inertia } from '@inertiajs/vue3';

  const props = defineProps({
    listing: Object
  });

  // Progress bar
  Inertia.on('progress', (event) => {
    // if there's progress
    if (event.detail.progress.percentage) {
      NProgress.set((event.detail.progress.percentage / 100) * 0.9);
    }
  });

  const form = useForm({
    images: [] // array of images
  });

  // convert object to array
  const imageErrors = computed(() => Object.values(form.errors));

  const canUpload = computed(() => form.images.length);

  // Capture files and store in form array
  const addFiles = (event) => {
    // get uploaded images
    for (const image of event.target.files) {
      form.images.push(image);
    }
  };

  // Submit form and upload images
  const uploadImages = () => {
    form.post(route('realtor.listing.image.store', { listing: props.listing.id }), {
      onSuccess: () => form.reset('images') // reset images field
    });
  };

  const resetForm = () => form.reset('images'); // images field
</script>
