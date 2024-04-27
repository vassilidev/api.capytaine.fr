<?php

namespace App\Enums\Scraper;

use Filament\Support\Colors\Color;

enum Method: string
{
    case GET = 'get';
    case POST = 'post';

    public function color(): string
    {
        return match ($this) {
            self::GET => 'success',
            self::POST => 'info',
        };
    }
}
