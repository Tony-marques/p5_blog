<?php

namespace App\Services;

class ImageService
{
    /**
     * image processing
     * @param $image
     * @param $pathToRedirect
     * @return string|void
     */
    public static function verifyImage($image, $pathToRedirect = null)
  {
    $ext_allowed = ["jpg", "jpeg", "png", "webp"];

    $ext = \pathinfo($image["name"])["extension"];

    if (!\in_array($ext, $ext_allowed)) {
      $_SESSION["image"] = [
        "error" => "Extension non autorisée"
      ];

      \header("location: $pathToRedirect");
      return;
    } else {

      if ($image["size"] > 2000000) {
        $_SESSION["image"] = [
          "error" => "Image trop volumineuse"
        ];
        return;
      }

      $newName = md5(\uniqid());
      $newPathFile = ROOT . "/public/uploads/profile/$newName.$ext";
      if (!\move_uploaded_file($_FILES["profil_picture"]["tmp_name"], $newPathFile)) {
      }
      return "$newName.$ext";
    }
  }
}
