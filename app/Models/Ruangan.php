<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_ruangan';
    protected $guarded = ['id_ruangan'];
    protected $keyType = 'string';
    public $incrementing = false;
    
}
