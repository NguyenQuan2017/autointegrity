<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $table = "aiPart";
    protected $fillable = ['PartNumber', 'LowPrice'];

    public function carpart()
    {
        return $this->belongsTo('App\Models\Cartpart');
    }
}
