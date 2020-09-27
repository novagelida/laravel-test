<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Middleware\Interfaces\IConfigurationProxy;

class SetMaxResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:maxresults {results : number of results to return}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure the maximun number of results returned by a gif search';

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
    public function handle(IConfigurationProxy $configurationProxy)
    {
        $maxResultsToShow = $this->argument('results');

        if ($maxResultsToShow == 0)
        {
            $this->error('results has to be a non-zero, positive integer!');

            return -1;
        }

        $configurationProxy->setMaxResultsToShow($maxResultsToShow);

        return 0;
    }
}
