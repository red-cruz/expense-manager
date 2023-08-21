<template>
  <div class="d-flex justify-content-between mb-3">
    <h4>{{ pageTitle }}</h4>
    <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <slot></slot>
      </ol>
    </nav>
  </div>
</template>

<script setup>
defineProps({ pageTitle: String });
</script>

<style lang="scss" scoped></style>
