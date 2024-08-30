<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapePinboardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape-pinboard-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape pinboard and insert new data to DB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
