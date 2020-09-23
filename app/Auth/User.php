<?php

declare(strict_types=1);

namespace App\Auth;

use Cartalyst\Sentinel\Users\EloquentUser;

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
}
