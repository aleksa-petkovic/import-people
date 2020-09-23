<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Auth\User;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * A Sentinel instance.
     */
    private Sentinel $sentinel;

    /**
     * Users to seed.
     */
    private array $users = [
        [
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'first_name' => 'John',
            'last_name' => 'Administrator',
            'roles' => ['admin'],
        ],
    ];

    /**
     * @param Sentinel $sentinel An instance of Sentinel.
     */
    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->users as $userConfig) {
            if (!$this->userExists($userConfig['email'])) {
                $this->createUser($userConfig);
            }
        }
    }

    /**
     * Checks whether a user with the given email exists.
     *
     * @param string $email The email being searched for.
     *
     * @return bool
     */
    private function userExists(string $email): bool
    {
        return User::whereEmail($email)->exists();
    }

    /**
     * Creates a new user according to the specified config, and assigns the
     * roles.
     *
     * @param array $userConfig The complete user configuration.
     *
     * @return void
     */
    private function createUser(array $userConfig): void
    {
        $roles = $userConfig['roles'];

        unset($userConfig['roles']);

        $user = $this->sentinel->registerAndActivate($userConfig);

        foreach ($roles as $role) {
            $this->attachToRole($user, $role);
        }
    }

    /**
     * Attaches a user to a role.
     *
     * @param User   $user     The user which is being assigned to a role.
     * @param string $roleSlug The slug of the role.
     *
     * @return void
     */
    private function attachToRole(User $user, string $roleSlug): void
    {
        $role = $this->sentinel->findRoleBySlug($roleSlug);
        $role->users()->attach($user);
    }
}

