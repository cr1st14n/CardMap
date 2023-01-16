<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    // use HasFactory;
    protected $connection = 'sqlsrv';

    protected $table='Empleados';
    protected $primaryKey = 'idEmpleado'; 
    public $timestamps = false;
}
