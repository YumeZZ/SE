<?php
session_start();
require_once('model.php');
require_once('loginModel.php');

//將請求的行為存入action
$action =$_REQUEST['act'];

switch ($action) {

//刪除書單
case 'delete':
    $id = (int) $_REQUEST['id'];
    $uid = (int) $_REQUEST['uid'];
    echo "string";
    if ($id > 0 and ($_SESSION['uID']) == $uid) {
        deleteBook($id);
    }
    break;

//新增書單
case 'insert':
    $title=$_REQUEST['title'];
    $msg=$_REQUEST['msg'];
    $name=$_REQUEST['myname'];
    $author=$_REQUEST['author'];
    insertBook($title, $msg, $author, $name);
    // insertBook($title, $msg, $author, $_SESSION['uID']);
    break;

//
case 'update':
    $id = (int) $_REQUEST['id'];
    $title=$_REQUEST['title'];
    $msg=$_REQUEST['msg'];
    $author = $_REQUEST['author'];
    updateBook($id, $title, $msg, $author);
    break;

case 'like':
    $id = (int) $_REQUEST['id'];
    if ($id > 0) {
        likeBook($id);
    }
    break;

case 'dislike':
    $id = (int) $_REQUEST['id'];
    if ($id > 0) {
        dislikeBook($id);
    }
    break;

case 'insertCmt':
    $bkID=(int)$_REQUEST['bkID'];
    $msg=$_REQUEST['msg'];
    insertComment($bkID, $msg, $_SESSION['uID']);
    break;

case 'deleteComment':
    $id = (int) $_REQUEST['id'];
    if ($id > 0 and isAdmin($_SESSION['uID'])) {
        deleteComment($id);
    }
    break;
}

?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>(嘿嘿其實我不會出現)</title>
    </head>
    <body>
        <?php
            header('Location: view.php');
        ?>
        <!-- <a href='view.php'>執行完成，回留言板</a> -->
    </body>
</html>