<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'status'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'task_employee', 'task_id', 'employee_id');
    }
}


