<?php

require_once "DBInit.php";

class ThemesDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT tid,name,description FROM theme");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function get($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT tid,name,description FROM theme WHERE tid = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $theme = $statement->fetch();

        if ($theme != null) {
            return $theme;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function validNewName($name) {
        $dbh = DBInit::getInstance();
        $query = "SELECT COUNT(tid) FROM theme WHERE name = :name";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array(
            ':name'=> $name,
        ));

        return $stmt->fetchColumn(0) == 0;
    }

    public static function insert($name, $desc) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO theme (name, description) 
            VALUES (:name, :desc)");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":desc", $desc);
        $statement->execute();
    }

}
