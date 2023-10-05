<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\ImageService;
use App\Services\UserService;
use App\Services\UtilService;

class ProfileController extends AbstractController
{
    /**
     * Edit profile page
     */
    public function edit($id)
    {
        $id = (int)$id;
        $userRepository = new UserRepository();
        $user = $userRepository->findOne($id);

        if (!$user->getId()) {
            \header("location: /utilisateurs");
            return;
        }

        if ($user->getId() !== $_SESSION["user"]["id"] && !AuthService::isAdmin()) {
            \header("location: /utilisateurs");
            return;
        }

        AuthService::checkUserLogOut();

        // Check image
        if (!empty($_FILES["profil_picture"]["name"])) {
            $path = ImageService::verifyImage($_FILES["profil_picture"], "/profil/edition/{$_SESSION['user']['id']}");
        }

        if (isset($_POST["submit"])) {
            // Edit article
            if ($_SESSION["csrf_token"] !== $_POST["csrf_token"]) {
                $_SESSION["error"]["csrf_token"] = "Il y a un problème avec votre token";

                \header("location: /profil/edition/$id");
                return;
            }

            if (!UserService::checkFields($_POST)) {
                UserService::createErrorSessionFields($_POST);
                UserService::createTmpProfileSession($_POST);
                \header("location: /profil/edition/$id");
                return;
            }

            $user->setAge($_POST["age"])
                ->setFirstname($_POST["firstname"])
                ->setLastname($_POST["lastname"]);

            $_SESSION["user"]["firstname"] = $_POST["firstname"];
            $_SESSION["user"]["lastname"] = $_POST["lastname"];
            $_SESSION["user"]["age"] = $_POST["age"];

            // 1. The user already has an image but does not submit a new one
            if (!empty($user->getAvatar()) && empty($_FILES["profil_picture"]["name"])) {
                $user->setAvatar($user->getAvatar());

                $_SESSION["user"]["avatar"] = "{$user->getAvatar()}";
            }

            // 2. The user already has image and adds one
            if (!empty($user->getAvatar()) && !empty($_FILES["profil_picture"]["name"])) {
                if (\file_exists("uploads/profile/{$user->getAvatar()}")) {
                    \unlink("uploads/profile/{$user->getAvatar()}");
                }
                $user->setAvatar($path);

                $_SESSION["user"]["avatar"] = "$path";
            }

            // 3. The user don't have image and adds one
            if (empty($user->getAvatar()) && !empty($_FILES["profil_picture"]["name"])) {

                $user->setAvatar($path);
                $_SESSION["user"]["avatar"] = "$path";
            }

            $_SESSION["profile"]["message"] = "Profil mis à jour avec succès.";

            $userRepository->update($_POST, $_FILES, $user);
            \header("location: /profil/edition/{$_SESSION['user']['id']}");
            return;
        }

        $form = UserService::createForm($_SESSION, $user);

        return $this->render("profile/edit", "mon profil", [
            "form" => $form->create(),
            "user" => $user
        ]);
    }

    /**
     * Delete profile
     */
    public function delete($id)
    {
        AuthService::checkAdmin(pathToRedirect: "/");

        $id = (int)$id;
        $userModel = new User();
        $userRepository = new UserRepository();
        $user = $userRepository->findOne($id);

//        UtilService::beautifulArray($user);

        if (!$user) {
            \header("location: /utilisateurs");
            return;
        }

        $userRepository->delete($id);

        \header("location: /utilisateurs");
        return;
    }
}
