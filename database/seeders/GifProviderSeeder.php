<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GifProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gif_providers')->insert([
            'identifier' => 'tenor',
            'description' => 'this is tenor',
            'calls' => 0,
            'credentials' => json_encode(['api_key' => '7E8WQAGAZ1I1', 'protocol' => 'https']),
            'research_endpoint' => 'api.tenor.com/v1/search'
        ]);

        //Example: http://api.giphy.com/v1/gifs/search?q=ryan+gosling&api_key=YOUR_API_KEY&limit=5
        DB::table('gif_providers')->insert([
            'identifier' => 'giphy',
            'description' => 'this is giphy',
            'calls' => 0,
            'credentials' => json_encode(['api_key' => 'XJjbtjbIsJxVdFirK8GXHN85ulrTHCt4', 'protocol' => 'http']),
            'research_endpoint' => 'api.giphy.com/v1/gifs/search'
        ]);

    }
}
