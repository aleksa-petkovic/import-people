<?php

declare(strict_types=1);

namespace App\Auth\User;

use App\Auth\User;
use Carbon\Carbon;
use Cartalyst\Sentinel\Sentinel;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class Repository
{
    /**
     * A User model instance.
     */
    protected User $userModel;

    /**
     * A Sentinel instance.
     */
    protected Sentinel $sentinel;

    /**
     * @param User     $userModel A user model instance.
     * @param Sentinel $sentinel  A Sentinel instance.
     */
    public function __construct(User $userModel, Sentinel $sentinel)
    {
        $this->userModel = $userModel;
        $this->sentinel = $sentinel;
    }

    /**
     * Gets all users.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->userModel->all();
    }

    /**
     * Gets a user by email.
     *
     * @param string $email The email address.
     *
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->userModel->where('email', $email)->get()->first();
    }

    /**
     * Finds the user by ID, or throws an exception if the ID doesn't exist.
     *
     * @param int $id The user's ID.
     *
     * @return User
     */
    public function findOrFail(int $id): User
    {
        return $this->userModel->findOrFail($id);
    }

    /**
     * Returns all users that have no roles.
     *
     * @return Collection
     */
    public function getUsersWithoutRoles(): Collection
    {
        return $this->userModel->withoutRoles()->get();
    }

    /**
     * Creates and activates a new user and returns it.
     *
     * @param array $inputData The input data for the new user.
     *
     * @return User
     */
    public function create(array $inputData): User
    {
        $userConfig = [
            'email' => Arr::get($inputData, 'email', ''),
            'password' => Arr::get($inputData, 'password'),
            'first_name' => Arr::get($inputData, 'first_name', ''),
            'last_name' => Arr::get($inputData, 'last_name', ''),
        ];

        $user = $this->sentinel->registerAndActivate($userConfig);

        $user->save();

        $role = $this->sentinel->findRoleBySlug($inputData['role']);
        $role->users()->attach($user);

        return $user;
    }

    /**
     * Generates a cryptographically secure token for accessing the API.
     *
     * @return string
     */
    protected function generateAuthToken(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(64));
    }

    /**
     * Generates a new auth token for a user, and updates their timestamp.
     *
     * @param User $user The user whose token should be updated.
     *
     * @return bool
     */
    protected function updateAuthToken(User $user): bool
    {
        $user->auth_token = $this->generateAuthToken();
        $user->auth_token_updated_at = Carbon::now();
        return $user->save();
    }

    /**
     * Updates a user's auth token if needed.
     *
     * An auth token update is needed only when the auth token has expired.
     *
     * @param User $user The user whose token should be updated.
     *
     * @return bool
     */
    public function touch(User $user): bool
    {
        if ($user->isAuthTokenExpired()) {
            return $this->updateAuthToken($user);
        }
        return true;
    }
}
