<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import Breadcrumb from '../partials/Breadcrumb.vue';
import { onMounted, ref } from 'vue';
// import UserCreate from '../Layouts/UserCreate.vue';
// import UserUpdate from '../Layouts/UserUpdate.vue';
import Select from 'datatables.net-select';
import { Modal } from 'bootstrap';
DataTable.use(Select);
DataTable.use(DataTablesCore);

defineProps({ isAdmin: Boolean, users: Object });
const emit = defineEmits(['update-user']);
let dt;
const table = ref();
const selectedRow = ref(null);
const data = ref(usePage().props.users);
const options = {
  searching: false,
  info: false,
  order: [0, 'asc'],
  paging: false,
  select: true,
  columns: [
    { data: 'id' },
    { data: 'name' },
    { data: 'email' },
    { data: 'role.name' },
    { data: 'created_at' },
    { data: 'updated_at' },
  ],
  columnDefs: [
    {
      targets: [0, 5],
      visible: false,
    },
  ],
};

onMounted(() => {
  dt = table.value.dt;
});

function create(user) {
  data.value.push(user);
}
function update(user) {
  let idx = data.value.findIndex((r) => r.id === user.id);
  data.value[idx] = user;
}
function remove(userId) {
  let idx = data.value.findIndex((r) => r.id === userId);
  data.value.splice(idx, 1);
}
function showUpdateModal() {
  const selected = dt.row('.selected');
  if (selected.index() === 0) return; // admin
  selectedRow.value = selected.data();
  Modal.getOrCreateInstance('#update-user-modal').show();
}
</script>

<template>
  <Head title="Users" />
  <Breadcrumb :page-title="'users'">
    <li class="breadcrumb-item">User Management</li>
    <li class="breadcrumb-item fw-bold" aria-current="page">Users</li>
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
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Created at</th>
          <th>Updated at</th>
        </tr>
      </thead>
    </DataTable>
    <div class="sticky-bottom float-end pb-4 pe-2">
      <button
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#add-user-modal"
        class="btn btn-light border border-2"
      >
        Add user
      </button>
    </div>
  </div>
  <!-- <UserCreate @user-created="create" />
  <UserUpdate
    :selectedRow="selectedRow"
    @user-updated="update"
    @user-deleted="remove"
  /> -->
</template>
<style></style>
