<?php

declare(strict_types=1);

namespace App\Domain\PinnedLink\Enums;

use DavidIanBonner\Enumerated\Enumerated;
use DavidIanBonner\Enumerated\HasEnumeration;
use Illuminate\Support\Collection;

// I feel strongly typed code leads to better development practices
// This class uses a helper package to give Enums all the functionally they need
enum Tags: string implements Enumerated
{
    use HasEnumeration;

    case LARAVEL = 'laravel';
    case VUE = 'vue';
    case VUEJS = 'vue-js';
    case PHP = 'php';
    case API = 'api';

    public static function key(): string
    {
        return 'tags';
    }

    public static function toCheckbox(): Collection
    {
        return Collection::make(static::cases())->map(fn ($enum) => [
            'value' => $enum->value,
            'label' => $enum->line(),
        ]);
    }
}
