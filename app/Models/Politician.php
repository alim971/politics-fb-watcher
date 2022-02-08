<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Politician extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    public function fullName() {
        return $this->name . " " . $this->surname;
    }

    public function nick() {
        return $this->username;
    }
}
