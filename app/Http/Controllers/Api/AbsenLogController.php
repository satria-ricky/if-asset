<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AbsenLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsenLogController extends Controller
{
    public function index(){
        $data = AbsenLog::get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of AbsenLog',
            'data' => $data
        ], 200);
     }
 
    public function get($id){
        $data = AbsenLog::where('id',$id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail AbsenLog Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail AbsenLog Not Found',
                'data' => null
            ], 404);
        }
    }
 
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "id_dept" => "required",
            "jenis_absen" => "required",
            "pin" => "required",
            "tanggal_absen" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }
    
        $data = new AbsenLog;
        $data->id_dept = $request->id_dept;
        $data->jenis_absen = $request->jenis_absen;
        $data->pin = $request->pin;
        $data->tanggal_absen = $request->tanggal_absen;
        $data->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'New AbsenLog Created',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "id_dept" => "required",
            "jenis_absen" => "required",
            "pin" => "required",
            "tanggal_absen" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all(),
            ],500);
        }
        
        $data = AbsenLog::firstWhere('id',$id);
        // return $data;
        if ($data){
            $data->id_dept = $request->id_dept;
            $data->jenis_absen = $request->jenis_absen;
            $data->pin = $request->pin;
            $data->tanggal_absen = $request->tanggal_absen;
            $data->update();
            return response()->json([
                'status' => 'success',
                'message' => 'AbsenLog Updated',
                'data' => $data
            ], 201);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'AbsenLog Not Found',
                'data' => null
            ], 404);
        }
    }

    public function destroy($id){
        $data = AbsenLog::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Detail AbsenLog Deleted',
            'data' => null
        ], 201);
    }

    public function send(Request $request){
        return $request->card;
    }
}
