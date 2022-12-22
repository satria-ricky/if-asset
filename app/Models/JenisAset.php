<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAset extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_jenis';
    protected $guarded = ['id_jenis'];
    
}
