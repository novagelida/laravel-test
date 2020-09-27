<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\DefaultProviderChanged;

class SetProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:provider {id : provider identifier}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change default provider and flush research cache';

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
    public function handle()
    {
        $id = $this->argument('id');

        if(empty($id))
        {
            $this->error('please provide a non-empty provider id!');

            return -1;
        }

        event(new DefaultProviderChanged($id));
        
        return 0;
    }
}
