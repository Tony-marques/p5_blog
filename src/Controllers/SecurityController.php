<?php


namespace App\Controllers;

use App\App\FormBuilder;
use App\Controllers\AbstractController;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\UserService;

//use App\services\AuthService;

class SecurityController extends AbstractController
{
    /**
     * Logout
     */
    public function logout()
    {
        if (!isset($_SESSION["user"])) {
            \header("location: /");
            return;
        }

        unset($_SESSION["user"]);
        \header("location: /");
        return;
    }

    /**
     * login view
     */
    public function login()
    {
    AuthService::checkUserLogged();

        if (isset($_POST["submit"])) {
            if ($_SESSION["csrf_token"] != $_POST["csrf_token"]) {
                $_SESSION["error"]["csrf_token"] = "Il y a un problème avec votre token";
                \header("location: /connexion");
                return;
            }

            $_SESSION["temporary_user"] = [
                "email" => $_POST["email"],
            ];

            if (\filter_var($_POST["email"], \FILTER_VALIDATE_EMAIL) === false) {
                $_SESSION["error"] = [
                    "email" => "Format d'adresse email incorrect !"
                ];

                \header("location: /connexion");
                return;
            }

            $_POST = \filter_input_array(INPUT_POST, [
                "email" => \FILTER_SANITIZE_EMAIL,
                "password" => \FILTER_SANITIZE_FULL_SPECIAL_CHARS
            ]);

            $userService = new UserService();
            $userRepository = new UserRepository();
            $user = $userRepository->findBy(["email" => $_POST["email"]]);
            $userModel = new User();
//        UtilService::beautifulArray($user[0]);

            $userModel->hydrate($user[0]);
//            UtilService::beautifulArray($userModel);

            if (!$user) {
                $_SESSION["error"] = [
                    "login" => "Adresse e-mail ou mot de passe incorrect !"
                ];

                \header("location: /connexion");
                return;
            }

            if (\password_verify($_POST["password"], $userModel->getPassword())) {
                $_SESSION = [
                    "user" => [
                        "id" => $userModel->getId(),
                        "firstname" => $userModel->getFirstname() !== null ? $userModel->getFirstname() : "",
                        "lastname" => $userModel->getLastname() !== null ? $userModel->getLastname() : "",
                        "age" => $userModel->getAge() !== null ? $userModel->getAge() : "",
                        "avatar" => $userModel->getAvatar() !== null ? $userModel->getAvatar() : "",
                        "role" => $userModel->getRole() !== null ? $userModel->getRole() : "",
                    ]
                ];
                \header("location: /");
                return;
            } else {
                $_SESSION["error"] = [
                    "login" => "Adresse e-mail ou mot de passe incorrect !"
                ];

                \header("location: /connexion");
                return;
            }
        }

        $CSRFToken = bin2hex(random_bytes(32));
        $_SESSION["csrf_token"] = $CSRFToken;

        $form = new FormBuilder();
        $form->startForm()
            ->startDiv([
                "class" => "form-container"
            ])
            ->startDiv([
                "class" => "form-group"
            ])
            ->setInput(type: "text", name: "email", attributs: [
                "value" => !empty($_SESSION["temporary_user"]["email"]) ? $_SESSION["temporary_user"]["email"] : "",
                "placeholder" => "Adresse e-mail"
            ])
            ->startDiv(content: isset($_SESSION["error"]["email"]) ? $_SESSION["error"]["email"] : "", attributs: [
                "class" => isset($_SESSION["error"]["email"]) ? "error mt-10" : ""
            ])
            ->endDiv()
            ->endDiv()
            ->startDiv([
                "class" => "form-group"
            ])
            ->setInput(type: "password", name: "password", attributs: [
                "placeholder" => "Mot de passe"
            ])
            ->startDiv(content: isset($_SESSION["error"]["login"]) ? $_SESSION["error"]["login"] : "", attributs: [
                "class" => isset($_SESSION["error"]["login"]) ? "error mt-10" : ""
            ])
            ->endDiv()
            ->startDiv(content: isset($_SESSION["error"]["csrf_token"]) ? $_SESSION["error"]["csrf_token"] : "", attributs: [
                "class" => isset($_SESSION["error"]["csrf_token"]) ? "error mt-10" : ""
            ])
            ->endDiv()
            ->endDiv()
            ->startDiv(content: !empty($_SESSION["success"]["message"]) ? $_SESSION["success"]["message"] : "", attributs: [
                "class" => !empty($_SESSION["success"]["message"]) ? "success" : ""
            ])
            ->endDiv()
            ->endDiv()
            ->setButton("Me connecter", [
                "class" => "button-primary button"
            ])
            ->setInput(type: "hidden", name: "csrf_token", attributs: [
                "value" => $_SESSION["csrf_token"]
            ])
            ->endForm();


        return $this->render(path: "security/login", title: "connexion", data: [
            "form" => $form->create()
        ]);
    }

