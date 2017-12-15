<?php
    session_start();
    require("dbconnect.php");

    //推薦書單編號(id) & 使用者(id)存入變數
    $id = (int)$_REQUEST['id'];
    $uid = (int) $_REQUEST['uid'];

    //選出該編號(id)的推薦書單資訊
    $sql = "SELECT * FROM book WHERE id = $id;";
    //執行SQL指令, 失敗則顯示無法獲取資訊
    $result = mysqli_query($conn, $sql) or die("DB Error: Cannot retrieve message.");
    
    //檢查是否可編輯
    if (($_SESSION['uID']) != $uid) {
        echo "<a href='view.php'>[回推薦列表]</a><br/>";
        echo "You can't edit this";
        exit(0);
    }

    if ($rs = mysqli_fetch_assoc($result)) {
        $title = $rs['title'];
        $msg = $rs['msg'];
        $author = $rs['author'];
        $language = $rs['language'];
        // $uID = $rs['uID'];
    } else {
        echo "錯誤的書單編號(id)";
        exit(0);
    }

    
?>
<!DOCTYPE html>
<html>
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

          語言 : <select name="language" id="language">
              <option value="中" <?php if($language=="中") echo 'selected="selected"'; ?>>中</option>
              <option value="英" <?php if($language=="英") echo 'selected="selected"'; ?>>英</option>
              <option value="日" <?php if($language=="日") echo 'selected="selected"'; ?>>日</option>
              <option value="其他" <?php if($language=="其他") echo 'selected="selected"'; ?>>其他</option>
            </select>
          
          <input type="submit" name="Submit" value="送出" />
      </form>
  </body>
</html>
