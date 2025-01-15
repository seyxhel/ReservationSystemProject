<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $fillable = [
        'name',
        'email',
        'student_id',
        'program',
        'year_section',
        'gender',
        'birthday',
        'contact_number',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
