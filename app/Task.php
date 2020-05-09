<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function tasklist() 
    {
        return $this->belongsTo(Tasklist::class);
    }
}
