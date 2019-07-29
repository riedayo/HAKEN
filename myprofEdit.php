<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　プロフィール編集ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

//================================
// 画面処理
//================================

//DBからユーザーデータを取得
$dbFormData = getUser($_SESSION['user_id']);

debug('取得したユーザー情報：'.print_r($dbFormData,true));

//postされていた場合
if(!empty($_POST)){
  debug('POST送信があります');
  debug('POST情報：'.print_r($_POST,true));

  //変数にユーザー情報を代入
  $username = $_POST['username'];
  //$year = $_POST['year'];
  $email = $_POST['email'];
  $tel = $_POST['tel'];
  $pref = $_POST['pref'];
  $addr = $_POST['addr'];
  $station = $_POST['station'];
  $pic = $_POST['pic'];

  //DBの情報と入力情報が異なる場合にバリデーションを行う
  //DBから帰ってくる値は全て文字列型で入ってくるので適宜intにキャストする必要がある！重要！
  if($dbFormData['username'] !== $username){
    //名前の最大文字数チェック
    validMaxLen($username, 'username');
  }
  if($dbFormData['email'] !== $email){
    //emailの最大文字数チェック
    validMaxLen($email,'email');
    if(empty($err_msg['email'])){
      //emailの重複チェク
      validEmailDup($email,'email');
    }
    //emailの形式チェック
    validEmail($email,'email');
    //emailの未入力チェック
    validRequired($email,'email');
  }

  if($dbFormData['tel'] !== $tel){
    //TEL形式チェック
    validTel($tel,'tel');
  }
  if($dbFormData['addr'] !== $addr){
    //住所の最大文字数チェック
    validMaxLen($addr, 'addr');
  }
  if($dbFormData['station'] !== $station){
    //最寄駅の最大文字数チェック
    validMaxLen($station, 'station');
  }

  if(empty($err_msg)){
    debug('バリデーションOKです');


//例外処理
try{
  //DBへ接続
  $dbh = dbConnect();
  //SQL文作成
  $sql = 'UPDATE users SET email = :email, username = :username, tel = :tel, pref = :pref, addr = :addr, station = :station, pic = :pic WHERE id = :u_id';
  $data = array(':email' => $email, ':username' => $username, ':tel' => $tel, ':pref' => $pref, ':addr' => $addr, ':station' => $station, ':pic' => $pic, ':u_id' => $dbFormData['id']);
  //クエリ実行
  $stmt = queryPost($dbh,$sql,$data);

  //クエリ成功の場合
  if($stmt){
    $_SESSION['msg-msg_success'] = SUC02;
    debug('マイページへ遷移します');
    header("Location:myAnken.php");//マイページへ
  }

}catch(Exception $e) {
  error_log('エラー発生：' . $e->getMessage());
  $err_msg['common'] = MSG07;
}

}
}

