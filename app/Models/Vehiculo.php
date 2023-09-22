<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehiculo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "vehiculo";

    public function Transportistas() {
        return $this -> hasMany(Transportista::class);
    }
}