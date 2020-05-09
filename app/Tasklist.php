<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasklist extends Model
{
    public function task()
    {
        return $this->hasMany(Task::class);
    }
}
