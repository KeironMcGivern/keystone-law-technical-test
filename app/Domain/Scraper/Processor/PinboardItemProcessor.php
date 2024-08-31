<?php

namespace App\Domain\Scraper\Processor;

use App\Domain\PinnedLink\Actions\UpsertPinnedLinked;
use App\Models\PinnedLink;
use Illuminate\Support\Arr;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Support\Configurable;

class PinboardItemProcessor implements ItemProcessorInterface
{
    use Configurable;

    public function processItem(ItemInterface $item): ItemInterface
    {
        // Grab each item that was passed to the yield function in the main scraper class
        // and then for each of these items check to see if the url is present in the database
        // and grab that model, if it is not null will be passed to out upsert class
        // The model will then be updated or created depending on if it exists
        foreach($item->all() as $link) {
            $pinnedLink = PinnedLink::where('url', Arr::get($link, 'url', null))->first();

            (new UpsertPinnedLinked($link, $pinnedLink))->execute();
        }

        return $item;
    }
}
