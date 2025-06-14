<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory;
    use HasRoles;
    use Notifiable;

    protected $guard_name = 'api';

    protected $fillable = ['name', 'email', 'status'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_employee', 'employee_id', 'task_id');
    }
}
