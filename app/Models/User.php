<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'dni', 'phone', 'avatar', 'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'student_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function reviewedOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'reviewed_by');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isTeacher(): bool
    {
        return $this->hasRole('profesor');
    }

    public function isStudent(): bool
    {
        return $this->hasRole('estudiante');
    }
}
