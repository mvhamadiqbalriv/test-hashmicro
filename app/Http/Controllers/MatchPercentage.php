<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatchPercentage extends Controller
{
    public function index()
    {
        return view('match_percentage');
    }

    public function calculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_1' => 'required',
            'input_2' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ], 400);
        }
        
        if($request->type == '1'){
            $input1 = strtolower($request->input_1);
            $input2 = strtolower($request->input_2);
        }else{
            $input1 = $request->input_1;
            $input2 = $request->input_2;
        }

        $count = 0;
        $sameChar = [];
        $length = strlen($input1);

        for($i=0; $i<$length; $i++) {
            if(strpos($input2, $input1[$i]) !== false) {
                if(in_array($input1[$i], $sameChar)){
                    continue;
                }
                $sameChar[] = $input1[$i];
                $count++;
            }
        }

        return response()->json([
            'status' => true,
            'data' => [
                'char' => $sameChar,
                'result' => ($count / $length) * 100
            ]
        ]);
    }
}
