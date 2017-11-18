<?php
    session_start();
    require("model.php");
    require_once('loginModel.php');

    //檢查是否有登入(cookie存在uID)， 沒有登入就到loginForm.php
    if (!isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
        header("Location: loginForm.php");
        exit(0);
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>推薦書單</title>
  </head>

  <body>
    <p>推薦書單所有留言&nbsp;&nbsp;[<a href='loginForm.php'>登出</a>]</p>
    <hr />
    <table width=60% border="1">
      <tr>
        <td>編號</td>
        <td>功能</td>
        <td>書名</td>
        <td>推薦留言</td>
        <td>作者</td>
        <td>推薦人</td>
        <td>讚</td>
        <td>噓</td>
      </tr>

      <?php
          //將從網址"?id="中Get到的推薦書單編號存入bkID
          $bkID = (int)$_REQUEST['id'];
          $results = getBookDetail($bkID);
          if ($rs = mysqli_fetch_array($results)) {
            echo "<tr><td>" , $rs['id'] ,"</td><td>",
            "<a href='control.php?act=delete&id=",$rs['id'] ,"'>砍</a> | ",
            "<a href='editMessageForm.php?id=",$rs['id'] ,"'>改</a> | ",
            "<a href='control.php?act=like&id=",$rs['id'] ,"'>讚</a> | ",
            "<a href='control.php?act=dislike&id=",$rs['id'] ,"'>噓</a> | ",
            "</td><td>" , $rs['title'],
            "</td><td>" , $rs['msg'],
            "</td><td>", $rs['author'],
            "</td><td>", $rs['name'],
            "</td><td>(", $rs['push'],
            "</td><td>(", $rs['pull'], ")</td></td></tr>";
          }
          echo "</table><hr><table width='40%' border='1'><tr><td>作者</td><td>回應</td></tr>";


          $results = getComment($bkID);

          while ( $rs = mysqli_fetch_array($results)) {
              echo "<tr><td>",$rs['userName'], ":","</td><td>",$rs['msg'];
              if (isAdmin($_SESSION['uID'])) {
                  echo "&nbsp&nbsp<a href ='control.php?act=deleteComment&id=",$rs['id'],"'>[刪除回應]</a></td></tr>";
              } else {
                  echo "</td></tr>";
              }
              
          }
          echo "</table>";
      ?>
    <hr>
    <form method="post" action="control.php">
        <label>
          <!-- 將書本編號(bkID)及事件行為(act)以隱藏的input元素藏在Form裡面送出 -->
          <input name="bkID" type="hidden" value='<?php echo $bkID;?>' />
          <input name="act" type="hidden" value='insertCmt' />
        </label>
        <label>
          <?php
              echo "當前使用者: ", getUserName($_SESSION['uID']), "<br/>";
          ?>
          留言：
          <input name="msg" type="text" id="msg" />
          <input type="submit" name="Submit" value="新增" />
        </label>
    </form>
  </body>
</html>