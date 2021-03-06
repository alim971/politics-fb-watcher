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
        return Str::limit($this->text, 110, $end='...');
    }

    public function firstWords($numberOfWords = 5, $ending = '...') {
        if(strlen($this->text) > 110) {
            return Str::limit(Str::words(strip_tags($this->text), $numberOfWords, $ending), 110, $end = '...');
        }
        return Str::words($this->text, $numberOfWords, $ending);
    }

    public function politician() {
        $politician =  Politician::firstWhere('nick', $this->getTable());
        return $politician ?? Politician::firstWhere('username', $this->getTable());
    }

    public function reaction() {
        $politician =  $this->politician();
        $blog = Blog::where('post_id',$this->id)->where('politician_id', $politician->id)->first();
        return $blog;
    }
}
