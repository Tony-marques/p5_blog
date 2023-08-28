<?php

namespace App\app\router;

class Route
{

  protected string $path;
  protected string $action;
  protected array $matches;

  public function __construct(string $path, string $action)
  {
    $this->path = \trim($path, "/");
    $this->action = $action;
  }

  public function matches(string $url)
  {
    $path = \preg_replace("#:([\w]+)#", "([^/]+)", $this->path);

    if (\preg_match("#^$path$#i", $url, $matches)) {
      $this->matches = $matches;
      return true;
    } else {
      return false;
    }
  }

  // Retravailler la methode public / private
  public function execute()
  {
    $params = \explode("@", $this->action);
    $controller = new $params[0]();
    $method = $params[1];
    return isset($this->matches[1]) ? $controller->$method($this->matches[1]) : $controller->$method();
  }
}
