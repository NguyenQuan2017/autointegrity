<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarPart extends Model
{
    protected $table="aiCarPart";
    protected $fillable=['VehicleMake','VehicleModel','VehicleBadge','VehicleSeries'];

    public function parts(){

        return $this->hasOne('App\Models\Part','aiCarPartId','ID');

    }
}
