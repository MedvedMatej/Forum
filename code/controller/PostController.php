<?php

require_once("model/PostDB.php");
require_once("ViewHelper.php");

class PostController {

    public static function index() {
        if (isset($_GET["id"])) {
            ViewHelper::render("view/post-detail.php", ["post" => PostDB::get($_GET["id"])]);
        } else {
            ViewHelper::redirect(BASE_URL . "forum");
        }
    }

    public static function insert() {
        $rules = [
            "title" => FILTER_SANITIZE_SPECIAL_CHARS,
            "text" => FILTER_SANITIZE_SPECIAL_CHARS,
            "uid" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 0]
            ],
            "tid" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 0]
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["title"] = empty($data["title"]) ? "Title must not be empty." : "";
        $errors["uid"] = empty($data["uid"]) ? "User undefined." : "";
        $errors["tid"] = empty($data["tid"]) ? "Theme undefined." : "";

        $errors = [];
        $isDataValid = true;

        if (strlen(basename($_FILES["imgf"]["name"]))>0){
            $data["image"] = basename($_FILES["imgf"]["name"]);
            $target_file = "static/images/".$data["image"];

            if (file_exists($target_file)){
                $data["image"] = explode('.',$data["image"])[0].time().".".explode('.',$data["image"])[1];
            }

            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $errors["image"] = "Sorry, only JPG, JPEG, PNG & GIF files are supported.";
            }
        }

        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            if (strlen(basename($_FILES["imgf"]["name"]))>0){
                rename($_FILES["imgf"]["tmp_name"], "static/images/".$data["image"]);
            }

            PostDB::insert($data["title"], $data["text"], $data["image"], 
                $data["uid"], $data["tid"]);
            ViewHelper::redirect(BASE_URL . "forum");
        } else {
            ViewHelper::render("view/create-post-form.php");
        }
    }
/* 
    public static function delete() {
        $rules = [
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ],
            "delete_confirmation" => [
                "filter" => FILTER_VALIDATE_BOOLEAN
            ]
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["id"] = $data["id"] === null ? "Cannot delete without a valid ID." : "";
        $errors["delete_confirmation"] = $data["delete_confirmation"] === null ? "Forgot to check the delete box?" : "";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            BookDB::delete($data["id"]);
            $url = BASE_URL . "book";
        } else {
            if ($data["id"] !== null) {
                $url = BASE_URL . "book/edit?id=" . $data["id"];
            } else {
                $url = BASE_URL . "book";
            }
        }

        ViewHelper::redirect($url);
    } */

    public static function searchApi() {
        if (isset($_GET["query"])) {
            $hits = PostDB::search($_GET["query"]);
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }
}