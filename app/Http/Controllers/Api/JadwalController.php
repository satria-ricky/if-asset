<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function index(){
        $data = Jadwal::get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of Jadwal',
            'data' => $data
        ], 200);
     }
 
    public function get($id){
        $data = Jadwal::where('id_jadwal',$id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Jadwal Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Jadwal Not Found',
                'data' => null
            ], 404);
        }
    }
 
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "nama_jadwal" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }
    
        $data = new Jadwal;
        $data->nama_jadwal = $request->nama_jadwal;
        $data->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'New Jadwal Created',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "nama_jadwal" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all(),
            ],500);
        }
        
        $data = Jadwal::firstWhere('id_jadwal',$id);
        // return $data;
        if ($data){
            $data->nama_jadwal = $request->nama_jadwal;
            $data->update();
            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal Updated',
                'data' => $data
            ], 201);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Jadwal Not Found',
                'data' => null
            ], 404);
        }
    }

    public function destroy($id){
        $data = Jadwal::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Detail Jadwal Deleted',
            'data' => null
        ], 201);
    }

    public function send(Request $request){
        return $request->card;
    }
}
