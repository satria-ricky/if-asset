<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalKaryawanController extends Controller
{
    public function index(){
        $data = JadwalKaryawan::get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of JadwalKaryawan',
            'data' => $data
        ], 200);
     }
 
    public function get($id){
        $data = JadwalKaryawan::where('id_jadwal_karyawan',$id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail JadwalKaryawan Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail JadwalKaryawan Not Found',
                'data' => null
            ], 404);
        }
    }
 
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "id_jadwal" => "required",
            "id_karyawan" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }
    
        $data = new JadwalKaryawan;
        $data->id_jadwal = $request->id_jadwal;
        $data->id_karyawan = $request->id_karyawan;
        $data->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'New JadwalKaryawan Created',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "id_jadwal" => "required",
            "id_karyawan" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all(),
            ],500);
        }
        
        $data = JadwalKaryawan::firstWhere('id_jadwal_karyawan',$id);
        // return $data;
        if ($data){
            $data->id_jadwal = $request->id_jadwal;
            $data->id_karyawan = $request->id_karyawan;
            $data->update();
            return response()->json([
                'status' => 'success',
                'message' => 'JadwalKaryawan Updated',
                'data' => $data
            ], 201);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'JadwalKaryawan Not Found',
                'data' => null
            ], 404);
        }
    }

    public function destroy($id){
        $data = JadwalKaryawan::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Detail JadwalKaryawan Deleted',
            'data' => null
        ], 201);
    }

    public function send(Request $request){
        return $request->card;
    }
}
