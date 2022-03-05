<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tweet extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $dates = ['posted'];

    protected $fillable = [
        'html', 'posted', 'text',
    ];
    protected $primaryKey = 'id';

    public function shortText() {
        return Str::limit($this->text, 150, $end='...');
    }

    public function firstWords($numberOfWords = 5, $ending = '...') {
        if(Str::startsWith($this->text, '<a') && Str::endsWith($this->text, "a>")) {
            return Str::words(strip_tags($this->text), $numberOfWords, $ending);
        }
        if(strlen($this->text) > 150) {
            return Str::limit(Str::words(strip_tags($this->text), $numberOfWords, $ending), 150, $end = '...');
        }
        return Str::words($this->text, $numberOfWords, $ending);
    }

    public function twitter() {
        return Twitter::firstWhere('db', $this->getTable());
    }
}
