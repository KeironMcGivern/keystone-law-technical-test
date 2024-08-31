<?php

namespace Tests\Unit\Models;

use App\Models\PinnedLink;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_soft_deleted()
    {
        $tag = Tag::factory()->create();

        $tag->delete();

        $this->assertSoftDeleted('tags', [
            'id' => $tag->id,
        ]);
    }

    /** @test */
    public function it_can_be_force_deleted()
    {
        $tag = Tag::factory()->create();

        $tag->forceDelete();

        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
        ]);
    }

    /** @test */
    public function it_can_have_link()
    {
        $content = PinnedLink::factory()->create();
        $tag = Tag::factory()->create();

        $tag->links()->attach($content);

        $this->assertInstanceOf(PinnedLink::class, $tag->links->first());
        $this->assertCount(1, $tag->links);
    }
}
