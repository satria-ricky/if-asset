<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aturan;
use App\Models\Employ;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AturanController extends Controller
{
    public function index(){
        $data = Aturan::get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of Data',
            'data' => $data
        ], 200);
     }
 
     public function get($id){
         $data = Aturan::where('id',$id)->first();
         if($data){
             return response()->json([
                 'status' => 'success',
                 'message' => 'Detail Aturan Found',
                 'data' => $data
             ], 200);
         }else{
             return response()->json([
                 'status' => 'error',
                 'message' => 'Detail Aturan Not Found',
                 'data' => null
             ], 404);
         }
     }
 
     public function store(Request $request){
         $validator = Validator::make($request->all(),[
             "jam_masuk" => "required",
             "toleransi" => "required",
             "jam_masuk_set" => "required",
             "jam_pulang" => "required",
             "jam_pulang_jum" => "required",
             "lama_kerja" => "required",
             "um_max_masuk" => "required",
             "um_min_pulang" => "required",
             "periode" => "required",
         ]);
 
         if($validator->fails()){
             return response()->json([
                 'status' => 'Error',
                 'message' => $validator->messages()->all()
             ],500);
         }
       
         $data = new Aturan;
         $data->jam_masuk = $request->jam_masuk;
         $data->toleransi = $request->toleransi;
         $data->jam_masuk_set = $request->jam_masuk_set;
         $data->jam_pulang = $request->jam_pulang;
         $data->jam_pulang_jum = $request->jam_pulang_jum;
         $data->lama_kerja = $request->lama_kerja;
         $data->um_max_masuk = $request->um_max_masuk;
         $data->um_min_pulang = $request->um_min_pulang;
         $data->periode = $request->periode;
         $data->save();
         
         return response()->json([
             'status' => 'success',
             'message' => 'New Aturan Created',
             'data' => $data
         ], 201);
     }
 
     public function update(Request $request, $id){
         $validator = Validator::make($request->all(),[
            "jam_masuk" => "required",
            "toleransi" => "required",
            "jam_masuk_set" => "required",
            "jam_pulang" => "required",
            "jam_pulang_jum" => "required",
            "lama_kerja" => "required",
            "um_max_masuk" => "required",
            "um_min_pulang" => "required",
            "periode" => "required",
         ]);
 
         if($validator->fails()){
             return response()->json([
                 'status' => 'Error',
                 'message' => $validator->messages()->all(),
             ],500);
         }
         
         $data = Aturan::firstWhere('id',$id);
         if ($data){
            $data->jam_masuk = $request->jam_masuk;
            $data->toleransi = $request->toleransi;
            $data->jam_masuk_set = $request->jam_masuk_set;
            $data->jam_pulang = $request->jam_pulang;
            $data->jam_pulang_jum = $request->jam_pulang_jum;
            $data->lama_kerja = $request->lama_kerja;
            $data->um_max_masuk = $request->um_max_masuk;
            $data->um_min_pulang = $request->um_min_pulang;
            $data->periode = $request->periode;
             $data->update();
             return response()->json([
                 'status' => 'success',
                 'message' => 'Aturan Updated',
                 'data' => $data
             ], 201);
         }else{
             return response()->json([
                 'status' => 'error',
                 'message' => 'Aturan Not Found',
                 'data' => null
             ], 404);
         }
     }
 
     public function destroy($id){
         $data = Aturan::findOrFail($id);
         $data->delete();
         return response()->json([
             'status' => 'success',
             'message' => 'Detail Aturan Deleted',
             'data' => null
         ], 201);
     }
 
     public function send(Request $request){
         return $request->card;
     }
}
