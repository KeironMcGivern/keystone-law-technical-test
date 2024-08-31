<?php

declare(strict_types=1);

namespace App\Domain\PinnedLink\Actions;

use App\Models\PinnedLink;
use App\Models\Tag;
use Illuminate\Support\Arr;

class UpsertPinnedLinked
{
    protected ?array $data;

    protected ?PinnedLink $link;

    public function __construct(?array $data = null, ?PinnedLink $link = null)
    {
        $this->data = $data;
        $this->link = $link;
    }

    protected function processLinkTags(PinnedLink $link, ?array $tags = null): void
    {
        // If there is no tags present in the data passed this step is skipped
        // Best practice is to always exit early when possible
        if (! filled($tags)) {
            return;
        }

        // Iterate over each tag pass and check to see if it exists in the database
        // and grab the model or create a new one if it exists
        // We then check to see if the tag has been attached to the model and do so if not
        foreach($tags as $tag) {
            $tag = Tag::firstOrCreate([
                'name' => $tag,
            ]);

            if ($link->tags()->where('name', $tag)->count() === 0) {
                $link->tags()->attach($tag->id);
            }
        }
    }

    public function execute(): PinnedLink
    {
        // Check to see if the link model was passed to the constructor,
        // if not a black model is created
        $link = $this->link ? $this->link : new PinnedLink();

        // Check to see if there is data present to update the model and insert this new data
        if (filled($this->data)) {
            $link->fill([
                'url' => Arr::get($this->data, 'url'),
                'title' => Arr::get($this->data, 'title'),
                'comments' => Arr::get($this->data, 'comments'),
            ]);
        }

        $link->save();

        // Once the model is saved we can then check for tags and attach them to the model
        // through the pivot table created
        $this->processLinkTags($link->fresh(), Arr::get($this->data, 'tags'));

        return $link;
    }
}
