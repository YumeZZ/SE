<?php
    require("dbconnect.php");

    function getBookList() {
        global $conn;
        //$sql = "select * from guestbook;";
        // $sql = "select book.*, user.name from book, user where book.uID = user.id";
        $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID = user.id";

        return mysqli_query($conn, $sql);
    }

    //刪除指定編號(id)的推薦書單
    function deleteBook($id) {
        global $conn;

        //對$id 做基本檢誤
        $id = (int) $id;
        //產生SQL
        $sql = "DELETE FROM book WHERE id = $id;";
        return mysqli_query($conn, $sql);
    }

    function insertBook($title='', $msg='', $author='', $uID) {
        global $conn;

        if ($title > ' ') {
            //基本安全處理
            $title = mysqli_real_escape_string($conn, $title);
            $msg = mysqli_real_escape_string($conn, $msg);
            $author = mysqli_real_escape_string($conn, $author);
            $uID = (int)$uID;

            $sql = "INSERT INTO book (title, msg, author, uID) VALUES ('$title', '$msg','$author', $uID);";
            return mysqli_query($conn, $sql);
        } else {
            return false;
        }
    }

    function getBookDetail($id) {
        global $conn;
        //簡易的防錯誤
        if($id > 0) {
            //選取指定編號(id)推薦書單的全部內容
            $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID=user.id AND book.id = $id";

            $result = mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message."); //執行SQL查詢
        } else {
            $result = false;
        }
        return $result;
    }

    function updateBook($id, $title, $msg, $author) {
        global $conn;
        //基本安全處理
        $title = mysqli_real_escape_string($conn,$title);
        $msg = mysqli_real_escape_string($conn,$msg);
        $author = mysqli_real_escape_string($conn,$author);
        $id = (int)$id;

        //檢查title及id不為空
        if ($title and $id) {
            //將參數帶入SQL指令
            $sql = "UPDATE book SET title='$title', msg='$msg', author='$author' WHERE id = $id";
            mysqli_query($conn, $sql) or die("Insert failed, SQL query error");
        }
    }

    function likeBook($id) {
        global $conn;
        //對$id 做基本檢誤
        $id = (int) $id;
        
        //產生SQL
        $sql = "UPDATE book SET push = push + 1 WHERE id = $id;";
        return mysqli_query($conn, $sql);
    }

    function dislikeBook($id) {
        global $conn;
        //對$id 做基本檢誤
        $id = (int) $id;
        
        //產生SQL
        $sql = "UPDATE book SET pull = pull + 1 WHERE id = $id;";
        return mysqli_query($conn, $sql); 
    }

    function getComment($bkID) {
        global $conn;
        //選取"對應推薦書單ID的回應", 將使用者名稱以 userName欄位顯示
        $sql = "SELECT comment.*, user.name AS userName FROM comment, user WHERE comment.uID = user.id AND comment.bkID = $bkID";
        return mysqli_query($conn, $sql);
    }

    function insertComment($bkID, $msg, $uID) {
        global $conn;

        if ($msg > ' ') {
            //基本安全處理
            $bkID = (int) $bkID;
            $msg = mysqli_real_escape_string($conn, $msg);
            $uID = (int)$uID;
            
            //插入新的回應
            $sql = "INSERT INTO comment (bkID, msg, uID) VALUES ($bkID, '$msg',$uID);";
            //執行SQL指令
            return mysqli_query($conn, $sql);
        } else {
            return false;
        } 
    }

    function deleteComment($id) {
        global $conn;

        //對$id 做基本檢誤
        $id = (int) $id;

        //產生SQL
        $sql = "DELETE FROM comment WHERE id = $id";
        return mysqli_query($conn, $sql);
    }
?>