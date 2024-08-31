<?php

namespace Tests\Feature;

use App\Domain\PinnedLink\Enums\Tags;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PinnedLinkTest extends TestCase
{
    use RefreshDatabase;

    // Though stated tests aren't needed I feel simple feature tests
    // even in this capacity can keep healthy

    /** @test */
    public function it_can_access_links_page()
    {
        $this->get(route('pinnedLinks'))
            ->assertSuccessful()
            ->assertComponentIs('PinnedLinks')
            ->assertPropValue('tags', function ($viewData) {
                $this->assertEquals(
                    $viewData,
                    Tags::toCheckbox()->toArray()
                );
            });
    }
}
