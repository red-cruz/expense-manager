<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import Breadcrumb from '../partials/Breadcrumb.vue';
import { onMounted, reactive, ref } from 'vue';
import ExpenseCategoryCreate from '../Layouts/ExpenseCategoryCreate.vue';
import ExpenseCategoryUpdate from '../Layouts/ExpenseCategoryUpdate.vue';
import Select from 'datatables.net-select';
import { Modal } from 'bootstrap';
DataTable.use(Select);
DataTable.use(DataTablesCore);

defineProps({ expenseCategories: Object });
const emit = defineEmits(['update-expenseCategory']);
let dt;
const table = ref();
const selectedRow = ref(null);
const data = ref(usePage().props.expenseCategories);
const options = {
  searching: false,
  info: false,
  order: [0, 'asc'],
  paging: false,
  select: true,
  columns: [
    { data: 'id' },
    { data: 'name' },
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

function create(expenseCategory) {
  data.value.push(expenseCategory);
}
function update(expenseCategory) {
  let idx = data.value.findIndex((r) => r.id === expenseCategory.id);
  data.value[idx] = expenseCategory;
}
function remove(expenseCategoryId) {
  let idx = data.value.findIndex((r) => r.id === expenseCategoryId);
  data.value.splice(idx, 1);
}
function showUpdateModal() {
  const selected = dt.row('.selected');
  selectedRow.value = selected.data();
  Modal.getOrCreateInstance('#update-expenseCategory-modal').show();
}
</script>

<template>
  <Head title="Expense Categories" />
  <Breadcrumb :page-title="'Expense Management'">
    <li class="breadcrumb-item">Expense Management</li>
    <li class="breadcrumb-item fw-bold" aria-current="page">
      Expense Categories
    </li>
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
          <th>Display Name</th>
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
        data-bs-target="#add-expenseCategory-modal"
        class="btn btn-light border border-2"
      >
        Add Category
      </button>
    </div>
  </div>
  <ExpenseCategoryCreate @expenseCategory-created="create" />
  <ExpenseCategoryUpdate
    :selectedRow="selectedRow"
    @expenseCategory-updated="update"
    @expenseCategory-deleted="remove"
  />
</template>
<style></style>
