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
            <button
              v-if="deleteId"
              @click="deleteRole"
              type="button"
              class="btn btn-danger me-2"
              data-bs-dismiss="modal"
            >
              Delete
            </button>
            <span v-else>&nbsp;</span>
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
import Swal from 'sweetalert2';
import { defineProps } from 'vue';
import { notify } from '../helpers';
const props = defineProps({
  title: String,
  deleteId: Number,
  deleteAction: String,
  deleteEmitter: String,
  id: { type: String, required: true },
  action: { type: String, required: true },
  submit: { type: String, default: 'Save' },
});

const emit = defineEmits([
  'role-deleted',
  'user-deleted',
  'expenseCategory-deleted',
]);

function deleteRole() {
  Swal.fire({
    title: 'Are you sure you want to delete this item?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'No',
  }).then(function (isConfirm) {
    if (isConfirm.isConfirmed) {
      fetch(props.deleteAction, {
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content'),
        },
        method: 'post',
        body: JSON.stringify({ deleteId: props.deleteId }),
      }).then(async (response) => {
        try {
          const data = await response.json();
          notify({
            text: data.message,
            type: data?.type || 'success',
          });
          emit(props.deleteEmitter, props.deleteId);
        } catch (error) {
          notify({
            text: 'An unexpected error occured.',
            type: 'error',
          });
        }
      });
    }
  });
}
</script>

<style lang="scss"></style>
