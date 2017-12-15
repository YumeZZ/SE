<?php
    session_start();
    require("model.php");
    require_once('loginModel.php');

    // 檢查是否有登入(cookie存在uID)， 沒有登入就到loginForm.php
    if (!isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
        header("Location: loginForm.php");
        exit(0);
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>推薦書單</title>
  </head>

  <body>
    <p>我的推薦書單&nbsp;&nbsp;[<a href='loginForm.php'>登出</a>]</p>
    <a href="view.php">[回推薦列表]</a>
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
          $results = getList($_SESSION['uID']);

          //將回傳內容逐列顯示
          while ($rs = mysqli_fetch_array($results)) {
              echo "<tr><td>" , $rs['id'] ,"</td><td>",
              //傳bookid&uid
              "<a href='control.php?act=delete&id=",$rs['id'],"&uid=", $rs['uID'] ,"'>砍</a> | ",
              "<a href='editMessageForm.php?id=",$rs['id'],"&uid=", $rs['uID'] ,"'>改</a> | ",
              "<a href='control.php?act=like&id=",$rs['id'] ,"'>讚</a> | ",
              "<a href='control.php?act=dislike&id=",$rs['id'] ,"'>噓</a> | ",
              "<a href='viewDetail.php?id=",$rs['id'] ,"'>Cmt</a>",
              "</td><td>" , $rs['title'],
              "</td><td>" , $rs['msg'],
              "</td><td>", $rs['author'],
              "</td><td>", $rs['name'],
              "</td><td>(", $rs['push'],
              ")</td><td>(", $rs['pull'], ")</td></td></tr>";
          }
      ?>
    </table>
  </body>
</html>