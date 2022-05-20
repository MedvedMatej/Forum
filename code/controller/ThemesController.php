<?php
include("templates/SessionInit.php");
require_once("model/ThemesDB.php");
require_once("ViewHelper.php");

class ThemesController {

    public static function showThemeForm() {
       ViewHelper::render("view/create-theme-form.php");
    }

    public static function insert() {
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

    public static function getApi() {
        $hits = ThemesDB::getAll();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }
}