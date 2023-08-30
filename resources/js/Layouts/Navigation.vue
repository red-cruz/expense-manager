<template>
  <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0">
    <nav
      class="d-flex flex-column align-items-start px-3 pt-2 min-vh-100 text-white"
    >
      <NavProfile :role="user.role" />
      <p>{{ user.name }}({{ user.role }})</p>
      <ul class="nav flex-column align-items-start">
        <NavLink :href="'/'" :page="$inertia.page.url">Dashboard</NavLink>
        <div v-if="user.role_id === 1">
          <p class="m-1 mt-2 ms-0 align-middle">User Management</p>
          <ul class="nav flex-column">
            <NavLink :href="'/roles'" class="ms-3" :page="$inertia.page.url"
              >Roles</NavLink
            >
            <NavLink :href="'/users'" class="ms-3" :page="$inertia.page.url">
              Users
            </NavLink>
          </ul>
        </div>
        <p class="m-1 mt-2 ms-0 align-middle">Expense Management</p>
        <ul class="nav flex-column">
          <NavLink
            v-if="user.role_id === 1"
            :href="'/expenses/category'"
            class="ms-3"
            :page="$inertia.page.url"
          >
            Expense Categories
          </NavLink>
          <NavLink :href="'/expenses'" class="ms-3" :page="$inertia.page.url">
            Expenses
          </NavLink>
        </ul>
        <a
          v-if="user.role_id !== 1"
          href="#"
          data-bs-toggle="modal"
          data-bs-target="#update-password-modal"
          class="mt-2 text-white link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
        >
          Update password
        </a>
      </ul>
    </nav>
  </div>
  <Modal
    v-if="user.role_id !== 1"
    :id="'update-password'"
    :action="'/password:update'"
    :title="'Change password'"
    :submit="'Update'"
  >
    <div class="align-items-center">
      <div class="row mb-2">
        <div class="col-4">
          <label for="previous_password" class="col-form-label">
            Current password
          </label>
        </div>
        <div class="col-8">
          <input
            type="password"
            id="previous_password"
            name="previous_password"
            class="form-control"
            autocomplete="current-password"
            required
            minlength="6"
          />
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4">
          <label for="password" class="col-form-label"> New password </label>
        </div>
        <div class="col-8">
          <input
            type="password"
            id="password"
            name="password"
            class="form-control"
            autocomplete="new-password"
            required
            minlength="6"
          />
        </div>
      </div>
    </div>
  </Modal>
</template>

<script setup>
import NavProfile from '../Partials/NavProfile.vue';
import NavLink from '../Partials/NavLink.vue';
import Modal from './Modal.vue';
import Vts from 'vts.js';
import { onMounted } from 'vue';
import { closeModal, notify } from '../helpers';
import Swal from 'sweetalert2';
import { usePage } from '@inertiajs/vue3';
defineProps({ user: Object, page: String });
onMounted(() => {
  if (usePage().props.user.role_id !== 1)
    new Vts('update-password-form', {
      ajax: {
        success: ({ title }, response, form) => {
          notify({ text: title });
          form.classList.remove('was-validated');
          form.reset();
          closeModal('update-password-modal');
          Swal.close();
        },
      },
    });
});
</script>

<style lang="scss" scoped>
.col-auto {
  background-color: #134f5c;
}
</style>
