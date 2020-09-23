<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GifProvider extends Model
{
    use HasFactory;

    //TODO: $incrementig = false is probably overhead
    public $incrementing = false;
    protected $primaryKey = 'identifier';
    protected $keyType = 'string';
    protected $hidden = ['pivot'];

    public function keyword()
    {
        return $this->belongsToMany(Keyword::class);
    }
}
