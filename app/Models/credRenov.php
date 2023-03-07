<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class credRenov extends Model
{
    protected $connection = 'sqlsrv';

    // protected $table='';
    // protected $primaryKey = ''; 
    public $timestamps = false;
    use HasFactory;

}
