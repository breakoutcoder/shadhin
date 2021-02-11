<?php

namespace App\Config;

use App\Config\DB\DB;

/**
 * Class Auth
 * @package App\Config
 */
class Auth
{
    /**
     * @return false
     */
    public static function user()
    {
        if (getSession('login') && getSession('user_id')) {
            return DB::table('users')->where('id', getSession('user_id'))->first();
        } else {
            return false;
        }

    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public static function attempt($email, $password): bool
    {
        $user = DB::table('users')->where('email', $email)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                setSession('user_id', $user->id, true);
                setSession('login', 'true', true);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}