<?php

namespace App\Traits\Filament;

trait WithCountBadge
{
    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }
}