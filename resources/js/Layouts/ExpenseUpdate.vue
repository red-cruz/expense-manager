<template>
  <Modal
    :id="'update-expense'"
    :action="'/expenses:update'"
    :title="'Update Expense'"
    :submit="'Update'"
    :deleteId="selectedRow?.id"
    :deleteAction="'/expenses:delete'"
    :deleteEmitter="'expense-deleted'"
  >
    <input type="hidden" name="id" :value="selectedRow?.id" />
    <div class="align-items-center">
      <div class="row mb-2">
        <div class="col-4">
          <label for="expense_category_id" class="col-form-label">
            Expense Category
          </label>
        </div>
        <div class="col-8">
          <select
            id="expense_category_id"
            class="form-select"
            name="expense_category_id"
            :value="selectedRow?.expense_category_id"
          >
            <option v-for="category in categories" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-4">
          <label for="amount" class="col-form-label"> Amount </label>
        </div>
        <div class="col-8">
          <input
            type="number"
            id="amount"
            name="amount"
            class="form-control"
            autocomplete="off"
            min="1"
            :value="selectedRow?.amount"
            required
          />
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <label for="entry_date" class="col-form-label"> Entry Date </label>
        </div>
        <div class="col-8">
          <input
            type="date"
            id="entry_date"
            name="entry_date"
            class="form-control"
            required
            :value="selectedRow?.entry_date"
          />
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
import { usePage } from '@inertiajs/vue3';
const emit = defineEmits(['expense-updated']);
const categories = ref(usePage().props.expenseCategories);
defineProps({ selectedRow: Object });

onMounted(() => {
  new Vts('update-expense-form', {
    ajax: {
      success: ({ message, expense }, response, form) => {
        notify({ text: message });
        form.classList.remove('was-validated');
        form.reset();
        closeModal('update-expense-modal');
        emit('expense-updated', expense);
        Swal.close();
      },
    },
  });
});
</script>

<style lang="scss" scoped></style>
