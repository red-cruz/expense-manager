<template>
  <Link
    class="text-white link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
    :href="href"
    :class="{
      'link-underline-opacity-100': page === href || page === href + '/',
    }"
  >
    <slot></slot>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({ href: String, page: String });
</script>

<style lang="scss" scoped></style>
