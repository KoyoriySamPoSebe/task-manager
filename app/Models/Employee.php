<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'status'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_employee', 'employee_id', 'task_id');
    }
}
