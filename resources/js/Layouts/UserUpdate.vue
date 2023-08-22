<template>
  <Modal
    :id="'update-user'"
    :action="'/user:update'"
    :title="'Update user'"
    :submit="'Update'"
    :withDelete="true"
    :deleteId="selectedRow?.id"
    :_for="'user'"
  >
    <input type="hidden" name="id" :value="selectedRow?.id" />
    <div class="align-items-center">
      <div class="row mb-2">
        <div class="col-4">
          <label for="name" class="col-form-label"> Name </label>
        </div>
        <div class="col-8">
          <input
            type="text"
            id="name"
            name="name"
            class="form-control"
            autocomplete="name"
            :value="selectedRow?.name"
            required
          />
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-4">
          <label for="email" class="col-form-label"> Email address </label>
        </div>
        <div class="col-8">
          <input
            type="email"
            id="email"
            name="email"
            class="form-control"
            autocomplete="email"
            :value="selectedRow?.email"
            required
          />
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <label for="role" class="col-form-label"> Role </label>
        </div>
        <div class="col-8">
          <select class="form-select" name="role" :value="selectedRow?.role_id">
            <option v-for="role in roles" :value="role.id">
              {{ role.name }}
            </option>
          </select>
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
const updateuser = ref(null);
const emit = defineEmits(['user-updated']);
defineProps({ selectedRow: Object, roles: Object });

onMounted(() => {
  updateuser.value = new Vts('update-user-form', {
    ajax: {
      success: ({ message, user }, response, form) => {
        notify({ text: message });
        form.classList.remove('was-validated');
        form.reset();
        closeModal('update-user-modal');
        emit('user-updated', user);
        Swal.close();
      },
    },
  });
});
</script>

<style lang="scss" scoped></style>
