<?php

declare(strict_types=1);

namespace App\Models\Concerns\Tag;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait HasModelActions
{
    public static function getTagIds(mixed $values): array
    {
        return Tag::query()
            ->whereIn('name', is_array($values) ? $values : Arr::wrap($values)
            )
            ->get()
            ->pluck('id')
            ->toArray();
    }
}
