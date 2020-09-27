<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'value';
    protected $keyType = 'string';
    protected $hidden = ['pivot'];

    public function gifProviders()
    {
        return $this->belongsToMany(GifProvider::class)->withPivot('call_counter');
    }

    public function incrementCalls()
    {
        $this->increment('calls', 1);
        $this->save();
    }
}
