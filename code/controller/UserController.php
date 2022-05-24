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
        $rules = [
            "username" => FILTER_SANITIZE_SPECIAL_CHARS,
            "password" => FILTER_SANITIZE_SPECIAL_CHARS,
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["username"] = empty($data["title"]) ? "Username is empty." : "";
        $errors["password"] = empty($data["uid"]) ? "Password is empty." : "";

        $errors = [];
        $isDataValid = true;

        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if($isDataValid){
            $id = UserDB::validLoginAttempt($data["username"], $data["password"]);
            if (!is_null($id) && $id >= 0) {
                $_SESSION["user"] = $data["username"];
                $_SESSION["id"] = $id;
                ViewHelper::redirect(BASE_URL . "forum");
           } else {
                ViewHelper::render("view/user-login.php", [
                    "errorMessage" => "Invalid username or password."
                ]);
           }
        }
        else{
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
        $rules = [
            "username" => FILTER_SANITIZE_SPECIAL_CHARS,
            "password" => FILTER_SANITIZE_SPECIAL_CHARS,
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["username"] = empty($data["username"]) ? "Username is empty." : "";
        $errors["password"] = empty($data["password"]) ? "Password is empty." : "";

        $errors = [];
        $isDataValid = true;

        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if($isDataValid){
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
        else{
            ViewHelper::render("view/user-register.php", [
                "errorMessage" => "Username or password field is empty."
            ]);
        }
    }
}