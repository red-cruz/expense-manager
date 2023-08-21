<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import Breadcrumb from '../Partials/Breadcrumb.vue';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
defineProps({ user: Object });
const props = usePage().props;
const user = computed(() => props.user);
const expenses = computed(() => user.value.expenses);

onMounted(() => {
  const ctx = document.getElementById('myExpenses');

  // convert to array
  const expensesArr = Object.values(expenses.value);
  // get array of categories
  const categories = expensesArr.map((expense) => expense.expense_category);
  // get array of total amounts
  const total_amounts = expensesArr.map((expense) => expense.total_amount);

  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: categories,
      datasets: [
        {
          data: total_amounts,
        },
      ],
    },
  });
});
</script>

<template>
  <Head title="Dashboard" />
  <Breadcrumb :page-title="'My Expenses'">
    <li class="breadcrumb-item fw-bold" aria-current="page">Dashboard</li>
  </Breadcrumb>

  <div class="text-center">
    <div class="row">
      <div class="col-6">
        <div class="row">
          <h6 class="col-6">Expense Categories</h6>
          <h6 class="col-6">Total</h6>
        </div>

        <div v-for="expense in expenses" class="row">
          <div class="col-6">
            {{ expense.expense_category }}
          </div>
          <div class="col-6">$ {{ expense.total_amount }}</div>
        </div>
      </div>
      <div class="col-6">
        <canvas id="myExpenses"></canvas>
      </div>
    </div>
    <!-- <div v-else>No expenses to show</div> -->
  </div>
</template>
