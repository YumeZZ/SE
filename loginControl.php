<?php
// session_start();
//引入檔案
require_once('loginModel.php');
$action =$_REQUEST['act'];

switch ($action) {
case 'login':
    //取得從loginForm.php表單傳來之POST參數
    $userName = $_POST['id']; 
    $passWord = $_POST['pwd'];
    //比對密碼
    if ($id=checkUP($userName, $passWord)) { 
        //若正確，將userID存在session變數中，作為登入成功之記號
        $_SESSION['uID'] = $id; 
        header('Location: view.php');
    } else {
        //print error message
        echo "Invalid Username or Password - Try again <br />";
        echo '<a href="loginForm.php">重新登錄</a> ';
    }
    break;

}
?>