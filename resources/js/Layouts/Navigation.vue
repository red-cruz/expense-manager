<template>
  <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0">
    <nav
      class="d-flex flex-column align-items-start px-3 pt-2 min-vh-100 text-white"
    >
      <NavProfile :role="user.role" />
      <p>{{ user.name }}({{ user.role }})</p>
      <ul class="nav flex-column align-items-start">
        <NavLink :href="'/'" :page="$inertia.page.url">Dashboard</NavLink>
        <div>
          <p class="m-1 mt-2 ms-0 align-middle">User Management</p>
          <ul class="nav flex-column">
            <NavLink :href="'/roles'" class="ms-3" :page="$inertia.page.url"
              >Roles</NavLink
            >
            <NavLink :href="'/test'" class="ms-3" :page="$inertia.page.url">
              Users
            </NavLink>
          </ul>
        </div>
        <p class="m-1 mt-2 ms-0 align-middle">Expense Management</p>
        <ul class="nav flex-column">
          <NavLink
            v-if="user.role === 'Admin'"
            :href="'/test'"
            class="ms-3"
            :page="$inertia.page.url"
          >
            Expense Categories
          </NavLink>
          <NavLink :href="'/test'" class="ms-3" :page="$inertia.page.url">
            Expenses
          </NavLink>
        </ul>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import NavProfile from '../Partials/NavProfile.vue';
import NavLink from '../Partials/NavLink.vue';

defineProps({ user: Object, page: String });
</script>

<style lang="scss" scoped>
.col-auto {
  background-color: #134f5c;
}
</style>
