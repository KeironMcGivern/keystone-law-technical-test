<?php

namespace Tests\Concerns;

use App\Domain\PinnedLink\Enums\Tags;
use App\Models\Tag;
use Illuminate\Support\Collection;

trait HasTags
{
    protected Collection $tags;

    public function generateTags(): void
    {
        $this->tags = collect();

        Tags::collect()
            ->each(fn ($value) => $this->tags->push(Tag::factory()->create(['name' => $value])));
    }
}
