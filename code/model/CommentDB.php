<?php

require_once "DBInit.php";

class CommentDB {

    public static function getAll($pid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT cid, text, comment.date, pid, comment.uid, fid, username from comment, user WHERE comment.uid = user.uid AND pid= :pid");
        $statement->bindParam(":pid", $pid);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function insert($text, $pid, $uid, $fid) {
        $db = DBInit::getInstance();
        $date = date("Y-m-d H:i:s");
        if ($fid == -1){
            $fid = null;
        }
        $statement = $db->prepare("INSERT INTO comment (text, date, pid, uid, fid) VALUES (:text, :date, :pid, :uid, :fid)");
        $statement->bindParam(":text", $text);
        $statement->bindParam(":date", $date);
        $statement->bindParam(":pid", $pid);
        $statement->bindParam(":uid", $uid);
        $statement->bindParam(":fid", $fid);
        $statement->execute();
    }

}
