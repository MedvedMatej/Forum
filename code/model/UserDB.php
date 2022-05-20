<?php

require_once "DBInit.php";

class UserDB {

    // Returns true if a valid combination of a username and a password are provided.
    public static function validLoginAttempt($username, $password) {
        $dbh = DBInit::getInstance();
        $query = "SELECT uid FROM user WHERE username = :username AND password = :password";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array(
            ':username'=> $username,
            ':password'=> $password
        ));

        $row = $stmt->fetch();
        if(!$row)
            return -1;

        return $row["uid"];
    }

    public static function validRegisterUsername($username) {
        $dbh = DBInit::getInstance();
        $query = "SELECT COUNT(uid) FROM user WHERE username = :username";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array(
            ':username'=> $username,
        ));

        return $stmt->fetchColumn(0) == 0;
    }

    public static function registerUser($user, $pass) {
        $db = DBInit::getInstance();
        $date = date("Y-m-d");

        $statement = $db->prepare("INSERT INTO `user` (`username`, `password`, `date`)
            VALUES (:user, :pass, :date)");
        $statement->bindParam(":user", $user);
        $statement->bindParam(":pass", $pass);
        $statement->bindParam(":date", $date);
        $statement->execute();
    }
}
