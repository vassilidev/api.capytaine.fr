<?php

namespace App\Enums\Scraper;

enum Type: string
{
    case WEBHOOK = 'webhook';
    case MANUAL = 'manual';
}
