<?php
//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　退会ページ　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

//==========================
//ログイン画面処理
//==========================

//postされている場合
if(!empty($_POST)){
  debug('POST送信があります。');

  //例外処理
  try{
    //DBへ接続
    $dbh = dbConnect();
    //SQL文作成
    $sql1 = 'UPDATE users SET delete_flg = 1 WHERE id = :us_id';
    $sql2 = 'UPDATE anken_rireki SET delete_flg = 1 WHERE user_id = :us_id';
    $sql3 = 'UPDATE user_favo SET delete_flg = 1 WHERE user_id = :us_id';

    //データ流し込み
    $data = array(':us_id' => $_SESSION['user_id']);
    //クエリ実行
    $stmt1 = queryPost($dbh,$sql1, $data);
    $stmt2 = queryPost($dbh,$sql2, $data);
    $stmt3 = queryPost($dbh,$sql3, $data);

    //クエリ実行成功の場合
    if($stmt1){
      session_destroy();
      debug('セッション変数の中身：'.print_r($_SESSION,true));
      debug('トップページへ遷移します');
      header("Location:thankyou.php");
    }else{
      debug('クエリが失敗しました');
      $err_msg['common'] = MSG07;
    }

  }catch(Exception $e){
    error_log('エラー発生：' . $e->getMessage());
    $err_msg['common'] = MSG07;
  }
}
debug('画面表示終了<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');

 ?>

<?php
$siteTitle = '退会';
require('head.php');
 ?>

  <body class="page-login page-1colum">

    <!-- メニュー -->
    <?php
    require('header.php');
     ?>
    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">



      <h2>退会</h2>


      <!-- Main -->
      <section id="main">
        <div class="form-container">
          <form class="form" action="" method="post">

            <div class="area-msg">
              <?php
              if(!empty($err_msg['common'])) echo $err_msg['common'];
               ?>
            </div>
<!--
              <p class="note" style="text-align: center;">
                今までありがとうございました！<br>
                本当にお疲れ様でした。<br>
                また待っています。

              </p>
-->
              <div class="big-btn">
                <!-- ここのname属性に名前が無いとpostされたことにならないから重要。このページはinputがsubmitしか無いから -->
                <input type="submit" name="submit" value="退会する">
              </div>
          </form>

        </div>
        <a href="mypage.php">&lt; マイページに戻る</a>

      </section>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>
