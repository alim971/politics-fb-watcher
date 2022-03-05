<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Twitter extends Model
{
    protected $fillable = [
        'name',
        'nick',
        'url',
    ];

    use HasFactory;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'db';
    }

    public function fullName() {
        return $this->name;
    }
}
