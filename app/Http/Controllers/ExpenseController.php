<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index()
    {
        // user info
        $user = User::with(['role'])->find(Auth::id());
        $user = $user->toArray();
        $user['role'] = Role::find($user['role_id'])->name;

        // expenses
        $expenses = ($user['role'] === 'Admin') ? Expense::all() : Expense::where('user_id', Auth::id())->get();
        $user['expenses'] = $expenses->toArray();

        // category
        $expenseCategories = ExpenseCategory::all();

        foreach ($user['expenses'] as $key => $expense) {
            // get expense category
            $category = $expenseCategories->find($expense['expense_category_id']);
            $user['expenses'][$key]['expense_category'] = $category;
            // format date
            $created_at = date("Y-m-d", strtotime($expense['created_at']));
            $user['expenses'][$key]['created_at'] = $created_at;
        }

        return Inertia::render('Expenses', [
          'user' => $user,
          'expenseCategories' => $expenseCategories
        ]);
    }

    public function create(Request $request)
    {
        $expense = new Expense();
        $expense->user_id = Auth::id();
        $expense->expense_category_id = $request->expense_category_id;
        $expense->amount = $request->amount;
        $expense->entry_date = $request->entry_date;
        $expense->save();
        $expense->expenseCategory;
        $expense = $expense->toArray();
        $expense['created_at'] = date("Y-m-d", strtotime($expense['created_at']));
        return response()->json(['message' => 'Expense successfully added', 'expense' => $expense]);
    }

    public function update(Request $request)
    {
        $expense = Expense::find($request->id);
        $expense->expense_category_id = $request->expense_category_id;
        $expense->amount = $request->amount;
        $expense->entry_date = $request->entry_date;
        $expense->save();
        $expense->expenseCategory;
        $expense = $expense->toArray();
        $expense['created_at'] = date("Y-m-d", strtotime($expense['created_at']));
        return response()->json(['message' => 'Expense successfully added', 'expense' => $expense]);
    }

    public function delete(Request $request)
    {
        $expenses = Expense::find($request->deleteId);
        $expenses->delete();
        return response()->json([
          'message' => 'Successfully deleted'
        ]);
    }
}
