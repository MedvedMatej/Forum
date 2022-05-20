<?php
include("templates/SessionInit.php");
require_once("model/UserDB.php");
require_once("ViewHelper.php");

class UserController {

    public static function showLoginForm() {
       ViewHelper::render("view/user-login.php");
    }

    public static function showRegisterForm() {
        ViewHelper::render("view/user-register.php");
    }

    public static function login() {
        $id = UserDB::validLoginAttempt($_POST["username"], $_POST["password"]);
       if (!is_null($id) && $id >= 0) {
            $_SESSION["user"] = $_POST["username"];
            $_SESSION["id"] = $id;
            ViewHelper::redirect(BASE_URL . "forum");
       } else {
            ViewHelper::render("view/user-login.php", [
                "errorMessage" => "Invalid username or password."
            ]);
       }
    }

    public static function logout() {
        unset($_SESSION["user"]);
        unset($_SESSION["id"]);
        session_destroy();
        ViewHelper::redirect(BASE_URL . "forum");
    }

    public static function register() {
        if (UserDB::validRegisterUsername($_POST["username"])) {
             $vars = [
                 "username" => $_POST["username"]
             ];
             UserDB::registerUser($_POST["username"],$_POST["password"]);
             ViewHelper::render("view/user-register-success.php", $vars);
        } else {
             ViewHelper::render("view/user-register.php", [
                 "errorMessage" => "Username already taken."
             ]);
        }
    }
}