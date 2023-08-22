<template>
  <Modal
    :id="'add-expense'"
    :action="'/expenses:create'"
    :title="'Add Expense'"
  >
    <div class="align-items-center">
      <div class="row mb-2">
        <div class="col-4">
          <label for="expense_category_id-create" class="col-form-label">
            Expense Category
          </label>
        </div>
        <div class="col-8">
          <select
            id="expense_category_id-create"
            class="form-select"
            name="expense_category_id"
          >
            <option v-for="category in categories" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-4">
          <label for="amount-create" class="col-form-label"> Amount </label>
        </div>
        <div class="col-8">
          <input
            type="number"
            id="amount-create"
            name="amount"
            class="form-control"
            autocomplete="off"
            min="1"
            required
          />
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <label for="entry_date-create" class="col-form-label">
            Entry Date
          </label>
        </div>
        <div class="col-8">
          <input
            type="date"
            id="entry_date-create"
            name="entry_date"
            class="form-control"
            required
          />
        </div>
      </div>
    </div>
  </Modal>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Modal from './Modal.vue';
import Vts from 'vts-form';
import Swal from 'sweetalert2';
import { closeModal, notify } from '../helpers';
import { usePage } from '@inertiajs/vue3';
const addexpense = ref(null);
const emit = defineEmits(['expense-created']);
const categories = ref(usePage().props.expenseCategories);
onMounted(() => {
  addexpense.value = new Vts('add-expense-form', {
    ajax: {
      success: ({ message, expense }, response, form) => {
        notify({ text: message });
        form.classList.remove('was-validated');
        form.reset();
        closeModal('add-expense-modal');
        emit('expense-created', expense);
        Swal.close();
      },
    },
  });
});
</script>

<style lang="scss" scoped></style>
