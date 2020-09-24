<?php

namespace Database\Factories;

use App\Models\GifProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GifProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GifProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'identifier' => 'tenor',
            'description' => 'this is tenor',
            'calls' => 0,
            'credentials' => json_encode(['api_key' => '7E8WQAGAZ1I1', 'protocol' => 'https']),
            'research_endpoint' => 'api.tenor.com/v1/search'
        ];
    }
}
