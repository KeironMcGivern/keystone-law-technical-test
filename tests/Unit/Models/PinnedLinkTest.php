<?php

namespace Tests\Unit\Models;

use App\Models\PinnedLink;
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
}
