<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AbsenType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsenTypeController extends Controller
{
    public function index(){
        $data = AbsenType::get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of AbsenType',
            'data' => $data
        ], 200);
     }
 
    public function get($id){
        $data = AbsenType::where('id',$id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail AbsenType Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail AbsenType Not Found',
                'data' => null
            ], 404);
        }
    }
 
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "jenis_absen" => "required",
            "nama" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }
    
        $data = new AbsenType;
        $data->jenis_absen = $request->jenis_absen;
        $data->nama = $request->nama;
        $data->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'New AbsenType Created',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "jenis_absen" => "required",
            "nama" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all(),
            ],500);
        }
        
        $data = AbsenType::firstWhere('id',$id);
        // return $data;
        if ($data){
            $data->jenis_absen = $request->jenis_absen;
            $data->nama = $request->nama;
            $data->update();
            return response()->json([
                'status' => 'success',
                'message' => 'AbsenType Updated',
                'data' => $data
            ], 201);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'AbsenType Not Found',
                'data' => null
            ], 404);
        }
    }

    public function destroy($id){
        $data = AbsenType::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Detail AbsenType Deleted',
            'data' => null
        ], 201);
    }

    public function send(Request $request){
        return $request->card;
    }
}
