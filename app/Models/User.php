<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\FilamentManager;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasName
{
    use HasUuids,
        Billable,
        HasFactory,
        Notifiable,
        SoftDeletes;

    protected $appends = [
        'avatar'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'firstname',
        'lastname',
        'username',
        'date_of_birth',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'date_of_birth'     => 'date',
        ];
    }

    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }

    public function connectors(): MorphToMany
    {
        return $this->morphToMany(Connector::class, 'connectorable')->using(Connectorable::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Connector::class, 'taggable');
    }

    public function getAvatarAttribute(): string
    {
        $params = [
            'seed'            => $this->id,
            'backgroundColor' => 'FF79C6'
        ];

        return 'https://api.dicebear.com/8.x/fun-emoji/svg?' . http_build_query($params);
    }

    public function getFilamentAvatarUrl(): string
    {
        return $this->avatar;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
