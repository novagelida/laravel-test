<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;
    
    //TODO: $incrementig = false is probably overhead
    public $incrementing = false;
    protected $primaryKey = 'value';
    protected $keyType = 'string';
    protected $hidden = ['pivot'];

    public function search($value)
    {
        //TODO: we want to insert a new record here. We don't want to save an existing one
        $this->value = $value;
        $this->save();
    }

    public function gifProvider()
    {
        return $this->belongsToMany(GifProvider::class);
    }
}
