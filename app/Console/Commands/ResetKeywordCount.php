<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Middleware\Interfaces\IKeywordProxy;

class ResetKeywordCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keyword:resetcount {keyword}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set to 0 all the providers call counters for the given keyword';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(IKeywordProxy $keywordProxy)
    {
        $keyword = $this->argument('keyword');

        if (empty($keyword))
        {
            $this->error('Please provide a non-empty keyword!');

            return -1;
        }

        $keywordProxy->resetProvidersCallCount($keyword);
        
        return 0;
    }
}
