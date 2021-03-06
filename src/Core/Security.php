<?php


namespace App\Core;


class Security
{
    public static function isAuthenticatedUser(): bool
    {
        if (App::get("user") !== null)
            return true;

        return false;

    }

    public static function isUserGranted($minRole): bool
    {
        if ($minRole === 'ROLE_ANONYMOUS')
            return true;
        $user = App::get('user');
        if ($user === null) {
            App::get(Router::class)->redirect('login');
        } else
            $userRole = $user->getRole();

        // we load the app roles
        $roles = App::get("config")["security"]["roles"];

        // we get the role values
        $userRoleValue = $roles[$userRole]; //ROLE_USER => 2
        $minRoleValue = $roles[$minRole]; //ROLE_ADMIN => 3

        // we return the comparison
        return ($userRoleValue >= $minRoleValue);
    }

    public static function encode(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    public static function checkPassword(string $password, string $userPassword): bool {
        return password_verify($password, $userPassword);
    }




}