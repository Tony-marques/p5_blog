<?php

namespace App\app\router;

class Router
{

  private string $url;
  protected array $routes = [];

  public function __construct(string $url)
  {
    $this->url = trim($url, "/");
  }

  public function get(string $path, string $action)
  {
    $this->routes["GET"][] = new Route($path, $action);
  }

  public function post(string $path, string $action)
  {
    $this->routes["POST"][] = new Route($path, $action);
  }

  public function run()
  {
    try {
      foreach ($this->routes[$_SERVER["REQUEST_METHOD"]] as $route) {
        if ($route->matches($this->url)) {
          $route->execute();
        } else {
          // throw new RouterException("Cette page n'existe pas");
        }
      }
    } catch (RouterException $e) {
      echo $e->getMessage();
      // \header("location: /");
      exit;
    }
  }
}
