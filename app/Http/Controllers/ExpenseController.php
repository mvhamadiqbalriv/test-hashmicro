<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{

    public function index()
    {
        $categories = ExpenseCategory::get();
        $expense = Expense::get();
        $total = Expense::sum('amount');

        return view('expense.index', compact(
            'categories', 'expense', 'total'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'item' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'amount' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ], 400);
        }
        
        if ($request->category_id) {
            $categories = explode(',', $request->category_id);
        }

        $data = new Expense([
            'item' => $request->item,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'description' => $request->description
        ]);

        if($data->save()){
            if ($request->category_id) {
                $data->categories()->sync($categories);
            }
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => false
            ], 404);
        }
    }
    
    public function detail($id)
    {
        $expense = Expense::with('categories')->find($id);

        if($expense){
            $expense->categoriesSelected = $expense->categories->pluck('id')->toArray();
            return response()->json([
                'status' => true,
                'data' => $expense
            ]);
        }else{
            return response()->json([
                'status' => false
            ], 404);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'category_id' => 'required',
            'item' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'amount' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ], 400);
        }

        $data = Expense::find($request->id);

        if ($request->category_id) {
            $categories = explode(',', $request->category_id);
        }

        $data->item = $request->item ?: $data->item;
        $data->price = $request->price ?: $data->price;
        $data->quantity = $request->quantity ?: $data->quantity;
        $data->amount = $request->amount ?: $data->amount;
        $data->description = $request->description ?: $data->description;

        if($data->save()){
            if ($request->category_id) {
                $data->categories()->sync($categories);
            }
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => false
            ], 404);
        }
    }
    
    public function delete($id)
    {
        $data = Expense::find($id);

        if($data->delete()){
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => false
            ], 404);
        }
    }

    public function categoriesIndex()
    {
        $categories = ExpenseCategory::get();

        return view('expense.category.index', compact(
            'categories'
        ));
    }

    public function categoriesStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ], 400);
        }

        $data = new ExpenseCategory([
            'name' => $request->name
        ]);

        if($data->save()){
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => false
            ], 404);
        }
    }

    public function categoriesDetail($id)
    {
        $categories = ExpenseCategory::find($id);

        if($categories){
            return response()->json([
                'status' => true,
                'data' => $categories
            ]);
        }else{
            return response()->json([
                'status' => false
            ], 404);
        }
    }

    public function categoriesUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ], 400);
        }

        $data = ExpenseCategory::find($request->id);

        $data->name = $request->name ?: $data->name;

        if($data->save()){
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => false
            ], 404);
        }
    }

    public function categoriesDelete($id)
    {
        $data = ExpenseCategory::find($id);

        if($data->delete()){
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => false
            ], 404);
        }
    }
}
