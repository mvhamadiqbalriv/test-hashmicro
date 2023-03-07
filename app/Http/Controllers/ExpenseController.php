<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ExpenseCategory::get();
        $expense = Expense::get();
        $total = Expense::sum('amount');

        return view('expense.index', compact(
            'categories', 'expense', 'total'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        $data = new Expense([
            'category_id' => $request->category_id,
            'item' => $request->item,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'description' => $request->description
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $expense = Expense::find($id);

        if($expense){
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        $data->category_id = $request->category_id ?: $data->category_id;
        $data->item = $request->item ?: $data->item;
        $data->price = $request->price ?: $data->price;
        $data->quantity = $request->quantity ?: $data->quantity;
        $data->amount = $request->amount ?: $data->amount;
        $data->description = $request->description ?: $data->description;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
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
