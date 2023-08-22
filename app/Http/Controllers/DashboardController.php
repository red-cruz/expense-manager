<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::with('role')->find(Auth::id());

        // $expenses
        $expenses = $user->expenses->groupBy('expense_category_id');
        foreach ($expenses as $expense) {
            $expense['expense_category'] = ExpenseCategory::find($expense[0]->expense_category_id)->name;
            $expense['total_amount'] = round($expense->sum('amount'), 2);
        }

        // overwrite
        $user = $user->toArray();
        $user['role'] = Role::find($user['role_id'])->name;
        $user['expenses'] = $expenses;

        return Inertia::render('Dashboard', [
          'user' => $user,
        ]);
    }
}
