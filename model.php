<?php
    require("dbconnect.php");

    // 取得所有書單列表並依照推薦次數排列
    function getBookList() {
        global $conn;

        //產生SQL
        // $sql = "select book.*, user.name from book, user where book.uID = user.id";
        // SELECT book.*, user.name FROM book, user WHERE book.uID = user.id ORDER BY push*3 - pull *2 DESC, book.id
        $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID = user.id ORDER BY push DESC, book.id";

        return mysqli_query($conn, $sql);
    }

    // 取得自己/此推薦人的所有推薦書單
    function getList($uid) {
        global $conn;
        $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID = user.id AND book.uID = $uid";
        return mysqli_query($conn, $sql);
    }

    // function getPresonalList($uid) {

    //     global $conn;
    //     $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID = user.id AND book.uID = $uid";

    //     return mysqli_query($conn, $sql);
    // }

    //刪除指定編號(id)的推薦書單
    function deleteBook($id) {
        global $conn;

        //對$id 做基本檢誤
        $id = (int) $id;

        $sql = "DELETE FROM book WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    function insertBook($title='', $msg='', $author='', $language='', $uID) {
        global $conn;

        if ($title > ' ') {
            //基本安全處理
            $title = mysqli_real_escape_string($conn, $title);
            $msg = mysqli_real_escape_string($conn, $msg);
            $author = mysqli_real_escape_string($conn, $author);
            $language = mysqli_real_escape_string($conn, $language);
            $uID = (int)$uID;

            $sql = "INSERT INTO book (title, msg, author,language , uID) VALUES ('$title', '$msg','$author', '$language', $uID);";
            return mysqli_query($conn, $sql);
        } else {
            return false;
        }
    }

    // 檢視此書單所有留言
    function getBookDetail($id) {
        global $conn;
  
        if($id > 0) {
            //選取指定編號(id)推薦書單的全部內容
            $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID=user.id AND book.id = $id";

            $result = mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message."); 
        } else {
            $result = false;
        }
        return $result;
    }

    // 從editCmt接收修改資料後更新
    function updateBook($id, $title, $msg, $author, $language) {
        global $conn;
        //基本安全處理
        $title = mysqli_real_escape_string($conn,$title);
        $msg = mysqli_real_escape_string($conn,$msg);
        $author = mysqli_real_escape_string($conn,$author);
        $language = mysqli_real_escape_string($conn,$language);
        $id = (int)$id;

        //檢查title及id不為空
        if ($title and $id) {
            //將參數帶入SQL指令
            $sql = "UPDATE book SET title='$title', msg='$msg', author='$author', language='$language' WHERE id = $id";
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
    function checklike($id, $uid) {
        global $conn;
        //對$id 做基本檢誤
        $id = (int) $id;
        $uid = (int) $uid;
        $like = 1;
        //產生SQL
        $sql = "INSERT INTO likeOnce (bID, uID, liketime) VALUES ($id, '$uid', $like);";
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

    //只有管理員可刪除不雅留言
    function deleteComment($id) {
        global $conn;

        //對$id 做基本檢誤
        $id = (int) $id;

        //產生SQL
        $sql = "DELETE FROM comment WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    // 當書單刪除時 裡面的留言一並刪除
    function deleteAllCmt($id) {
        global $conn;

        //對$id 做基本檢誤
        $id = (int) $id;
        //產生SQL
        $sql = "DELETE FROM comment WHERE bkID = $id";
        return mysqli_query($conn, $sql);
    }


    function viewtime($id) {
        global $conn;
        // if(isset($_SESSION['uID'])) { 
            $sql = "UPDATE book SET view = view + 1 WHERE id = $id;";
            return mysqli_query($conn, $sql);
        // } 
    }

    function popular($push) {
        
        if ($push >= 5 ) {
            echo "<span style='color: red;'>&nbsp;熱門</span>";
        } else if ($push <= 5 and $push >= 3) {
            echo "<span style='color: blue; background-color:yellow'>&nbsp;尚可</span>";
        }
    }

?>