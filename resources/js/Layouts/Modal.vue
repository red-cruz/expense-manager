<template>
  <div :id="id + '-modal'" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ title }}</h5>
        </div>
        <form :action="action" :id="id + '-form'" method="post" novalidate>
          <div class="modal-body">
            <slot></slot>
          </div>
          <div class="modal-footer justify-content-between">
            <slot name="deleteBtn">&nbsp;</slot>
            <div>
              <button
                type="button"
                class="btn btn-secondary me-2"
                data-bs-dismiss="modal"
              >
                Cancel
              </button>
              <button type="submit" class="btn btn-success">
                {{ submit }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
defineProps({
  title: String,
  id: { type: String, required: true },
  action: { type: String, required: true },
  submit: { type: String, default: 'Save' },
});
</script>

<style lang="scss" scoped></style>
