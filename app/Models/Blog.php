<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        return 'url';
    }

    public function politician() {
        return $this->belongsTo(Politician::class);
    }

    public function post() {
        $table = new Post;
        $table->setTable($this->politician->nick());
        return $table->find($this->post_id);
    }

    public function shortText() {
        return Str::limit($this->text, 150, $end='...');
    }

    public function firstWords($numberOfWords = 5, $ending = '...') {
        return Str::words($this->text, $numberOfWords, $ending);
    }
}
