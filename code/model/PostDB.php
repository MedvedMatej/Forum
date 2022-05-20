<?php

require_once "DBInit.php";

class PostDB {

    /* public static function getForIds($ids) {
        $db = DBInit::getInstance();

        $id_placeholders = implode(",", array_fill(0, count($ids), "?"));

        $statement = $db->prepare("SELECT id, author, title, description, price, year, quantity
            FROM book WHERE id IN (" . $id_placeholders . ")");
        $statement->execute($ids);

        return $statement->fetchAll();
    } */

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT pid, title, text, image, p.date, username FROM post p, user u where p.uid=u.uid");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function get($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT pid, title, text, image, p.date, username FROM post p, user u where p.uid=u.uid AND pid = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $post = $statement->fetch();

        if ($post != null) {
            return $post;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function insert($title, $text, $image, $uid, $tid) {
        $db = DBInit::getInstance();
        $date = date("Y-m-d H:i:s");
        $statement = $db->prepare("INSERT INTO post (title, text, image, date, uid, tid) 
            VALUES (:title, :text, :image, :date, :uid, :tid)");
        $statement->bindParam(":title", $title);
        $statement->bindParam(":text", $text);
        $statement->bindParam(":image", $image);
        $statement->bindParam(":date", $date);
        $statement->bindParam(":uid", $uid);
        $statement->bindParam(":tid", $tid);
        $statement->execute();
    }

    public static function update($id, $author, $title, $description, $price, $year, $quantity) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE book SET author = :author, title = :title, 
            description = :description, price = :price, year = :year, quantity = :quantity 
            WHERE id = :id");
        $statement->bindParam(":author", $author);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":price", $price);
        $statement->bindParam(":year", $year);
        $statement->bindParam(":quantity", $quantity);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM book WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }    

    public static function search($query) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT pid, title, text, image, post.date, post.uid, username 
            FROM post, user, theme WHERE user.uid = post.uid AND theme.tid = post.tid AND (title RLIKE :query OR text RLIKE :query OR username RLIKE :query OR theme.name RLIKE :query)");
        $statement->bindValue(":query", $query);
        $statement->execute();

        return $statement->fetchAll();
    }    
}
