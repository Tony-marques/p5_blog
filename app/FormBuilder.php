<?php

namespace App\app;

class FormBuilder
{

  public $html;

  public function create()
  {
    return $this->html;
  }

  public function startForm(string $method = "POST", string $action = "#", array $attributs = [])
  {
    $this->html .= "<form method='$method' action='$action'";
    $this->html .= $attributs ? $this->setAttribute($attributs) . ">" : ">";
    return $this;
  }

  public function endForm()
  {
    $this->html .= "</form>";
    
  }

  public function setInput(?string $type, ?string $name, array $attributs = [])
  {
    $this->html .= "<input type='$type' name='$name'";
    $this->html .= $attributs ? $this->setAttribute($attributs) . ">" : ">";
    return $this;
  }

  public function setTextarea(string $name, string $content = null, array $attributs = [])
  {
    $this->html .= "<textarea name='$name'";
    $this->html .= $attributs ? $this->setAttribute($attributs) : "";
    $this->html .= ">$content</textarea>";
    return $this;
  }

  public function setLabel(string $for, string $name, array $attributs = [])
  {
    $this->html .= "<label for='$for'";
    $this->html .= $attributs ? $this->setAttribute($attributs) : "";
    $this->html .= ">$name</label>";

    return $this;
  }

  public function setButton(string $name, array $attributs = [])
  {
    $this->html .= "<button type='submit' name='submit'";
    $this->html .= $attributs ? $this->setAttribute($attributs) : "";
    $this->html .= ">$name</button>";

    return $this;
  }

  public function startDiv(array $attributs = [])
  {
    $this->html .= "<div ";
    $this->html .= $attributs ? $this->setAttribute($attributs) . ">" : ">";

    return $this;
  }

  public function endDiv()
  {
    $this->html .= "</div> ";

    return $this;
  }

  private function setAttribute(array $attributs)
  {
    foreach ($attributs as $key => $value) {
      $this->html .= " $key='$value'";
    }
  }

  public static function validate(array $form, array $fields)
  {
    foreach ($fields as $field) {
      if (!isset($form[$field]) || empty($form[$field])) {
        return false;
      }
      return true;
    }
  }
}
