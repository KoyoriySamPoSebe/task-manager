<?php

namespace App\Models;

use App\Events\TaskStatusUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status'];

    protected $dispatchesEvents = [
        'updated' => TaskStatusUpdated::class,
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'task_employee', 'task_id', 'employee_id');
    }
}
