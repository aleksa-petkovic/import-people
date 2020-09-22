<?php

declare(strict_types=1);

namespace App\Auth\Role;

interface Roles
{
    /**
     * Member role.
     */
    public const MEMBER = 'member';

    /**
     * Admin role.
     */
    public const ADMIN = 'admin';
}
