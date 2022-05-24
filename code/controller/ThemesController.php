<?php
include("templates/SessionInit.php");
require_once("model/ThemesDB.php");
require_once("ViewHelper.php");

class ThemesController {

    public static function showThemeForm() {
       ViewHelper::render("view/create-theme-form.php");
    }

    public static function insert() {
        $rules = [
            "name" => FILTER_SANITIZE_SPECIAL_CHARS,
            "desc" => FILTER_SANITIZE_SPECIAL_CHARS,
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errors["name"] = empty($data["name"]) ? "Name is empty." : "";


        $errors = [];
        $isDataValid = true;

        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if($isDataValid){

            if (ThemesDB::validNewName($_POST["name"])){
                ThemesDB::insert($_POST["name"], $_POST["desc"]);
                //maybe umesna stran
                ViewHelper::render("view/create-post-form.php");
            }
            else{
                ViewHelper::render("view/create-theme-form.php", [
                    "errorMessage" => "Theme with given name already exists."
                ]);
            }
        }
        else{
            ViewHelper::render("view/create-theme-form.php", [
                "errorMessage" => "Theme name is empty."
            ]);
        }
    }

    public static function getApi() {
        $hits = ThemesDB::getAll();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }
}