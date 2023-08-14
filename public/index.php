<?php

use App\app\Router;
use App\app\router\Router2;

require '../vendor/autoload.php';

define("ROOT", dirname(__DIR__));

// $router = new Router();
// $router->start();
\session_start();

$router2 = new Router2($_GET["p"]);

// HOME
$router2->get("/", "App\controllers\HomeController@index");


// PROFILE
$router2->get("/profil/edition/:id", "App\controllers\ProfileController@edit");
$router2->post("/profil/edition/:id", "App\controllers\ProfileController@edit");


// SECURITY
$router2->get("/connexion", "App\controllers\SecurityController@login");
$router2->post("/connexion", "App\controllers\SecurityController@login");
$router2->get("/inscription", "App\controllers\SecurityController@register");
$router2->post("/inscription", "App\controllers\SecurityController@register");
$router2->get("/deconnexion", "App\controllers\SecurityController@logout");


// ARTICLE
$router2->get("/articles", "App\controllers\ArticleController@index");

$router2->get("/article/nouveau", "App\controllers\ArticleController@new");
$router2->post("/article/nouveau", "App\controllers\ArticleController@new");

$router2->get("/article/:id", "App\controllers\ArticleController@showOne");
$router2->post("/article/:id", "App\controllers\ArticleController@showOne");

$router2->get("/article/edition/:id", "App\controllers\ArticleController@edit");
$router2->post("/article/edition/:id", "App\controllers\ArticleController@edit");

$router2->get("/article/suppression/:id", "App\controllers\ArticleController@delete");

// COMMENTS
$router2->get("/commentaire/validation/:id", "App\controllers\CommentController@validate");

$router2->get("/commentaire/suppression/:id", "App\controllers\CommentController@delete");

$router2->get("/commentaires", "App\controllers\CommentController@checkAllComments");


$router2->run();
