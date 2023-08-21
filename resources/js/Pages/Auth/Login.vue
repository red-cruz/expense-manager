<template>
  <Head title="Log in" />
  <div class="container mt-5">
    <header class="d-flex justify-content-between">
      <h3 class="mb-3">Log in to Expense Manager</h3>
      <ThemeToggle class="mt-1" />
    </header>
    <form
      id="login-form"
      action="/login"
      method="post"
      class="w-100"
      novalidate
    >
      <div class="form-floating mb-3">
        <input
          type="email"
          class="form-control"
          id="name"
          name="email"
          placeholder="Email"
          autocomplete="email"
          required
          value="admin@email.com"
        />
        <label for="name">Email address</label>
      </div>
      <div class="form-floating">
        <input
          type="password"
          class="form-control"
          id="password"
          name="password"
          placeholder="Password"
          autocomplete="current-password"
          required
          minlength="8"
          value="Pass@1234"
        />
        <label for="password">Password</label>
      </div>
      <button class="btn bg-dark-subtle mt-3 float-end" type="submit">
        Log in
      </button>
    </form>
  </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import ThemeToggle from '../../Partials/ThemeToggle.vue';
import Vts from 'vts-form';
import { onMounted } from 'vue';
import Swal from 'sweetalert2';

onMounted(() => {
  new Vts('login-form', {
    ajax: {
      beforeSend: (requestInit, abortController) => {
        Swal.fire({
          title: 'Logging in...',
          icon: 'info',
          text: 'Please wait.',
          allowOutsideClick: false,
          showCancelButton: true,
          showConfirmButton: false,
          cancelButtonText: 'Cancel',
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.cancel) {
            abortController.abort();
          }
        });
      },
      success: () => {
        Swal.close();
        router.visit('/', { method: 'get' });
      },
    },
  });
});
</script>

<style lang="scss" scoped></style>
