<?php

declare(strict_types=1);

namespace App\Auth\Auth;

use App\Auth\Auth\AbstractAuthService;
use App\Auth\Role\Roles;
use App\Auth\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Session\Store as Session;
use Illuminate\Translation\Translator;

class WebAuthService extends AbstractAuthService
{
    /**
     * A Sentinel instance.
     */
    private Sentinel $sentinel;

    /**
     * A Translator instance.
     */
    private Translator $translator;

    /**
     * A Session store instance.
     */
    private Session $session;

    /**
     * @param Sentinel       $sentinel       A Sentinel instance.
     * @param Translator     $translator     A translator.
     * @param Session        $session        A session store.
     */
    public function __construct(
        Sentinel $sentinel,
        Translator $translator,
        Session $session
    ) {
        parent::__construct();

        $this->sentinel = $sentinel;
        $this->translator = $translator;
        $this->session = $session;
    }

    /**
     * Attempts to log the user in.
     *
     * Returns `true` on success and `false` on failure.
     *
     * If successful, the user's CSRF token will be regenerated for security
     * purposes.
     *
     * If unsuccessful, the authentication errors will be stored in
     * `$this->errors`.
     *
     * @param array $inputData The input data.
     *
     * @return bool
     */
    public function login(array $inputData): bool
    {
        $credentials = [
            'email' => $inputData['email'],
            'password' => $inputData['password'] === null ? '' : $inputData['password'],
        ];

        $rememberMe = array_key_exists('remember_me', $inputData);

        try {
            if ($this->sentinel->authenticate($credentials, $rememberMe)) {
                $this->session->regenerateToken();

                return true;
            }
        } catch (NotActivatedException $exception) {
            $this->errors->add('email', $this->translator->get('login.errors.email.notActivated'));

            return false;
        } catch (ThrottlingException $exception) {
            $this->errors->add('email', $this->translator->get('login.errors.email.suspended'));

            return false;
        }

        $this->errors->add('email', $this->translator->get('login.errors.email.unregistered'));

        return false;
    }

    /**
     * Logs the current user out.
     *
     * The user's CSRF token will be regenerated for security purposes.
     *
     * @return bool
     */
    public function logout(): bool
    {
        $this->sentinel->logout();
        $this->session->regenerateToken();

        return true;
    }

    /**
     * Register and activate user.
     *
     * @param array $userConfig A UserConfig array
     *
     * @return User
     */
    public function registerUser(array $userConfig): User
    {
        $user = $this->sentinel->registerAndActivate($userConfig);

        $user->save();

        $role = $this->sentinel->getRoleRepository()->findBySlug(Roles::MEMBER);

        $role->users()->attach($user);

        return $user;
    }
}
