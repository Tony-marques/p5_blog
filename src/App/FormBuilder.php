<?php

namespace App\App;

class FormBuilder
{

  public $html;

  public function create(): string
  {
    return $this->html;
  }

  public function startForm(string $method = "POST", string $action = "#", array $attributs = []): self
  {
    $this->html .= "<form method='$method' action='$action'";
    if ($attributs) {
      $this->setAttribute($attributs);
    }
    $this->html .= ">";
    return $this;
  }

  public function endForm(): void
  {
    $this->html .= "</form>";
  }

  public function setInput(?string $type, ?string $name, array $attributs = []): self
  {
    $this->html .= "<input type='$type' name='$name'";
    if ($attributs) {
      $this->setAttribute($attributs);
    }
    $this->html .= ">";
    return $this;
  }

  public function setTextarea(string $name, string $content = null, array $attributs = []): self
  {
    $this->html .= "<textarea name='$name'";
    if ($attributs) {
      $this->setAttribute($attributs);
    }
    $this->html .= ">$content</textarea>";

    return $this;
  }

  public function setLabel(string $for, string $name, array $attributs = []): self
  {
    $this->html .= "<label for='$for'";
    if ($attributs) {
      $this->setAttribute($attributs);
    }
    $this->html .= ">$name</label>";

    return $this;
  }

  public function setButton(string $name, array $attributs = []): self
  {
    $this->html .= "<button type='submit' name='submit'";
    if ($attributs) {
      $this->setAttribute($attributs);
    }
    $this->html .= ">$name</button>";
    
    return $this;
  }

  public function startDiv(array $attributs = [], string $content = null): self
  {
    $this->html .= "<div ";
    if ($attributs) {
      $this->setAttribute($attributs);
    }
    $this->html .= ">$content";

    return $this;
  }

  public function endDiv(): self
  {
    $this->html .= "</div> ";

    return $this;
  }

  private function setAttribute(array $attributs): void
  {
    foreach ($attributs as $key => $value) {
      $this->html .= " $key='$value'";
    }
  }

  public static function validate(array $form, array $fields): bool
  {
    foreach ($fields as $field) {
      if (!isset($form[$field]) || empty($form[$field])) {
        return false;
      }
      return true;
    }
  }
}
