<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワード再発行認証キー入力ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証はなし（ログインできない人が使う画面なので）

//SESSIONに認証キーがあるか確認、なければリダイレクト
if(empty($_SESSION['auth_key'])){
  header("Location:passRemindSend.php"); //認証キー送信するメールアドレスフォームへ戻る
}

//================================
// 画面処理
//================================
//post送信されていた場合
if(!empty($_POST)){
  debug('POST送信があります');
  debug('POSTの中身：'.print_r($_POST,true));

  //変数にユーザー情報を代入
  $auth_key = $_POST['token'];

  //未入力チェック
  validRequired($auth_key, 'token');

  if(empty($err_msg)){
    debug('未入力チェックOK');

    //固定長チェック
    validLength($auth_key, 'token');
    //半角チェック
    validHalf($auth_key,'token');

    if(empty($err_msg)){
      debug('バリデーションOK！');


    if($auth_key !== $_SESSION['auth_key']){
      $err_msg['common'] = MSG15;
    }
    if(time() > $_SESSION['auth_key_limit']){
      $err_msg['common'] = MSG16;
    }

    if(empty($err_msg)){
      debug('認証OK！');

      $pass = makeRandKey(); //今度はパスを作る

      try{
      //例外処理
      $dbh = dbConnect();
      $sql = 'UPDATE users SET pass = :pass WHERE email = :email AND delete_flg = 0';
      $data = array(':email' => $_SESSION['auth_email'], ':pass' => password_hash($pass, PASSWORD_DEFAULT));
      //クエリ実行
      $stmt = queryPost($dbh, $sql, $data);

      //クエリ成功の場合
      if($stmt){
        debug('クエリ成功！');

        //メールを送信
$from = 'hatanorie@gmail.com';
$to = $_SESSION['auth_email'];
$subject = '【パスワード再発行完了】｜WEBUHAKEN';
//EOTはEndOfFileの略。ABCでもなんでもいい。先頭の<<<の後の文字列と合わせること。最後のEOTの前後に空白など何も入れてはいけない。
//EOT内の半角空白も全てそのまま半角空白として扱われるのでインデントはしないこと
$comment = <<<EOT
本メールアドレス宛にパスワードの再発行を致しました。
下記のURLにて再発行パスワードをご入力頂き、ログインください。

ログインページ：http://localhost:8888/WEBUhaken/login.php
再発行パスワード：{$pass}
※ログイン後、パスワードのご変更をお願い致します

////////////////////////////////////////
ウェブカツマーケットカスタマーセンター
URL
E-mail hatanorie@gmail.com
////////////////////////////////////////
EOT;
sendMail($from, $to, $subject, $comment);

        //セッション削除
        session_unset();
        $_SESSION['msg_success'] = SUC04;
        debug('セッション変数の中身：'.print_r($_SESSION,true));

        header("Location:login.php");
        return;

        //クエリ成功しなかったら
      }else{
        debug('クエリに失敗！');
        $err_msg['common'] = MSG07;
      }
    }catch(Exception $e){
      error_log('エラー発生：'.$e->getMessage());
      $err_msg['common'] = MSG07;
    }
    }
  }
}
}
 ?>
<?php
$siteTitle = '認証キー入力画面';
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
      <h2>認証キー入力画面</h2>


      <!-- Main -->
      <section id="main">
        <div class="form-container">
          <form class="form" action="" method="post">
            <p class="note">8桁の英数字を入力してください。</p>
            <div class="area-msg">
              <?php echo getErrMsg('common'); ?>
            </div>
              <label class="<?php if(!empty($err_msg['token'])) echo 'err'; ?>" >
                8桁の認証キー
                <input type="text" name="token" value="<?php echo getFormData('token'); ?>" >
              </label>
              <div class="area-msg">
                <?php echo getErrMsg('token'); ?>
              </div>

              <div class="big-btn">
                <input type="submit" name="" value="パスワード変更">
              </div>

          </form>




        </div>

      </section>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>
