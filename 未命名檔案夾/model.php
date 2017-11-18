<?php
    require("dbconnect.php");

    function getBookList() {
        global $conn;
        //$sql = "select * from guestbook;";
        // $sql = "select book.*, user.name from book, user where book.uID = user.id";
        $sql = "select book.*, user.name from book, user where book.uID = user.id ORDER BY push DESC, book.id";

        return mysqli_query($conn, $sql);
    }
    
        // function getSelfBookList($uID) {
    //     global $conn;
    //     //選取目前登入使用者(uID)所有的推薦書單資訊 (由於書單資訊記載的推薦人是以編號(id), 所以還要額外從user資料表中搜尋user.id對應的暱稱)
    //     $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID = user.id AND book.uID = $uID";
    //     //執行SQL指令並將結果回傳
    //     return mysqli_query($conn, $sql);
    // }

    function deleteBook($id) {
        global $conn;

        //對$id 做基本檢誤
        $id = (int) $id;
        //產生SQL
        $sql = "delete from book where id=$id;";
        return mysqli_query($conn, $sql); //執行SQL

    }

    function insertBook($title='', $msg='', $author='', $uID) {
        global $conn;

        if ($title > ' ') {
            //基本安全處理
            $title = mysqli_real_escape_string($conn, $title);
            $msg = mysqli_real_escape_string($conn, $msg);
            $author = mysqli_real_escape_string($conn, $author);
            $uID = (int)$uID;
            
            $sql = "insert into book (title, msg, author, uID) values ('$title', '$msg','$author', $uID);";
            return mysqli_query($conn, $sql); //執行SQL
        } else {
            return false;
        }
        
    }

    function getBookDetail($id) {
        global $conn;
        if($id > 0) {
            $sql = "select book.*, user.name from book, user where book.uID=user.id and book.id=$id;";
            $result = mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message."); //執行SQL查詢
        } else {
            $result = false;
        }
        return $result;
    }

    function updateBook($id, $title, $msg, $author) {
        global $conn;
        $title=mysqli_real_escape_string($conn,$title);
        $msg=mysqli_real_escape_string($conn,$msg);
        $author=mysqli_real_escape_string($conn,$author);
        $id = (int)$id;

        if ($title and $id) { //if title is not empty
            $sql = "update book set title='$title', msg='$msg', author='$author' where id=$id;";
            mysqli_query($conn, $sql) or die("Insert failed, SQL query error"); //執行SQL
        }
    }

    function likeBook($id) {
        global $conn;
        //對$id 做基本檢誤
        $id = (int) $id;
        
        //產生SQL
        $sql = "update book set push = push+1 where id = $id;";
        return mysqli_query($conn, $sql); //執行SQL
    }

    function dislikeBook($id) {
        global $conn;
        //對$id 做基本檢誤
        $id = (int) $id;
        
        //產生SQL
        $sql = "update book set pull = pull + 1 where id = $id;";
        return mysqli_query($conn, $sql); //執行SQL
    }

    // function addComment($bookID, $uID, $msg) {
    //     global $conn;

    // }

    function getComment($bkID) {
        global $conn;
        $sql = "select comment.*, user.name as userName from comment, user where comment.uID=user.id and comment.bkID = $bkID";
        return mysqli_query($conn, $sql);
    }

    function insertComment($bkID, $msg, $uID) {
        global $conn;

        if ($msg > ' ') {
            //基本安全處理
            $bkID = (int)$bkID;
            $msg = mysqli_real_escape_string($conn, $msg);
            $uID = (int)$uID;
            
            //Generate SQL
            $sql = "insert into comment (bkID, msg, uID) values ('$bkID', '$msg', $uID);";

            return mysqli_query($conn, $sql); //執行SQL
        } else return false;
    }

    function deleteComment($id) {
        global $conn;

        //對$id 做基本檢誤
        $id = (int) $id;

        //產生SQL
        $sql = "delete from comment where id=$id;";
        return mysqli_query($conn, $sql); //執行SQL
    }
?>