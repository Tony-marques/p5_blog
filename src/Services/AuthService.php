<?php

namespace App\Services;

use App\Repositories\UserRepository;

class AuthService
{


    /**
     * If no logged, redirect
     * @param $pathToRedirect
     * @return void
     */
    public static function checkUserLogOut(string $pathToRedirect = "/"): void
    {
        if (!isset($_SESSION["user"])) {
            \header("location: $pathToRedirect");
            return;
        }
    }

    /**
     * If logged, redirect
     * @param string $pathToRedirect
     * @return void
     */
    public static function checkUserLogged(string $pathToRedirect = "/"): void
    {
        if (isset($_SESSION["user"])) {
            \header("location: $pathToRedirect");
            return;
        }
    }

    /**
     * Return true or false if admin or not
     * @return bool
     */
    public static function isAdmin():bool
    {
        if (empty($_SESSION["user"]["id"])) {
            return false;
        }
        $userRepository = new UserRepository();
        $currentUser = $userRepository->findOne($_SESSION["user"]["id"]) ?? "";

        $userRole = json_decode($currentUser->getRole());

        if (\in_array("ROLE_ADMIN", $userRole)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * If not admin, redirect
     * @param string $pathToRedirect
     * @return void
     */
    public static function checkAdmin(string $pathToRedirect = "/"):void
    {
        $admin = self::isAdmin();
        if ($admin === false) {
            \header("location: $pathToRedirect");
            return;
        }
    }
}
