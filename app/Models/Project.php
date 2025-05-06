<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'client_name',
        'project_manager',
        'budget',
        'status',
        'start_date',
        'end_date',
        'delivery_date',
        'location',
        'category',
        'code',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('priority');
    }

    // Accessor pour name (capitalize automatiquement)
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
            set: fn($value) => strtolower($value)
        );
    }

    // Accessor pour budget avec 2 décimales
    protected function budget(): Attribute
    {
        return Attribute::make(
            get: fn($value) => number_format($value, 2, '.', ''),
            set: fn($value) => $value
        );
    }
}
