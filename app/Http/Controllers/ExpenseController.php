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
        try {
            $validated = $request->validate([
              'expense_category_id' => 'required|exists:expense_categories,id',
              'amount' => 'required|Integer|min:1',
              'entry_date' => 'required|date',
            ]);

            $expense = new Expense();
            $expense->user_id = Auth::id();
            $expense->expense_category_id = $validated['expense_category_id'];
            $expense->amount = $validated['amount'];
            $expense->entry_date = $validated['entry_date'];
            $expense->save();
            $expense->expenseCategory;
            $expense = $expense->toArray();

            $expense['created_at'] = date("Y-m-d", strtotime($expense['created_at']));

            return response()->json([
              'message' => '$'.$validated['amount'].' "'.$expense['expense_category']['name'].'" expense has added',
              'expense' => $expense
            ]);

        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json([
              'title' => 'Invalid input',
              'errors' => $err->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
              'title' => 'Error: '.$th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
              'id' => 'exists:expenses,id',
              'expense_category_id' => 'required|exists:expense_categories,id',
              'amount' => 'required|Integer|min:1',
              'entry_date' => 'required|date',
            ]);
            $expense = Expense::find($request->id);
            $expense->expense_category_id = $validated['expense_category_id'];
            $expense->amount = $validated['amount'];
            $expense->entry_date = $validated['entry_date'];
            $expense->save();
            $expense->expenseCategory;
            $expense = $expense->toArray();
            $expense['created_at'] = date("Y-m-d", strtotime($expense['created_at']));

            return response()->json([
              'message' => '$'.$validated['amount'].' "'.$expense['expense_category']['name'].'" expense has updated',
              'expense' => $expense
            ]);

        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json([
              'title' => 'Invalid input',
              'errors' => $err->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
              'title' => 'Error: '.$th->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $validated = $request->validate([
              'deleteId' => 'exists:expenses,id',
            ]);
            $expense = Expense::find($validated['deleteId']);
            $expense->delete();
            return response()->json([
              'message' => '$'.$expense->amount.' expense has been deleted'
            ]);

        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json([
              'title' => 'Invalid input',
              'errors' => $err->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
              'title' => 'Error: '.$th->getMessage()
            ], 500);
        }
    }
}
