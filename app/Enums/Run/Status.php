<?php

namespace App\Enums\Run;

enum Status: string
{
    case PENDING = 'pending';
    case RUNNING = 'running';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::RUNNING => 'info',
            self::COMPLETED => 'success',
            self::FAILED => 'danger',
            self::CANCELLED => 'warning',
        };
    }
}
