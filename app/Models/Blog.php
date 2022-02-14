<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'title';
    }

    public function politician() {
        return $this->hasOne(Politician::class);
    }

    public function post() {
        $table = new Post;
        $table->setTable($this->politician()->nick());
        return $table->find($this->postId());
    }
}
