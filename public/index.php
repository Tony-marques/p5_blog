<?php

use App\app\router\Router;

require '../vendor/autoload.php';

define("ROOT", dirname(__DIR__));

\session_start();

$Router = new Router($_GET["p"]);

// HOME
$Router->get("/", "App\controllers\HomeController@index");
$Router->post("/", "App\controllers\HomeController@index");


// PROFILE
$Router->get("/profil/edition/:id", "App\controllers\ProfileController@edit");
$Router->post("/profil/edition/:id", "App\controllers\ProfileController@edit");


// SECURITY
$Router->get("/connexion", "App\controllers\SecurityController@login");
$Router->post("/connexion", "App\controllers\SecurityController@login");
$Router->get("/inscription", "App\controllers\SecurityController@register");
$Router->post("/inscription", "App\controllers\SecurityController@register");
$Router->get("/deconnexion", "App\controllers\SecurityController@logout");


// ARTICLE
$Router->get("/articles", "App\controllers\ArticleController@index");
$Router->get("/articles/:page", "App\controllers\ArticleController@index");

// protected route for admin
$Router->get("/article/nouveau", "App\controllers\ArticleController@new");
$Router->post("/article/nouveau", "App\controllers\ArticleController@new");

$Router->get("/article/:id", "App\controllers\ArticleController@showOne");
$Router->post("/article/:id", "App\controllers\ArticleController@showOne");

$Router->get("/article/edition/:id", "App\controllers\ArticleController@edit");
$Router->post("/article/edition/:id", "App\controllers\ArticleController@edit");

$Router->get("/article/suppression/:id", "App\controllers\ArticleController@delete");

// COMMENTS
$Router->get("/commentaire/validation/:id", "App\controllers\CommentController@validate");
$Router->get("/commentaire/validation/page/:id", "App\controllers\CommentController@validateFromComments");
$Router->get("/commentaire/suppression/page/:id", "App\controllers\CommentController@deleteFromComments");
$Router->get("/commentaire/suppression/:id", "App\controllers\CommentController@delete");
$Router->get("/commentaires", "App\controllers\CommentController@checkAllComments");

// USERS
$Router->get("/utilisateurs", "App\controllers\SecurityController@allUsers");
$Router->get("/utilisateur/suppression/:id", "App\controllers\ProfileController@delete");


$Router->run();
