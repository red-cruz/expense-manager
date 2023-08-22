<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $user = User::with('role')->find(Auth::id());

        // overwrite
        $user = $user->toArray();
        $user['role'] = $user['role']['name'];

        $expenseCategories = ExpenseCategory::all()->toArray();

        foreach ($expenseCategories as $key => $expenseCategory) {
            $expenseCategories[$key]['created_at'] = date("Y-m-d", strtotime($expenseCategory['created_at']));
        }

        return Inertia::render('ExpenseCategory', [
          'user' => $user,
          'expenseCategories' => $expenseCategories
        ]);
    }

    public function create(Request $request)
    {
        $expenseCategory = new ExpenseCategory();
        $expenseCategory->name = $request->name;
        $expenseCategory->description = $request->description;
        $expenseCategory->save();
        $expenseCategory = $expenseCategory->toArray();
        $expenseCategory['created_at'] = date("Y-m-d", strtotime($expenseCategory['created_at']));
        return response()->json(['message' => 'expenseCategory successfully added', 'expenseCategory' => $expenseCategory]);
    }

    public function update(Request $request)
    {
        $expenseCategory = ExpenseCategory::find($request->id);
        $expenseCategory->name = $request->name;
        $expenseCategory->description = $request->description;
        $expenseCategory->save();
        $expenseCategory = $expenseCategory->toArray();
        $expenseCategory['created_at'] = date("Y-m-d", strtotime($expenseCategory['created_at']));
        return response()->json(['message' => 'expenseCategory successfully updated', 'expenseCategory' => $expenseCategory]);
    }

    public function delete(Request $request)
    {
        $expenseCategory = ExpenseCategory::find($request->deleteId);
        $expenseCategory->delete();
        return response()->json([
          'message' => 'Successfully deleted'
        ]);
    }
}
