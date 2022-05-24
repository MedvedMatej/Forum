<?php

require_once("controller/PostController.php");
require_once("controller/UserController.php");
require_once("controller/ThemesController.php");
require_once("controller/CommentController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim(htmlspecialchars($_SERVER["PATH_INFO"]), "/") : "";

$urls = [
    "forum" => function () {
        ViewHelper::render("view/forum.php", ["posts" => PostDB::getAll()]);
    },
    "user/login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::login();
        } else {
            UserController::showLoginForm();
        }
    },
    "user/logout" => function () {
        UserController::logout();
    },
    "user/register" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::register();
        } else {
            UserController::showRegisterForm();
        }
    },
    "post" => function () {
        PostController::index();
    },
    "post/create" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            PostController::insert();
        } else {
            ViewHelper::render("view/create-post-form.php");
        }
    },
    "theme/create" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ThemesController::insert();
        } else {
            ThemesController::showThemeForm();
        }
    },
    "api/post/search" => function () {
        PostController::searchApi();
    },
    "api/theme/get" => function () {
        ThemesController::getApi();
    },
    "api/comment/get" => function () {
        CommentController::getApi();
    },
    "comment/create" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            CommentController::insert();
        }
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "forum");
    },
];

try {
    if (isset($urls[$path])) {
       $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
} 
