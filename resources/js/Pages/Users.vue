<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import Breadcrumb from '../partials/Breadcrumb.vue';
import { onMounted, ref } from 'vue';
import RoleCreate from '../Layouts/RoleCreate.vue';
import RoleUpdate from '../Layouts/RoleUpdate.vue';
import Select from 'datatables.net-select';
import { Modal } from 'bootstrap';
DataTable.use(Select);
DataTable.use(DataTablesCore);

defineProps({ isAdmin: Boolean, roles: Object });
const emit = defineEmits(['update-role']);
let dt;
const table = ref();
const selectedRow = ref(null);
const data = ref(usePage().props.roles);
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

function create(role) {
  data.value.push(role);
}
function update(role) {
  let idx = data.value.findIndex((r) => r.id === role.id);
  data.value[idx] = role;
}
function remove(roleId) {
  let idx = data.value.findIndex((r) => r.id === roleId);
  data.value.splice(idx, 1);
}
function showUpdateModal() {
  const selected = dt.row('.selected');
  if (selected.index() === 0) return; // admin
  selectedRow.value = selected.data();
  Modal.getOrCreateInstance('#update-role-modal').show();
}
</script>

<template>
  <Head title="Roles" />
  <Breadcrumb :page-title="'Roles'">
    <li class="breadcrumb-item">User Management</li>
    <li class="breadcrumb-item fw-bold" aria-current="page">Roles</li>
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
        data-bs-target="#add-role-modal"
        class="btn btn-light border border-2"
      >
        Add Role
      </button>
    </div>
  </div>
  <RoleCreate @role-created="create" />
  <RoleUpdate
    :selectedRow="selectedRow"
    @role-updated="update"
    @role-deleted="remove"
  />
</template>
<style></style>
