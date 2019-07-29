<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワード再発行メール送信ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証はなし（ログインできない人が使う画面だから）

//================================
// 画面処理
//================================

//postされていた場合
if(!empty($_POST)){
  debug('POST送信があります');
  debug('POST送信の中身：'.print_r($_POST,true));

  //変数にPOST情報を代入
  $email = $_POST['email'];

  //未入力チェック
  validRequired($email,'email');

  if(empty($err_msg)){
    debug('未入力チェックはOK');

    //emailの形式チェック
    validEmail($email,'email');
    //emailの最大文字数チェック
    validMaxLen($email,'email');

    if(empty($err_msg)){
      debug('バリデーションOK！');

      //例外処理
      try{
        //DB接続
        $dbh = dbConnect();
        $sql = 'SELECT count(*) FROM users WHERE email = :email AND delete_flg = 0';
        $data = array(':email' => $email );
        //クエリ実行
        $stmt = queryPost($dbh,$sql,$data);
        //クエリ結果の値を取得！
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //EmailがDBに登録されている場合(array_shiftは最初の１個目だからid?)
        if($stmt && array_shift($result)){
          debug('クエリ成功！DBに登録あり！');
          $_SESSION['msg_success'] = SUC03;

          $auth_key = makeRandKey(); //認証キーを生成する

          //メールを送信する
          $from = 'hatanorie@gmail.com';
          $to = $email;
          $subject = '【パスワード再発行認証】| WEBUHAKEN';
          $comment = <<<EOT
本メールアドレス宛にパスワード再発行のご依頼がありました。
下記のURLにて認証キーをご入力いただくと英数字が組み合わさったパスワードが再発行されます。

パスワード再発行認証キー入力ページ：http://localhost:8888/WEBUhaken/passRemindRecieve.php
認証キー：{$auth_key}
※認証キーの有効期限は３０分間です。

認証キーを再発行されたい場合は下記ページより再度発行する事ができます。
http://localhost:8888/WEBUhaken/passRemindSend.php

////////////////////////////////////////
WEBUhakenカスタマーセンター
URL  /
E-mail hatanorie@gmail.com
////////////////////////////////////////
EOT;

        sendMail($from, $to, $subject, $comment);

        //認証に必要な情報をセッションへ保存
        $_SESSION['auth_key'] = $auth_key;
        $_SESSION['auth_email'] = $email;
        $_SESSION['auth_key_limit'] = time()+(60*30); //現在時刻＋３０分後のUNIXタイムスタンプを入れる
        debug('セッションの中身：'.print_r($_SESSION,true));

        header("Location:passRemindRecieve.php"); //認証キーページへ

      }else{
        debug('クエリに失敗したorDBに登録のないEmailが入力されました');
        $err_msg['common'] = MSG07;
      }

    }catch( Exception $e) {
      error_log('エラー発生($e->getMessage()のやつ)：'.$e->getMessage());
      $err_msg['common'] = MSG07;
    }
    }
  }
}

 ?>

<?php
$siteTitle = 'パスワードメール送信画面';
require('head.php');
 ?>

  <body class="page-login page-1colum">

    <!-- メニュー -->
    <?php
    require('header.php');
     ?>
    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">
      <h2></h2>


      <!-- Main -->
      <section id="main">
        <div class="form-container">
          <form class="form" action="" method="post">
            <p class="note">ご指定のメールアドレス宛にパスワード再発行用のURLと認証キーをお送り致します。</p>
            <div class="area-msg">
              <?php if(!empty($err_msg['common'])) echo $err_msg['common']; ?>
            </div>
              <label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
                メールアドレス
                <input type="text" name="email" value="<?php getFormData('email'); ?>" >
                <!-- なぜここにgetFormDataが？！ -->
              </label>
              <div class="area-msg">
                <?php echo getErrMsg('email');  ?>
              </div>

              <div class="big-btn">
                <input type="submit" name="" value="メールを送る">
              </div>

          </form>




        </div>

      </section>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>
