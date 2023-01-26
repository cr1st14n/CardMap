<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class credVisitante extends Model
{
    protected $connection = 'sqlsrv';

    protected $table='credVisitante';
    // protected $primaryKey = ''; 
    public $timestamps = false;
    use HasFactory;
}