debug('画面表示処理終了<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>

<?php
$siteTitle = 'プロフィール編集画面';
require('head.php');
 ?>

  <body class="page-login page-2colum">

    <!-- メニュー -->
    <?php
    require('header.php');
     ?>
    <!-- メインコンテンツ -->
    <h2>プロフィール変更</h2>
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
              if(!empty($err_msg['common'])) echo $err_msg['common'];
               ?>
            </div>
              <label class="<?php if(!empty($err_msg['username'])) echo 'err';?>">
                氏名
                <input type="text" name="username" value="<?php echo getFormData('username'); ?>">
              </label>
              <div class="err_msg">
                <?php if(!empty($err_msg['username'])) echo $err_msg['username']; ?>
              </div>
              <label style="margin-bottom: 20px;">
                生まれた年（西暦）
                <!-- 登録時に入力した情報をそのまま表示するだけにしたい！考え中-->
                <a style="display: block;"><?php echo $dbFormData['year']; ?></a>
              </label>

              <label class="<?php if(!empty($err_msg['email'])) echo 'err' ?>">
                email
                <input type="text" name="email" value="<?php echo getFormData('email'); ?>">
              </label>
              <div class="err_msg">
                <?php if(!empty($err_msg['email'])) echo $err_msg['email']; ?>
              </div>
              <label class="<?php if(!empty($err_msg['tel'])) echo 'err'; ?>">
                電話番号
                <input type="text" name="tel" value="<?php echo getFormData('tel'); ?>">
              </label>
              <div class="area-msg">
                <?php if(!empty($err_msg['tel'])) echo $err_msg['tel']; ?>
              </div>
              <label class="<?php if(!empty($err_msg['pref'])) echo 'err'; ?>">
                都道府県
                <select name="pref">
                  <option value='<?php echo getFormData('pref');?>' selected><?php echo getFormData('pref');?></option>
                  <option value="北海道">北海道</option>
                  <option value="青森県">青森県</option>
                  <option value="岩手県">岩手県</option>
                  <option value="宮城県">宮城県</option>
                  <option value="秋田県">秋田県</option>
                  <option value="山形県">山形県</option>
                  <option value="福島県">福島県</option>
                  <option value="茨城県">茨城県</option>
                  <option value="栃木県">栃木県</option>
                  <option value="群馬県">群馬県</option>
                  <option value="埼玉県">埼玉県</option>
                  <option value="千葉県">千葉県</option>
                  <option value="東京都">東京都</option>
                  <option value="神奈川県">神奈川県</option>
                  <option value="新潟県">新潟県</option>
                  <option value="富山県">富山県</option>
                  <option value="石川県">石川県</option>
                  <option value="福井県">福井県</option>
                  <option value="山梨県">山梨県</option>
                  <option value="長野県">長野県</option>
                  <option value="岐阜県">岐阜県</option>
                  <option value="静岡県">静岡県</option>
                  <option value="愛知県">愛知県</option>
                  <option value="三重県">三重県</option>
                  <option value="滋賀県">滋賀県</option>
                  <option value="京都府">京都府</option>
                  <option value="大阪府">大阪府</option>
                  <option value="兵庫県">兵庫県</option>
                  <option value="奈良県">奈良県</option>
                  <option value="和歌山県">和歌山県</option>
                  <option value="鳥取県">鳥取県</option>
                  <option value="島根県">島根県</option>
                  <option value="岡山県">岡山県</option>
                  <option value="広島県">広島県</option>
                  <option value="山口県">山口県</option>
                  <option value="徳島県">徳島県</option>
                  <option value="香川県">香川県</option>
                  <option value="愛媛県">愛媛県</option>
                  <option value="高知県">高知県</option>
                  <option value="福岡県">福岡県</option>
                  <option value="佐賀県">佐賀県</option>
                  <option value="長崎県">長崎県</option>
                  <option value="熊本県">熊本県</option>
                  <option value="大分県">大分県</option>
                  <option value="宮崎県">宮崎県</option>
                  <option value="鹿児島県">鹿児島県</option>
                  <option value="沖縄県">沖縄県</option>
                  </select>
              </label>
              <div class="area-msg">
                <?php if(!empty($err_msg['pref'])) echo $err_msg['pref']; ?>
              </div>
              <label class="<?php if(!empty($err_msg['addr'])) echo 'err'; ?>">
                <input type="text" name="addr" value="<?php echo getFormData('addr'); ?>">
              </label>
              <div class="area-msg">
                <?php if(!empty($err_msg['addr'])) echo $err_msg['addr']; ?>
              </div>
              <label class="<?php if(!empty($err_msg['station'])) echo 'err'; ?>">
                最寄り駅
                <input type="text" name="station" value="<?php echo getFormData('station'); ?>" >
              </label>
              <div class="area-msg">
                <?php if(!empty($err_msg['station'])) echo $err_msg['station']; ?>
              </div>
                プロフィール画像（実物と違いすぎるとお仕事をお断りする場合あり）
              <label class="area-drop" style="height:370px;lineheight:370px;">
                <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                <input type="file" name="pic" class="input-file" style="height:370px;">
                <img src="(unknown)" alt="" class="prev-img" style="display:none;">
                ドラッグ&ドロップ
              </label>

              <div class="big-btn">
                <input type="submit" name="" value="変更する">
              </div>
          </form>




        </div>

      </section>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>
