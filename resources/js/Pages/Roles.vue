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

defineProps({ isAdmin: Boolean, roles: Object });

DataTable.use(Select);
DataTable.use(DataTablesCore);
let dt;
const table = ref();
const selectedRow = ref(null);
let roles = usePage().props.roles;
const data = ref(
  Object.values(roles).map(
    ({ id, name, description, created_at, updated_at }) => {
      return [id, name, description, created_at, updated_at];
    },
  ),
);
const options = {
  searching: false,
  info: false,
  ordering: false,
  paging: false,
  select: true,
  columnDefs: [
    {
      targets: [0, 4],
      visible: false,
    },
  ],
};
const emit = defineEmits(['update-role']);
onMounted(() => {
  dt = table.value.dt;
});

function create({ id, name, description, created_at, updated_at }) {
  // roles.push(role);
  data.value.push([id, name, description, created_at, updated_at]);
}
function update(role) {
  console.log(role, data.value);
  let idx = data.value.find((r) => r.id == role.id);
  data.value[idx] = role;
  console.log(idx);
}
function remove(roleId) {
  dt.rows({ selected: true }).every(function () {
    let idx = data.value.indexOf(this.data());
    data.value.splice(idx, 1);
  });
}
function showUpdateModal() {
  const selected = dt.row('.selected');
  if (selected.index() === 0) return; // admin
  const [id, name, description, created_at, updated_at] = selected.data();
  selectedRow.value = { id, name, description, created_at, updated_at };
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
  <RoleUpdate :selectedRow="selectedRow" @role-updated="update" />
</template>
<style></style>
