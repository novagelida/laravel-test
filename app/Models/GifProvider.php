<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GifProvider extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'slug';
    protected $keyType = 'string';

}
