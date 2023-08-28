<?php

namespace App\services;

class ImageService
{


  public static function verifyImage($image, $pathToRedirect = null)
  {
    $ext_allowed = ["jpg", "jpeg", "png", "webp"];

    $ext = \pathinfo($image["name"])["extension"];

    if (!\in_array($ext, $ext_allowed)) {
      $_SESSION["image"] = [
        "error" => "Extension non autorisée"
      ];
      // echo "no ok";
      \header("location: $pathToRedirect");
      exit;
    } else {

      if ($image["size"] > 2000000) {
        $_SESSION["image"] = [
          "error" => "Image trop volumineuse"
        ];

        exit;
      }

      $newName = md5(\uniqid());
      $newPathFile = ROOT . "/public/uploads/profile/$newName.$ext";
      if (!\move_uploaded_file($_FILES["profil_picture"]["tmp_name"], $newPathFile)) {
      }
      return "$newName.$ext";
    }
    // UtilService::beautifulArray($ext);
    // exit;


    // return $image;
  }
}
