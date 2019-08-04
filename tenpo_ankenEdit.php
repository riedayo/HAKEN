<?php

//共通変数・関数ファイルを読み込む
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　案件作成画面　「');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

//================================
// 画面処理
//================================

// 画面表示用データ取得
//================================
// GETデータを格納
$a_id = (!empty($_GET['a_id'])) ? $_GET['a_id'] : '';
//DBから案件データを取得
$dbFormData = (!empty($a_id)) ? getAnken($_SESSION['user_id'],$a_id) : '';
//新規登録画面か編集画面か判別用フラグ
$edit_flg = (empty($dbFormData)) ? false : true;

// パラメータ改ざんチェック
//================================
// GETパラメータはあるが、改ざんされている（URLをいじくった）場合、正しい商品データが取れないのでマイページへ遷移させる
if(!empty(a_id) && empty($dbFormData)){
  debug('GETパラメータの商品IDが違います');
  header("Location:tenpo_mypage.php"); //マイページへ
}



    //POST送信されていた場合は以下の処理が走るぞ！
    if(!empty($_POST)){
      debug('POST送信があります。');
      debug('POST情報：'.print_r($_POST,true));
      debug('FILE情報：'.print_r($_FILES,true));

      //変数にユーザー情報を代入
      $anken_date = $_POST['anken_date'];
      $salary = $_POST['salary'];
      $bosyu = $_POST['bosyu'];
      $start_time = $_POST['start_time'];
      $comment = $_POST['comment'];
      //画像をアップロードし、パスを格納
      $pic = ( !empty($_FILES['pic']['name']) ) ? uploadImg($_FILES['pic'],'pic') : '';
      //画像をPOSTしていないがすでにDBに登録されている場合、DBのパスを入れる(POSTには反映されないので)
      $pic = ( empty($pic) && !empty($dbFormData['pic']) ) ? $dbFormData['pic'] : $pic;

      //未入力チェック
      validRequired($anken_date,'anken_date');
      validRequired($salary,'salary');
      validRequired($bosyu,'bosyu');
      validRequired($start_time,'start_time');
      validRequired($comment,'comment');

      if(empty($err_msg)){
        debug('バリデーションおk');

        //例外処理
        try{
          //DB接続
          $dbh = dbConnect();
          $sql = 'INSERT INTO anken (anken_date, salaly, bosyu, start_time, comment, create_date) VALUES(:anken_date, :salaly, :bosyu, :start_time, :comment, :create_date)';

          $data = array(':anken_date' => $anken_date, ':salaly' => $salary, ':bosyu' => $bosyu, ':start_time' => $start_time, ':comment' => $comment, ':create_date' => date('Y-m-d H:i:s'));


          //クエリ実行
          $stmt = queryPost($dbh,$sql,$data);


 ?>

<?php
$siteTitle = '案件詳細';
require('head.php');
 ?>

  <body class="page-login page-1colum">

    <!-- メニュー -->
<?php
require('header.php');
 ?>
    <!-- メインコンテンツ -->
    <h2>お仕事を登録</h2>
    <div id="contents" class="site-width">






      <!-- Main -->
      <section id="main">
        <div class="anken-detail">
          <form class="" action="" method="post">


          <table>
            <tr>
              <th>依頼日</th>
              <td><input type="date" name="anken_date" value=""></td>
            </tr>
            <tr>
              <th>店舗名</th>
              <td></td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td></td>
            </tr>
            <tr>
              <th>住所</th>
              <td></td>
            </tr>
            <tr>
              <th>最寄駅</th>
              <td></td>
            </tr>
            <tr>
              <th>時給</th>
              <td><input type="text" name="salary" placeholder="3500">円</td>
            </tr>
              <tr>
                <th>募集人数</th>
                <td><input type="text" name="bosyu" placeholder="3">人</td>
              </tr>
              <tr>
              <th>業種</th>
              <td></td>
            </tr>
            <tr>
              <th>勤務開始時間</th>
              <td>
              <select class="time" name="start_time">
                <option value="" disabled>選択してください</option>
                <option value="1">19:00</option>
                <option value="1">19:30</option>
                <option value="1">20:00</option>
                <option value="1">20:30</option>
                <option value="1">21:00</option>
                <option value="1">21:30</option>
                <option value="1">22:00</option>
              </select>
              </td>
            </tr>
            <tr>
              <th>到着時間</th>
              <td></td>
            </tr>
            <tr>
              <th>派遣到着時間（２回目以降）</th>
              <td></td>
            </tr>
            <tr>
              <th>税金</th>
              <td></td>
            </tr>
            <tr>
              <th>厚生費</th>
              <td></td>
            </tr>
            <tr>
              <th>貸衣装</th>
              <td></td>
            </tr>
            <tr>
              <th>送迎代</th>
              <td></td>
            </tr><tr>
              <th>送迎範囲</th>
              <td></td>
            </tr>
            <tr>
              <th>注意事項</th>
              <td><textarea type="text" name="comment" placeholder="黒ドレスは禁止でお願いします。勤務中のストールはOK" style="background:white;"></textarea>
            </tr>
          <tr>
            <th>店舗写真</th>
            <td></td>
            <input type="file" name="pic" value="">
          </tr>

          </table>

          <div class="big-btn">
            <input type="submit" name="" value="依頼する">
          </div>
            </form>
        </div>

      </section>

    </div>




    <!-- footer -->
<?php
require('footer.php');
 ?>
