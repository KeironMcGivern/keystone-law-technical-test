<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\PinnedLink\Enums\Tags;
use Inertia\Inertia;
use Inertia\Response;

class PinnedLinkController
{
    public function index(): Response
    {
        return Inertia::render('PinnedLinks', [
            'tags' => Tags::toCheckbox()->toArray(),
        ]);
    }
}
