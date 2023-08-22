<template>
  <Modal
    :id="'update-role'"
    :action="'/role:update'"
    :title="'Update Role'"
    :submit="'Update'"
  >
    <input type="hidden" name="id" :value="selectedRow?.id" />
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
            :value="selectedRow?.name"
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
            >{{ selectedRow?.description }}</textarea
          >
        </div>
      </div>
    </div>
    <template #deleteBtn>
      <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">
        Delete
      </button>
    </template>
  </Modal>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Modal from './Modal.vue';
import Vts from 'vts-form';
import Swal from 'sweetalert2';
import { closeModal } from '../helpers';
const updateRole = ref(null);
const emit = defineEmits(['role-updated']);
defineProps({ selectedRow: Object });

onMounted(() => {
  updateRole.value = new Vts('update-role-form', {
    ajax: {
      success: ({ title, message, role }, response, form) => {
        Swal.fire({
          title: title,
          html: message,
          icon: 'success',
        });
        form.classList.remove('was-validated');
        form.reset();
        closeModal('update-role-modal');
        emit('role-updated', role);
      },
    },
  });
});
</script>

<style lang="scss" scoped></style>
