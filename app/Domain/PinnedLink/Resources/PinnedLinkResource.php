<?php

declare(strict_types=1);

namespace App\Domain\PinnedLink\Resources;

use App\Domain\PinnedLink\Enums\Tags;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PinnedLinkResource extends JsonResource
{
    protected function getTagLines(): array
    {
        if (!filled($this->tags)) {
            return [];
        }

        return collect($this->tags)
            ->map(fn (Tag $tag) => Tags::from($tag->name)->line())
            ->toArray();
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->guid,
            'url' => $this->url,
            'title' => $this->title,
            'comments' => $this->comments,
            'tags' => $this->tags,
            'tagsReadable' => $this->getTagLines(),
        ];
    }
}
