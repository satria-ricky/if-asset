<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeptController extends Controller
{
    public function index(){
        $data = Dept::get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of Dept',
            'data' => $data
        ], 200);
     }
 
    public function get($id){
        $data = Dept::where('id_dept',$id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Dept Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Dept Not Found',
                'data' => null
            ], 404);
        }
    }
 
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "nama_dept" => "required",
            "level" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }
    
        $data = new Dept;
        $data->nama_dept = $request->nama_dept;
        $data->level = $request->level;
        $data->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'New Dept Created',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "nama_dept" => "required",
            "level" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all(),
            ],500);
        }
        
        $data = Dept::firstWhere('id_dept',$id);
        // return $data;
        if ($data){
            $data->nama_dept = $request->nama_dept;
            $data->level = $request->level;
            $data->update();
            return response()->json([
                'status' => 'success',
                'message' => 'Dept Updated',
                'data' => $data
            ], 201);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Dept Not Found',
                'data' => null
            ], 404);
        }
    }

    public function destroy($id){
        $data = Dept::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Detail Dept Deleted',
            'data' => null
        ], 201);
    }

    public function send(Request $request){
        return $request->card;
    }
}
