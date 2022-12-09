<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriRuangan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_histori_ruangan';
    protected $guarded = ['id_histori_ruangan'];
}
