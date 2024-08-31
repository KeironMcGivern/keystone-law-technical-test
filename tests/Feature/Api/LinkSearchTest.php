<?php

namespace Tests\Feature\Api;

use App\Domain\PinnedLink\Enums\Tags;
use App\Models\PinnedLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\Concerns\HasTags;
use Tests\TestCase;

class LinkSearchTest extends TestCase
{
    use RefreshDatabase;
    use HasTags;

    // Though stated tests aren't needed I feel simple feature tests
    // even in this capacity can keep healthy

    protected Collection $links;

    public function setUp(): void
    {
        parent::setUp();

        $this->generateTags();

        $this->links = collect();

        $tagsArray = [];

        foreach ($this->tags as $tag) {
            array_push($tagsArray, $tag->id);

            $link = PinnedLink::factory()->create();

            $link->tags()->attach($tag);

            $this->links->push($link);

            if (count($tagsArray) > 1) {
                $link = PinnedLink::factory()->create();

                $link->tags()->attach($tagsArray);

                $this->links->push($link);
            }
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

    /** @test */
    public function it_can_get_and_filter_pinned_links()
    {
        $response = $this->get(
            route('api.getLinks', ['tags' => [Tags::LARAVEL->value, Tags::VUE->value]])
        )->assertSuccessful();

        $content = $response->decodeResponseJson();

        $this->assertEquals(1, count($content));
    }
}
