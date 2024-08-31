<?php

declare(strict_types=1);

namespace App\Domain\Scraper\Actions;

use App\Domain\PinnedLink\Enums\Tags;
use App\Domain\Scraper\Processor\PinboardItemProcessor;
use Generator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use Symfony\Component\DomCrawler\Crawler;

class PinboardScraper extends BasicSpider
{
    protected Collection $links;

    public array $startUrls = [
        'https://pinboard.in/u:alasdairw?per_page=120',
    ];

    public array $itemProcessors = [
        PinboardItemProcessor::class,
    ];

    protected function checkLinkIsActive(?string $url = null): bool
    {
        // Exit early if no url is present
        if (! filled($url)) {
            return false;
        }

        // Here we pass the url to Laravels build in http client and true if the url is active
        return Http::get($url)->successful();
    }

    protected function parsePinInfo(Crawler $node): void
    {
        // Initialise the collection used to store all tag information
        $tags = collect();

        // Grab each element with the class "tag" and iterate over each element found
        // and then push the text value to the tags collection
        $node->filter(' .tag ')->each(fn (Crawler $node) => $tags->push($node->text()));

        // Since we only want specific tags we check the tag value against the
        // values found in the Tag enum class filtering out all the unwanted
        $tags = $tags->filter(fn ($value) => in_array($value, Tags::values()));

        $url = $node->filter(' .bookmark_title ')->attr('href');

        // We then check to see if the url is still active and if so all other information that is
        // needed is then grabbed using the relevant class and the appropriate method is then
        // called to get the information needed
        if ($this->checkLinkIsActive($url)) {
            $this->links->push([
                'url' => $url,
                'title' => $node->filter(' .bookmark_title ')->text(),
                'comments' => $node->filter(' .description ')->text(),
                'tags' => $tags->toArray(),
            ]);
        }
    }

    public function parse(Response $response): Generator
    {
        // Initialise the collection used to store all link information
        $this->links = collect();

        // Grab each element that has a parent element with the class "bookmark"
        // and contains an element with the class "display".
        // This information is then iterated on by the parse function
        $response->filter('.bookmark > .display ')
            ->each(fn (Crawler $node) => $this->parsePinInfo($node));

        // All items are then passed to the yield function where the information is
        // processed by the "PinboardItemProcessor" class
        yield $this->item($this->links->toArray());
    }
}
