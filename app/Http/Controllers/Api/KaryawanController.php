<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index(){
        $data = Karyawan::get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of Karyawan',
            'data' => $data
        ], 200);
     }
 
    public function get($id){
        $data = Karyawan::where('id_karyawan',$id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Karyawan Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Karyawan Not Found',
                'data' => null
            ], 404);
        }
    }
 
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "nama_depan" => "required",
            "nama_belakang" => "required",
            "pin" => "required",
            "status" => "required",
            "status2" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }
    
        $data = new Karyawan;
        $data->nama_depan = $request->nama_depan;
        $data->nama_belakang = $request->nama_belakang;
        $data->pin = $request->pin;
        $data->status = $request->status;
        $data->status2 = $request->status2;
        $data->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'New Karyawan Created',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "nama_depan" => "required",
            "nama_belakang" => "required",
            "pin" => "required",
            "status" => "required",
            "status2" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all(),
            ],500);
        }
        
        $data = Karyawan::firstWhere('id_karyawan',$id);
        // return $data;
        if ($data){
            $data->nama_depan = $request->nama_depan;
            $data->nama_belakang = $request->nama_belakang;
            $data->pin = $request->pin;
            $data->status = $request->status;
            $data->status2 = $request->status2;
            $data->update();
            return response()->json([
                'status' => 'success',
                'message' => 'Karyawan Updated',
                'data' => $data
            ], 201);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan Not Found',
                'data' => null
            ], 404);
        }
    }

    public function destroy($id){
        $data = Karyawan::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Detail Karyawan Deleted',
            'data' => null
        ], 201);
    }

    public function send(Request $request){
        return $request->card;
    }
}
