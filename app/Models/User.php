<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasName
{
    use HasUuids,
        Billable,
        HasFactory,
        Notifiable,
        SoftDeletes;

    protected $appends = [
        'avatar',
        'display_name',
        'current_billing_plan',
    ];

    protected $withCount = [
        'calendars',
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
        'preferred_language'
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

    protected static function booted(): void
    {
        static::updated(static function (User $customer) {
            if ($customer->hasStripeId()) {
                $customer->syncStripeCustomerDetails();
            }
        });
    }

    public function currentSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->active()->latestOfMany();
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

    public function getDisplayNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function stripeName(): string
    {
        return $this->getDisplayNameAttribute();
    }

    public function getFilamentName(): string
    {
        return $this->getDisplayNameAttribute();
    }

    public function getCurrentBillingPlanAttribute()
    {
        return $this->subscriptions()->active()->first()?->type ?? null;
    }
}
