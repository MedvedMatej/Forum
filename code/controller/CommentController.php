<?php
include("templates/SessionInit.php");
require_once("model/CommentDB.php");
require_once("ViewHelper.php");

class CommentController {

    public static function insert() {
        CommentDB::insert($_POST["comment"], $_POST["pid"], $_POST["uid"], $_POST["fid"]);
        ViewHelper::redirect(BASE_URL . "post?id=". $_POST["pid"]);
    }

    public static function getApi() {
        if (isset($_GET["query"])) {
            $hits = CommentDB::getAll($_GET["query"]);
        }
        else{
            $hits = [];
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }
}