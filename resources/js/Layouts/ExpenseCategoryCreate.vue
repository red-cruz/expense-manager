<template>
  <Modal
    :id="'add-expenseCategory'"
    :action="'/expenses/category:create'"
    :title="'Add Category'"
  >
    <div class="align-items-center">
      <div class="row mb-2">
        <div class="col-4">
          <label for="display_name-create" class="col-form-label">
            Display Name
          </label>
        </div>
        <div class="col-8">
          <input
            type="text"
            id="display_name-create"
            name="name"
            class="form-control"
            autocomplete="off"
            required
          />
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <label for="description-create" class="col-form-label">
            Description
          </label>
        </div>
        <div class="col-8">
          <textarea
            type="text"
            id="description-create"
            name="description"
            class="form-control"
            autocomplete="off"
            required
          ></textarea>
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
const addexpenseCategory = ref(null);
const emit = defineEmits(['expenseCategory-created']);

onMounted(() => {
  addexpenseCategory.value = new Vts('add-expenseCategory-form', {
    ajax: {
      success: ({ message, expenseCategory }, response, form) => {
        notify({ text: message });
        form.classList.remove('was-validated');
        form.reset();
        closeModal('add-expenseCategory-modal');
        emit('expenseCategory-created', expenseCategory);
        Swal.close();
      },
    },
  });
});
</script>

<style lang="scss" scoped></style>
