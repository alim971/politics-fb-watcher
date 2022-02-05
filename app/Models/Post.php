<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\Page
 *
 * @property int            $id
 * @property string         $text
 * @property bool           $edit
 * @property \Carbon\Carbon $date
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page wherePublic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereDate($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PageText[] $pageText
 */
class Post extends Model
{
    use HasFactory;

    protected $dates = ['date'];
    protected $fillable = [
        'id',
        'text',
        'edit',
        'date',
        'img'
    ];

    public function shortText() {
        return Str::limit($this->text, 150, $end='...');
    }

    public function firstWords($numberOfWords = 5, $ending = '...') {
        return Str::words($this->text, $numberOfWords, $ending);
    }

    public function politician() {
        return Politician::firstWhere('nick', str_replace('_', '.', $this->getTable()));
    }
}