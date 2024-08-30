<?php

declare(strict_types=1);

namespace App\Domain\PinnedLink\Enums;

use DavidIanBonner\Enumerated\Enumerated;
use DavidIanBonner\Enumerated\HasEnumeration;

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
}
