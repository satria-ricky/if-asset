<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_jurusan';
    protected $guarded = ['id_jurusan'];
    protected $keyType = 'string';
    public $incrementing = false;
    
}
