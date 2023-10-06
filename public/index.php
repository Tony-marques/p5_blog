<?php

use App\App\App\router\Router;

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$env = $_ENV["APP_ENV"];

if (file_exists(dirname(__DIR__) . "/.env.$env")) {
  $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__), ".env.$env");
  $dotenv->load();
};

\session_start();

$router = new Router($_GET["p"]);

// HOME
$router->get("/", "App\controllers\HomeController@index");
$router->post("/", "App\controllers\HomeController@index");


// PROFILE
$router->get("/profil/edition/:id", "App\controllers\ProfileController@edit");
$router->post("/profil/edition/:id", "App\controllers\ProfileController@edit");


// SECURITY
$router->get("/connexion", "App\controllers\SecurityController@login");
$router->post("/connexion", "App\controllers\SecurityController@login");
$router->get("/inscription", "App\controllers\SecurityController@register");
$router->post("/inscription", "App\controllers\SecurityController@register");
$router->get("/deconnexion", "App\controllers\SecurityController@logout");


// ARTICLE
$router->get("/articles", "App\controllers\ArticleController@index");
$router->get("/articles/:page", "App\controllers\ArticleController@index");

// protected route for admin
$router->get("/article/nouveau", "App\controllers\ArticleController@new");
$router->post("/article/nouveau", "App\controllers\ArticleController@new");

$router->get("/article/:id", "App\controllers\ArticleController@showOne");
$router->post("/article/:id", "App\controllers\ArticleController@showOne");

$router->get("/article/edition/:id", "App\controllers\ArticleController@edit");
$router->post("/article/edition/:id", "App\controllers\ArticleController@edit");

$router->get("/article/suppression/:id", "App\controllers\ArticleController@delete");

// COMMENTS
$router->get("/commentaire/validation/:id", "App\controllers\CommentController@validate");
$router->get("/commentaire/validation/page/:id", "App\controllers\CommentController@validateFromComments");
$router->get("/commentaire/suppression/page/:id", "App\controllers\CommentController@deleteFromComments");
$router->get("/commentaire/suppression/:id", "App\controllers\CommentController@delete");
$router->get("/commentaires", "App\controllers\CommentController@checkAllComments");

// USERS
$router->get("/utilisateurs", "App\controllers\SecurityController@allUsers");
$router->get("/utilisateur/suppression/:id", "App\controllers\ProfileController@delete");


$router->run();
