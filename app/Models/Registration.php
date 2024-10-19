<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = ['nid', 'name', 'email', 'vaccine_center_id', 'status'];

    public function vaccineCenter()
    {
        return $this->belongsTo(VaccineCenter::class);
    }
}
