<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name', 'email', 'status'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_employee', 'employee_id', 'task_id');
    }
}


