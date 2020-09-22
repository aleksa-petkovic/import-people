<?php

declare(strict_types=1);

namespace App\Auth\Auth;

use App\Auth\Role\Roles;
use App\Auth\User;
use App\Auth\User\Repository as UserRepository;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiAuthService extends AbstractAuthService
{
    /**
     * An UserRepository instance.
     */
    private UserRepository $userRepository;

    /**
     * A Sentinel instance.
     */
    private Sentinel $sentinel;

    /**
     * @param UserRepository             $userRepository             A UserRepository instance.
     * @param Sentinel                   $sentinel                   A Sentinel instance.
     */
    public function __construct(
        UserRepository $userRepository,
        Sentinel $sentinel
    ) {
        $this->userRepository = $userRepository;
        $this->sentinel = $sentinel;
    }

    /**
     * Registers a new user.
     *
     * @param string      $email        A user email.
     * @param string      $password     A user password.
     * @param string      $firstName    A user first name.
     * @param string      $lastName     A user last name.
     *
     * @throws ModelNotFoundException
     *
     * @return User
     */
    public function register(
        string $email,
        string $password,
        string $firstName,
        string $lastName
    ): User {
        $user = $this->userRepository->create([
            'role' => Roles::MEMBER,
            'email' => $email,
            'password' => $password,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);

        return $user;
    }

    /**
     * Authenticate user with email and password.
     *
     * @param string $email     The user's email address.
     * @param string $password  The user's password.
     *
     * @return User
     */
    public function authenticate(string $email, string $password): User
    {
        $this->sentinel->stateless([
            'email' => $email,
            'password' => $password,
        ]);
        $user = $this->sentinel->getUser();

        $this->userRepository->touch($user);

        return $user;
    }
}
