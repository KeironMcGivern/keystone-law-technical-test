<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Domain\PinnedLink\Enums\Tags;
use App\Domain\PinnedLink\Resources\PinnedLinkResource;
use App\Models\PinnedLink;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LinkSearchController
{
    public function __invoke(Request $request): JsonResponse
    {
        // Here we collect the tags that are passed in the request, we then filter them to ensure
        // only valid tags are used to filter the query
        $tags = collect($request->get('tags'))
            ->filter(fn (string $tag) => in_array($tag, Tags::collect()->toArray()))
            ->toArray();

        $links = PinnedLink::query()
            ->forTags($tags)
            ->get();

        return response()
            ->json(PinnedLinkResource::collection($links));
    }
}
