<?php

declare(strict_types=1);

namespace App\Auth;

use Carbon\Carbon;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class User extends EloquentUser
{
    /**
     * @inheritDoc
     */
    protected $visible = [
        'id',
        'email',
        'first_name',
        'last_name',
        'full_name',
    ];

    /**
     * @inheritDoc
     */
    protected $appends = [
        'full_name',
    ];

    protected $casts = [
        'auth_token_updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Limits the query to users that don't have roles attached.
     *
     * @param Builder $query The query builder instance.
     *
     * @return Builder
     */
    public function scopeWithoutRoles(Builder $query): Builder
    {
        return $query->has('roles', '=', 0);
    }

    /**
     * Limits the query to users who have never logged-in.
     *
     * @param Builder $query The query builder instance.
     *
     * @return Builder
     */
    public function scopeNeverLoggedIn(Builder $query): Builder
    {
        return $query->whereNull('last_login');
    }

    /**
     * Limits the query to users who have logged-in at least once.
     *
     * @param Builder $query The query builder instance.
     *
     * @return Builder
     */
    public function scopeLoggedInAtLeastOnce(Builder $query): Builder
    {
        return $query->whereNotNull('last_login');
    }

    /**
     * Get the unique identifier for the user.
     *
     * This is part of the `Authenticatable` interface which we don't want to
     * explicitly implement - because our "remember me" tokens work differently.
     *
     * However, the method is required for the `ThrottleRequests` middleware, so
     * we need it here in order for that middleware to be able to execute.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Gets the user's full name.
     *
     * If neither the first nor last name are defined, the user's email address
     * will be returned.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        $fullName = trim("{$this->first_name} {$this->last_name}");

        return $fullName ?: $this->email;
    }

    /**
     * Gets the user's first (and only) role.
     *
     * The Sentinel package (which we use for handling users) supports multiple
     * roles per user, but our system just needs one (which is handled at the
     * application level), so we'll return it here.
     *
     * @return EloquentRole
     */
    public function getRoleAttribute(): EloquentRole
    {
        return $this->roles()->first();
    }

    /**
     * Checks whether the user's auth token has expired.
     *
     * @return bool
     */
    public function isAuthTokenExpired(): bool
    {
        if ($this->auth_token_updated_at === null) {
            return true;
        }

        $expiresAt = $this->auth_token_updated_at->copy()->addSeconds($this->maxAge);

        return $expiresAt->isPast();
    }

    /**
     * Checks whether the user has never logged in.
     *
     * @return bool
     */
    public function hasNeverLoggedIn(): bool
    {
        return $this->last_login === null;
    }

    /**
     * Checks whether the user has logged in at least once.
     *
     * @return bool
     */
    public function hasLoggedInAtLeastOnce(): bool
    {
        return !$this->hasNeverLoggedIn();
    }
}
