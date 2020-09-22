<?php

declare(strict_types=1);

namespace Database\Seeders;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * A Sentinel instance.
     */
    protected Sentinel $sentinel;

    /**
     * Role configuration.
     */
    protected array $roles = [
        [
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => [
                'App\Http\Controllers\Admin\HomeController@index' => true,
            ],
        ],
        [
            'name' => 'Member',
            'slug' => 'member',
            'permissions' => [],
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
        foreach ($this->roles as $roleConfig) {
            $role = $this->sentinel->findRoleBySlug($roleConfig['slug']);

            if ($role === null) {
                $this->createRole($roleConfig);
            } else {
                $this->updateRole($role, $roleConfig);
            }
        }
    }

    /**
     * Creates the passed role.
     *
     * @param array $roleConfig The role configuration.
     *
     * @return void
     */
    protected function createRole(array $roleConfig): void
    {
        $this->sentinel->getRoleRepository()->createModel()->create($roleConfig);
    }

    /**
     * Updates the passed role with the specified parameters.
     *
     * @param EloquentRole $role       The Eloquent role instance.
     * @param array        $roleConfig The role configuration.
     *
     * @return void
     */
    protected function updateRole(EloquentRole $role, array $roleConfig): void
    {
        $role->name = $roleConfig['name'];
        $role->permissions = $roleConfig['permissions'];

        $role->save();
    }
}

