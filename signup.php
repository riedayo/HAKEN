<?php

//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　登録画面　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();


    //POST送信されていた場合は以下の処理が走るぞ！
    if(!empty($_POST)){
      debug('POST送信があります。');

      //変数にユーザー情報を代入
      $email = $_POST['email'];
      $pass = $_POST['pass'];
      $pass_re = $_POST['pass_re'];
      $username = $_POST['username'];
      $year = $_POST['year'];
      $tel = $_POST['tel'];
      $pref = $_POST['pref'];
      $addr = $_POST['addr'];
      $station = $_POST['station'];



      //未入力チェック
      validRequired($email,'email');
      validRequired($pass,'pass');
      validRequired($pass_re,'pass_re');
      validRequired($username,'username');
      validRequired($year,'year');
      validRequired($tel,'tel');
      validRequired($pref,'pref');
      validRequired($addr,'addr');
      validRequired($station,'station');

      if(empty($err_msg)){

        //emailの形式チェック
        validEmail($email,'email');
        //emailの最大文字数チェック
        validMaxLen($email,'email');
        //email重複チェック
        validEmailDup($email);
        debug('validEmailDupの中身：'.print_r($email,true));


        //パスワード半角英数字チェック
        validHalf($pass,'pass');
        //パスワードの最大文字数チェック
        validMaxLen($pass,'pass');
        //パスワードの最小文字数チェック
        validMinLen($pass,'pass');

        //パスワード（再入力）の最大文字数チェック
        validMaxLen($pass_re,'pass_re');
        //パスワード（再入力）の最小文字数チェック
        validMinLen($pass_re,'pass_re');

        //電話番号の形式チェック
        validTel($tel,'tel');

        if(empty($err_msg)){

          //パスワードと再入力が合っているかチェック
          validMatch($pass, $pass_re,'pass_re');

          if(empty($err_msg)){
            debug('バリデーションおk');

            //例外処理
            try{
              //DB接続
              $dbh = dbConnect();
              $sql = 'INSERT INTO users (email, pass, username, year, tel, pref, addr, station, login_time, create_date) VALUES(:email,:pass, :username, :year, :tel, :pref, :addr, :station, :login_time,  :create_date)';
              $data = array(':email' => $email, ':pass' => password_hash($pass, PASSWORD_DEFAULT),':username' => $username, ':year' => $year, ':tel' => $tel, ':pref' => $pref, ':addr' => $addr, ':station' => $station,
              ':login_time' => date('Y-m-d H:i:s'),
              ':create_date' => date('Y-m-d H:i:s'));


              //クエリ実行
              $stmt = queryPost($dbh,$sql,$data);

              //クエリ成功の場合
              if($stmt){
                //ログイン有効期限（デフォルトを1時間とする）
                $sesLimit = 60*60;
                //最終ログイン日時を現在日時に
                $_SESSION['login_date'] = time(); //time関数は1970年1月1日0時０分を0年としてそこから１足していった数
                $_SESSION['login_limit'] = $sesLimit;

                //ユーザーIDを格納(lastInsertIdメソッドは直前でINSERTしたIDをPDOオブジェクトからとって来るメソッド！便利！)
                $_SESSION['user_id'] = $dbh->lastInsertId();

                debug('セッション変数の中身：'.print_r($_SESSION,true));

                debug('マイページへ遷移します');
                header("Location:myAnken.php");//マイページへ

                }

                }catch(Exception $e){
                error_log('エラー発生：'. $e->getMessage());

                $err_msg['common'] = MSG07;

            }
          }
        }

    }



}

debug('画面表示終了<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');

 ?>

<?php
$siteTitle = '登録ページ';
require('head.php');
 ?>

  <body class="page-login page-1colum">

    <!-- メニュー -->
    <?php
    require('header.php');
     ?>
    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">



      <h2>登録</h2>


      <!-- Main -->
      <section id="main">
        <div class="form-container">
          <form class="form" action="" method="post">
            <div class="area-msg">
              <?php
              if(!empty($err_msg['common'])) echo $err_msg['common'];
               ?>
            </div>
              <label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
                メールアドレス
                <input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>" placeholder="hanako@gmail.com">
              </label>
              <div class="area-msg">
                <?php
                if(!empty($err_msg['email'])) echo $err_msg['email'];
                 ?>
              </div>

              <label class="<?php if(!empty($err_msg['pass'])) echo 'err'; ?>">
                パスワード
                <input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>" >
              </label>
              <div class="area-msg">
                <?php if(!empty($err_msg['pass'])) echo $err_msg['pass']; ?>
              </div>

              <label class="<?php if(!empty($err_msg['pass_re'])) echo 'err'; ?>">
                パスワード再入力
                <input type="password" name="pass_re" value="<?php if(!empty($_POST['pass_re'])) echo $_POST['pass_re']; ?>">
              </label>
              <div class="area-msg">
                <?php if(!empty($err_msg['pass_re'])) echo $err_msg['pass_re']; ?>
              </div>


                <label class="<?php if(!empty($err_msg['username'])) echo 'err'; ?>">
                  氏名
                  <input type="text" name="username" value="<?php if(!empty($_POST['username'])) echo $_POST['username']; ?>" placeholder="山田花子">
                </label>
                <div class="area-msg">
                  <?php
                  if(!empty($err_msg['username'])) echo $err_msg['username'];
                   ?>
                </div>
                <label class="<?php if(!empty($err_msg['year'])) echo 'err'; ?>">
                  生まれた年（西暦）
                  <input type="number" name="year" value="<?php if(!empty($_POST['year'])) echo $_POST['year']; ?>" placeholder="1995">
                </label>
                <div class="area-msg">
                  <?php if(!empty($err_msg['year'])) echo $err_msg['year']; ?>
                </div>
                <label class="<?php if(!empty($err_msg['tel'])) echo 'err'; ?>">
                  電話番号
                  <input type="text" name="tel" value="<?php if(!empty($_POST['tel'])) echo $_POST['tel']; ?>" placeholder="09012345678">
                </label>
                <div class="area-msg">
                  <?php if(!empty($err_msg['tel'])) echo $err_msg['tel']; ?>
                </div>
                <label class="<?php if(!empty($err_msg['pref'])) echo 'err'; ?>">
                  住所
                  <select name="pref">
                    <option value='' disabled selected style='display:none; color:#dcdcdc;'>選択してください</option>
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
                  <input type="text" name="addr" value="<?php if(!empty($_POST['addr'])) echo $_POST['addr']; ?>" placeholder="町田市原町田1-1-1　◯◯ハイツ204">
                </label>
                <div class="area-msg">
                  <?php if(!empty($err_msg['addr'])) echo $err_msg['addr']; ?>
                </div>
                <label class="<?php if(!empty($err_msg['station'])) echo 'err'; ?>">
                  最寄り駅
                  <input type="text" name="station" value="<?php if(!empty($_POST['station'])) echo $_POST['station']; ?>" placeholder="町田駅">
                </label>
                <div class="area-msg">
                  <?php if(!empty($err_msg['station'])) echo $err_msg['station']; ?>
                </div>


              <p>ログインは<a href="login.php">こちら</a></p>

              <div class="big-btn">
                <input type="submit" name="" value="登録！">
              </div>
          </form>
          </div>



        </div>

      </section>

    </div>


    <!-- footer -->
    <?php
    require('footer.php');
     ?>
