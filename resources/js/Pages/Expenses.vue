<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import Breadcrumb from '../partials/Breadcrumb.vue';
import { onMounted, reactive, ref } from 'vue';
import ExpenseCreate from '../Layouts/ExpenseCreate.vue';
import ExpenseUpdate from '../Layouts/ExpenseUpdate.vue';
import Select from 'datatables.net-select';
import { Modal } from 'bootstrap';
DataTable.use(Select);
DataTable.use(DataTablesCore);

defineProps({ isAdmin: Boolean, expenses: Object });
const emit = defineEmits(['update-expense']);
let dt;
const table = ref();
const selectedRow = ref(null);
const data = ref(usePage().props.expenses);
const options = {
  searching: false,
  info: false,
  order: [0, 'asc'],
  paging: false,
  select: true,
  columns: [
    { data: 'id' },
    { data: 'expense' },
    { data: 'description' },
    { data: 'created_at' },
    { data: 'updated_at' },
  ],
  columnDefs: [
    {
      targets: [0, 4],
      visible: false,
    },
  ],
};

onMounted(() => {
  dt = table.value.dt;
});

function create(expense) {
  data.value.push(expense);
}
function update(expense) {
  let idx = data.value.findIndex((r) => r.id === expense.id);
  data.value[idx] = expense;
}
function remove(expenseId) {
  let idx = data.value.findIndex((r) => r.id === expenseId);
  data.value.splice(idx, 1);
}
function showUpdateModal() {
  const selected = dt.row('.selected');
  selectedRow.value = selected.data();
  Modal.getOrCreateInstance('#update-expense-modal').show();
}
</script>

<template>
  <Head title="Expenses" />
  <Breadcrumb :page-title="'Expense Management'">
    <li class="breadcrumb-item">Expense Management</li>
    <li class="breadcrumb-item fw-bold" aria-current="page">Expenses</li>
  </Breadcrumb>

  <div class="container">
    <DataTable
      ref="table"
      :data="data"
      :options="options"
      class="table table-striped table-hover border border-2 border-dark-subtle"
      @select="showUpdateModal"
    >
      <thead>
        <tr>
          <th>Id</th>
          <th>Expense Category</th>
          <th>Description</th>
          <th>Created at</th>
          <th>Updated at</th>
        </tr>
      </thead>
    </DataTable>
    <div class="sticky-bottom float-end pb-4 pe-2">
      <button
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#add-expense-modal"
        class="btn btn-light border border-2"
      >
        Add Category
      </button>
    </div>
  </div>
  <ExpenseCreate @expense-created="create" />
  <ExpenseUpdate
    :selectedRow="selectedRow"
    @expense-updated="update"
    @expense-deleted="remove"
  />
</template>
<style></style>
