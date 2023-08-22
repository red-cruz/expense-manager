<script setup>
import ThemeToggle from '../Partials/ThemeToggle.vue';
import Navigation from './Navigation.vue';

defineProps({ user: Object });
</script>

<template>
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <Navigation :user="user" />
      <div class="col py-3">
        <ul class="nav justify-content-between border-bottom">
          <li class="nav-item"><ThemeToggle /></li>
          <div class="d-flex">
            <li class="nav-item me-3 me-lg-5">
              <p>Welcome to Expense Manager</p>
            </li>
            <li class="nav-item">
              <a
                id="logout-btn"
                href="/logout"
                class="text-dark link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                tabindex="-1"
                role="button"
                >Log out</a
              >
            </li>
          </div>
        </ul>
        <main class="container mt-4">
          <slot></slot>
        </main>
      </div>
    </div>
  </div>
</template>
<style lang="scss">
@import 'noty/src/noty.scss';
@import 'noty/src/themes/bootstrap-v4.scss';
</style>
<style scoped>
.btn {
  border: none;
}
</style>
