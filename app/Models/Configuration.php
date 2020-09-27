<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function updateDefaultGifProvider(string $identifier)
    {
        $this->current_gif_provider = $identifier;
        $this->save();
    }

    public function setMaxResultsTOShow(int $resultsToShow)
    {
        $this->max_results_to_show = $resultsToShow;
        $this->save();
    }
}
