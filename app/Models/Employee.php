<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = "employees";

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['id', 'firstname', 'lastname', 'age', 'department', 'position'];

    protected $hidden = ['created_at', 'updated_at'];

    public static $rules = [
        'id' => 'required|string|size:8|unique:employees,id',
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'age' => 'required|integer|min:18|max:100',
        'department' => 'required|string|max:255',
        'position' => 'required|string|max:255',
    ];

    public static $updateRules = [
        'id' => 'prohibited',
        'firstname' => 'string|max:255',
        'lastname' => 'string|max:255',
        'age' => 'integer|min:18|max:100',
        'department' => 'string|max:255',
        'position' => 'string|max:255',
    ];
}
