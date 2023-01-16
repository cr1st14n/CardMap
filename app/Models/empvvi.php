<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empvvi extends Model
{
     
    protected $connection = 'sqlsrv2';
    protected $table = 'Empleados';
    // protected $primaryKey = 'idPuerta';
    use HasFactory;
}
