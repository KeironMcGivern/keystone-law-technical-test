<?php

namespace Tests\Feature\Api;

use App\Domain\PinnedLink\Enums\Tags;
use App\Models\PinnedLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class LinkSearchTest extends TestCase
{
    use RefreshDatabase;

    protected Collection $links;

    public function setUp(): void
    {
        parent::setUp();

        $this->links = collect();

        foreach (Tags::collect() as $tag) {
            $this->links->push(PinnedLink::factory()->create(['tags' => [$tag]]));
        }
    }

    /** @test */
    public function it_can_get_pinned_links()
    {
        $response = $this->get(route('api.getLinks'))
            ->assertSuccessful();

        $content = $response->decodeResponseJson();

        $this->assertEquals($this->links->count(), count($content));
    }
}
