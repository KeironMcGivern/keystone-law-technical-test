<?php

namespace App\Console\Commands;

use App\Domain\Scraper\Actions\PinboardScraper;
use Illuminate\Console\Command;
use RoachPHP\Roach;

class ScrapePinboardCommand extends Command
{
    protected $signature = 'scraper:get-pinboard-items';

    protected $description = 'Scrape pinboard and insert new data to DB';

    protected function getPinnedLinks(): void
    {
        // Having looked at all the options available to me I felt the two best options to use
        // for scraping the information needed was `Guzzle` and the package I have chosen to use
        // "RoachPHP". I feel this was the best option for the task as it has all the functionally
        // needed in a simple and clean package. It also allows for better further development,
        // working on scraper previously many need to be updated several times a year and other
        // sites change and I feel this would allow for the easiest updates
        Roach::startSpider(PinboardScraper::class);
    }

    public function handle()
    {
        // I know not needed but seperating out the call to the class from the main function
        // is far cleaner and easier to read, plus this leaves room for expansion later
        $this->getPinnedLinks();
    }
}
