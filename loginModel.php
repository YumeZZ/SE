<?php
    //啟用session 變數功能
    session_start(); 
    require("dbconnect.php"); //匯入連結資料庫之共用程式碼

    //檢查帳密
    function checkUP($userName,$passWord) {
        global $conn;
        //將特殊SQL字元編碼，以免被SQL Injection
        $userName = mysqli_real_escape_string($conn,$userName); 
        //產生SQL指令 查詢該帳號(userName = loginID)的密碼
        $sql = "SELECT password, id FROM user WHERE loginID ='$userName'";
         //執行SQL查詢
        if ($result = mysqli_query($conn, $sql)) { 
            //取得第一筆資料
            if ($row = mysqli_fetch_assoc($result)) { 
                //比對密碼
                if ($row['password'] == $passWord) { 
                    //密碼相符就回傳使用者的id編號
                    return $row['id'];
                } else {
                    //否則印出錯誤訊息
                    return 0;
                }
            } else {
                //搜尋不到該使用者，印出錯誤訊息
                return 0;
            }
        } else{
            //SQL指令失敗
            return 0;
        }
    }
    //檢查該使用者是否為管理員
    function isAdmin($uID){
        global $conn;
        // $uid=(int)$uID;
        //產生SQL指令 從user資料表中查出該ID的管理員狀態
        $sql = "SELECT role FROM user WHERE id = $uID"; 
        //執行SQL查詢
        if ($result = mysqli_query($conn,$sql)) { 
            if ($row = mysqli_fetch_assoc($result)) {
                if ($row['role'] == 999) {
                    return true;
                }
            }
        }
        return false;
    }
    
    function getUserName($id) {
        global $conn;
        $id = (int) $id;
        $sql = "SELECT name FROM user WHERE id = $id";
        //執行SQL查詢
        if ($result = mysqli_query($conn,$sql)) {
            //取得第一筆資料
            if ($row = mysqli_fetch_assoc($result)) {
                return $row['name'];
            } else {
                //查不到資料
                return false;
            }
        }
        //查詢失敗
        return false;
    }

?>
