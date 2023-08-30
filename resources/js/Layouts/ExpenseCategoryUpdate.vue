<template>
  <Modal
    :id="'update-expenseCategory'"
    :action="'/expenses/category:update'"
    :title="'Update Category'"
    :submit="'Update'"
    :deleteId="selectedRow?.id"
    :deleteAction="'/expenses/category:delete'"
    :deleteEmitter="'expenseCategory-deleted'"
  >
    <input type="hidden" name="id" :value="selectedRow?.id" />
    <div class="align-items-center">
      <div class="row mb-2">
        <div class="col-4">
          <label for="display_name" class="col-form-label">
            Display Name
          </label>
        </div>
        <div class="col-8">
          <input
            type="text"
            id="display_name"
            name="name"
            class="form-control"
            autocomplete="off"
            :value="selectedRow?.name"
            required
          />
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <label for="description" class="col-form-label"> Description </label>
        </div>
        <div class="col-8">
          <textarea
            type="text"
            id="description"
            name="description"
            class="form-control"
            autocomplete="off"
            required
            >{{ selectedRow?.description }}</textarea
          >
        </div>
      </div>
    </div>
  </Modal>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Modal from './Modal.vue';
import Vts from 'vts.js';
import Swal from 'sweetalert2';
import { closeModal, notify } from '../helpers';
const emit = defineEmits(['expenseCategory-updated']);
defineProps({ selectedRow: Object });

onMounted(() => {
  new Vts('update-expenseCategory-form', {
    ajax: {
      success: ({ message, expenseCategory }, response, form) => {
        notify({ text: message });
        form.classList.remove('was-validated');
        form.reset();
        closeModal('update-expenseCategory-modal');
        emit('expenseCategory-updated', expenseCategory);
        Swal.close();
      },
    },
  });
});
</script>

<style lang="scss" scoped></style>
