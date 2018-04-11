<?php
/**
 * Date: 2018-04-10
 * Time: 22:35
 */

namespace App;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\App;

class PasswordGuard implements Guard
{
    /** @var UserProvider $provider */
    protected $provider;

    public function __construct(UserProvider $user_provider)
    {
        $this->provider = $user_provider;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return session()->has('authenticated');
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !session()->has('authenticated');
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return null;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        return null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return App::make('App\PasswordUser')->getAuthPassword() === $credentials['password'];
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        return;
    }
}
