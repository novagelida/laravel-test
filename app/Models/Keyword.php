<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'value';
    protected $keyType = 'string';
    protected $hidden = ['pivot'];

    public function gifProvider()
    {
        return $this->belongsToMany(GifProvider::class)->withPivot('call_counter');
    }
}
