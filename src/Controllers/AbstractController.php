<?php

namespace App\Controllers;

use App\Services\AuthService;

/**
 *
 */
class AbstractController
{
    public function render(string $path, string $title, array $data = [], string $template = "default"): void
    {

        \extract($data);

        ob_start();

        // Render true or false for navbar
        $isAdmin = AuthService::isAdmin();

        require_once __DIR__ . "/../.." . "/templates/$path.php";

        $content = \ob_get_clean();

        require_once __DIR__ . "/../.." . "/templates/$template.php";

        unset($_SESSION["error"]);
        unset($_SESSION["temporary_user"]);
        unset($_SESSION["success"]);
        unset($_SESSION["image"]);
        unset($_SESSION["comment"]);
        unset($_SESSION["profile"]);
        unset($_SESSION["tmp_article"]);
        unset($_SESSION["contact"]);
    }
}
