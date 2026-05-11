<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'category_id', 'title', 'slug', 'description',
        'image', 'price', 'level', 'duration_hours', 'is_published',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_published' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('position');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function approvedOrders(): HasMany
    {
        return $this->hasMany(Order::class)->where('status', 'approved');
    }
}
