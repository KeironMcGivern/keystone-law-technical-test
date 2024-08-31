<?php

namespace Tests\Unit\Models;

use App\Models\PinnedLink;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PinnedLinkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_soft_deleted()
    {
        $content = PinnedLink::factory()->create();

        $content->delete();

        $this->assertSoftDeleted('pinned_links', [
            'id' => $content->id,
        ]);
    }

    /** @test */
    public function it_can_be_force_deleted()
    {
        $content = PinnedLink::factory()->create();

        $content->forceDelete();

        $this->assertDatabaseMissing('pinned_links', [
            'id' => $content->id,
        ]);
    }

    /** @test */
    public function it_can_have_tags()
    {
        $content = PinnedLink::factory()->create();
        $tag = Tag::factory()->create();

        $content->tags()->attach($tag);

        $this->assertInstanceOf(Tag::class, $content->tags->first());
        $this->assertCount(1, $content->tags);
    }
}