    /**
     * Register page
     */
    public function register()
    {
    AuthService::checkUserLogged();

        if (isset($_POST["submit"])) {
            if ($_SESSION["csrf_token"] != $_POST["csrf_token"]) {
                $_SESSION["error"]["csrf_token"] = "Il y a un problème avec votre token !";
                \header("location: /inscription");
                return;
            }
            $passwordRegex = "^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,})$";

            $userModel = new User();
            $user = $userModel->findByEmail($_POST["email"]);
            $userExist = null;
            if ($user) {
                $userExist = true;
            }

            if (
                \strlen($_POST["firstname"]) <= 3
                || \strlen($_POST["lastname"]) <= 3
                || !\filter_var($_POST["email"], \FILTER_VALIDATE_EMAIL)
                || !\preg_match("#$passwordRegex#", $_POST["password"])
                || $userExist
            ) {

                $_SESSION["temporary_user"] = [
                    "firstname" => $_POST["firstname"],
                    "lastname" => $_POST["lastname"],
                    "email" => $_POST["email"],
                ];

                $_SESSION["error"] = [
                    "register" => [
                        "firstname" => \strlen($_POST["firstname"]) <= 3 ? "Votre prénom doit faire au minimum 3 caractères." : "",
                        "lastname" => \strlen($_POST["lastname"]) <= 3 ? "Votre nom doit faire au minimum 3 caractères." : "",

                        "email" => ($userExist) ? "Cet utilisateur existe déjà" : (!\filter_var($_POST["email"], \FILTER_VALIDATE_EMAIL) ? "Format incorrect pour votre adresse e-mail." : ""),

                        "password" => !\preg_match("#$passwordRegex#", $_POST["password"]) ? "Votre mot de passe doit faire au minimum 8 caractères et contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial." : "",
                    ]
                ];

                \header("location: /inscription");
                return;
            }

            $_POST = \filter_input_array(INPUT_POST, [
                "email" => \FILTER_SANITIZE_EMAIL,
                "password" => \FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                "firstname" => \FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                "lastname" => \FILTER_SANITIZE_FULL_SPECIAL_CHARS
            ]);

            $hashedPassword = \password_hash($_POST["password"], \PASSWORD_ARGON2I);

            $userModel = new User();
            $userModel->setEmail($_POST["email"])
                ->setPassword($hashedPassword)
                ->setFirstname($_POST["firstname"])
                ->setLastname($_POST["lastname"])
                ->setRole("[\"ROLE_USER\"]");

            $userModel->create();

            $_SESSION["success"] = [
                "message" => "Votre compte a été créé avec succès !"
            ];

            \header("location: /connexion");
            return;
        }

        $CSRFToken = bin2hex(random_bytes(32));

        $_SESSION["csrf_token"] = $CSRFToken;

        $form = new FormBuilder();
        $form->startForm()
            ->startDiv([
                "class" => "form-container"
            ])
            ->startDiv([
                "class" => "form-group"
            ])
            ->setInput(
                type: "text",
                name: "firstname",
                attributs: [
                    "value" => !empty($_SESSION["temporary_user"]["firstname"]) ? $_SESSION["temporary_user"]["firstname"] : "",
                    "placeholder" => "Prénom",
                    "autocomplete" => "off"
                ]
            )
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["register"]["firstname"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["register"]["firstname"]) ? $_SESSION["error"]["register"]["firstname"] : "")
            ->endDiv()
            ->endDiv()
            ->startDiv([
                "class" => "form-group"
            ])
            ->setInput(
                type: "text",
                name: "lastname",
                attributs: [
                    "value" => !empty($_SESSION["temporary_user"]["lastname"]) ? $_SESSION["temporary_user"]["lastname"] : "",
                    "placeholder" => "Nom"
                ]
            )
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["register"]["lastname"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["register"]["lastname"]) ? $_SESSION["error"]["register"]["lastname"] : "")
            ->endDiv()
            ->endDiv()
            ->startDiv([
                "class" => "form-group"
            ])
            ->setInput(
                type: "text",
                name: "email",
                attributs: [
                    "value" => !empty($_SESSION["temporary_user"]["email"]) ? $_SESSION["temporary_user"]["email"] : "",
                    "placeholder" => "Adresse e-mail"
                ]
            )
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["register"]["email"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["register"]["email"]) ? $_SESSION["error"]["register"]["email"] : "")
            ->endDiv()
            ->endDiv()
            ->startDiv([
                "class" => "form-group"
            ])
            ->setInput(type: "password", name: "password", attributs: [
                "value" => "",
                "placeholder" => "Mot de passe"
            ])
            ->startDiv(attributs: [
                "class" => !empty($_SESSION["error"]["register"]["password"]) ? "error mt-10" : ""
            ], content: !empty($_SESSION["error"]["register"]["password"]) ? $_SESSION["error"]["register"]["password"] : "")
            ->endDiv()
            ->endDiv()
            ->startDiv(content: !empty($_SESSION["error"]["csrf_token"]) ? $_SESSION["error"]["csrf_token"] : "", attributs: [
                "class" => !empty($_SESSION["error"]["csrf_token"]) ? "error mt-10" : ""
            ])
            ->endDiv()
            ->endDiv()
            ->setInput("hidden", "csrf_token", attributs: [
                "value" => $_SESSION["csrf_token"]
            ])
            ->setButton("Créer mon compte", [
                "class" => "button-primary button"
            ])
            ->endForm();


        return $this->render(path: "security/register", title: "inscription", data: [
            "form" => $form->create()
        ]);
    }

    /**
     * Manage users page
     */
    public function allUsers()
    {
    AuthService::checkAdmin(pathToRedirect: "/");

        $userModel = new User();
        $userRepository = new UserRepository();

        $users = $userRepository->findBy(["role" => "[\"ROLE_USER\"]"]);

        return $this->render(path: "security/allUsers", title: "gestion utilisateurs", data: [
            "users" => $users
        ]);
    }
}
