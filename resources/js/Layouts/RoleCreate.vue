<template>
  <Modal :id="'add-role'" :action="'/role:create'" :title="'Add Role'">
    <div class="align-items-center">
      <div class="row mb-2">
        <div class="col-4">
          <label for="display_name" class="col-form-label">
            Display Name
          </label>
        </div>
        <div class="col-8">
          <input
            type="text"
            id="display_name"
            name="name"
            class="form-control"
            autocomplete="off"
            required
          />
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <label for="description" class="col-form-label"> Description </label>
        </div>
        <div class="col-8">
          <textarea
            type="text"
            id="description"
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
import Vts from 'vts-form';
import Swal from 'sweetalert2';
import { closeModal, notify } from '../helpers';
const addRole = ref(null);
const emit = defineEmits(['role-created']);

onMounted(() => {
  addRole.value = new Vts('add-role-form', {
    ajax: {
      success: ({ message, role }, response, form) => {
        notify({ text: message });
        form.classList.remove('was-validated');
        form.reset();
        closeModal('add-role-modal');
        emit('role-created', role);
        Swal.close();
      },
    },
  });
});
</script>

<style lang="scss" scoped></style>
