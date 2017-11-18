<?php
    session_start();
    //set the login mark to empty
    $_SESSION['uID'] = 0;
?>
<h1>登錄</h1>
<hr />
<!-- 將使用者的帳密送至 loginControl.php 進行處理 -->
<form method="post" action="loginControl.php">
    <input type="hidden" name="act" value="login">
    User Name: <input type="text" name="id"><br />
    Password : <input type="password" name="pwd"><br />
    <input type="submit">
</form>