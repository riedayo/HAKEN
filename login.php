<?php

//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログインページ　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

//==========================
//ログイン画面処理
//==========================

//postされていた場合
if(!empty($_POST)){
  debug('POST送信があります。');

  //変数にユーザー情報を代入
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $pass_save = (!empty($_POST['pass_save'])) ? true : false; //これはショートハンド

  //未入力チェック
  validRequired($email,'email');
  validRequired($pass,'pass');

  //emailの形式チェック
  validEmail($email,'email');
  //emailの最大文字数チェック
  validMaxLen($email,'email');

  //パスワード半角英数字チェック
  validHalf($pass,'pass');
  //パスワードの最大文字数チェック
  validMaxLen($pass,'pass');
  //パスワードの最小文字数チェック
  validMinLen($pass,'pass');

if(empty($err_msg)){
  debug('バリデーションおk');

  //例外処理
  try{
    //DBへ接続
    $dbh = dbConnect();
    $sql = 'SELECT pass, id FROM users WHERE email = :email AND delete_flg = 0';
    $data =array(':email' => $email);
    //クエリ実行
    $stmt = queryPost($dbh, $sql, $data);
    //クエリ結果の値を取得する
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    debug('クエリ結果の中身：'.print_r($result,true));

    //パスワード照合（array_shiftを使って$resultの一番最初のアイテムであるpassを取得している！）
    if(!empty($result) && password_verify($pass, array_shift($result))){//第二引数でresult['pass']でもいける？
      debug('パスワードがマッチしました。');

      //ログイン有効期限（デフォルトを1時間とする）
      $sesLimit = 60*60;
      //最終ログイン日時を現在日時に
      $_SESSION['login_date'] = time(); //time関数は1970年1月1日0時０分を0年としてそこから１足していった数

      //ログイン保持にチェックがある場合
      if($pass_save){
        debug('$pass_saveの中身：'.print_r($pass_save,true));
        debug('ログインしたままにする、にチェックがあります');
        //ログイン有効期限を30日にしてセット
        $_SESSION['login_limit'] = $sesLimit*24*30;
      }else {
        debug('ログインしたままにする、にチェックがありません');
        //次回からログイン保持しないので、ログイン有効期限を1時間後にセット
        $_SESSION['login_limit'] = $sesLimit;
      }
      //ユーザーIDを格納
      $_SESSION['user_id'] = $result['id'];

      debug('セッション変数の中身：'.print_r($_SESSION,true));
      debug('マイページへ遷移します');
      header("Location:mypage.php");//マイページへ
    }else{
      debug('パスワードがアンマッチです。');
      $err_msg['common'] = MSG09;
    }
  }catch(Exception $e){
    error_log('エラー発生：'. $e->getMessage());

    $err_msg['common'] = MSG07;
  }
}

}

debug('画面表示終了<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');

 ?>

 <?php
 $siteTitle = 'ログイン';
 require('head.php');
  ?>

  <body class="page-login page-1colum">

    <!-- メニュー -->
    <?php
    require('header.php');
     ?>

     <p id="js-show-msg" style="display:none;" class="msg-slide">
       <?php echo getSessionFlash('msg_success'); ?>
     </p>
    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">
      <h2>ログイン</h2>


      <!-- Main -->
      <section id="main">
        <div class="form-container">
          <form class="form" action="" method="post">
            <div class="area-msg">
              <?php
                if(!empty($err_msg['common'])) echo $err_msg['common'];
               ?>
            </div>
              <label <?php if(!empty($err_msg['email'])) echo 'err'; ?>>
                メールアドレス
                <input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>" placeholder="hanako@gmail.com">
              </label>
              <div class="area-msg">
                <?php if(!empty($err_msg['email'])) echo $err_msg['email']; ?>
              </div>
              <label <?php if(!empty($err_msg['pass'])) echo 'err'; ?>>
                パスワード
                <input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
              </label>
              <div class="area-msg">
                <?php if(!empty($err_msg['pass'])) echo $err_msg['pass']; ?>
              </div>

            <label>
              <input type="checkbox" name="pass_save" >ログインしたままにする
            </label>


              <p>パスワードを忘れた方は<a href="passRemindSend.php">こちら</a></p>

              <div class="big-btn">
                <input type="submit" name="" value="ログイン">
              </div>
          </form>




        </div>

      </section>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>
