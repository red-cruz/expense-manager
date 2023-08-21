<template>
  <div class="mt-3 text-white">
    <Icon
      v-if="role === 'admin'"
      icon="eos-icons:admin-outlined"
      width="50px"
    />
    <Icon v-else icon="teenyicons:user-circle-solid" width="50px" />
  </div>
</template>

<script setup>
import { Icon } from '@iconify/vue'
defineProps({ role: String })
</script>

<style lang="scss" scoped></style>
