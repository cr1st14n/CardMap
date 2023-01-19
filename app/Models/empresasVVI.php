<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresasVVI extends Model
{
    protected $connection = 'sqlsrv2';
    protected $table = 'Empresas';
    use HasFactory;
}
