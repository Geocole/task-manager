<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function budget(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format(intval($value), 2, '.', ''),
            set: fn ($value) => $value
        );
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

}
