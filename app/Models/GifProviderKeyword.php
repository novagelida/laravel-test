<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GifProviderKeyword extends Pivot
{
    public $timestamps = false;
    protected $table = "gif_provider_keyword";
}
