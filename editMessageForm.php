<?php
    session_start();
    require("dbconnect.php");

    //推薦書單編號(id)存入變數
    $id = (int)$_REQUEST['id'];
    //選出該編號(id)的推薦書單資訊
    $sql = "select * from book where id = $id;";
    //執行SQL指令, 失敗則顯示無法獲取資訊
    $result = mysqli_query($conn, $sql) or die("DB Error: Cannot retrieve message.");
    
    //如果有資料則將書名、推薦訊息、作者存入變數
    if ($rs = mysqli_fetch_assoc($result)) {
        $title = $rs['title'];
        $msg = $rs['msg'];
        $author = $rs['author'];
        $uID = $rs['uID'];
    } else {
        echo "錯誤的書單編號(id)";
        exit(0);
    }
    if (($_SESSION['uID']) != $uID) {
        echo "You can't edit this";
        exit(0);
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改</title>
</head>
<body>
    <a href="view.php">[回推薦列表]</a>
    <h1>編輯推薦內容: #<?php echo $id;?></h1>
    <form method="post" action="control.php?act=update">
        <input type="hidden" name='id' value="<?php echo $id;?>">
        <!-- 將推薦書單的編號(id)以隱藏的input元素藏在Form裡面送出 -->
        書名 : <input name="title" type="text" id="title" value="<?php echo $title;?>" /> <br>

        留言內容 : <input name="msg" type="text" id="msg" value="<?php echo $msg;?>" /> <br>

        作者 : <input name="author" type="text" id="author" value="<?php echo $author;?>" /> <br>
        <input type="submit" name="Submit" value="送出" />
    </form>
</body>
</html>
