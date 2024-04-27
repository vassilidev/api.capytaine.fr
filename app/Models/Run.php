<?php

namespace App\Models;

use App\Enums\Run\Status;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Run extends Model
{
    use HasUuids,
        HasFactory,
        SoftDeletes;

    protected $fillable = [
        'scraper_id',
        'status',
        'response',
        'request',
        'started_at',
        'ended_at'
    ];

    protected $casts = [
        'status'     => Status::class,
        'response'   => 'array',
        'request'    => 'array',
        'started_at' => 'datetime',
        'ended_at'   => 'datetime'
    ];

    public function scraper(): BelongsTo
    {
        return $this->belongsTo(Scraper::class);
    }

    public function extraction(): HasOne
    {
        return $this->hasOne(Extraction::class);
    }

    public function results(): HasManyThrough
    {
        return $this->hasManyThrough(Result::class, Extraction::class);
    }

    public function canBeAbort(): bool
    {
        return $this->status === Status::PENDING || $this->status === Status::RUNNING;
    }

    public function isCompleted(): bool
    {
        return $this->status === Status::COMPLETED;
    }

    public function abort(): bool
    {
        if (!$this->canBeAbort()) {
            return false;
        }

        $status = $this->forceFill([
            'status'     => Status::CANCELLED,
            'ended_at'   => now(),
            'deleted_at' => now(),
            'response'   => 'Cancelled by user',
        ])->save();

        if ($status) {
            Notification::make()
                ->info()
                ->title('Scraper run cancelled')
                ->send();
        } else {
            Notification::make()
                ->danger()
                ->title('Error while cancelling scraper run')
                ->send();
        }

        return $status;
    }

    public function end(): bool
    {
        return $this->forceFill([
            'status'   => Status::COMPLETED,
            'ended_at' => now(),
        ])->save();
    }
}
