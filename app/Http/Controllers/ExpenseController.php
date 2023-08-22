<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index()
    {
        $user = User::with(['role', 'expenses'])->find(Auth::id());
        foreach($user->expenses as $expenses) {
            $expenses->expenseCategory;
        }
        $user = $user->toArray();
        $user['role'] = $user['role']['name'];

        return Inertia::render('Expenses', [
          'user' => $user
        ]);
    }

    public function create(Request $request)
    {
        $expenses = new Expense();
        $expenses->name = $request->name;
        $expenses->description = $request->description;
        $expenses->save();
        $expenses = $expenses->toArray();
        $expenses['created_at'] = date("Y-m-d", strtotime($expenses['created_at']));
        return response()->json(['message' => 'Expense Category successfully added', 'expenseCategory' => $expenses]);
    }

    public function update(Request $request)
    {
        $expenses = Expense::find($request->id);
        $expenses->name = $request->name;
        $expenses->description = $request->description;
        $expenses->save();
        $expenses = $expenses->toArray();
        $expenses['created_at'] = date("Y-m-d", strtotime($expenses['created_at']));
        return response()->json(['message' => 'Expense Category successfully updated', 'expenseCategory' => $expenses]);
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
