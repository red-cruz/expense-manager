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
        try {
            $validated = $request->validate([
              'name' => 'required|unique:expense_categories,name|max:255',
              'description' => 'required',
            ]);

            $expenseCategory = new ExpenseCategory();
            $expenseCategory->name = $validated['name'];
            $expenseCategory->description = $validated['description'];
            $expenseCategory->save();
            $expenseCategory = $expenseCategory->toArray();
            $expenseCategory['created_at'] = date("Y-m-d", strtotime($expenseCategory['created_at']));

            return response()->json([
              'message' => $expenseCategory['name'].' has been added to expense categories',
              'expenseCategory' => $expenseCategory
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
              'id' => 'exists:expense_categories,id|Integer',
              'name' => 'required|max:255',
              'description' => 'required',
            ]);
            $expenseCategory = ExpenseCategory::find($validated['id']);
            $expenseCategory->name = $validated['name'];
            $expenseCategory->description = $validated['description'];
            $expenseCategory->save();
            $expenseCategory = $expenseCategory->toArray();
            $expenseCategory['created_at'] = date("Y-m-d", strtotime($expenseCategory['created_at']));

            return response()->json([
              'message' => $expenseCategory['name'].' has been updated',
              'expenseCategory' => $expenseCategory
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
              'deleteId' => 'exists:expense_categories,id',
            ]);
            $expenseCategory = ExpenseCategory::find($validated['deleteId']);
            $expenseCategory->delete();
            return response()->json([
              'message' => $expenseCategory->name.' has been deleted'
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
