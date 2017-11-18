<?php
    session_start();
    //導入model.php
    require("model.php");

    //導入loginModel.php, 為了使用getUserName來得到使用者名稱
    require("loginModel.php");

    //檢查是否有登入(cookie存在uID)， 沒有登入就到loginForm.php
    if (!isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
        header("Location: loginForm.php");
        exit(0);
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>推薦書單</title>
  </head>

  <body>
    <p>所有推薦書單&nbsp;&nbsp;[<a href='loginForm.php'>登出</a>]</p>
    
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
        //呼叫model.php裡面的getBookList函式, 並將回傳的結果存到results
        $results = getBookList();
        
        //將回傳內容逐列顯示
        while ($rs = mysqli_fetch_array($results)) {
          echo "<tr><td>" , $rs['id'] ,"</td><td>",
          "<a href='control.php?act=delete&id=",$rs['id'],"&uid=", $rs['uID'] ,"'>砍</a> | ",
          "<a href='editMessageForm.php?id=",$rs['id'] ,"'>改</a> | ",
          "<a href='control.php?act=like&id=",$rs['id'] ,"'>讚</a> | ",
          "<a href='control.php?act=dislike&id=",$rs['id'] ,"'>噓</a> | ",
          "<a href='viewDetail.php?bid=",$rs['id'] ,"'>Cmt</a> | ",
          // "</td><td><a href='showBook.php?id=" ,$rs['id'],  "'>" , $rs['title'],"</a>",
          "</td><td>" , $rs['title'],
          "</td><td>" , $rs['msg'],
          "</td><td>", $rs['author'],
          "</td><td>", $rs['name'],
          "</td><td>(", $rs['push'],
          ")</td><td>(", $rs['pull'], ")</td></td></tr>";
        }
      ?>

      <tr>
        <!-- 以表單的方式將新增資料送至control.php -->
        <form method="post" action="control.php">
        <td colspan="2">
          <label>
            <input type="submit" name="Submit" value="新增" />
            <input name="act" type="hidden" value='insert' />
          </label>
        </td>
        <td>
          <label>
            <input name="title" type="text" id="title" />
          </label>
        </td>
        <td>
          <label>
            <input name="msg" type="text" id="msg" />
         </label>
        </td>
        <td>
          <label>
            <input name="author" type="text" id="author" />
          </label>
        </td>
        <td colspan="3">
          <label>
            <?php
                echo "使用者: ", getUserName($_SESSION['uID']);
            ?>
            <!-- 將使用者的uID以隱藏的input元素藏在Form裡面送出 -->
            <input name="myname" type="hidden" id="myname" value='<?php echo $_SESSION['uID']; ?>' />
          </label>
        </td>
        </form>
      </tr>
    </table>
  </body>
</html>
