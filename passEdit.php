<?php
//共通変数・関数ファイルを読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワード変更ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

//================================
// 画面処理
//================================

//DBからユーザーエータを取得
$userData = getUser($_SESSION['user_id']);
debug('取得したユーザー情報：'.print_r($userData,true));

//post送信されていた場合
if(!empty($_POST)){
  debug('POST送信があります');
  debug('POST送信の中身:'.print_r($_POST,true));

  //変数にユーザー情報を代入
  $pass_old = $_POST['pass_old'];
  $pass_new = $_POST['pass_new'];
  $pass_new_re = $_POST['pass_new_re'];

  //未入力チェック
  validRequired($pass_old,'pass_old');
  validRequired($pass_new,'pass_new');
  validRequired($pass_new_re,'pass_new_re');

  if(empty($err_msg)){
    debug('未入力チェックOK！');

    //古いパスワードチェック
    validPass($pass_old,'pass_old');
    //新しいパスワードのチェック
    validPass($pass_new,'pass_new');

    //古いパスワードとDBに入っているパスワードを照合（DBに入っているデータと同じであれば、半角英数字チェックや最大文字数チェックは省いておk）
    if(!password_verify($pass_old,$userData['pass'])){
      $err_msg['pass_old'] = MSG12;
    }

    //新しいパスワードと古いパスワードが同じかチェック(同じものは使えないよ！)
    if($pass_old === $pass_new){
      $err_msg['pass_new'] = MSG13;
    }

    //パスワードと再入力があっているかチェック（ログイン画面では最大最小チェックもしていたがパスワードの方でチェックしているので実は必要ない）
    validMatch($pass_new, $pass_new_re, 'pass_new_re');

    if(empty($err_msg)){
      debug('バリデーションOK！（新旧パスの半角チェック、古パスがDBと一緒か、新パスは古いのとちゃんと違うかOK）');

      //例外処理
      try{
      //DB接続
      $dbh = dbConnect();
      $sql = 'UPDATE users SET pass = :pass WHERE id = :id';
      $data = array(':id' => $_SESSION['user_id'], ':pass' => password_hash($pass_new, PASSWORD_DEFAULT));
      //クエリ実行
      $stmt = queryPost($dbh,$sql,$data);

      //クエリ成功の場合
      if($stmt){
        $_SESSION['msg_success'] = SUC01;

        //メールを送信
        $username = $userData['username'];
        $from = 'hatanorie@gmail.com';
        $to = $userData['email'];
        $subject = 'パスワード変更通知｜HAKEN';
        //EOTはEndOfFileの略。ABCでもいい。先頭の<<の後の文字列と合わせること。最後のEOTの前後に空白とかは入れてはダメ。
        //EOT内の半角空白も全てそのまま半角空白として扱われるのでインデントはしないこと
        $comment = <<<ABC
{$username}　さん
パスワードが変更されました。

///////////////////////////////////
WEBUhaken
URL　http://WEBUhaken.com
E-mail hatanorie@gmail.com
///////////////////////////////////
ABC;

          sendMail($from,$to,$subject,$comment);

          header("Location:mypage.php");

      }

    }catch (Exception $e){
        error_log('エラー発生：' .$e->getMessage());
        $err_msg['common'] = MSG07;
    }
    }
  }
}


 ?>

<?php
$siteTitle = 'パスワード変更';
require('head.php');
 ?>

  <body class="page-login page-2colum">

    <!-- メニュー -->
    <?php
    require('header.php');
     ?>
    <!-- メインコンテンツ -->
    <h2>パスワード変更</h2>
    <div id="contents" class="site-width">


      <!-- サイドバー -->
        <?php
        require('sidebar_mypage.php');
         ?>
      <!-- Main -->
      <section id="main">
        <div class="form-container">
          <form class="form" action="" method="post">
            <div class="area-msg">
              <?php
              echo getErrMsg('common');
               ?>
            </div>
              <label class="<?php if(!empty($err_msg['pass_old'])) echo 'err'; ?>" >
                古いパスワード
                <input type="password" name="pass_old" value="<?php echo getFormData('pass_old'); ?>">
              </label>
              <div class="area-msg">
                <?php echo getErrMsg('pass_old'); ?>
              </div>

              <label class="<?php if(!empty($err_msg['pass_new'])) echo 'err'; ?>">
                新しいパスワード
                <input type="password" name="pass_new" value="<?php echo getFormData('pass_new'); ?>" >
              </label>
              <div class="area-msg">
                <?php echo getErrMsg('pass_new'); ?>
              </div>

              <label class="<?php if(!empty($err_msg['pass_new_re'])) echo 'err'; ?>">
                新しいパスワード（再入力）
                <input type="password" name="pass_new_re" value="<?php echo getFormData('pass_new_re'); ?>">
              </label>
              <div class="area-msg">
                <?php echo getErrMsg('pass_new_re'); ?>
              </div>

              <div class="big-btn">
                <input type="submit" name="" value="変更">
              </div>
          </form>




        </div>

      </section>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>
